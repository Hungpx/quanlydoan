<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Doan.php';
use Model\Base\ModelMapper;
class DoanMapper extends ModelMapper{
    const TABLE_NAME = 'doan';
    /**
     * 
     * @var $model \Model\Doan 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'maDoan'            => $model->getMaDoan(),
            'tenDoan'           => $model->getTenDoan(),
            'maLoai'            => $model->getMaLoai() ? : null,
            'maChude'           => $model->getMaChude() ? : null,
            'yeucau'            => $model->getYeucau() ? : null,
            'giangvienHD'       => $model->getGiangvienHD() ? : null,
            'namRaDe'           => $model->getNamRaDe() ? : null,
            'soSVThamGia'       => $model->getSoSVThamGia() ? : null,
            'ngayHetHan'        => $model->getNgayHetHan() ? : null,
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
            if ($model->getOption('loadInfor')){
                //Lấy thông tin giảng viên hướng dẫn
                $queryStr = 'select * from giangvien WHERE id = '.$model->getGiangvienHD();
                $query = $this->connect->query($queryStr);
                if($row = $query->fetch_assoc()){
                  $model->addOption('tenGV', $row['tenGV']);
                }
                
                //Lấy thông tin chủ đề
                $queryStr = 'select * from chude WHERE id = '.$model->getMaChude();
                $query = $this->connect->query($queryStr);
                if($row = $query->fetch_assoc()){
                    $model->addOption('tenChude', $row['tenChude']);
                }
                
                //Lấy thông tin loại
                $queryStr = 'select * from loaidoan WHERE id = '.$model->getMaLoai();
                $query = $this->connect->query($queryStr);
                if($row = $query->fetch_assoc()){
                    $model->addOption('tenLoai', $row['tenLoai']);
                }
            }
            if ($model->getOption('loadTotalSV')){
                $queryStr = 'select COUNT(DISTINCT tbl.maSV) as totalSV from sinhvien_thamgia as tbl WHERE maDoan ='.$model->getId();
                $query = $this->connect->query($queryStr);
                if($row = $query->fetch_assoc()){
                    $model->addOption('totalSV', $row['totalSV'] ? : 0);
                }
                
            }
            return $model;
        }
        return null;
    }    
    
    public function search($user){
        $queryStr = 'select * from '.self::TABLE_NAME;
        $query = $this->connect->query($queryStr);
        $result = [];
        while($row = $query->fetch_assoc()){
            $doan = new Doan();
            $doan->exchangeArray($row);
            $result[] = $doan;
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
    
    public function fetchAll($model){
        $whereArr = [];
        if ($model->getGiangvienHD()){
            $whereArr[] = 'giangvienHD = "'.$model->getGiangvienHD().'"';
        }
        if ($model->getOption('tenGV')){
            $whereArr[] = 'gv.tenGV LIKE "%'.$model->getOption('tenGV').'%"';
        }
        if ($model->getOption('status')){
            $today = getCurrentDate();
            if ((int)$model->getOption('status') > 0){
                $whereArr[] = 'da.ngayHetHan >= "'.$today.'"';
            }else{
                $whereArr[] = 'da.ngayHetHan <= "'.$today.'"';
            }
        }
        if ($model->getId()){
            $whereArr[] = 'da.id = '.$model->getId();
        }
        if ($model->getMaChude()){
            $whereArr[] = 'maChude = '.$model->getMaChude();
        }
        if ($model->getMaLoai()){
            $whereArr[] = 'maLoai = '.$model->getMaLoai();
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' as da';
        if ($model->getOption('tenGV')){
            $queryStr .= ' INNER JOIN giangvien as gv ON gv.id = da.giangvienHD';
        }
        if ($whereArr){
            $queryStr .= ' WHERE '.implode(' AND ', $whereArr).' ORDER BY da.id DESC';
        }
        $query = $this->connect->query($queryStr);
        $result = [];
        $loaiDoanIds = []; $chudeIds =[]; $giangvienIds = []; $doanIds = [];
        while($row = $query->fetch_assoc()){
            $doan = new Doan();
            $doan->exchangeArray($row);
            $loaiDoanIds[$doan->getMaLoai()] = $doan->getMaLoai();
            $chudeIds[$doan->getMaChude()] = $doan->getMaChude();
            $giangvienIds[$doan->getGiangvienHD()] = $doan->getGiangvienHD();
            $doanIds[$doan->getId()] = $doan->getId();
            $result[] = $doan;
        }
        $dsLoaiDoan = [];
        if ($loaiDoanIds){
            $queryStr = 'select * from loaidoan WHERE id IN ('.implode(' ,', $loaiDoanIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $dsLoaiDoan[$row['id']] = $row['tenLoai'];
            }
        }
        $dsChude = [];
        if ($chudeIds){
            $queryStr = 'select * from chude WHERE id IN ('.implode(' ,', $chudeIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $dsChude[$row['id']] = $row['tenChude'];
            }
        }
        $giangviens = [];
        if ($giangvienIds){
            $queryStr = 'select * from giangvien WHERE id IN ('.implode(' ,', $giangvienIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $giangviens[$row['id']] = $row['tenGV'];
            }
        }
        $totalSV = []; //Số lượng sinh viên đăng ký đồ án
        if ($doanIds){
            $queryStr = 'select maDoan, COUNT(tbl.maSV) as totalSV from sinhvien_thamgia as tbl WHERE maDoan IN ('.implode(' ,', $doanIds).') AND maDoan is NOT NULL';
            $queryStr .= ' GROUP BY maDoan';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $totalSV[$row['maDoan']] = $row['totalSV'];
            }
        }
        
        foreach ($result as $doan){
            if (!empty($dsLoaiDoan[$doan->getMaLoai()])){
                $doan->addOption('tenLoai', $dsLoaiDoan[$doan->getMaLoai()]);
            }
            if (!empty($dsChude[$doan->getMaChude()])){
                $doan->addOption('tenChude', $dsChude[$doan->getMaChude()]);
            }
            if (!empty($giangviens[$doan->getGiangvienHD()])){
                $doan->addOption('tenGV', $giangviens[$doan->getGiangvienHD()]);
            }
            if (!empty($totalSV[$doan->getId()])){
                $doan->addOption('totalSV', $totalSV[$doan->getId()]);
            }
        }
        return $result;
    }
    
    public function isExist($model){
        if (! $model->getMaDoan() && ! $model->getTenDoan() && ! $model->getGiangvienHD()){
            return false;
        }
        $whereArr = [];
        if ($model->getMaDoan()){
            $whereArr[] = 'maDoan = "'.$model->getMaDoan().'"';
        }
        if ($model->getTenDoan()){
            $whereArr[] = 'tenDoan = "'.$model->getTenDoan().'"';
        }
        if ($model->getGiangvienHD()){
            $whereArr[] = 'giangvienHD = "'.$model->getGiangvienHD().'"';
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