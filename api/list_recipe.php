<?php 
require_once "../koneksi.php"; 
$hasil = mysqli_query($con,"select * from recipe order by name"); 

        $posisi = array();

        while($baris = mysqli_fetch_assoc($hasil)) {
        	$arb=array("recipe"=>$baris);
            $posisi[] = $arb;
        } 

		$status=true;
		
		$arr=array("status"=>$status,"list_recipe"=>$posisi);
		echo json_encode($arr);
 
?> 
