<?php
namespace App\Http\Traits;

trait countTrait {

    public function Count($model){
        $count=$model::count();
        return $count;

    }

}
