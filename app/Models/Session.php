<?php

namespace App\Models;

use App\Library\ValidationMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    use ValidationMethods;
    
    protected $table = "sessions";
    public $timestamps = false;
    protected $guarded = []; 
    
}
