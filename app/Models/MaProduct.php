<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static take(int $int)
 * @method static select(string $string)
 */
class MaProduct extends Model
{
    use HasFactory;
    protected $connection = 'db_kyc';

    protected $table = "ma_product";

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
