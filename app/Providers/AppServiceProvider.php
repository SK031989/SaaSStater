<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $settingsPath = config_path('settings.json');
        $projectName = 'SaaSStater';
        $projectLogo = 'shield';
        $projectLogoImage = '';
        $activeTheme = 'obsidian';
        $projectDescription = '';

        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $projectName = $settings['project_name'] ?? $projectName;
            $projectLogo = $settings['project_logo'] ?? $projectLogo;
            $projectLogoImage = $settings['project_logo_image'] ?? $projectLogoImage;
            $activeTheme = $settings['active_theme'] ?? $activeTheme;
            $projectDescription = $settings['project_description'] ?? $projectDescription;
        }

        config([
            'app.name' => $projectName,
            'settings.project_name' => $projectName,
            'settings.project_logo' => $projectLogo,
            'settings.project_logo_image' => $projectLogoImage,
            'settings.active_theme' => $activeTheme,
            'settings.project_description' => $projectDescription,
        ]);
    }
}
