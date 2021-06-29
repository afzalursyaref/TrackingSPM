<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agenda extends Model
{
    use HasFactory;

    protected $table = "agenda";
    protected $guarded = ['id', 'created_at', 'updated_at'];
    
    protected $casts = [
        'tgl_agenda' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the Skpk associated with the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Skpk(): HasOne
    {
        return $this->hasOne(Skpk::class, 'id', 'skpk_id');
    }

    /**
     * Get the verifikasi that owns the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function verifikasi(): HasOne
    {
        return $this->hasOne(Verifikasi::class, 'agenda_id');
    }

    /**
     * Get the disposisi associated with the Agenda
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function disposisi_user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'disposisi_user_id');
    }
}
