<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPengelola extends Model
{
    use HasFactory;

    protected $table = "d_pengelola";
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the pengelola that owns the DetailPengelola
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pengelola(): BelongsTo
    {
        return $this->belongsTo(Pengelola::class, 'pengelola_id');
    }
}
