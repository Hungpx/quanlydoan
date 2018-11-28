<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Baiviet.php';
use Model\Base\ModelMapper;
class BaivietMapper extends ModelMapper{
    const TABLE_NAME = 'baiviet';
    /**
     * 
     * @var $model \Model\Baiviet 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'menuId'         => $model->getMenuId(),
            'mota'           => $model->getMota() ? : null,
            'chitiet'        => $model->getChitiet() ? : null,
            'tieude'         => $model->getTieude() ? : null,
            'anhDaiDien'     => $model->getAnhDaiDien() ? : null,
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
        if (! $model->getMenuId()){
            return false;
        }
        $whereArr = [];
        if ($model->getMenuId()){
            $whereArr[] = 'menuId = "'.$model->getMenuId().'"';
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
        $whereArr = [];
        if ($model->getMenuId()){
            $whereArr[] = 'menuId = "'.$model->getMenuId().'"';
        }
        
        $queryStr = 'select * from '.self::TABLE_NAME;
        if ($whereArr){
            $queryStr .=' WHERE '.implode(' AND ', $whereArr);
        }
        $query = $this->connect->query($queryStr);
        $result = [];$menuIds = [];
        while($row = $query->fetch_assoc()){
            $baiviet = new Baiviet();
            $baiviet->exchangeArray($row);
            $menuIds[$baiviet->getMenuId()] = $baiviet->getMenuId();
            $result[] = $baiviet;
        }
        $menus = [];
        if ($menuIds){
            $queryStr = 'select * from menu WHERE id IN ('.implode(' ,', $menuIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $menus[$row['id']] = $row['tenMenu'];
            }
        }
        foreach ($result as $baiviet){
            if (!empty($menus[$baiviet->getMenuId()])){
                $baiviet->addOption('tenMenu', $menus[$baiviet->getMenuId()]);
            }
        }
        return $result;
    }
}