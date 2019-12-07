<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LOBS extends Model
{
    //
    protected $connection= 'mysql';
//    protected $guarded = [] ;
    protected $table = 'lobs';
    protected $fillable = ['Lob_name','Description','Image', 'created_at', 'updated_at'];
    public $timestamps = false ;

}
