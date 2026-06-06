<?php

namespace App\Http\Controllers;

use App\Models\Acter;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Rewiew;
use App\Models\Room;
use App\Models\Session;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;



class AdminController extends Controller
{
    private function notAdmin(){
        return session("role") == 0;
    }
    
    public function createMovie_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        Movie::rule_all();
        $result = Movie::validate();
        $result["stars"] = 0;
        $image = $request->file("title_image");
        if (!$request->hasFile('title_image') || !$request->file('title_image')->isValid()) {
            return back()->withErrors("Файл обложки не выбран или загружен с ошибкой (проверьте размер файла).");
        }
        try{
            $path = $image->store("movies", "public");
            $result["title_image"] = $path;
            Movie::insert($result);
            return redirect()->route("admin_movies");
        }catch (\Throwable $e){
            return back()->withErrors("Не удалось создать фильм:".$e->getMessage());
        }
    }


    public function changeMovie_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        Movie::rule_name();
        Movie::rule_author();
        Movie::rule_year();
        Movie::rule_description();
        $id = $request->get("id");
        if($request->hasFile("title_image")){
            Movie::rule_image();
            $result = Movie::validate();
            $oldPath = Movie::where("id", $id)->select("title_image")->first();
            Storage::disk("public")->delete($oldPath);
            $image = $request->file("title_image");
            $path  = $image->store("movies", "public");
            $result["title_image"] = $path;
            Movie::where("id", $id)->update($result);
        }else{
            $result = Movie::validate();
            Movie::where("id", $id)->update($result);
        }
        return redirect()->route("admin_movies");
    }


    public function deleteMovie_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Movie::delete($id);
        return back();
    }


    public function admin_users_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $users = User::paginate(6);
        return view("admin.users", ["users" => $users]);
    }


    public function admin_rewiews_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $rewiews = Rewiew::paginate(6);
        return view("admin.rewiews", ["rewiews" => $rewiews]);
    }


    public function admin_rooms_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $rooms = Room::paginate(4);
        return view("admin.rooms", ["rooms" => $rooms]);
    }


    public function addRoom_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        Room::rule_all();
        $rooms = Room::validate();
        Room::insert($rooms);
        return redirect()->route("admin_rooms");
    }

    public function admin_movies_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $moves = Movie::join("genre", "movies.genre_id", "=", "genre.id")->select("movies.*", "genre.name as genre_name")->paginate(6);
        return view("admin.movies", ["movies" => $moves]);
    }


    public function deleteUser_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        User::delete($id);
        return back();
    }


    public function changeUser_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        $role = $request->get("role");
        User::where("id", $id)->update(["role_id" => $role]);
        return back();
    }


    public function createMoviePage_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $genres = Genre::all();
        return view("admin.create_movie", ["genres" => $genres]);
    }


    public function createActor_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        Acter::rule_all();
        $result = Acter::validate();
        Acter::insert($result);
        return back();
    }
    


    public function createActorPage_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $movies = Movie::all()->select("name", "id");
        return view("admin.create_actor", ["movies" => $movies]);
    }


    public function allowRewiew_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Rewiew::where("id", $id)->update(["status" => 1]);
        return back();
    }


    public function deleteRewiew_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Rewiew::delete($id);
        return back();
    }


    public function cancleRewiew_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Rewiew::where("id", $id)->update(["status" => 2]);
        return back();
    }



    public function deleteRoom_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Room::delete($id);
        return back();
    }


    public function changeRoom_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Room::rule_all();
        $result = Room::validate();
        Room::where("id", $id)->update($result);
        return redirect()->route("admin_rooms");
    }


    public function changeRoomPage_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        $room = Room::find($id);
        return view("admin.changeRoom", ["room" => $room]);
    }


    public function changeMoviePage_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        $movie = Movie::find($id);
        return view("admin.changeMoviePage", ["movie" => $movie]);
    }


    


    public function addRoomPage_get(Request $request){
        $rooms = Room::paginate(6);
        return view("admin.rooms", ["rooms" => $rooms]);
    }


    public function createGenre_post(Request $request){
        Genre::rule_name();
        $result = Genre::validate();
        Genre::insert($result);
        return redirect()->route("genres");
    }


    public function genres_get(Request $request){
        $genres = Genre::all();
        return view("admin.genres", ["genres" => $genres]);
    }


    public function deleteGenre_post(Request $request){
        $id = $request->get("id");
        Genre::delete($id);
        return back();
    }


    public function createSession_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        Session::rule_all();
        $result = Session::validate();
        Session::insert($result);
        return back();
    }


    public function deleteSession_post(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $id = $request->get("id");
        Session::delete($id);
        return back();
    }


    public function createSessionPage_get(Request $request){
        if($this->notAdmin()){
            return redirect()->route("main");
        }
        $movies = Movie::all();
        $rooms = Room::all();
        $sessions = Session::join("movies", "sessions.movie_id", "=", "movies.id")->join("rooms", "sessions.room_id", "=", "rooms.id")->select("movies.name as movie_name", "sessions.*", "rooms.name as room_name")->paginate(6);
        return view("admin.create_session", ["movies" => $movies, "rooms" => $rooms, "sessions" => $sessions]);
    }

}