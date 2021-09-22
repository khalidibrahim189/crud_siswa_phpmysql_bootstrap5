<?php

$servername = "localhost";
$user = "root";
$password = "";
$db = "crud_mahasiswa";


$koneksi = mysqli_connect($servername, $user, $password, $db) or die(mysqli_error($koneksi));

//button simpan diklik(simpan data ke database dari php)

if (isset($_POST['simpan'])) {
    //pengujian edit
    if ($_GET['hal'] == "edit") {
        //data edit
        $edit = mysqli_query($koneksi, "UPDATE siswa set
                                nama = '$_POST[nama]',
                                ttl = '$_POST[ttl]',
                                jurusan = '$_POST[jurusan]'
                                WHERE id = '$_GET[id]'
                            ");
        if ($edit) { //jika berhasil
            echo "<script>
                alert('simpan data berhasil edit');
                document.location = 'index.php'; 
                </script>";
        } else {
            echo "<script>
                alert('edit data gagal');
                document.location = 'index.php'; 
                </script>";
        }
    } else {
        //simpan data baru
        $simpan = mysqli_query($koneksi, "INSERT INTO siswa(nama,ttl, jurusan)
        VALUES ('$_POST[nama]',
               '$_POST[ttl]',
               '$_POST[jurusan]')
               ");
        if ($simpan) { //jika berhasil
            echo "<script>
                alert('simpan data berhasil dong');
                document.location = 'index.php'; 
                </script>";
        } else {
            echo "<script>
                alert('simpan data gagal');
                document.location = 'index.php'; 
                </script>";
        }
    }
}

//pengujian edit / hapus saat diklik
if (isset($_GET['hal'])) {
    //tampilkan uji data yang akan diedit (uji)
    if ($_GET['hal'] == "edit") {
        //tampilakn data yang akan diedit
        $tampil = mysqli_query($koneksi, "SELECT * FROM siswa WHERE id = '$_GET[id]'");
        $data = mysqli_fetch_array($tampil);
        if ($data) {
            //jika data ditemukan maka data akan ditampung ke variabel
            $nama = $data['nama'];
            $ttl = $data['ttl'];
            $jurusan = $data['jurusan'];
        }
    } elseif ($_GET['hal'] == "hapus") {
        //persiapan hapus data
        $hapus = mysqli_query($koneksi, "DELETE FROM siswa WHERE id = '$_GET[id]'");
        if ($hapus) {
            echo "<script>
            alert('Hapus Data berhasil');
            document.location = 'index.php'; 
            </script>";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD PHP MY SQL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>


    <div class="container">
        <h2 class="text-center">CRUD Mahasiswa</h2>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Form Mahasiswa</div>
                        <div class="card-body">
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="">Nama</label>
                                    <input type="text" name="nama" value="<?= $nama ?>" class="form-control" placeholder="masukan nama" required>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="">Tempat Tanggal lahir</label>
                                    <input type="text" name="ttl" value="<?= $ttl ?>" class="form-control" placeholder="masukan ttl" required>
                                </div>
                                <div class="form-group mt-4">
                                    <label for="">Jurusan</label>
                                    <input type="text" name="jurusan" value="<?= $jurusan ?>" class="form-control" placeholder="masukan jurusan" required>
                                </div>

                                <button type="submit" class="btn btn-success mt-2" name="simpan">Simpan</button>
                                <button type="reset" class="btn btn-danger mt-2" name="reset">Kosongkan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-4">
                    <div class="card">
                        <div class="card-header  bg-primary text-white">
                            Tampilan Data
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <div class="row">
                                    <div class="mx-auto">
                                        <table class="table table-bordered table-striped">

                                            <tr>
                                                <th>No.</th>
                                                <th>Nama</th>
                                                <th>TTL</th>
                                                <th>Jurusan</th>
                                                <th>Aksi</th>
                                            </tr>


                                            <!-- tahap awal buat perulangan sesuaikan didata base -->
                                            <?php
                                            $id = 1;
                                            $tampil = mysqli_query($koneksi, "SELECT *  FROM siswa order by id desc");
                                            while ($data = mysqli_fetch_array($tampil)) :

                                            ?>

                                                <tr>
                                                    <td><?= $id++; ?></td>
                                                    <td><?= $data['nama'] ?></td>
                                                    <td><?= $data['ttl'] ?></td>
                                                    <td><?= $data['jurusan'] ?></td>
                                                    <td>
                                                        <a href="index.php?hal=edit&id=<?= $data['id'] ?>" class="btn btn-danger">Edit</a>
                                                        <a href="index.php?hal=hapus&id=<?= $data['id'] ?>" onclick="return confirm('Apakah yakin ingin dihapus?')" class="btn btn-warning">Hapus</a>
                                                    </td>
                                                </tr>

                                            <?php endwhile; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</body>

</html>