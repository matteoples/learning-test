<?php

namespace App\View\Components;

use Illuminate\View\Component;

class InputField extends Component
{
    public string $type;
    public mixed $value;
    public ?string $name;
    public string $mode;

    public bool $isReadonly;

    public function __construct(
        string $type = 'text',
        mixed $value = null,
        ?string $name = null,
        string $mode = 'edit'
    ) {
        $this->type = $type;
        $this->value = $value;
        $this->name = $name;
        $this->mode = $mode;

        $this->isReadonly = $mode === 'readonly';
    }

    public function render()
    {
        return view('components.input-field');
    }
}