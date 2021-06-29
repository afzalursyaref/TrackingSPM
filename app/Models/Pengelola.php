<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengelola extends Model
{
    use HasFactory;
    protected $table = "pengelola";
    protected $guarded = ["created_at", "updated_at"];

    /**
     * Get the verifikasi that owns the Pengelola
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifikasi(): BelongsTo
    {
        return $this->belongsTo(Verifikasi::class, 'verifikasi_id');
    }

    /**
     * Get all of the detailPengelola for the Pengelola
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function detailPengelola(): HasMany
    {
        return $this->hasMany(DetailPengelola::class, 'pengelola_id', 'id');
    }

    /**
     * Get the bud associated with the Pengelola
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bud(): HasOne
    {
        return $this->hasOne(Bud::class, 'pengelola_id');
    }
}
