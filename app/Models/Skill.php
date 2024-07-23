<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable=[
        'name','image'
    ];
    protected $hidden=[
        'pivot'
    ];
    public function projects()
    {
       return $this->beLongsToMany(Project::class,'project_skill');
    }
}
