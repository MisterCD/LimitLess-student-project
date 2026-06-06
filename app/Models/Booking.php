<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;

class Booking extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "bookings";
    public $timestamps = false;
    protected $guarded = [];
     

    public static function rule_session_id(){
      VALIDATION->add("session_id", ["required" => "Сианс обязателен",
                                     "integer" => "Сианс должен быть числом"]);
    }


    public static function rule_plase_id(){
      VALIDATION->add("plase_id", ["required" => "Место обязательно", 
                                   "integer" => "Место должно быть числом"]);
    }
    public static function rule_all(){
        self::rule_session_id();
        self::rule_plase_id();
    }

}