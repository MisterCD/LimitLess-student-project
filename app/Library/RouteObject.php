<?php
class RouteObject {
    private $classname;
    public string $routePath;
    public string $namesp;
    public function __construct($classname, string $route = "/", $namesp = ""){
        $this->classname = $classname;
        $this->routePath = $route;
        $this->namesp = $namesp;

    }

    public function get(string $route, string $method_get, string $name){
        Route::get($this->routePath.$route, [$this->classname, $method_get."_get"])->name($this->namesp.$name);
    }
    public function get_by_name(string $name){
        Route::get($this->routePath.$name, [$this->classname, $name."_get"])->name($this->namesp.$name);
    }
    public function post_by_name(string $name){
        Route::post($this->routePath.$name, [$this->classname, $name."_post"])->name($this->namesp.$name);
    }

    public function post(string $route, string $method_post, string $name){
        Route::post($this->routePath.$route, [$this->classname, $method_post."_post"])->name($this->namesp.$name);
    }

}
