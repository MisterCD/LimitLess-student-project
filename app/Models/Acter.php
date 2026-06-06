<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;
class Acter extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "acter";
    public $timestamps = false;
    protected $guarded = []; 

    public static function rule_name(){
        VALIDATION->add("name", ["required" => "Имя актера обязательно"]);
    }
    public static function rule_movie_id(){
      VALIDATION->add("movie_id", ["required" => "Фильм обязателен", "integer" => "id должен быть числом"]);
    }
    public static function rule_all(){
        self::rule_name();
        self::rule_movie_id();
    }

}