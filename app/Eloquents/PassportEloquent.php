<?php

namespace App\Eloquents;

class PassportEloquent{
    protected $model;
    
    public function __construct(\App\Models\Passport $model) {
        $this->model = $model;
    }
    
    public function all($args = []) {
        $opts = [
            'orderby' => 'price',
            'order' => 'asc'
        ];
        
        $opts = array_merge($opts, $args);
        return $this->model->orderby($opts['orderby'], $opts['order'])->get();
    }
    
    public function show($id, $columns=['*']){
        if(is_null($id)){
            return null;
        }
        return $this->model->find($id, $columns);
    }

}

