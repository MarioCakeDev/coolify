<form class="flex flex-col w-full gap-2 rounded" wire:submit='submit'>
    <div class="flex flex-wrap gap-4 sm:flex-nowrap">
        <x-forms.input id="server.settings.dns_records"
                       label="DNS Records Type"
                       required
                       helper="You can specify the type of DNS records to be set (e.g. A, AAAA, CNAME)."
        />
        <x-forms.input id="server.settings.dns_records_value"
                       label="DNS Records Value"
                       required
                       helper="You can specify the value of the DNS records to be set."
        />

        <x-forms.dropdown
            id="server.settings.dns_provider_id"
            label="DNS Provider"
            helper="DNS Provider which should be used to set DNS records."
            placeholder="Select DNS Provider"
            required
            :values="$dns_providers"
        />
    </div>

</form>
