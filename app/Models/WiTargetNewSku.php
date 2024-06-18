<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static take(int $int)
 * @method static where(string $string, $cust_id)
 * @method static find($id)
 * @property mixed $custid
 * @property mixed $new_sku
 * @property mixed $new_target_sale
 * @property mixed $new_target_month
 * @property mixed $createon
 */
class WiTargetNewSku extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_newsku';

    protected $fillable = ['custid','new_sku','new_target_sale','new_target_month','createon'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    public function SkuName (): HasOne{
        return $this->hasOne(MaProduct::class, 'pid', 'new_sku');
    }
}
