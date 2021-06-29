<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skpk extends Model
{
    use HasFactory;

    protected $table = "skpk";
    protected $guarded = ['id'];

    public $timestamps = false;
}
