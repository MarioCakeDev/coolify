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
    ) {
        $this->values = iterator_to_array($this->normalizedValues());
    }

    public function render(): View|Closure|string
    {
        return view('components.forms.dropdown');
    }

    private function normalizedValues(): iterable
    {
        $nameKey = 'name';
        $idKey = 'id';

        foreach ($this->values as $value) {
            if (is_null($value)) {
                continue;
            }

            if (! is_array($value)) {
                yield [
                    $nameKey => $value,
                    $idKey => $value,
                ];

                continue;
            }

            $has_name = array_key_exists($nameKey, $value);
            $has_id = array_key_exists($idKey, $value);
            if ($has_name && ! $has_id) {
                yield [
                    $nameKey => $value[$nameKey],
                    $idKey => $value[$nameKey],
                ];
            }
            if ($has_id && ! $has_name) {
                yield [
                    $nameKey => $value[$idKey],
                    $idKey => $value[$idKey],
                ];
            }
            if ($has_name && $has_id) {
                yield $value;
            }
        }
    }
}
