<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'value']; //allow these columns for mass assignment

    public static function setMode($configMode, $isOn) {
        $mode = self::where('name', '=', $configMode)->first();
        if ($isOn === null) {
            $isOn = false;
        } else {
            $isOn = true;
        }
        $mode->value = $isOn;
        $mode->save();
    }

    public static function getModeIsOn($configMode) {
        $mode = self::where('name', '=', $configMode)->first();
        return $mode->value;
    }
}
