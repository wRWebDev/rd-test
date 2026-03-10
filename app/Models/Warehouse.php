<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property string $uuid
 * @property string $name
 * @property string $slug
 * @property string $geo_location
 * @property string $address_1
 * @property string $address_2
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $state_code
 * @property string $country_code
 */
class Warehouse extends Model
{
    /** @use HasFactory<\Database\Factories\WarehouseFactory> */
    use HasFactory;

    use HasUlids;

    /** @var string */
    protected $primaryKey = 'uuid';

    /** @return array<string> */
    public function uniqueIds()
    {
        return [
            'uuid',
        ];
    }
}
