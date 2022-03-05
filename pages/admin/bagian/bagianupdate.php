<?php
$database = new Database();
if (isset($_GET['id'])){
    include_once "database/database.php";
    $database =new Database();
    $db = $database->getConnection();

    $id = $_GET['id'];
    $findSql = "SELECT * FROM bagian WHERE id = ?";
    $stmt = $db->prepare($findSql);
    $stmt->bindParam(1,$_GET['id']);
    $stmt->execute();
    $row = $stmt->fetch();
    if (isset($row['id'])){
        if(isset($_POST['button_update'])){
            $validateSql = "SELECT * FROM bagian WHERE nama_bagian = ? AND id != ?";
            $stmt = $db->prepare($validateSql);
            $stmt->bindParam(1,$_POST['nama_bagian']);
            $stmt->bindParam(2,$_POST['id']);
            $stmt->execute();
            if($stmt->rowCount() > 0) {
?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button"class="close" data-dismiss="alert" aria-hidden ="true">x</button>
            <h5><i class="icon fas fa-ban"></i> Gagal</h5>
            Nama bagian Sudah Terdaftar
        </div>
<?php
        }else{
            $updateSql = "UPDATE bagian SET nama_bagian = ?,karyawan_id = ?,lokasi_id = ? WHERE id = ?";
            $stmt = $db->prepare($updateSql);
            $stmt->bindParam(1,$_POST['nama_bagian']);
            $stmt->bindParam(2,$_POST['karyawan_id']);
            $stmt->bindParam(3,$_POST['lokasi_id']);
            $stmt->bindParam(4,$_POST['id']);
            if($stmt->execute()){
                $_SESSION['hasil'] = true;
                $_SESSION['pesan'] = "Berhasil Update Data";
            }else {
                $_SESSION['hasil'] = false;
                $_SESSION['pesan'] = "Gagal Update Data";
            }
            echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
            }
        }
 ?>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb2">
                <div class="col-sm-6">
                    <h1>Ubah Data bagian</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="?page=home">Home</a></li>
                        <li class="breadcrumb-item"><a href="?page=bagianread">Bagian</a></li>
                        <li class="breadcrumb-item active">Ubah Data</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Ubah bagian</h3>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                    <label for="nama_bagian">Nama bagian</label>
                    <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']?>"> 
                        <input type="text" class="form-control" name="nama_bagian" value="<?php echo $row['nama_bagian']?>"> 
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
                       $selected = $row_k["id"] == $row['karyawan_id'] ? " selected" : "";
                        echo "<option value=\"" . $row_k["id"] . "\" " . $selected . ">" . $row_k["nama_lengkap"]. "</option>";
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
                        $selected = $row_l["id"] == $row['lokasi_id'] ? " selected" : "";
                        echo "<option value=\"" . $row_l["id"] . "\" " . $selected . ">" . $row_l["nama_lokasi"]. "</option>";
                        }
                       ?>
                   </select>
                </div>
                    <a href="?page=bagianread" class="btn btn-danger btn-sm float-right"><i class="fa fa-times"></i> Batal</a>
                    <button type="submit" name="button_update" class="btn btn-success btn-sm float-right"><i class="fa fa-save"></i> Simpan</button>
                </form>
            </div>


        </div>
    </section>
<?php
    } else {
        echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
    }
} else {
    echo "<meta http-equiv='refresh' content='0;url=?page=bagianread'>";
}
include_once "partials/scripts.php";
?>
