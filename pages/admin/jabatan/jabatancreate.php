<?php 
if (isset($_POST['button_create'])){
    $database= new Database();
    $db = $database->getConnection();

    $sql = "select * from jabatan where nama_jabatan = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1,$_POST['nama_jabatan']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      ?>  
        <div class="alert alert-danger alert-dismissible">
        <button class="close" type ="button" data-dismiss="alert" aria-hidden ="true">X</button>
        <h5><i class="icon fas fa-ban"> Gagal</i></h5>
        Nama jabatan sudah ada
        </div>
      <?php
    } else {

        $insertSql = "INSERT INTO jabatan VALUES (NULL,?,?,?,?)";
        $stmt = $db->prepare($insertSql);
        $stmt->bindParam(1,$_POST['nama_jabatan']);
        $stmt->bindParam(2,$_POST['gapok_jabatan']);
        $stmt->bindParam(3,$_POST['tunjangan_jabatan']);
        $stmt->bindParam(4,$_POST['uang_makan_perhari']);
        if ($stmt->execute()){
           $_SESSION['hasil'] = true;
           $_SESSION['pesan'] = "Berhasil Simpan Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Simpan Data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=jabatanread'>";
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data jabatan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=jabatanread">Jabatan</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah jabatan</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                   <label for="nama_jabatan">Nama jabatan</label>
                    <input type="text" class="form-control" name="nama_jabatan">
                </div>
                <div class="form-group">
                   <label for="gapok_jabatan">Gaji Pokok jabatan</label>
                    <input type="number" class="form-control" name="gapok_jabatan" onkeypress='return (event.charCode > 47 && event.charCode <58) || event.charCode == 46'>
                </div>
                <div class="form-group">
                   <label for="tunjangan_jabatan">Tunjangan jabatan</label>
                    <input type="number" class="form-control" name="tunjangan_jabatan" onkeypress='return (event.charCode > 47 && event.charCode <58) || event.charCode == 46'>
                </div>
                <div class="form-group">
                   <label for="uang_makan_perhari">Uang Makan Perhari</label>
                    <input type="number" class="form-control" name="uang_makan_perhari" onkeypress='return (event.charCode > 47 && event.charCode <58) || event.charCode == 46'>
                </div>
                <a href="?page=jabatanread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
            </form>
        </div>


    </div>
</section>
<?php include_once "partials/scripts.php"?>