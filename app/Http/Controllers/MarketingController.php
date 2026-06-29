<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MarketingController extends Controller
{
    /**
     * Show the main landing / home page.
     */
    public function index(): View
    {
        $features = config('marketing.features', []);
        $pricing  = config('marketing.pricing', []);

        return view($this->getThemeView('index'), compact('features', 'pricing'));
    }

    /**
     * Show the detailed features list.
     */
    public function features(): View
    {
        $features = config('marketing.features', []);

        return view($this->getThemeView('features'), compact('features'));
    }

    /**
     * Show the pricing page.
     */
    public function pricing(): View
    {
        $pricing = config('marketing.pricing', []);

        return view($this->getThemeView('pricing'), compact('pricing'));
    }

    /**
     * Show the contact page.
     */
    public function contact(): View
    {
        return view($this->getThemeView('contact'));
    }

    /**
     * Switch application/marketing pages theme.
     */
    public function setTheme(Request $request): RedirectResponse
    {
        $theme = $request->input('theme', config('marketing.default_theme', 'obsidian'));
        $allowed = array_keys(config('marketing.themes', []));

        if (in_array($theme, $allowed, true)) {
            session(['marketing_theme' => $theme]);
        }

        return back()->with('success', 'Theme switched successfully.');
    }

    /**
     * Retrieve the view path of the active theme.
     */
    protected function getThemeView(string $view): string
    {
        $theme = session('marketing_theme', config('marketing.default_theme', 'obsidian'));
        return "themes.{$theme}.{$view}";
    }
}
