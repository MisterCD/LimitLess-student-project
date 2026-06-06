<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;
class Genre extends Model
{
    use HasFactory;
    use ValidationMethods;

    protected $table = "genre";
    public $timestamps = false;
    protected $guarded = []; 

    public static function rule_name(){
        VALIDATION->add("name", ["required" => "Имя жанра обязательно",
                                 "min"      => "Минимум 6 символов",
                                 "max"      => "Максимум 30 символов"], ["min" => 6, "max" => 30]);
    }

}