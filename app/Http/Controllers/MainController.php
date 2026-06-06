<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Rewiew;
use Illuminate\Http\Request;

class MainController extends Controller
{

    public function main_get(Request $request){
        $movies = Movie::limit(5)->get();
        return view("main", ["movies" => $movies]);
    }


    public function login_get(Request $request){
        return view("login");
    }


    public function movies_get(Request $request){
        return view("movies", ["movies" => Movie::paginate(8)]);
    }


    public function about_get(Request $request){
        return view("about");
    }


    public function contacts_get(Request $request){
        return view("contacts");
    }


    public function movie_page_get(Request $request){
        $id      =  $request->get("id");
        $movie   =  Movie::find($id);
        $rewiews =  Rewiew::where("id", $id);
        return view("movie_page", ["movie" => $movie, "rewiews" => $rewiews]);
    }


    public function booking_get(Request $request){
 
    }

}