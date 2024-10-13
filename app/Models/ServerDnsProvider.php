<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    description: 'DNS records for a server that shall be set on the DNS provider',
    properties: [
        'server_id' => ['type' => 'integer'],
        'dns_provider_id' => ['type' => 'integer'],
        'dns_record_type' => ['type' => 'string'],
        'dns_record_value' => ['type' => 'string'],
    ],
    type: 'object'
)]

class ServerDnsProvider extends Model
{
    protected $guarded = [];
}
