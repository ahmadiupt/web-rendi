<style type="text/css">
table{
    width:100%;
    font-family : Arial, Helvetica, sans-serif;
    border-collapse: collapse;
}
th{
    border : 1px solid #ddd;
    padding : 8px;
    text-align: center;
}
td {
    border: 1px solid #ddd;
    padding: 8px;
}

td.angka {
    text-align : right;
}
</style>

<span style= "font-size: 20px; font-weight: bold"> Rekapitulasi Penggajian <br></span>
<br>
<br>
<table >
   <colgroup>
    <col style="width: 5%" class="anggka">
    <col style="width: 15%" class="anggka">
    <col style="width: 20%" class="anggka">
    <col style="width: 20%" class="anggka">
    <col style="width: 20%" class="anggka">
    <col style="width: 20%" class="anggka">
    </colgroup>
<thead>
    <tr>
        <th>No</th>
        <th>Tahun</th>
        <th>Gajih Pokok</th>
        <th>Tunjangan</th>
        <th>Uang Makan</th>
        <th>Total</th>
    </tr>
</thead>
<tbody>
    <?php 
    include "../database/database.php";

    $database = new Database();
    $db= $database->getConnection();
    $selectSql = "SELECT tahun, SUM(P.gapok) jgapok,SUM(P.tunjangan) jtunjangan, SUM(P.uang_makan) juang_makan,SUM(P.gapok)+ SUM(P.tunjangan) + SUM(P.uang_makan) total FROM penggajian P GROUP BY tahun;";
    $stmt = $db->prepare($selectSql);
    $stmt->execute();

    $no =1;
    $total_gapok = 0;
    $total_tunjangan = 0;
    $total_uang_makan = 0;
    $total_total = 0;
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $total_gapok +=$row['jgapok'];
        $total_tunjangan += $row['jtunjangan'];
        $total_uang_makan += $row['juang_makan'];
        $total_total += $row['total'];
    
    ?>
    <tr>
        <td><?php echo $no++ ?></td>
        <td><?php echo $row['tahun']?></td>
        <td><?php echo number_format($row['jgapok'])?></td>
        <td><?php echo number_format($row['jtunjangan'])?></td>
        <td><?php echo number_format($row['juang_makan'])?></td>
        <td><?php echo number_format($row['total'])?></td>
    </tr>

<?php
}
?>
<tr>
        <td colspan="2" >Grand Total</td>
        <td><?php echo number_format($total_gapok)?></td>
        <td><?php echo number_format($total_tunjangan)?></td>
        <td><?php echo number_format($total_uang_makan)?></td>
        <td><?php echo number_format($total_total)?></td>
</tr>
</tbody>
</table>