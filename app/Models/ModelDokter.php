<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDokter extends Model
{
    protected $table = "tb_dokter";
    protected $primaryKey = "id_dokter";
    protected $returnType = "object";
    protected $allowedFields = ['spesialis', 'no_str', 'nama', 'j_kel', 'username', 'email', 'no_hp', 'alamat', 'password', 'up_ktp', 'pasfoto', 'posisi'];

    public function allData()
    {
        return $this->db->table('tb_dokter')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_dokter)
    {
        return $this->db->table('tb_dokter')
            ->where('id_dokter', $id_dokter)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_dokter')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_dokter')
            ->where('id_dokter', $data['id_dokter'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_dokter')
            ->where('id_dokter', $data['id_dokter'])
            ->delete($data);
    }
}
