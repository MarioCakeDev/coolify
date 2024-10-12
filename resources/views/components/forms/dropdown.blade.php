<div class="w-full" x-data="{
                        open: false,
                        search: '{{ $search }}',
                        dropdownValues: @js($values),
                        placeholder: '{{$placeholder}}',
                        init() {
                            this.$watch('search', value => {
                                if (value === '') {
                                    this.open = true;
                                }
                            })
                        }
                    }">
    <div class="flex gap-1 items-center mb-1 text-sm font-medium">
        <label for="{{ $id }}">{{ $label }}</label>
        @if ($required)
            <x-highlighted text="*" />
        @endif
        @if ($helper)
            <x-helper class="ml-2" :helper="$helper" />
        @endif
    </div>
    <div class="relative">
        <div class="inline-flex relative items-center w-64">
            <input autocomplete="off" wire:dirty.class.remove='dark:focus:ring-coolgray-300 dark:ring-coolgray-300'
                   wire:dirty.class="dark:focus:ring-warning dark:ring-warning" x-model="search"
                   @focus="open = true" @click.away="open = false" @input="open = true" class="w-full input"
                   placeholder="{{ $placeholder }}">
            <input hidden="true" wire:model.debounce.300ms="{{ $id }}">
            <svg class="absolute right-0 mr-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                 viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" @click="open = true">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"/>
            </svg>
        </div>
        <div x-show="open"
             class="overflow-auto overflow-x-hidden absolute z-50 mt-1 w-64 max-h-60 bg-white rounded-md border shadow-lg dark:bg-coolgray-100 dark:border-coolgray-200 scrollbar">
            <template
                x-for="value in values.filter(val => val.name.toLowerCase().includes(search.toLowerCase()))"
                :key="value.name">
                <div @click="search = value.name; open = false; $wire.set('{{ $id }}', value.id)"
                     class="px-4 py-2 text-gray-800 cursor-pointer hover:bg-gray-100 dark:hover:bg-coolgray-300 dark:text-gray-200"
                     x-text="value.name"></div>
            </template>
        </div>
    </div>
</div>
