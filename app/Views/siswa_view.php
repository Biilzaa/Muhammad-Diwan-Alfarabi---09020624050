<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Formulir Pendaftaran Siswa</title>
    <style>
        h1 {
            text-align: center;
            color: #2564ebef;
        }

        body {
            background-color: #f3f4f6;
        }

        form {
            background-color: #f9fafb;
            margin: auto;
            max-width: 700px;
            padding: 30px;
        }

        label {
            display: inline-block;
            width: 160px;
            margin-bottom: 15px;
        }

        textarea {
            vertical-align: top;
        }

        table {
            color: #ffffff;
            background-color: #2564ebef;
            border-collapse: collapse;
            border-color: #ffffff;
            margin: auto;
            width: 60%;
        }

        button {
            background-color: #2564ebef;
            color: #ffffff;
            border: none;
            font-weight: bold;
            margin: auto;
            width: 100%;
            cursor: pointer;
        }

        .btn-action {
            width: auto;
            padding: 5px 10px;
            margin: 2px;
        }
    </style>
</head>

<body>
    <form action="<?= base_url('siswa/save') ?>" method="post" id="form-register">
        <h1>Formulir Pendaftaran Siswa</h1>
        <input type="hidden" name="id" value="<?= $editvalue['id'] ?? '' ?>">

        <label>Nama Calon Siswa : </label>
        <input type="text" name="nama" id="nama" placeholder="Tuliskan nama kamu" value="<?= $editvalue['nama'] ?? '' ?>" class="form">
        <br>

        <label>Tempat/Tanggal Lahir : </label>
        <input type="text" name="Tempat-Lahir" placeholder="Tuliskan tempat lahir kamu" value="<?= $editvalue['tempatLahir'] ?? '' ?>">
        <input type="date" name="Tanggal-Lahir" value="<?= $editvalue['tanggalLahir'] ?? '' ?>">
        <br>

        <label>Provinsi : </label>
        <select name="id_provinsi" onchange="getDataKabupaten(this.value)">
            <option value="">Pilih Provinsi</option>
            <?php foreach ($provinsi as $p): ?>
                <option value="<?= $p['id'] ?>" <?= (isset($editvalue['id_provinsi']) && $editvalue['id_provinsi'] == $p['id']) ? "selected" : "" ?>>
                    <?= $p['nama'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>

        <label>Kabupaten/Kota : </label>
        <div id="divKabko" style="display:inline-block;">
            <select id="kabkota" name="kabkota">
                <option value="0">Pilih Kabupaten/Kota</option>
                <?php if (isset($editvalue['id_kabkota'])): ?>
                    <option value="<?= $editvalue['id_kabkota'] ?>" selected>Terpilih</option>
                <?php endif; ?>
            </select>
        </div>
        <br>

        <label>Agama : </label>
        <select name="Agama">
            <?php foreach (['Islam', 'Kristen', 'Katholik', 'Budha', 'Hindu', 'Konghucu'] as $ag): ?>
                <option value="<?= $ag ?>" <?= (isset($editvalue['agama']) && $editvalue['agama'] == $ag) ? "selected" : "" ?>><?= $ag ?></option>
            <?php endforeach; ?>
        </select>
        <br>

        <label>Alamat : </label>
        <textarea name="Alamat" cols="40" rows="5" placeholder="Tuliskan alamat kamu"><?= $editvalue['alamat'] ?? '' ?></textarea>
        <br><br>

        <label>Nomor : </label>
        <input type="number" name="Nomor" placeholder="Tuliskan nomor kamu" value="<?= $editvalue['telepon'] ?? '' ?>">
        <br>

        <label>Jenis Kelamin : </label>
        <input type="radio" value="1" name="Jenis-Kelamin" <?= (isset($editvalue['jenisKelamin']) && $editvalue['jenisKelamin'] == '1') ? 'checked' : '' ?>> Laki-laki
        <input type="radio" value="0" name="Jenis-Kelamin" <?= (isset($editvalue['jenisKelamin']) && $editvalue['jenisKelamin'] == '0') ? 'checked' : '' ?>> Perempuan
        <br>

        <label>Hobi : </label>
        <?php $hobi = $editvalue['hobi'] ?? ''; ?>
        <input type="checkbox" value="Membaca" name="Hobi[]" <?= (strpos($hobi, 'Membaca') !== false) ? 'checked' : '' ?>> Membaca
        <input type="checkbox" value="Menulis" name="Hobi[]" <?= (strpos($hobi, 'Menulis') !== false) ? 'checked' : '' ?>> Menulis
        <input type="checkbox" value="Olahraga" name="Hobi[]" <?= (strpos($hobi, 'Olahraga') !== false) ? 'checked' : '' ?>> Olahraga
        <br>

        <label>Pas Foto : </label>
        <input type="file" name="Foto">
        <br>

        <button type="button" id="btnSubmit">SUBMIT</button>
    </form>
    <br>

    <table border="1">
        <thead>
            <tr>
                <th rowspan="2">Nama</th>
                <th colspan="2">Lahir</th>
                <th rowspan="2">No Telp</th>
                <th rowspan="2">Agama</th>
                <th rowspan="2">Aksi</th>
            </tr>
            <tr>
                <th>Tempat</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($siswa as $row): ?>
                <tr>
                    <td><?= $row["nama"]; ?></td>
                    <td><?= $row["tempatLahir"]; ?></td>
                    <td><?= $row["tanggalLahir"]; ?></td>
                    <td><?= $row["telepon"]; ?></td>
                    <td><?= $row["agama"]; ?></td>
                    <td>
                        <a href="<?= base_url('siswa/edit/' . $row['id']) ?>"><button class="btn-action">Update</button></a>
                        <button type="button" class="btn-action" onclick="hapus(<?= $row['id'] ?>)">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $("#btnSubmit").click(function() {
            if ($("#nama").val().length < 5) {
                alert("Karakter Nama harus lebih dari 5");
            } else {
                $("#form-register").submit();
            }
        });

        function hapus(id) {
            if (confirm("Yakin hapus data?")) {
                $.ajax({
                    type: 'POST',
                    url: "<?= base_url('siswa/delete') ?>/" + id,
                    success: function() {
                        alert("Data terhapus");
                        location.href = "<?= base_url('siswa') ?>";
                    }
                });
            }
        }

        function getDataKabupaten(idProvinsi) {
            $.ajax({
                type: 'POST',
                url: "<?= base_url('siswa/getKabko') ?>/" + idProvinsi,
                success: function(hasil) {
                    $("#kabkota").html(hasil);
                }
            });
        }
    </script>
</body>

</html>