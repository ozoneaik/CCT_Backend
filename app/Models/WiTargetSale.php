<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static take(int $int)
 * @property mixed $custid
 * @property mixed $target_sale
 * @property mixed $target_month
 * @property mixed $createon
 */
class WiTargetSale extends Model
{
    use HasFactory;

    /**
     * @var array|mixed
     */

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_sale';

    protected $fillable = ['cust_id','target_month','target_sale'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
