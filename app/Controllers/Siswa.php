<?php

namespace App\Controllers;

use App\Models\SiswaModel;

class Siswa extends BaseController
{
    protected $siswaModel;

    public function __construct()
    {
        $this->siswaModel = new SiswaModel();
    }

    public function index($id = null)
    {
        $data = [
            'siswa'     => $this->siswaModel->findAll(),
            'provinsi'  => $this->siswaModel->getProvinsi(),
            'editvalue' => $id ? $this->siswaModel->find($id) : null
        ];
        return view('siswa_view', $data);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $jenis_kelamin = $this->request->getPost('Jenis-Kelamin') ?? '';
        $hobi = $this->request->getPost('Hobi');

        $user_data = [
            'nama'         => $this->request->getPost('nama'),
            'tempatLahir'  => $this->request->getPost('Tempat-Lahir'),
            'tanggalLahir' => $this->request->getPost('Tanggal-Lahir'),
            'id_provinsi'  => $this->request->getPost('id_provinsi'),
            'id_kabkota'   => $this->request->getPost('kabkota'),
            'agama'        => $this->request->getPost('Agama'),
            'alamat'       => $this->request->getPost('Alamat'),
            'telepon'      => $this->request->getPost('Nomor'),
            'jenisKelamin' => $jenis_kelamin,
            'hobi'         => $hobi ? implode(", ", $hobi) : ''
        ];

        if ($id) {
            $this->siswaModel->update($id, $user_data);
        } else {
            $this->siswaModel->insert($user_data);
        }

        return redirect()->to(base_url('siswa'));
    }

    public function delete($id_proses)
    {
        $this->siswaModel->delete($id_proses);
        return $this->response->setJSON(['status' => 'deleted']);
    }

    public function getKabko($id_prov)
    {
        $result = $this->siswaModel->getKabupatenKota($id_prov);
        echo '<option value="0">Pilih Kabupaten/Kota</option>';
        foreach ($result as $row) {
            echo "<option value='{$row['id']}'>{$row['nama']}</option>";
        }
    }
}
