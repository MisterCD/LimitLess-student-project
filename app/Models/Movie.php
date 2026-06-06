<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Movie extends Model
{
    use HasFactory;
    use ValidationMethods;
    
    protected $table = "movies";
    public $timestamps = false;
    protected $guarded = []; 

    public static function rule_name(){
        VALIDATION->add("name", ["required" => "Поле имени обязательно",
                                 "min"      => "Имя должно бть больше 6 символов",
                                 "max"      => "Имя должно быть меньше 50 символов"],
                                ["min" => 6,"max" => 50]);
    }
    public static function rule_year(){
        VALIDATION->add("year", ["integer"  => "Поле года должно быть числом",
                                 "required" => "Поле года обязательно"]);
    }
    public static function rule_description(){
        VALIDATION->add("description", ["required" => "Поле с описанием обязательно",
                                        "max"      => "Поле с описанием может быть максимум 200 символов"],
                                       ["max"      => 200]);
    }
    public static function rule_image(){
        VALIDATION->add("title_image", ["required" => "Файл обложки обязателен", 
                                        "image"    => "неверный формат изображения"],
                                       ["image"    => "png:jpeg"]);
    }
    public static function rule_author(){
        VALIDATION->add("author", ["required" => "Поле автора обязательно",
                                   "min"      => "Поле автора должно быть минимум 6 символов",
                                   "max"      => "Поле автора должно быть максимум 30 символов"],
                                   ["min" => 6, "max" => 30]);
    }
    public static function rule_all(){
        self::rule_name();
        self::rule_author();
        self::rule_year();
        self::rule_description();
        self::rule_image();
        self::rule_genre();
    }
    
    

    public static function rule_genre(){
      VALIDATION->add("genre_id", ["required" => "Поле жанра обязательно", 
                                "integer" => "Жанр должен быть числом id"]);
    }

}