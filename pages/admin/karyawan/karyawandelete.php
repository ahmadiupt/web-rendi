<?php
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $database = new Database();
    $db = $database->getConnection();

    $selectSql = "SELECT * FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($selectSql);
    $stmt->bindParam(1,$_GET['id']);
    $stmt->execute();

    $no =1;
    $row = $stmt->fetch();
    $pengguna_id = $row['pengguna_id'];

    $deleteSql = "DELETE FROM karyawan WHERE id = ?";
    $stmt = $db->prepare($deleteSql);
    $stmt->bindParam(1,$_GET['id']);
    if($stmt->execute()){
        $deletepeng = "DELETE FROM pengguna WHERE id = ? ";
        $stmtpeng = $db->prepare($deletepeng);
        $stmtpeng->bindParam(1,$pengguna_id);

        if($stmtpeng->execute()){
            $_SESSION['hasil'] = true;
            $_SESSION['pesan'] = "Berhasil Delete Data";
        }else{
            $_SESSION['hasil'] = false;
            $_SESSION['pesan'] = "Gagal Delete Data Pengguna";
        }
    } else{
        $_SESSION['hasil'] = false;
        $_SESSION['pesan'] = "Gagal Delete Data Karyawan";
    }
}
echo "<meta http-equiv='refresh' content='0;url=?page=karyawanread'>";
?>