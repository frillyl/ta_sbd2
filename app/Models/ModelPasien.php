<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPasien extends Model
{
    protected $table = "tb_pasien";
    protected $primaryKey = "id_pasien";
    protected $returnType = "object";
    protected $allowedFields = ['no_rm', 'nama', 'j_kel', 'email', 'no_hp', 'alamat', 'up_ktp', 'pasfoto'];

    public function allData()
    {
        return $this->db->table('tb_pasien')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_pasien)
    {
        return $this->db->table('tb_pasien')
            ->where('id_pasien', $id_pasien)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_pasien')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_pasien')
            ->where('id_pasien', $data['id_pasien'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_pasien')
            ->where('id_pasien', $data['id_pasien'])
            ->delete($data);
    }
}
