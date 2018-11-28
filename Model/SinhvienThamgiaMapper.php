<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'SinhvienThamgia.php';
use Model\Base\ModelMapper;
use Model\Sinhvien;

if (!class_exists('SinhvienThamgiaMapper')) {
    class SinhvienThamgiaMapper extends ModelMapper{
        const TABLE_NAME = 'sinhvien_thamgia';
        /**
         * 
         * @var $model \Model\Sinhvien 
         */
        public function save($model){
            //Nếu không có ID thì là thêm mới, nếu có ID thì là update
            $data = [
                'maSV'      => $model->getMaSV(),
                'tenSV'     => $model->getTenSV() ? : null,
                'maDoan'    => $model->getMaDoan(),
                'tenDoan'   => $model->getTenDoan(),
                'lanThamGia'=> $model->getLanThamgia() ? : null,
                'fileName'  => $model->getFileName() ? : null,
                'trangthai' => $model->getTrangthai() ? : null,
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
        
        public function update($model){
            if (!$model->getMaSV() || !$model->getMaDoan()){
                return false;
            } 
            $data = [
                'maSV'      => $model->getMaSV(),
                'tenSV'     => $model->getTenSV() ? : null,
                'maDoan'    => $model->getMaDoan(),
                'tenDoan'   => $model->getTenDoan(),
                'lanThamGia'=> $model->getLanThamgia() ? : null,
                'fileName'  => $model->getFileName() ? : null,
                'trangthai' => $model->getTrangthai() ? : null,
            ];
            $valueUpdate = [];
            foreach ($data as $field => $value){
                $valueUpdate[] = $field .' = "'.$value.'"';
            }
            $queryStr = 'UPDATE '.self::TABLE_NAME.' SET '.implode(', ', $valueUpdate).' WHERE maSV='.$model->getMaSV().' AND maDoan= '.$model->getMaDoan();
            $query = $this->connect->query($queryStr);
            return $model;
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
            if (! $model->getMaDoan() && ! $model->getMaSV()){
                return false;
            }
            $whereArr = [];
            if ($model->getMaDoan()){
                $whereArr[] = 'svtg.maDoan = "'.$model->getMaDoan().'"';
            }
            if ($model->getMaSV()){
                $whereArr[] = 'svtg.maSV = "'.$model->getMaSV().'"';
            }
            $queryStr = 'select * from '.self::TABLE_NAME .' as  svtg';
            if ($model->getOption('maLoai') || $model->getOption('namRaDe')){
                $queryStr .= ' INNER JOIN doan as da ON da.id = svtg.maDoan';
                if ($model->getOption('maLoai')){
                    $whereArr[] = 'da.maLoai = "'.$model->getOption('maLoai').'"';
                }
                if ($model->getOption('namRaDe')){
                    $whereArr[] = 'da.namRaDe = "'.$model->getOption('namRaDe').'"';
                }
            }
            $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
            $query = $this->connect->query($queryStr);
            if ($result = $query->fetch_assoc()){
                $model->exchangeArray($result);
                return true;
            }
            return false;
        }
        
        public function fetchAll($model){
            $whereArr = [];
            if ($model->getMaDoan()){
                $whereArr[] = 'svtg.maDoan = "'.$model->getMaDoan().'"';
            }
            if ($model->getMaSV()){
                $whereArr[] = 'svtg.maSV = "'.$model->getMaSV().'"';
            }
            if ($model->getTrangthai()){
                $whereArr[] = 'svtg.trangthai = "'.$model->getTrangthai().'"';
            }
            $queryStr = 'select svtg.maDoan, svtg.maSV, svtg.fileName, svtg.lanThamGia, svtg.trangthai
                FROM '.self::TABLE_NAME.' as svtg
                INNER JOIN doan as da
                ON da.id = svtg.maDoan 
               WHERE '.implode(' AND ', $whereArr).' ORDER BY da.maLoai DESC';
            $query = $this->connect->query($queryStr);
            $result = [];
            $sinhvienIds = []; $doanIds = [];
            while($row = $query->fetch_assoc()){
                $sinhvienThamgia = new SinhvienThamgia();
                $sinhvienThamgia->exchangeArray($row);
                $sinhvienIds[$sinhvienThamgia->getMaSV()] = $sinhvienThamgia->getMaSV();
                $doanIds[$sinhvienThamgia->getMaDoan()] = $sinhvienThamgia->getMaDoan();
                $result[] = $sinhvienThamgia;
            }
           $sinhviens = [];
            if($sinhvienIds){
                $queryStr = 'select sv.id, sv.maSV, sv.tenSV, l.tenLop, k.tenKhoa 
                    FROM sinhvien as sv 
                    INNER JOIN lop as l 
                    ON l.id = sv.maLop  
                    INNER JOIN khoa as k
                    ON k.id = l.maKhoa
                    WHERE sv.id IN ('.implode(' ,', $sinhvienIds).')';
                $query = $this->connect->query($queryStr);
                while($row = $query->fetch_assoc()){
                    $sinhvien = new Sinhvien();
                    $sinhvien->exchangeArray($row);
                    $sinhvien->addOption('tenKhoa', $row['tenKhoa']);
                    $sinhvien->addOption('tenLop', $row['tenLop']);
                    $sinhviens[$row['id']] = $sinhvien;
                }
            }
            $doans = [];
            if($doanIds){
                $queryStr = 'select da.id, da.tenDoan, da.namRaDe, da.ngayHetHan, l.tenLoai, cd.tenChude
                    FROM doan as da
                    INNER JOIN loaidoan as l
                    ON l.id = da.maLoai
                    INNER JOIN chude as cd
                    ON cd.id = da.maChude
                    WHERE da.id IN ('.implode(' ,', $doanIds).')';
                $query = $this->connect->query($queryStr);
                while($row = $query->fetch_assoc()){
                    $doan = new Doan();
                    $doan->exchangeArray($row);
                    $doan->addOption('tenLoai', $row['tenLoai']);
                    $doan->addOption('tenChude', $row['tenChude']);
                    $doans[$row['id']] = $doan;
                }
            }
            
           if ($result){
               foreach ($result as $sinhvienThamgia){
                   if (!empty($sinhviens[$sinhvienThamgia->getMaSV()])){
                       $sinhvienThamgia->addOption('sinhvien', $sinhviens[$sinhvienThamgia->getMaSV()]);
                   }
                   if (!empty($doans[$sinhvienThamgia->getMaDoan()])){
                       $sinhvienThamgia->addOption('doan', $doans[$sinhvienThamgia->getMaDoan()]);
                   }
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
    }
}