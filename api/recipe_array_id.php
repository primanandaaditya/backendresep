<?php
require_once "../koneksi.php";

if (isset($_POST["ids"])){

    $ids=$_POST["ids"];


    $sql="select recipejoin.recipe_id, 
            recipe.name as recipeName,
            group_concat(ingredient.name) as ing_name
            from recipejoin 
            inner join recipe on recipejoin.recipe_id = recipe.id
            inner join ingredient on recipejoin.ingredient_id = ingredient.id
            where recipe.id IN ($ids)
            group by recipe.id";

    $hasil = mysqli_query($con,$sql);

    $posisi = array();

    while($baris = mysqli_fetch_assoc($hasil)) {
        $bhns=$baris["ing_name"];
        $bhn=explode(",",$bhns);

        $arb=array("recipe_name"=>$baris["recipeName"],"list_ingredient"=>$bhn);
        $posisi[] = $arb;
    }

    $status=true;


    $arr=array("status"=>$status,"list_recipe"=>$posisi);
    echo json_encode($arr);

}else{

    $status=false;
    $message="Parameter missing";

    $arr=array("status"=>$status,"list_recipe"=>$message);
    echo json_encode($arr);

}




?>
