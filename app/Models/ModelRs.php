<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelRs extends Model
{
    protected $table = "tb_rs";
    protected $primaryKey = "id_rs";
    protected $returnType = "object";
    protected $allowedFields = ['nm_rs', 'no_telp', 'alamat'];

    public function allData()
    {
        return $this->db->table('tb_rs')
            ->orderBy('nm_rs', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_rs)
    {
        return $this->db->table('tb_rs')
            ->where('id_rs', $id_rs)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_rs')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_rs')
            ->where('id_rs', $data['id_rs'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_rs')
            ->where('id_rs', $data['id_rs'])
            ->delete($data);
    }
}
