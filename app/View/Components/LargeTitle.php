<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Enums\FontWeight;

class LargeTitle extends Component
{
    public ?string $color;
    public FontWeight $weight;

    public function __construct(
        string $color = null,
        FontWeight $weight = FontWeight::Bold
    ) {
        $this->color = $color ?? "var(--primary-text)";
        $this->weight = $weight;
    }

    public function render()
    {
        return view('components.large-title');
    }
}


/*

<x-large-title color="var(--primary-text)" :weight="FW::Bold"> 
    Titolo
</x-large-title>
*/