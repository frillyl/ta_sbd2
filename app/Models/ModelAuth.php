<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAuth extends Model
{
    public function login_petugas($username)
    {
        return $this->db->table('tb_petugas')->where([
            'username' => $username,
        ])->get()->getRowArray();
    }
}
