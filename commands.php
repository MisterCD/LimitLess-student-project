<?php



function init(Packfolder $packfolder){
    VERIBLES->set("css_path", "resources/css");
    $packfolder->addCommand("declare:type", function(){
        global $packfolder;
        $type = arg_next();
        VERIBLES->set($type."_path", "./");
        $packfolder->addCommand($type.":path", function(){
            global $type;
            $path = arg_next();
            VERIBLES->set($type."_path", $path);
            exit_if_not_input();
        });
        $packfolder->addCommand($type.":create", function(){
            global $type;
            $name = arg_next();
            $path = VERIBLES->get($type."_path");
            doCommand("cd $path ; ni \"$name.$type\"");
            exit_if_not_input();
        });
        $packfolder->addCommand($type.":clear", function(){
            global $type;
            $name = arg_next();
            $path = VERIBLES->get($type."_path");
            doCommand("cd $path ; rm \"$name.$type\"");
            exit_if_not_input();
        });
        $packfolder->addCommand($type.":dir", function(){
            global $type;
            $path = VERIBLES->get($type."_path");
            $name = arg_next();
            doCommand("cd $path ; mkdir $name");
            exit_if_not_input();
        });    
    });
    $packfolder->addCommand("css:path", function(){
        $path = arg_next();
        VERIBLES->set("css_path", $path);
        exit_if_not_input();
    });
    $packfolder->addCommand("css:create", function(){
        $name = arg_next();
        $path = VERIBLES->get("css_path");
        doCommand("cd $path ; ni \"$name.css\"");
        VERIBLES->set("css_target", $name);
        exit_if_not_input();
    });
    $packfolder->addCommand("css:clear", function(){
        $name = arg_next();
        $path = VERIBLES->get("css_path");
        doCommand("cd $path ; rm \"$name.css\"");
        exit_if_not_input();
    });
    $packfolder->addCommand("css:class", function(){
        $file = VERIBLES->get("css_target");
        $path = VERIBLES->get("css_path");
        $name = arg_next();
        file_put_contents($path."/".$file.".css", PHP_EOL.".$name{\n\n}\n", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("css:target",function(){
        $name = arg_next();
        VERIBLES->set("css_target", $name);
        exit_if_not_input();
    });
    $packfolder->addCommand("css:dir", function(){
        $path = VERIBLES->get("css_path");
        $name = arg_next();
        doCommand("cd $path ; mkdir $name");
        exit_if_not_input();
    });
    VERIBLES->set("js_path", "resources/js");
    $packfolder->addCommand("js:path", function(){
        $path = arg_next();
        VERIBLES->set("js_path", $path);
        exit_if_not_input();
    });
    $packfolder->addCommand("js:create", function(){
        $name = arg_next();
        $path = VERIBLES->get("js_path");
        doCommand("cd $path ; ni \"$name.js\"");
        VERIBLES->set("js_target", $name);
        exit_if_not_input();
    });
    $packfolder->addCommand("js:clear", function(){
        $name = arg_next();
        $path = VERIBLES->get("js_path");
        doCommand("cd $path ; rm \"$name.js\"");
        exit_if_not_input();
    });
    $packfolder->addCommand("js:function", function(){
        $file = VERIBLES->get("js_target");
        $path = VERIBLES->get("js_path");
        $name = arg_next();
        file_put_contents($path."/".$file.".css", PHP_EOL."function $name(){\n\n}\n", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("js:target",function(){
        $name = arg_next();
        VERIBLES->set("js_target", $name);
        exit_if_not_input();
    });
    $packfolder->addCommand("js:dir", function(){
        $path = VERIBLES->get("js_path");
        $name = arg_next();
        doCommand("cd $path ; mkdir $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("controller", function(){
        $name = arg_next()."Controller";
        doCommand("php artisan make:controller $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("route:get", function(){
        $controller = arg_next()."Controller";
        $name = arg_next();
        $route = "/".arg_next();
        file_put_contents("routes/web.php", PHP_EOL."Route::get('$route', [App\Http\Controllers\\{$controller}::class, '{$name}_get'])->name('$name');", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("route:post", function(){
        $controller = arg_next()."Controller";
        $name = arg_next();
        $route = "/".arg_next();
        file_put_contents("routes/web.php", PHP_EOL."Route::post('$route', [App\Http\Controllers\\{$controller}::class, '{$name}_post'])->name('$name');", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("create:post", function(){
        $controller = arg_next();
        $name = arg_next();
        $route = arg_next();
        doCommand("php packfolder route:post $controller $name $route");
        doCommand("php packfolder method:post $controller $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("create:get", function(){
        $controller = arg_next();
        $name = arg_next();
        $route = arg_next();
        doCommand("php packfolder route:get $controller $name $route");
        doCommand("php packfolder method:get $controller $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("method:get", function(){
        $controller = arg_next()."Controller";
        $name = arg_next();
        $filePath = "app/Http/Controllers/$controller.php";
        $file = fopen($filePath, 'r+');

        if ($file) {
             
            fseek($file, -1, SEEK_END);

         
            while (fseek($file, -1, SEEK_CUR) === 0) {
                if (fread($file, 1) === "\n") {
                 
                    ftruncate($file, ftell($file));
                    break;
                }
             
                fseek($file, -1, SEEK_CUR);
            }

            fclose($file);
        }
        file_put_contents($filePath, PHP_EOL."    public function {$name}_get(Request \$request){\n \n    }\n", FILE_APPEND);
        file_put_contents($filePath, PHP_EOL."}", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("method:post", function(){
        $controller = arg_next()."Controller";
        $name = arg_next();
        $filePath = "app/Http/Controllers/$controller.php";
        $file = fopen($filePath, 'r+');

        if ($file) {
             
            fseek($file, -1, SEEK_END);

         
            while (fseek($file, -1, SEEK_CUR) === 0) {
                if (fread($file, 1) === "\n") {
                 
                    ftruncate($file, ftell($file));
                    break;
                }
             
                fseek($file, -1, SEEK_CUR);
            }

            fclose($file);
        }
        file_put_contents($filePath, PHP_EOL."    public function {$name}_post(Request \$request){\n \n    }\n", FILE_APPEND);
        file_put_contents($filePath, PHP_EOL."}", FILE_APPEND);
        exit_if_not_input();
    });
    $packfolder->addCommand("read", function(){
        readPackCommands("./pack.txt");
    });
    $packfolder->addCommand("print", function(){
        $name = arg_next();
        if(VERIBLES->check($name)){
            $var = VERIBLES->get($name);
            print $var;
        }
        exit_if_not_input();
    });
    VERIBLES->set("view_path", "resources/views");
    $packfolder->addCommand("view:path", function(){
        $path = arg_next();
        VERIBLES->set("view_path", $path);
        exit_if_not_input();
    });
    $packfolder->addCommand("view:create", function(){
        $name = arg_next();
        $path = VERIBLES->get("view_path");
        doCommand("cd $path ; ni \"$name.blade.php\"");
        exit_if_not_input();
    });
    $packfolder->addCommand("view:clear", function(){
        $name = arg_next();
        $path = VERIBLES->get("view_path");
        doCommand("cd $path ; rm \"$name.blade.php\"");
        exit_if_not_input();
    });
    $packfolder->addCommand("view:dir", function(){
        $path = VERIBLES->get("view_path");
        $name = arg_next();
        doCommand("cd $path ; mkdir $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("dir", function(){
        $path = arg_next();
        $name = arg_next();
        doCommand("cd \"$path\" ; mkdir $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("component", function(){
        $name = arg_next();
        doCommand("php artisan make:component $name");
    });
    $packfolder->addCommand("model", function(){
        $name = arg_next();
        doCommand("php artisan make:model $name");
        exit_if_not_input();
    });
    $packfolder->addCommand("migration", function(){
        $name = arg_next();
        doCommand("php artisan make:migration create{$name}_table");
        exit_if_not_input();
    });
    $packfolder->addCommand("input", function(){
        while($values != "exit"){
            $values = readline("Введине команды: ");
            read($values);
        }
    });
    $packfolder->addCommand("exit", function(){
        exit();
    });
    $packfolder->addCommand("clear:dir", function(){
        $path = arg_next()."/*";
        doCommand("Remove-Item -Path \"$path\" -Recurse -Force");
        exit_if_not_input();
    });
    $packfolder->addCommand("clear:project", function(){
        doCommand("Remove-Item -Path \"resources/css/*\" -Recurse -Force");
        doCommand("Remove-Item -Path \"resources/js/*\" -Recurse -Force");
        doCommand("Remove-Item -Path \"resources/views/*\" -Recurse -Force");
        doCommand("Remove-Item -Path \"app/Http/Controllers/*\" -Recurse -Force");
        doCommand("Remove-Item -Path \"app/Models/*\" -Recurse -Force");
        doCommand("Remove-Item -Path \"database/migrations/*\" -Recurse -Force");
        exit_if_not_input();
    });
    $packfolder->addCommand("rule", function(){
        $model = arg_next();
        $name = arg_next();
        $filePath = "app/Models/$model.php";
        $file = fopen($filePath, 'r+');

        if ($file) {
             
            fseek($file, -1, SEEK_END);

         
            while (fseek($file, -1, SEEK_CUR) === 0) {
                if (fread($file, 1) === "\n") {
                 
                    ftruncate($file, ftell($file));
                    break;
                }
             
                fseek($file, -1, SEEK_CUR);
            }

            fclose($file);
        }
        file_put_contents($filePath, PHP_EOL."    public static function rule_{$name}(){\n      VALIDATION->add(\"{$name}\", [\"required\" => \"\"]);\n    }\n", FILE_APPEND);
        file_put_contents($filePath, PHP_EOL."}", FILE_APPEND);
        exit_if_not_input();
    });
    
}