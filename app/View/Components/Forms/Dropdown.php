<?php

namespace App\View\Components\Forms;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Dropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $label,
        public string $id,
        public iterable $values,
        public string $search = '',
        public string $placeholder = '',
        public string $helper = 'Select...',
        public bool $required = false,
    ) {}

    public function render(): View|Closure|string
    {
        return view('components.forms.dropdown', [
            'placeholder' => $this->placeholder,
            'label' => $this->label,
            'id' => $this->id,
            'helper' => $this->helper,
            'values' => $this->values,
            'search' => $this->search,
            'required' => $this->required,
        ]);
    }
}
