<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Icon extends Component
{
    public string $name;
    public ?string $color;

    /**
     * @param string $name Nome dell'icona (corrispondente al file Blade in components/icons)
     * @param string|null $color Classe Tailwind o valore CSS (opzionale)
     */
    public function __construct(string $name, ?string $color = null)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function render()
    {
        if (!View::exists("components.icons.{$this->name}")) {
            return null;
        }

        return view("components.icons.{$this->name}");
    }
}