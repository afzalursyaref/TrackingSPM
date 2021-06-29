<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bud extends Model
{
    use HasFactory;

    protected $table = "bud";
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the pengelola associated with the Bud
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pengelola(): HasOne
    {
        return $this->hasOne(Pengelola::class, 'id', 'pengelola_id');
    }

    /**
     * Get all of the detailBud for the Bud
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailBud(): HasMany
    {
        return $this->hasMany(DetailBud::class, 'bud_id', 'id');
    }
}
