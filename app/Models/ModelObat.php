<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelObat extends Model
{
    protected $table = "tb_obat";
    protected $primaryKey = "id_obat";
    protected $returnType = "object";
    protected $allowedFields = ['nm_obat', 'jenis', 'kategori', 'tgl_kadaluarsa', 'stok', 'harga', 'created_at'];

    public function allData()
    {
        return $this->db->table('tb_obat')
            ->orderBy('tgl_kadaluarsa', 'ASC')
            ->get()->getResultArray();
    }

    public function detailData($id_obat)
    {
        return $this->db->table('tb_obat')
            ->where('id_obat', $id_obat)
            ->get()->getRowArray();
    }

    public function add($data)
    {
        $this->db->table('tb_obat')->insert($data);
    }

    public function edit($data)
    {
        $this->db->table('tb_obat')
            ->where('id_obat', $data['id_obat'])
            ->update($data);
    }

    public function delete_data($data)
    {
        $this->db->table('tb_obat')
            ->where('id_obat', $data['id_obat'])
            ->delete($data);
    }
}
