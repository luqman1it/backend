<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable=[
       'name',
       'description',
       'img_url',
       'link',
       'type_id'
        ];

        // public function types(){
        //     return $this->hasMany(Type::class);
        // }
        public function type(){
            return $this->belongsTo(Type::class);
        }
}
