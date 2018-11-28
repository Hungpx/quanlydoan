<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Menu.php';
use Model\Base\ModelMapper;
class MenuMapper extends ModelMapper{
    const TABLE_NAME = 'menu';
    /**
     * 
     * @var $model \Model\Menu 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'tenMenu'     => $model->getTenMenu(),
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
    
    public function fetchAll($model){
        $queryStr = 'select * from '.self::TABLE_NAME.' ORDER BY id ASC';
        $query = $this->connect->query($queryStr);
        $result = [];
        $menuIds = [];
        while($row = $query->fetch_assoc()){
            $menu = new Menu();
            $menu->exchangeArray($row);
            $result[] = $menu;
            $menuIds[$menu->getId()] = $menu->getId();
        }
        $totalBaiviet = [];
        if ($menuIds){
            $queryStr = 'select menuId, COUNT(bv.id) as totalBaiviet from baiviet as bv WHERE menuId IN ('.implode(' ,', $menuIds).') AND menuId is NOT NULL';
            $queryStr .= ' GROUP BY menuId';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $totalBaiviet[$row['menuId']] = $row['totalBaiviet'];
            }
        }
        foreach ($result as $menu){
            if (!empty($totalBaiviet[$menu->getId()])){
                $menu->addOption('totalBaiviet', $totalBaiviet[$menu->getId()]);
            }
        }
        return $result;
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
    
    public function isExist($model){
        if (! $model->getTenMenu()){
            return false;
        }
        $whereArr = [];
        if ($model->getTenMenu()){
            $whereArr[] = 'tenMenu = "'.$model->getTenMenu().'"';
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
}