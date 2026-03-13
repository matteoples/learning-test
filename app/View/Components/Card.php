<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    public string $classes;

    public function __construct(
        public bool $active = false,
        public bool $clickable = false,
        public string $size = 'medium'
    ) {
        $size = strtolower($size);

        if (!in_array($size, ['small', 'medium', 'large'])) {
            $size = 'medium';
        }

        $sizeMap = [
            'small'  => 'p-3',
            'medium' => 'p-4',
            'large'  => 'p-6',
        ];

        $baseClasses = "{$sizeMap[$size]} rounded-lg border flex flex-col transition duration-200";
        $baseClasses .= " bg-even";

        if ($this->active) {
            $baseClasses .= " bg-accent border-accent";
        }

        if ($this->clickable) {
            $baseClasses .= " cursor-pointer";
        }

        $this->classes = $baseClasses;
    }

    public function render(): View|Closure|string
    {
        return view('components.card');
    }
}
