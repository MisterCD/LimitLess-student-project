<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Rewiew;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;



    


class UserController extends Controller
{
    private function notAuth(){
        return empty(session("user_id"));
    }

    public function login_post(Request $request){
        User::rule_email();
        User::rule_password();
        $result = User::validate();
        if(User::where("email", $result["email"])->exists()){
            $user = User::where("email", $request["email"])->first();
            if(Hash::check($result["password"], $user->password)){
                session(["user_id" => $user->id, "role" => $user->role_id]);
                return redirect()->route("user");
            }else{
                return back()->withErrors("Неверный пароль");
            }
        }else{
            return back()->withErrors("Такого пользователя не существует");
        }
    }


    public function logout_post(Request $request){
        session()->forget("user_id");
        session()->forget("role");
        return redirect()->route("login");
    }


    public function changeUser_post(Request $request){
       if($this->notAuth()){
            return redirect()->route("login");
       }
       if($request->has("password")){
            User::rule_password_old();
            User::rule_password();
            $result = User::validate();
            $id = session("user_id");
            $user = User::find($id)->select("password")->get();
            if(Hash::check($result["password"], $user->password)){
                User::find($id)->update(["password" => $result["password"]]);
            }else{
                return back()->withErrors("Ошибка неверный пароль");
            }
       }else{
            User::rule_name();
            User::rule_email();
            User::rule_telefon();
            $result = User::validate();
            $id = $request->get("id");
            User::where("id", $id)->update($result);
       }
       return back();
    }


    public function deleteUser_post(Request $request){
        if($this->notAuth()){
            return redirect()->route("login");
        }
        $id = $request->get("id");
        User::delete($id);
        return redirect()->route("login");
    }


    public function createUser_post(Request $request){
        User::rule_all();
        $result = User::validate();
        $result["password"] = Hash::make($result["password"]);
        User::insert($result);
        $id = User::where("email", $result["email"])->select("id")->get();
        session(["user_id" => $id, "role" => 0]);
        return redirect()->route("user");
    }


    public function createBooking_post(Request $request){
        if($this->notAuth()){
            return redirect()->route("login");
        }
        Booking::rule_all();
        $booking = Booking::validate();
        $booking["user_id"] = session("user_id");
        if(Booking::where("session_id", $booking["session_id"])->where("plase_id", $booking["plase_id"])->exists()){
            return back()->withErrors("Это место уже занято");
        }else{
            Booking::insert($booking);
        }
        return redirect()->route("user");
    }
    


    public function deleteRewiew_post(Request $request){
        if($this->notAuth()){
            return redirect()->route("login");
        }
        $id = $request->get("id");
        $rewiew = Rewiew::find($id);
        if($rewiew->user_id == session("user_id")){
            Rewiew::delete($id);
        }else{
            return back()->withErrors("Вы не являетесь владельцем этого отзыва");
        }    
        return back();
    }


    public function createRewiew_post(Request $request){
        if($this->notAuth()){
            return redirect()->route("login");
        }
        Rewiew::rule_all();
        $result = Rewiew::validate();
        $result["user_id"] = session("user_id");
        $result["status"] = 0;
        Rewiew::insert($result);
        return back();
    }


    public function user_get(Request $request){
        if($this->notAuth()){
            return redirect()->route("login");
        }
        $user = User::find(session("user_id"));
        return view("user", ["user" => $user]);
    }


    public function register_get(Request $request){
        return view("register");
    }

}