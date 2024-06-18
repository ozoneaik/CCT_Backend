<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static take(int $int)
 * @method static where(string $string, $cust_id)
 * @method static find($id)
 * @property mixed $custid
 * @property mixed $trainstart
 * @property mixed $trainend
 * @property mixed $train_desc
 * @property mixed $train_month
 * @property Carbon|mixed $createon
 */
class WiTargetTrain extends Model
{
    use HasFactory;

    protected $connection = 'db_kyc';

    protected $table = 'wi_target_train';

    protected $fillable = ['id','custid','trainstart','trainend','train_desc','train_month'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }
}
