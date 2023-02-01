<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory;
    // protected $fillable = [
    //     'name',
    // ];

    public static function allTags(){
        return
            'Laravel,PHP,VueJS,Fullstack,API,TailwindCSS,JavaScript,Backend,Git,AWS,TALL Stack,Frontend,Engineer,Craft CMS,Lead,Livewire,MySQL,React,Senior,SQL,AlpineJS';
    }
}
