<?php
// Koneksi ke database
$server = "localhost";
$username = "root";
$password = "dlris30g";
$database = "sitdl";

$conn = mysql_connect($server, $username, $password);
mysql_select_db($database, $conn);

// Mengambil data dari POST
$idpc = $_POST['idpc'];
$user = $_POST['user'];
$lokasi = $_POST['lokasi'];
$tipe_perawatan_id = $_POST['tipe_perawatan_id'];
$tahun = $_POST['tahun'];
$selectedItems = $_POST['selected_items']; // Array checkbox yang dicentang
$unselectedItems = $_POST['unselected_items'];
$tanggal = date("Y-m-d");
// Loop melalui setiap item yang dicentang dan simpan ke dalam database

//add perawatan
if(count($selectedItems ) >0 ){
    foreach ($selectedItems as $itemId) {
        //$query_exist = "SELECT * FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'";
        $query_exist =  mysql_query( "SELECT id FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun' ");
        $exist_count = mysql_num_rows($query_exist);

        
        if($exist_count == 0){
            $query = "INSERT INTO perawatan (idpc, tipe_perawatan_id, tipe_perawatan_item_id, tanggal_perawatan ) 
                VALUES ('$idpc', '$tipe_perawatan_id', '$itemId', '$tanggal')";
                
        }
        
        mysql_query($query, $conn);
        
    }
}

//remove perawatan
if(count($unselectedItems ) >0 ){

    foreach ($unselectedItems as $itemId) {
        //$query_exist = "SELECT * FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun'";
        $query_exist =  mysql_query( "SELECT id FROM perawatan WHERE idpc = '$idpc' AND tipe_perawatan_id = '$tipe_perawatan_id' AND tipe_perawatan_item_id = '$itemId' AND YEAR(tanggal_perawatan) = '$tahun' ");
        $exist_count = mysql_num_rows($query_exist);
        // $row	= mysql_fetch_array($query_exist); 
        // $idperawatan = $row[0];
        
       
        // Jika data ditemukan, ambil ID perawatan
        if ($exist_count > 0) {
            $row = mysql_fetch_array($query_exist);
            $idperawatan = $row['id'];
            
            // Hapus data berdasarkan ID yang ditemukan
            $querydelete = "DELETE FROM perawatan WHERE id = '$idperawatan'";
            mysql_query($querydelete, $conn);
        }
        // if($exist_count == 0){
        //     $querydelete = "DELETE FROM perawatan WHERE id = '$idperawatan'  ";
        // }else{
        //     continue;
        // }
        
    
       // mysql_query($querydelete, $conn);
    }
}



// Cek jika ada data yang berhasil disimpan
if (mysql_affected_rows($conn) > 0) {
    echo "Data berhasil disimpan.";
    //echo $exist_count;
} else {
    echo "Gagal menyimpan data.";
}

// Tutup koneksi
mysql_close($conn);
?>