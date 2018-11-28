<?php
namespace Model;
include_once 'Base/ModelMapper.php';
include_once  'PhanBien.php';
use Model\Base\ModelMapper;
class PhanBienMapper extends ModelMapper{
    const TABLE_NAME = 'phanbien';
    /**
     * 
     * @var $model \Model\PhanBien 
     */
    public function save($model){
        //Nếu không có ID thì là thêm mới, nếu có ID thì là update
        $data = [
            'id'            => $model->getId(),
            'maDoan'        => $model->getMaDoan(),
            'maSV'          => $model->getMaSV(),
            'maGVPB1'       => $model->getMaGVPB1() ? : null,
            'maGVPB2'       => $model->getMaGVPB2() ? : null,
            'maGVPB3'       => $model->getMaGVPB3() ? : null,
            'nhanxet'       => $model->getNhanxet() ? : null,
            'diemPB1'       => $model->getDiemPB1() ? : null,
            'diemPB2'       => $model->getDiemPB2() ? : null,
            'diemPB3'       => $model->getDiemPB3() ? : null,
            'trangthai'     => $model->getTrangthai() ? : null,
            'trangthaiSua'  => $model->getTrangthaiSua() ? : null,
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
            $whereArr[] = '(maGVPB1 = "'.$model->getMaGV().'" OR maGVPB2 = "'.$model->getMaGV().'" OR  maGVPB3 = "'.$model->getMaGV().'" )';
        }
        $queryStr = 'select * from '.self::TABLE_NAME .' as pb WHERE '.implode(' AND ', $whereArr);
        
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
            $whereArr[] = 'pb.maDoan = "'.$model->getMaDoan().'"';
        }
        if ($model->getMaSV()){
            $whereArr[] = 'pb.maSV = "'.$model->getMaSV().'"';
        }
        if ($model->getMaGVPB1()){
            $whereArr[] = 'pb.maGVPB1 = "'.$model->getMaGVPB1().'"';
        }
        if ($model->getMaGVPB2()){
            $whereArr[] = 'pb.maGVPB2 = "'.$model->getMaGVPB2().'"';
        }
        if ($model->getMaGVPB3()){
            $whereArr[] = 'pb.maGVPB3 = "'.$model->getMaGVPB3().'"';
        }
        if ($model->getMaGV()){
            $whereArr[] = '(pb.maGVPB1 = "'.$model->getMaGV().'" OR pb.maGVPB2 = "'.$model->getMaGV().'" OR  pb.maGVPB3 = "'.$model->getMaGV().'" )';
        }
        if ($model->getOption('loadGVPB')){
            $whereArr[] = '(pb.maGVPB1 > 0 AND pb.maGVPB2 > 0 AND pb.maGVPB3 > 0)';
        }
        if ($model->getOption('trangthais')){
            $whereArr[] = 'pb.trangthai  IN ('.implode(', ', $model->getOption('trangthais')).')';
        }
        $queryStr = 'select pb.maDoan, pb.maSV, pb.maGVPB1, pb.maGVPB2, pb.maGVPB3, pb.trangthai, pb.diemPB1, pb.diemPB2, pb.diemPB3, pb.trangthaiSua ,hd.diem
          FROM '.self::TABLE_NAME.' as pb
          INNER JOIN huongdan as hd 
          ON hd.maSV = pb.maSV AND hd.maDoan = pb.maDoan
         ';
        if ($model->getOption('q') || $model->getOption('maLop') || $model->getOption('maSV')){
            $queryStr .= ' INNER JOIN sinhvien as sv
                          ON pb.maSV = sv.id
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
                          ON pb.maDoan = da.id
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
        $query = $this->connect->query($queryStr);
        $sinhvienIds = [];
        $giangvienIds = [];
        $doanIds = [];
        $result = [];
        while($row = $query->fetch_assoc()){
            $phanbien = new PhanBien();
            $phanbien->exchangeArray($row);
            $phanbien->addOption('diemHD', $row['diem']);
            $sinhvienIds[$phanbien->getMaSV()] = $phanbien->getMaSV();
            $giangvienIds[$phanbien->getMaGVPB1()] = $phanbien->getMaGVPB1();
            $giangvienIds[$phanbien->getMaGVPB2()] = $phanbien->getMaGVPB2();
            $giangvienIds[$phanbien->getMaGVPB3()] = $phanbien->getMaGVPB3();
            $doanIds[$phanbien->getMaDoan()] = $phanbien->getMaDoan();
            $result[] = $phanbien;
        }
        $giangviens = [];
        if ($giangvienIds){
            $queryStr = 'select * from giangvien WHERE id IN ('.implode(' ,', $giangvienIds).')';
            $query = $this->connect->query($queryStr);
            while($row = $query->fetch_assoc()){
                $giangvien = new Giangvien();
                $giangvien->exchangeArray($row);
                $giangviens[$row['id']] = $giangvien;
            }
        }
        
        $sinhviens = [];
        if ($sinhvienIds){
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
            foreach ($result as $phanbien){
                if (!empty($sinhviens[$phanbien->getMaSV()])){
                    $phanbien->addOption('sinhvien', $sinhviens[$phanbien->getMaSV()]);
                }
                if ($phanbien->getMaGVPB1() && !empty($giangviens[$phanbien->getMaGVPB1()])){
                    $phanbien->addOption('giangvienPB1', $giangviens[$phanbien->getMaGVPB1()]);
                }
                if ($phanbien->getMaGVPB2() && !empty($giangviens[$phanbien->getMaGVPB2()])){
                    $phanbien->addOption('giangvienPB2', $giangviens[$phanbien->getMaGVPB2()]);
                }
                if ($phanbien->getMaGVPB3() && !empty($giangviens[$phanbien->getMaGVPB3()])){
                    $phanbien->addOption('giangvienPB3', $giangviens[$phanbien->getMaGVPB3()]);
                }
                if (!empty($doans[$phanbien->getMaDoan()])){
                    $phanbien->addOption('doan', $doans[$phanbien->getMaDoan()]);
                }
            }
        }
       
        return $result;
    }
}