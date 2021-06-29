<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Verifikasi extends Model
{
    use HasFactory;

    protected $table = "verifikasi";
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the Agenda associated with the Verifikasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Agenda(): BelongsTo
    {
        return $this->belongsTo(Agenda::class);
    }

    /**
     * Get the pengelola associated with the Verifikasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function pengelola(): HasOne
    {
        return $this->hasOne(Pengelola::class, 'verifikasi_id', 'id');
    }

    /**
     * Get the disposisi_user associated with the Verifikasi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function disposisi_user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'disposisi_user_id');
    }
}
