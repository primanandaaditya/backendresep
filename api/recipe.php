<?php 
require_once "../koneksi.php"; 
$hasil = mysqli_query($con,"select id,name,useby,pict from ingredient order by name"); 

        $posisi = array();

        while($baris = mysqli_fetch_assoc($hasil)) {
        	$arb=array("ingredient"=>$baris);
            $posisi[] = $arb;
        } 

		$status=true;
		
		$arr=array("status"=>$status,"list_ingredient"=>$posisi);
		echo json_encode($arr);
 
?> 
