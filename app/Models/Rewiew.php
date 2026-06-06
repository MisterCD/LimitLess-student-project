<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Rewiew extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "rewiews";
    public $timestamps = false;
    protected $guarded = []; 

    public static function rule_description(){
      VALIDATION->add("description", ["required" => "Имя описания обязательно", 
                                      "max"      => "Максимум 200 символов"],
                                     ["max"     => 200]);
    }


    public static function rule_stars(){
      VALIDATION->add("stars", ["required"  => "Звезды обязательны", 
                                "integer"   => "Звезды должны быть чилсом",
                                "min"       => "Должна быть минимум 1 звезда",
                                "max"       => "Должны быть максимум 5 звезд"],
                                ["min" => 1, "max" => 5]);
    }
    public static function rule_all(){
        self::rule_description();
        self::rule_stars();
        self::rule_movie_id();
    }


    public static function rule_movie_id(){
      VALIDATION->add("movie_id", ["required" => "Фильм обязателен", 
                                   "integer" => "id должен быть числом"]);
    }

}