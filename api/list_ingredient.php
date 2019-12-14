<?php 
require_once "../koneksi.php"; 
$hasil = mysqli_query($con,"select id,name,useby,pict,
	IF(datediff( now(),useby ) <=0, '1', '0') as isavailable
	 from ingredient order by isavailable desc,name"); 

$jml = mysqli_num_rows($hasil);
if($jml==0){

	$status=false;
		
	$arr=array("status"=>$status,"list_ingredient"=>null);
	echo json_encode($arr);

}else{

	$posisi = array();

    while($baris = mysqli_fetch_assoc($hasil)) {
    	$arb=array("ingredient"=>$baris);
        $posisi[] = $arb;
    } 

	$status=true;
	
	$arr=array("status"=>$status,"list_ingredient"=>$posisi);
	echo json_encode($arr);

}

       
 
?> 
