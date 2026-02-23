<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Enums\FontWeight;

class Label extends Component
{
    public ?string $color;
    public FontWeight $weight;

    public function __construct(
        string $color = null,
        FontWeight $weight = FontWeight::Normal
    ) {
        $this->color = $color ?? "var(--secondary-text)";
        $this->weight = $weight;
    }

    public function render()
    {
        return view('components.label');
    }
}
