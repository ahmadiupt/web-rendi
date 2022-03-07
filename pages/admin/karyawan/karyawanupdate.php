<?php
if (isset($_GET['id'])){
    include_once "database/database.php";
    $database =new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT K.*,P.username,P.password,P.peran FROM karyawan K LEFT JOIN pengguna P ON K.pengguna_id=P.id WHERE K.id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1,$_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])){
        if(isset($_POST['button_update'])){
            $validateSql = "SELECT * FROM karyawan WHERE nama_lengkap = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1,$_POST['nama_lengkap']);
            $stmt->bindParam(2,$_POST['id']);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button"class="close" data-dismiss="alert" aria-hidden ="true">x</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Nama karyawan Sudah Terdaftar
        </div>
<?php
        }else{
            $updateSql = "UPDATE karyawan SET nik =?,nama_lengkap = ?,handphone = ?, email= ?,tanggal_masuk= ? WHERE id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1,$_POST['nik']);
            $stmt->bindParam(2,$_POST['nama_lengkap']);
            $stmt->bindParam(3,$_POST['handphone']);
            $stmt->bindParam(4,$_POST['email']);
            $stmt->bindParam(5,$_POST['tanggal_masuk']);
            $stmt->bindParam(6,$_POST['id']);
            if($stmt->execute()){

                $updatepeng ="UPDATE pengguna SET username =?, peran =? WHERE id= ?";
                $stmtpeng = $db->prepare($updatepeng);
                $stmtpeng->bindParam(1,$_POST['username']);
                $stmtpeng->bindParam(2,$_POST['peran']);
                $stmtpeng->bindParam(3,$_POST['pengguna_id']);
                if ($stmtpeng->execute()){
                    $_SESSION['hasil'] = true;
                    $_SESSION['pesan'] = "Berhasil Update Data";
                }else{
                    $_SESSION['hasil'] = false;
                }
             
            }else {
                $_SESSION['hasil'] = false;
                $_SESSION['pesan'] = "Gagal Update Data";
            }
            echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
            }
        }
 ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb2">
                <div class="col-sm-6">
                    <h1>Ubah Data karyawan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=karyawanread">Karyawan</a></li>
                        <li class="breadcrumb-item active">Ubah Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah karyawan</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                <div class="form-group">
                   <label for="nik">Nomor Induk Karyawan</label>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>">
                    <input type="hidden" class="form-control" name="pengguna_id" value="<?php echo $row['pengguna_id']?>">
                    <input type="text" class="form-control" name="nik" value="<?php echo $row['nik']?>">
                </div>
                <div class="form-group">
                   <label for="nama_lengkap">Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $row['nama_lengkap']?>">
                </div>
                <div class="form-group">
                   <label for="handphone">Handphone</label>
                    <input type="text" class="form-control" name="handphone" value="<?php echo $row['handphone']?>">
                </div>
                <div class="form-group">
                   <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $row['email']?>">
                </div>
                <div class="form-group">
                   <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" class="form-control" name="tanggal_masuk" value="<?php echo $row['tanggal_masuk']?>">
                </div>
                <div class="form-group">
                   <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $row['username']?>">
                </div>
                <div class="form-group">
                   <label for="peran">Peran</label>
                   <select name="peran" class="form-control">
                       <option value="">-- Pilih Peran --</option>
                       <option value="ADMIN" <?php echo $row['peran']== 'ADMIN'? "selected" : ""?>>ADMIN</option>
                       <option value="USER" <?php echo $row['peran']== 'USER'? "selected" : ""?>>USER</option>
                   </select>
                </div> 
                    <a href="?page=karyawanread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>


        </div>
    </section>
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
}
include_once "partials/scripts.php";
?>
