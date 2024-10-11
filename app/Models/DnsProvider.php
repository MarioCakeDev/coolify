<?php

namespace App\Models;

use OpenApi\Attributes as OA;
use Spatie\SchemalessAttributes\SchemalessAttributesTrait;

#[OA\Schema(
    description: 'Server model',
    properties: [
        'id' => ['type' => 'integer'],
        'name' => ['type' => 'string'],
        'description' => ['type' => 'string'],
        'config' => new OA\Schema(
            description: 'DNS Provider configuration',
            type: 'object',
            additionalProperties: true
        ),
    ],
    type: 'object'
)]

class DnsProvider extends BaseModel
{
    use SchemalessAttributesTrait;
}
