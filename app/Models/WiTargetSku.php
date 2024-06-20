<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static take(int $int)
 * @method static whereIn(string $string, array $array_column)
 * @method static where(string $string, mixed $new_target_month)
 * @property mixed $custid
 * @property mixed $target_month
 * @property mixed $target_sku_id
 * @property mixed $target_sku_sale
 * @property mixed $createon
 */
class WiTargetSku extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_sku';

    protected $fillable = ['custid','target_month','target_sku_sale','createon'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    public function SkuName (): HasOne{
        return $this->hasOne(MaProduct::class, 'pid', 'target_sku_id');
    }
}
