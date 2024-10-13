<?php

namespace App\Livewire\Server\DnsRecord;

use App\Models\DnsProvider;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Throwable;

class Add extends Component
{
    public iterable $dns_providers;

    public string $server_id;

    public string $dns_record_type;

    public string $dns_record_value;

    public string $dns_provider_id;

    public array $dns_record_types;

    private array $dns_record_type_validation_rules;

    public function __construct()
    {
        $this->dns_record_type_validation_rules = [
            'A' => 'ipv4',
            'AAAA' => 'ipv6',
            'CNAME' => function () {
                $value = $this->dns_record_value;
                // Checking if the value is a valid domain/hostname with the FILTER_FLAG_HOSTNAME flag is not enough because it will also allow IPv4 addresses.
                // Checking if the value is not an ipv4 will ensure that the user won't enter an ip at least.
                if (! filter_var($value, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME) ||
                    filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {

                    throw ValidationException::withMessages([
                        'dns_record_value' => 'The dns record value must be a valid domain name.',
                    ]);
                }
            },
        ];

        $this->dns_record_types = array_keys($this->dns_record_type_validation_rules);
    }

    public function mount(): void
    {
        $this->dns_providers = DnsProvider::all()->map(function ($dns_provider) {
            return [
                'id' => $dns_provider->id,
                'name' => $dns_provider->name,
            ];
        });
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.server.dns-record.add');
    }

    protected array $validationAttributes = [
        'dns_record_type' => 'DNS Record Type',
        'dns_record_value' => 'DNS Record Value',
        'dns_provider_id' => 'DNS Provider',
        'server_id' => 'Server',
    ];

    protected array $rules = [
        'dns_record_type' => 'required|string',
        'dns_record_value' => 'required|string',
        'dns_provider_id' => 'required|string',
        'server_id' => 'required|string',
    ];

    public function add_dns_record(): void
    {
        try {
            $input = $this->validate();

            $allowed_dns_record_types = implode(',', array_keys($this->dns_record_type_validation_rules));
            Validator::make($input, [
                'dns_record_type' => "in:$allowed_dns_record_types",
                'dns_record_value' => $this->dns_record_type_validation_rules[$this->dns_record_type],
            ])->validate();

            $new_dns_record = [
                'server_id' => $this->server_id,
                'dns_provider_id' => $this->dns_provider_id,
                'dns_record_type' => $this->dns_record_type,
                'dns_record_value' => $this->dns_record_value,
            ];
            DB::table('server_dns_providers')->insert($new_dns_record);

            $this->dispatch('success', 'DNS record added successfully.');
            $this->dispatch('refresh-dns-records');
        } catch (UniqueConstraintViolationException) {
            $this->dispatch('error', 'DNS record already exists.');
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            handleError($e, $this);
        }
    }
}
