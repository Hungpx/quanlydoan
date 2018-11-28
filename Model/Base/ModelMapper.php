<?php

namespace Model\Base;
class ModelMapper{
    protected $connect;
    public function __construct($connect) {
        $this->connect = $connect;
    }

    /**
    * @param Model $model
    */
    public function get($model)
    {
        if (! $model->getId()){
            return null;
        }       
        return $model;
    }
    
}