<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static take(int $int)
 * @method static where(string $string, $target_month)
 * @method static find($id)
 * @property mixed $pro_sku
 * @property mixed pro_desc
 * @property mixed pro_month
 * @property mixed custid
 * @property mixed createon
 */
class WiTargetPro extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_pro';

    protected $fillable = ['pro_sku', 'pro_desc', 'pro_month', 'custid','createon'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    public function SkuName (): HasOne{
        return $this->hasOne(MaProduct::class, 'pid', 'pro_sku');
    }
}
