<?php include_once "partials/cssdatatables.php"?>
  <!-- Content Header (Page header) -->
  <div class="content-header">
      <div class="container-fluid">
          <?php
          if (isset($_SESSION["hasil"])){
            if ($_SESSION["hasil"]){
          ?>
          <div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden=true >X</button>
              <h5><i class="icon fas fa-check"></i> Berhasil</h5>
              <?php echo $_SESSION["pesan"]?>
          </div>
        <?php
            } else {
        ?>
             <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden=true >X</button>
              <h5><i class="icon fas fa-ban"></i> Gagal</h5>
              <?php echo $_SESSION["pesan"]?>
          </div>
          <?php
            }
            unset($_SESSION['hasil']);
            unset($_SESSION['Pesan']);
          }
          ?>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">bagian</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">bagian</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"> Data bagian</h3>
            <a href="?page=bagiancreate" class="btn btn-success btn-sm float-right"><i class="fa fa-plus-circle"></i> Tambah Data</a>
        </div>
        <div class="card-body">
            <table id="mytable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bagian</th>
                        <th>Kepala Bagian</th>
                        <th>Lokasi</th>
                        <th>Opsi</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $database = new Database();
                $db = $database->getConnection();
                $selectSql = "SELECT b.nama_bagian,k.nama_lengkap as kepala_bagian,l.nama_lokasi as lokasi_bagian from bagian b LEFT JOIN karyawan k ON b.karyawan_id = k.id LEFT JOIN lokasi l ON b.lokasi_id = l.id";
                $stmt = $db->prepare($selectSql);
                $stmt->execute();
                $no=1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                    <tr>
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['nama_bagian']?></td>
                        <td><?php echo $row['kepala_bagian']?></td>
                        <td><?php echo $row['lokasi_bagian']?></td>
                        <td>
                            <form action="" class="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']?>">
                                <a href="?page=bagianupdate&id=<?php echo $row['id']?>" class="btn btn-primary btn-sm mr-1"><i class="fa fa-edit"></i> Ubah</a>
                                <a href="?page=bagiandelete&id=<?php echo $row['id']?>" class="btn btn-danger btn-sm" onClick="javascript: return confirm('Konfirmasi data akan dihapus?')"><i class="fa fa-trash"></i> Hapus</a>
                            </form>
                        </td>
                    </tr>
                <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <!-- /.content -->
    <?php include "partials/scripts.php"?>
    <?php include "partials/scriptsdatatables.php"?>
    <script>
        $(function(){
            $('#mytable').DataTable()
        });
    </script>