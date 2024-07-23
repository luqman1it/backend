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

protected $hidden=[
    'pivot'
];



        public function type(){

            return $this->belongsTo(Type::class);
        }
        //many to many
        public function skills()
        {
           return $this->beLongsToMany(Skill::class,'project_skill');
        }

}
