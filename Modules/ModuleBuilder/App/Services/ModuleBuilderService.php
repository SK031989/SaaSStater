<?php

namespace Modules\ModuleBuilder\App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Modules\ModuleBuilder\App\Events\ModuleCreated;
use Modules\ModuleBuilder\App\Models\DynamicModule;
use Modules\ModuleBuilder\App\Models\ModuleMenu;
use Modules\ModuleBuilder\App\Models\ModulePermission;
use Modules\ModuleBuilder\App\Repositories\FieldRepository;
use Modules\ModuleBuilder\App\Repositories\ModuleRepository;

class ModuleBuilderService
{
    public function __construct(
        protected ModuleRepository          $moduleRepo,
        protected FieldRepository           $fieldRepo,
        protected MigrationGeneratorService $migrationGenerator,
        protected ModelGeneratorService     $modelGenerator,
        protected ControllerGeneratorService $controllerGenerator,
        protected ViewGeneratorService      $viewGenerator,
        protected PermissionGeneratorService $permissionGenerator,
    ) {}

    // -------------------------------------------------------------------------
    // Module CRUD
    // -------------------------------------------------------------------------

    /**
     * Create a new dynamic module definition and fire the generation event.
     */
    public function createModule(array $data): DynamicModule
    {
        return DB::transaction(function () use ($data) {
            $data['slug'] = Str::slug($data['name']);

            $module = $this->moduleRepo->create($data);

            // Register default menu entry
            $this->createMenuEntry($module);

            // Fire event → listener dispatches generation job
            Event::dispatch(new ModuleCreated($module));

            return $module;
        });
    }

    /**
     * Update module definition; if already generated, flag as needs-regeneration.
     */
    public function updateModule(DynamicModule $module, array $data): DynamicModule
    {
        return DB::transaction(function () use ($module, $data) {
            if (isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            // If the module was previously generated, mark for re-generation
            if ($module->is_generated) {
                $data['is_generated'] = false;
            }

            return $this->moduleRepo->update($module, $data);
        });
    }

    /**
     * Delete module and its related records.
     */
    public function deleteModule(DynamicModule $module): bool
    {
        return DB::transaction(function () use ($module) {
            $module->fields()->delete();
            $module->menu()->delete();
            $module->permissions()->delete();
            return $this->moduleRepo->delete($module);
        });
    }

    // -------------------------------------------------------------------------
    // Generation Orchestration
    // -------------------------------------------------------------------------

    /**
     * Generate all files for the given module.
     *
     * @return array<string, string> map of file-type => generated path
     */
    public function generateModule(DynamicModule $module): array
    {
        $module->load('fields');
        $generated = [];

        $basePath = config('modulebuilder.modules_path') . DIRECTORY_SEPARATOR . $module->module_class_name;

        // 1. Migration
        $generated['migration'] = $this->migrationGenerator->generate($module);

        // 2. Model
        $generated['model'] = $this->modelGenerator->generate($module);

        // 3. Controller
        $generated['controller'] = $this->controllerGenerator->generate($module);

        // 4. Views (returns array of paths)
        $generated['views'] = $this->viewGenerator->generate($module);

        // 5. Permissions
        $generated['permissions'] = $this->permissionGenerator->generate($module);

        // 6. Routes (web + api)
        $generated['routes'] = $this->generateRoutes($module, $basePath);

        // 7. Mark as generated
        $this->moduleRepo->markGenerated($module, $basePath);

        return $generated;
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    private function createMenuEntry(DynamicModule $module): ModuleMenu
    {
        return ModuleMenu::create([
            'tenant_id' => $module->tenant_id,
            'module_id' => $module->id,
            'label'     => $module->name,
            'route'     => $module->route_name . '.index',
            'icon'      => $module->icon ?? 'bi-grid',
            'sort_order' => 99,
            'status'    => 'active',
        ]);
    }

    private function generateRoutes(DynamicModule $module, string $basePath): string
    {
        $className  = $module->module_class_name;
        $routeName  = $module->route_name;
        $routesPath = $basePath . DIRECTORY_SEPARATOR . 'routes';

        if (!is_dir($routesPath)) {
            mkdir($routesPath, 0755, true);
        }

        $webContent = <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use Modules\\{$className}\\App\Http\Controllers\\{$className}Controller;

Route::middleware(['web', 'auth', 'verified'])
    ->prefix('{$routeName}')
    ->name('{$routeName}.')
    ->group(function () {
        Route::resource('/', {$className}Controller::class)->parameters(['' => '{$routeName}']);
    });
PHP;

        $apiContent = <<<PHP
<?php

use Illuminate\Support\Facades\Route;
use Modules\\{$className}\\App\Http\Controllers\\{$className}ApiController;

Route::middleware(['api', 'auth:sanctum'])
    ->prefix('v1/{$routeName}')
    ->name('api.{$routeName}.')
    ->group(function () {
        Route::apiResource('/', {$className}ApiController::class)->parameters(['' => '{$routeName}']);
    });
PHP;

        file_put_contents($routesPath . '/web.php', $webContent);
        file_put_contents($routesPath . '/api.php', $apiContent);

        return $routesPath;
    }
}
