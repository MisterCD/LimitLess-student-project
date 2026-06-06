<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use const App\Library\VALIDATION;



class User extends Model
{
    use HasFactory;
    use ValidationMethods;
    protected $table = "users";
    public $timestamps = false;
    protected $guarded = []; 
    
    public static function rule_name(){
        VALIDATION->add("name",     ["required" => "Поле имени обязательно",
                                             "min"      => "Поле имени должно быть минимум 6 символов",
                                             "max"      => "Поле имени должно быть максимум 30 символов"],
                                            ["min"      => 6, 
                                             "max"      => 30]);
    }
    public static function rule_password(){
        VALIDATION->add("password", ["required" => "Поле пароля обязательно",
                                             "min"      => "Пароль должен быть минимум 6 символов",
                                             "max"      => "Пароль должен быть максимум 50 символов",],
                                             ["min"     => 6,
                                              "max"     => 50]);
    }
    public static function rule_email(){
        VALIDATION->add("email",    ["required" => "Поле почты обязательно",
                                             "regex"    => "Неправильый формат почты"],
                                             ["regex"   => "/.*@.*/"]);
    }
    public static function rule_telefon(){
        VALIDATION->add("telefon",  ["required" => "Поле номера телефона обязательно",
                                             "regex"    => "Неверный формат номера"],
                                             ["regex"   => "/\+7-\([0-9]{3}\)-[0-9]{2}-[0-9]{2}-[0-9]{3}/"]);
    }
    public static function rule_all(){
        self::rule_name();
        self::rule_password();
        self::rule_email();
        self::rule_telefon();
    }
    public static function validate(){
        return VALIDATION->validate_and_clear();
    }

    public static function rule_password_old(){
      VALIDATION->add("password", ["required" => "Поле пароля обязательно",
                                             "min"      => "Пароль должен быть минимум 6 символов",
                                             "max"      => "Пароль должен быть максимум 50 символов",],
                                             ["min"     => 6,
                                              "max"     => 50]);
    }

}