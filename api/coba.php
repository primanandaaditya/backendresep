<?php
require_once "../koneksi.php";


if(isset($_POST["ids"])){

    $ids=$_POST["ids"];

    $sql="select recipejoin.id,recipejoin.recipe_id,recipejoin.ingredient_id,recipejoin.created,
            recipe.name as recipe_name,ingredient.name as ingredient_available
            from recipejoin
            inner join recipe on recipe.id = recipejoin.recipe_id
            inner join ingredient on ingredient.id = recipejoin.ingredient_id
            where recipejoin.ingredient_id in ($ids) group by recipejoin.recipe_id";
    $hasil = mysqli_query($con,$sql);

    $jml_recipe = mysqli_num_rows($hasil);

    if($jml_recipe==0){

        $status=false;

        $arr=array("status"=>$status,"list_recipe"=>null);
        echo json_encode($arr);

    }else{

        $posisi = array();
        $posisi_hasil_missing = array();


        while($baris = mysqli_fetch_assoc($hasil)) {

            $recipe_id=$baris["recipe_id"];
            $sql_missing_ingredient="select ingredient_id, ingredient.name from
      
                                    (
                                    SELECT ingredient_id FROM recipejoin
                                    WHERE recipe_id = $recipe_id
                                    and
                                    ingredient_id NOT IN
                                    (SELECT ingredient_id from recipejoin where ingredient_id IN ($ids))
                                    )
                                    
                                    as tabel
                                    
                                    inner join ingredient
                                    on tabel.ingredient_id=ingredient.id";


            $hasil_missing=mysqli_query($con,$sql_missing_ingredient);

            $jml_missing = mysqli_num_rows($hasil_missing);

            if ($jml_missing==0){

                $arb=array("recipe_suggest"=>$baris,"missing_count"=>0, "missing_list"=>null);
                $posisi[] = $arb;


            }else{

                unset($posisi_hasil_missing);

                while ($baris_missing=mysqli_fetch_assoc($hasil_missing)){
                    $arc=array("missing_ingredient"=>$baris_missing);
                    $posisi_hasil_missing[]=$arc;
                }



                $arb=array("recipe_suggest"=>$baris,"missing_count"=>$jml_missing,"missing_list"=>$posisi_hasil_missing);
                $posisi[] = $arb;

            }



        }

        $status=true;

        $arr=array("status"=>$status,"list_recipe"=>$posisi);
        echo json_encode($arr);

    }




}else{
    $status=false;

    $arr=array("status"=>$status,"list_recipe"=>"No parameter");
    echo json_encode($arr);

}



?>
