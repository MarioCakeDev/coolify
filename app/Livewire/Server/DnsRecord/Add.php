<?php

namespace App\Livewire\Server\DnsRecord;

use App\Models\DnsProvider;
use Livewire\Component;

class Add extends Component
{
    public $dns_providers;

    public function mount()
    {
        $this->dns_providers = DnsProvider::all()->map(function ($dns_provider) {
            return [
                'id' => $dns_provider->id,
                'name' => $dns_provider->name,
            ];
        });
    }

    public function render()
    {
        return view('livewire.server.dns-record.add', [
            'dns_providers' => $this->dns_providers,
        ]);
    }
}
