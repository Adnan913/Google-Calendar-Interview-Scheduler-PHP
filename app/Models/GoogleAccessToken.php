<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleAccessToken extends Model
{
    use HasFactory;
    protected $fillable = ['employer_id','employer_email','access_token','refresh_token','token_type','expires_in','created','is_expired'];
}
