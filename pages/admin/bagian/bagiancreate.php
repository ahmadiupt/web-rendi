<?php 
$database = new Database();
if (isset($_POST['button_create'])){
    $database= new Database();
    $db = $database->getConnection();

    $sql = "select * from bagian where nama_bagian = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(1,$_POST['nama_bagian']);
    $stmt->execute();
    if($stmt->rowCount() > 0){
      ?>  
        <div class="alert alert-danger alert-dismissible">
        <button class="close" type ="button" data-dismiss="alert" aria-hidden ="true">X</button>
        <h5><i class="icon fas fa-ban"> Gagal</i></h5>
        Nama bagian sudah ada
        </div>
      <?php
    } else {

        $insertSql = "INSERT INTO bagian VALUES(NULL,?,?,?)";
        $stmt = $db->prepare($insertSql);
        $stmt->bindParam(1,$_POST['nama_bagian']);
        $stmt->bindParam(2,$_POST['karyawan_id']);
        $stmt->bindParam(3,$_POST['lokasi_id']);
        if ($stmt->execute()){
           $_SESSION['hasil'] = true;
           $_SESSION['pesan'] = "Berhasil Simpan Data";
        } else {
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Simpan Data";
        }
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
}
?>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb2">
            <div class="col-sm-6">
                <h1>Tambah Data bagian</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                    <li class="breadcrumb-item"><a href="?page=bagianread">bagian</a></li>
                    <li class="breadcrumb-item active">Tambah Data</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tambah bagian</h3>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="form-group">
                   <label for="nama_bagian">Nama bagian</label>
                    <input type="text" class="form-control" name="nama_bagian">
                </div>
                <div class="form-group">
                   <label for="karyawan_id">Kepala Bagian</label>
                   <select name="karyawan_id" id="" class="form-control">
                       <option value="">-- Pilih Kepala Bagian --</option>
                      <?php
                        $db =$database->getConnection();

                       $selectSql = "SELECT * FROM karyawan";
                       $stmt_karyawan= $db->prepare($selectSql);
                       $stmt_karyawan->execute();
                       while($row_k = $stmt_karyawan->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value=\"" . $row_k["id"] . "\">" . $row_k["nama_lengkap"]. "</option>";
                        }
                      ?>
                   </select>
                </div>
                <div class="form-group">
                   <label for="lokasi_id">Lokasi</label>
                   <select name="lokasi_id" id="" class="form-control">
                       <option value="">-- Pilih Lokasi Bagian --</option>
                       <?php
                       $selectSql = "SELECT * FROM lokasi";
                       $stmt_l= $db->prepare($selectSql);
                       $stmt_l->execute();
                       while($row_l = $stmt_l->fetch(PDO::FETCH_ASSOC)){
                        echo "<option value=\"" . $row_l["id"] . "\">" . $row_l["nama_lokasi"]. "</option>";
                        }
                       ?>
                   </select>
                </div>
                <a href="?page=bagianread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                <button type="submit" name="button_create" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
            </form>
        </div>


    </div>
</section>
<?php include_once "partials/scripts.php"?>