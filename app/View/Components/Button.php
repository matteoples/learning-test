<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public ?string $href;
    public string $variant;
    public ?string $icon;
    public ?string $form;
    public string $type;

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
        $this->form = $form;
        $this->type = $type;
    }

    public function classes(): string

    {
        return match($this->variant) {
            'primary'       => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg transition primary-color',
            'destructive'   => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg transition destructive-color',
            'secondary'     => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg transition secondary-color',
            'inline'        => 'flex items-center justify-center gap-2 px-4 py-2 font-medium inline-color',
            default         => 'flex items-center justify-center gap-2 rounded-lg transition primary-color',
        };
    }

    public function render()
    {
        return view('components.button');
    }
}