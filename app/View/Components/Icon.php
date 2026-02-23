<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\View;

class Icon extends Component
{
    public string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function render()
    {
        if (!View::exists("components.icons.{$this->name}")) {
            return null;
        }

        return view("components.icons.{$this->name}");
    }
}