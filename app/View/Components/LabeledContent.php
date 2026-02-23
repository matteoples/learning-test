<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LabeledContent extends Component
{
    public string $label;
    public string $value;
    public string $direction;

    /**
     * @param string $label
     * @param string $value
     * @param string $direction 'row' o 'column'
     */
    public function __construct(string $label = '', string $value = '', string $direction = 'column')
    {
        $this->label = $label;
        $this->value = $value;
        $this->direction = $direction;
    }

    public function containerClasses(): string
    {
        return $this->direction === 'column'
            ? 'flex flex-col items-start gap-1 w-full'
            : 'flex flex-row justify-between items-center w-full';
    }

    public function render(): View|Closure|string
    {
        return view('components.labeled-content');
    }
}