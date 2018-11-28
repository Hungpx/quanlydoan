<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Chude.php';
use Model\Base\ModelMapper;
class ChudeMapper extends ModelMapper{
    const TABLE_NAME = 'chude';
    /**
     * 
     * @var $model \Model\Chude 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'maChude'      => $model->getMaChude(),
            'tenChude'     => $model->getTenChude(),
        ];
        if (! $model->getId()){
            $valueUpdate = [];
            foreach ($data as $value){
                $valueUpdate[] = '"'.$value.'"';
            }
          $fieldArr = array_keys($data);
          $queryStr = 'INSERT INTO '.self::TABLE_NAME.' ('. implode(', ', $fieldArr).')'.' VALUES ('.implode(',', $valueUpdate).')';
          $query = $this->connect->query($queryStr);
          if ($this->connect->affected_rows == 1){
              $model->exchangeArray($data);
              $model->setId($this->connect->insert_id);
              return $model;
          }
          return false;
        }else{
            $valueUpdate = [];
            foreach ($data as $field => $value){
                $valueUpdate[] = $field .' = "'.$value.'"';
            }
            $queryStr = 'UPDATE '.self::TABLE_NAME.' SET '.implode(', ', $valueUpdate).' WHERE id='.$model->getId();
            $query = $this->connect->query($queryStr);
            return $model;
        }
    }
    public function get($model){
        if (! $model->getId()){
            return null;
        }
        $queryStr = 'select * from '.self::TABLE_NAME.' where id = '.$model->getId();
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return $model;
        }
        return null;
    }  
    
    public function isExist($model){
        if (! $model->getMaChude() && ! $model->getTenChude()){
            return false;
        }
        $whereArr = [];
        if ($model->getMaChude()){
            $whereArr[] = 'maChude = "'.$model->getMaChude().'"';
        }
        if ($model->getTenChude()){
            $whereArr[] = 'tenChude = "'.$model->getTenChude().'"';
        }
        if ($model->getId()){
            $whereArr[] = 'id <> '.$model->getId();
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' WHERE '.implode(' AND ', $whereArr);
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return true;
        }
        return false;
    }
    
    public function delete($model){
        if (! $model->getId()){
            return false;
        }
        $queryStr = 'DELETE from '.self::TABLE_NAME.' where id = '.$model->getId();
        $query = $this->connect->query($queryStr);
        if ($this->connect->affected_rows == 1){
            return true;
        }
        return false;
    }
    
    public function fetchAll($model){
        $queryStr = 'select * from '.self::TABLE_NAME;
        $query = $this->connect->query($queryStr);
        $result = [];
        while($row = $query->fetch_assoc()){
            $chude = new Chude();
            $chude->exchangeArray($row);
            $result[] = $chude;
        }
        return $result;
    }
}