<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'Huongdan.php';
use Model\Base\ModelMapper;
class HuongdanMapper extends ModelMapper{
    const TABLE_NAME = 'huongdan';
    /**
     * 
     * @var $model \Model\Huongdan 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'id'            => $model->getId(),
            'maDoan'        => $model->getMaDoan(),
            'maSV'          => $model->getMaSV(),
            'maGV'          => $model->getMaGV() ? : null,
            'nhanxet'       => $model->getNhanxet() ? : null,
            'diem'          => $model->getDiem() ? : null,
            'trangthai'     => $model->getTrangthai() ? : null,
            'trangthaiSua'  => $model->getTrangthaiSua() ? : null,
            'updateById'    => $model->getUpdateById() ? : null,
            'updateDateTime'=> $model->getUpdateDateTime() ? : null,
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
      return false;
        
    }
    public function get($model){
        if (! $model->getMaDoan() || ! $model->getMaSV()){
            return null;
        }
        $queryStr = 'select * from '.self::TABLE_NAME.' where maDoan = '.$model->getId().' AND maSV = '.$model->getMaSV();
        $query = $this->connect->query($queryStr);
        if ($result = $query->fetch_assoc()){
            $model->exchangeArray($result);
            return $model;
        }
        return null;
    }    
    
    public function isExist($model){
    if (! $model->getMaDoan() && ! $model->getMaSV() && ! $model->getMaGV()){
            return false;
        }
        $whereArr = [];
        if ($model->getMaDoan()){
            $whereArr[] = 'maDoan = "'.$model->getMaDoan().'"';
        }
        if ($model->getMaSV()){
            $whereArr[] = 'maSV = "'.$model->getMaSV().'"';
        }
        if ($model->getMaGV()){
            $whereArr[] = 'maGV = "'.$model->getMaGV().'"';
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' WHERE '.implode(' AND ', $whereArr);
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
            $whereArr[] = 'hd.maDoan = "'.$model->getMaDoan().'"';
        }
        if ($model->getMaSV()){
            $whereArr[] = 'hd.maSV = "'.$model->getMaSV().'"';
        }
        if ($model->getMaGV()){
            $whereArr[] = 'hd.maGV = "'.$model->getMaGV().'"';
        }
        if ($model->getOption('trangthais')){
            $whereArr[] = 'hd.trangthai  IN ('.implode(', ', $model->getOption('trangthais')).')';
        }
        $queryStr = 'select hd.maDoan, hd.maSV, hd.maGV, hd.diem, hd.trangthai, hd.nhanxet, hd.trangthaiSua, hd.updateById, hd.updateDateTime, svtg.fileName
                FROM '.self::TABLE_NAME.' as hd
                INNER JOIN sinhvien_thamgia as svtg
                ON hd.maDoan = svtg.maDoan AND hd.maSV = svtg.maSV';
        if ($model->getOption('q') || $model->getOption('maLop') || $model->getOption('maSV')){
            $queryStr .= ' INNER JOIN sinhvien as sv 
                          ON hd.maSV = sv.id  
                          ';
            if ($model->getOption('q')){
                $whereArr[] = '(sv.maSV LIKE "%'.$model->getOption('q').'%" OR sv.tenSV LIKE "%'.$model->getOption('q').'%")';
            }
            if ($model->getOption('maSV')){
                $whereArr[] = 'sv.maSV = "'.$model->getOption('maSV').'"';
            }
            if ($model->getOption('maLop')){
                $whereArr[] = 'sv.maLop = "'.$model->getOption('maLop').'"';
            }
        }
        if ($model->getOption('maLoai') || $model->getOption('tenDoan')){
            $queryStr .= ' INNER JOIN doan as da
                          ON hd.maDoan = da.id
                          ';
            if ($model->getOption('maLoai')){
                $whereArr[] = 'da.maLoai = "'.$model->getOption('maLoai').'"';
            }
            if ($model->getOption('tenDoan')){
                $whereArr[] = 'da.tenDoan  LIKE "%'.$model->getOption('tenDoan').'%"';
            }
        }
        if ($whereArr){
            $queryStr .= ' WHERE '.implode(' AND ', $whereArr);
        }
        $queryStr.= ' ORDER BY hd.maDoan DESC';

        $query = $this->connect->query($queryStr);
        $result = [];
        $sinhvienIds = []; $doanIds = [];$giangvienIds = [];
        while($row = $query->fetch_assoc()){
            $huongdan = new Huongdan();
            $huongdan->exchangeArray($row);
            $huongdan->addOption('fileName', $row['fileName']);
            $sinhvienIds[$huongdan->getMaSV()] = $huongdan->getMaSV();
            $doanIds[$huongdan->getMaDoan()] = $huongdan->getMaDoan();
            if ($huongdan->getMaGV()){
                $giangvienIds[$huongdan->getMaGV()] = $huongdan->getMaGV();
            }
            if ($huongdan->getUpdateById()){
                $giangvienIds[$huongdan->getUpdateById()] = $huongdan->getUpdateById();
            }
            
            $result[] = $huongdan;
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
        $giangviens = [];
        if ($giangvienIds){
            $queryStr = 'select * from giangvien WHERE id IN ('.implode(' ,', $giangvienIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $giangviens[$row['id']] = $row['tenGV'];
            }
        }
        if ($result){
            foreach ($result as $huongdan){
                if (!empty($sinhviens[$huongdan->getMaSV()])){
                    $huongdan->addOption('sinhvien', $sinhviens[$huongdan->getMaSV()]);
                }
                if (!empty($doans[$huongdan->getMaDoan()])){
                    $huongdan->addOption('doan', $doans[$huongdan->getMaDoan()]);
                }
                if (!empty($giangviens[$huongdan->getMaGV()])){
                    $huongdan->addOption('tenGV', $giangviens[$huongdan->getMaGV()]);
                }
                if (!empty($giangviens[$huongdan->getUpdateById()])){
                    $huongdan->addOption('updateName', $giangviens[$huongdan->getUpdateById()]);
                }
            }
        }
        return $result;
    }
    
    
}