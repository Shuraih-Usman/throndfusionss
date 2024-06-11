<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Admin extends Authenticatable
{
    use HasFactory;




    public static function current()
    {
        return Auth::guard('admin')->user();
    }
}
