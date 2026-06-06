<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Session extends Model
{
    use HasFactory;
    use ValidationMethods;
    
    protected $table = "sessions";
    public $timestamps = false;
    protected $guarded = []; 
    

    public static function rule_room_id(){
      VALIDATION->add("room_id", ["required" => "id комнаты обязательно", "integer" => "id должно быть числом"]);
    }


    public static function rule_movie_id(){
      VALIDATION->add("movie_id", ["required" => "id кино обязательно", "integer" => "id должно быть числом"]);
    }


    public static function rule_date(){
      VALIDATION->add("date", ["required" => "Дата обязательно", "date" => "Поле должно быть датой"], ["date_format" => "Y-m-d"]);
    }


    public static function rule_time(){
      VALIDATION->add("time", ["required" => "Время обязательно"], ["date_format" => "H:i"]);
    }
    public static function rule_all(){
        self::rule_date();
        self::rule_time();
        self::rule_movie_id();
        self::rule_room_id();
    }
    
}