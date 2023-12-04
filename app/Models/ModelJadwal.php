<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelJadwal extends Model
{
    protected $table = "tb_jadwal";
    protected $primaryKey = "id_jadwal";
    protected $returnType = "object";
    protected $allowedFields = ['poli', 'id_dokter', 'hari', 'waktu_mulai', 'waktu_selesai'];

    public function allData()
    {
        return $this->db->table('tb_jadwal')
            ->join('tb_dokter', 'tb_dokter.id_dokter = tb_jadwal.id_dokter', 'left')
            ->orderBy('tb_jadwal.hari', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_jadwal)
    {
        return $this->db->table('tb_jadwal')
            ->join('tb_dokter', 'tb_dokter.id_dokter = tb_jadwal.id_dokter', 'left')
            ->where('id_jadwal', $id_jadwal)
            ->get()->getRowArray();
    }

    public function delete_data($data)
    {
        $this->db->table('tb_jadwal')
            ->where('id_jadwal', $data['id_jadwal'])
            ->delete($data);
    }
}
