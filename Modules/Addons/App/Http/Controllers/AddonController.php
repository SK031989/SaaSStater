<?php

namespace Modules\Addons\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Addons\Services\AddonService;

class AddonController extends Controller
{
    public function __construct(protected AddonService $addonService) {}

    public function index()
    {
        $addons = $this->addonService->getAll();
        return view('Addons::index', compact('addons'));
    }

    public function create()
    {
        return view('Addons::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:100',
            'price_monthly' => 'required|numeric|min:0',
            'status'        => 'required|string',
            'description'   => 'nullable|string',
        ]);

        $this->addonService->create($validated);

        return redirect()->route('addons.index')->with('success', 'Addon extension created successfully.');
    }

    public function show($id)
    {
        $addon = $this->addonService->findById($id);
        return view('Addons::show', compact('addon'));
    }

    public function edit($id)
    {
        $addon = $this->addonService->findById($id);
        return view('Addons::edit', compact('addon'));
    }

    public function update(Request $request, $id)
    {
        $addon = $this->addonService->findById($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'code'          => 'nullable|string|max:100',
            'price_monthly' => 'required|numeric|min:0',
            'status'        => 'required|string',
            'description'   => 'nullable|string',
        ]);

        $this->addonService->update($addon, $validated);

        return redirect()->route('addons.index')->with('success', 'Addon extension updated successfully.');
    }

    public function destroy($id)
    {
        $addon = $this->addonService->findById($id);
        $this->addonService->delete($addon);

        return redirect()->route('addons.index')->with('success', 'Addon extension deleted successfully.');
    }
}
