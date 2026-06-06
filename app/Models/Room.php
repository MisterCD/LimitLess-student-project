<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Room extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "rooms";
    public $timestamps = false;
    protected $guarded = []; 

    public static function rule_name(){
        VALIDATION->add("name", ["required" => "Поле имено обязательно",
                                 "min"      => "Поле должно быть минимум 6 символов",
                                 "max"      => "Поле должно быть максимум 30 символов"],
                                 ["min" => 6,
                                  "max" => 30]);    
    }


    public static function rule_plases(){
      VALIDATION->add("plases", ["required" => "Количество мест обязательно",
                                 "integer" => "Количество мест должно быть числом"]);
    }


    public static function rule_row_plases(){
      VALIDATION->add("row_plases", ["required" => "Количество мест в ряду обязательно",
                                     "integer" => "Количество мест должно быть числом"]);
    }


    public static function rule_type(){
      VALIDATION->add("type", ["required" => "Тип обязателен", "integer" => "Тип должен быть числом"]);
    }
    public static function rule_all(){
        self::rule_name();
        self::rule_plases();
        self::rule_row_plases();
        self::rule_type();
    }

}