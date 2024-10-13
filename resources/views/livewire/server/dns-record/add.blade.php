<div class="flex flex-col w-full gap-2 rounded">
    <div class="flex gap-4 flex-wrap md:flex-nowrap">
        <x-forms.dropdown
            id="dns_record_type"
            label="DNS Records Type"
            helper="You can specify the type of DNS records to be set."
            placeholder="Select DNS Record Type"
            required
            :values="$dns_record_types"
        />

        <x-forms.input id="dns_record_value"
                       label="DNS Records Value"
                       required
                       placeholder="Enter DNS record Value"
                       helper="You can specify the value of the DNS records to be set.<br/>If DNS record type A is selected, you must specify a valid IPv4 address.<br/>If DNS record type AAAA is selected, you must specify a valid IPv6 address.<br/>If DNS record type CNAME is selected, you must specify a valid domain name."
        />

        <x-forms.dropdown
            id="dns_provider_id"
            label="DNS Provider"
            helper="DNS Provider which should be used to set DNS records."
            placeholder="Select DNS Provider"
            required
            :values="$dns_providers"
        />

        <x-forms.input id="server_id"
                       hidden
                       value="{{ $server_id }}" />
    </div>
    <div class="flex gap-2 items-center pt-4 pb-2 justify-end">
        <x-forms.button
            label="Add DNS Record"
            wire:click="add_dns_record('{{ $server_id }}', '{{ $dns_provider_id }}', '{{ $dns_record_type }}', '{{ $dns_record_value }}')"
            type="button">Add DNS Record</x-forms.button>
    </div>
</div>
