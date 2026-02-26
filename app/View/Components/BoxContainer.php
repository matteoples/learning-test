<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BoxContainer extends Component
{
    public string $size;
    public string $classes;
    public string $style;

    /**
     * @param string $size small|medium|large (default: medium)
     * @param string $direction column|row (default: column)
     */
    public function __construct(string $size = 'medium', string $direction = 'column')
    {
        $size = strtolower($size);

        if (!in_array($size, ['small', 'medium', 'large'])) {
            $size = 'medium';
        }

        $this->size = $size;

        // Imposta padding e gap in base alla size
        $sizeMap = [
            'small'  => ['padding' => 'p-3', 'gap' => 'gap-0'],
            'medium' => ['padding' => 'p-4', 'gap' => 'gap-2'],
            'large'  => ['padding' => 'p-6', 'gap' => 'gap-4'],
        ];

        // Costruisci classi finali
        $this->classes = "{$sizeMap[$size]['padding']} {$sizeMap[$size]['gap']} rounded-lg";
        $this->classes .= " border flex flex-col transition";

        // Stile del bordo
        $this->style = "border-color: var(--box-border);";

    }

    public function render(): View|Closure|string
    {
        return view('components.box-container');
    }
}