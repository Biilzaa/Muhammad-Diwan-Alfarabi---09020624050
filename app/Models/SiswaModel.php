<?php

namespace App\Models;

use CodeIgniter\Model;

class SiswaModel extends Model
{
    protected $table            = 'form';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nama',
        'tempatLahir',
        'tanggalLahir',
        'id_provinsi',
        'id_kabkota',
        'agama',
        'alamat',
        'telepon',
        'jenisKelamin',
        'hobi'
    ];

    public function getProvinsi()
    {
        return $this->db->table('provinsi')->orderBy('nama', 'ASC')->get()->getResultArray();
    }

    public function getKabupatenKota($id_prov)
    {
        return $this->db->table('kabupaten')
            ->where('id_provinsi', $id_prov)
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();
    }
}
