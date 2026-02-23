<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Enums\FontWeight;

class Title extends Component
{
    public ?string $color;
    public FontWeight $weight;

    public function __construct(
        string $color = null,
        FontWeight $weight = FontWeight::Semibold
    ) {
        $this->color = $color ?? "var(--primary-text)";
        $this->weight = $weight;
    }

    public function render()
    {
        return view('components.title');
    }
}


/*

<x--title color="var(--primary-text)" :weight="FW::Bold"> 
    Titolo Grande
</x--title>

*/