<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static take(int $int)
 * @method static where(string $string, $id)
 * @property mixed $id_targetbooth
 * @property mixed $skucode
 * @property mixed $skuqty
 * @property Carbon|mixed $createon
 */
class WiTargetBoothSku extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_booth_sku';

    protected $fillable = ['id_targetbooth','skucode','skuqty'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    public function GetNameSku (){
        return $this->belongsTo(MaProduct::class,'skucode','pid')->select('pid', 'pname');
    }
}
