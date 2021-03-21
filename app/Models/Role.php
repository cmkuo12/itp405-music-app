<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'name']; //allow these columns for mass assignment

    public static function getUser() {
        return self::where('slug', '=', 'user')->first(); //self references current class
    }

    public static function getAdmin() {
        return self::where('slug', '=', 'admin')->first(); //self references current class
    }
}
