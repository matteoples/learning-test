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
    public bool $iconOnly;

    public function __construct(
        ?string $href = null,
        string $variant = 'primary',
        ?string $icon = null,
        ?string $form = null,
        string $type = 'button',
        bool $iconOnly = false,
    ) {
        $this->href = $href;
        $this->variant = $variant;
        $this->icon = $icon;
        $this->form = $form;
        $this->type = $type;
        $this->iconOnly = $iconOnly;
    }

    public function classes(): string
    {
        return match($this->variant) {
            'primary'     => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium whitespace-nowrap transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 primary-color',
            'destructive' => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium whitespace-nowrap transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 destructive-color',
            'secondary'   => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium whitespace-nowrap transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 secondary-color',
            'inline'      => 'inline-flex items-center gap-1 font-medium whitespace-nowrap transition hover:underline focus:outline-none inline-color',
            default       => 'flex items-center justify-center gap-2 px-4 py-2 rounded-lg font-medium whitespace-nowrap transition active:scale-95 focus:outline-none focus:ring-2 focus:ring-offset-2 primary-color',
        };
    }

    public function render()
    {
        return view('components.button');
    }
}