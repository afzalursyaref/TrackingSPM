<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailBud extends Model
{
    use HasFactory;

    protected $table = "d_bud";
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the bud that owns the DetailBud
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bud(): BelongsTo
    {
        return $this->belongsTo(Bud::class, 'bud_id');
    }
}
