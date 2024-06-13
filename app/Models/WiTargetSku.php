<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static take(int $int)
 */
class WiTargetSku extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_sku';

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
