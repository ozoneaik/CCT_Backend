<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static take(int $int)
 * @method static where(string $string, $cust_id)
 * @method static find($id)
 * @method static select(string $string)
 * @method static leftJoin(string $string, string $string1, string $string2, string $string3)
 * @property mixed $startdate
 * @property mixed $enddate
 * @property mixed $custid
 * @property mixed $booth_month
 * @property mixed $createon
 */
class WiTargetBooth extends Model
{
    use HasFactory;
    protected $connection = 'db_kyc';

    protected $table = 'wi_target_booth';

    protected $fillable = ['startdate','enddate','booth_month','custid'];

    public $timestamps = false;

    protected static function boot() : void
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'asc');
        });
    }

    public function GetBoothSku (): HasMany
    {
        return $this->hasMany(WiTargetBoothSku::class, 'id_targetbooth', 'id');
    }


}
