<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelLab extends Model
{
    protected $table = "tb_lab";
    protected $primaryKey = "id_lab";
    protected $returnType = "object";
    protected $allowedFields = ['nm_lab', 'no_telp', 'alamat'];

    public function allData()
    {
        return $this->db->table('tb_lab')
            ->orderBy('nm_lab', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_lab)
    {
        return $this->db->table('tb_lab')
            ->where('id_lab', $id_lab)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_lab')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_lab')
            ->where('id_lab', $data['id_lab'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_lab')
            ->where('id_lab', $data['id_lab'])
            ->delete($data);
    }
}
