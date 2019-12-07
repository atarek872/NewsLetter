<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    //
    protected $connection= 'mysql';
//    protected $guarded = [] ;
    protected $table = 'news';
    protected $fillable = ['Header', 'body', 'Lob_id', 'created_at', 'updated_at'];
    public $timestamps = false ;

}
