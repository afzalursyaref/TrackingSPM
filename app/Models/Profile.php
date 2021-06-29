<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use function PHPUnit\Framework\isNull;

class Profile extends Model
{
    use HasFactory;

    protected $table = "profile";
    protected $guarded = ['created_at', 'updated_at'];

    /**
     * Get the user associated with the Profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function setJabatan($value)
    {
        if(isNull($this->jabatan)){
            return '';
        }
    }
}
