<?php 
require_once "../koneksi.php";

if (isset($_POST["id"])){

	$id = $_POST["id"];
	
	$sql = "select recipejoin.recipe_id, 
			recipe.name as recipe_name,
			recipe.pict,recipe.description,recipe.created,
			group_concat(ingredient.name) as ingredients
			from recipejoin 
			inner join recipe on recipejoin.recipe_id = recipe.id
			inner join ingredient on recipejoin.ingredient_id = ingredient.id
			where recipe.id = $id
			group by recipejoin.recipe_id";

    $hasil = mysqli_query($con,$sql);
    $jml = mysqli_num_rows($hasil);

    if ($jml==0){

    	$status=false;

	    $arr=array("status"=>$status,"recipe_detail"=>null);
	    echo json_encode($arr);

    }else{

    	$posisi = array();

	    while($baris = mysqli_fetch_assoc($hasil)) {
	        $arb=array("recipe"=>$baris);
	        $posisi[] = $arb;
	    }

	    $status=true;

	    $arr=array("status"=>$status,"recipe_detail"=>$posisi);
	    echo json_encode($arr);

    }

    



}else{
    $message="Parameter tidak mencukupi";
    $status=false;

    $arr=array("status"=>$status,"message"=>$message);
    echo json_encode($arr);

}

 
?> 
