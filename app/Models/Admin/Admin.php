<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = "admins";

    protected $fillable = ['username', 'email'];

    protected $hidden = ['password', 'remember_token'];

    protected $guarded = array();

}
