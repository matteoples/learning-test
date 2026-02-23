<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public ?string $href;
    public string $variant;
    public ?string $icon;

    /**
     * @param string|null $href URL del link (opzionale)
     * @param string $variant primary|secondary|inline
     * @param string|null $icon nome dell'icona (opzionale)
     */
    public function __construct(?string $href = null, string $variant = 'primary', ?string $icon = null)
    {
        $this->href = $href;
        $this->variant = $variant;
        $this->icon = $icon;
    }

    /**
     * Restituisce le classi Tailwind di base per ogni variante
     */
    public function classes(): string
    {
        return match($this->variant) {
            'primary' => 'flex items-center justify-center gap-2 rounded-lg transition primary-button',
            'secondary' => 'flex items-center gap-2 px-3 py-2 rounded-lg transition secondary-button',
            'inline' => 'flex items-center gap-2 transition font-medium inline-button',
            default => 'flex items-center justify-center gap-2 rounded-lg transition primary-button',
        };
    }

    public function render()
    {
        return view('components.button');
    }
}