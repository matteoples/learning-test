<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public ?string $href;
    public string $variant;
    public ?string $icon;
    public ?string $form;   // 👈 AGGIUNTO
    public string $type;    // 👈 AGGIUNTO

    /**
     * @param string|null $href
     * @param string $variant primary|secondary|inline
     * @param string|null $icon
     * @param string|null $form id del form da collegare
     * @param string $type button|submit|reset
     */
    public function __construct(
        ?string $href = null,
        string $variant = 'primary',
        ?string $icon = null,
        ?string $form = null,
        string $type = 'button'
    ) {
        $this->href = $href;
        $this->variant = $variant;
        $this->icon = $icon;
        $this->form = $form;      // 👈
        $this->type = $type;      // 👈
    }

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