<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    $deleteSql = "DELETE FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1,$_GET['id']);
    if($stmt->execute()){
        $deletepeng = "DELETE FROM pengguna SET "
        $_SESSION['hasil'] = true;
        $_SESSION['pesan'] = "Berhasil Delete Data";
    } else{
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Delete Data";
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=lokasiread'>";
?>