<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'code', 'expires_at'];
    public $timestamps = true;

}
