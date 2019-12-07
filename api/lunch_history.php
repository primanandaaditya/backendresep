<?php
require_once "../koneksi.php";


  $sql="select lunch_master.id, lunch_master.lunch_date,
        lunch_detail.recipe_id, recipe.name, recipe.pict, recipe.description
        from lunch_master
        inner join lunch_detail on lunch_master.id = lunch_detail.lunch_id
        inner join recipe on recipe.id = lunch_detail.recipe_id
        order by lunch_master.lunch_date desc";

    $hasil = mysqli_query($con,$sql);

    if (mysqli_num_rows($hasil)==0){

        $arr=array("status"=>false,"lunch_list"=>null);
        echo json_encode($arr);

    }else{

        $posisi = array();

        while($baris = mysqli_fetch_assoc($hasil)) {
            $arb=array("lunch"=>$baris);
            $posisi[] = $arb;
        }

        $status=true;

        $arr=array("status"=>$status,"lunch_list"=>$posisi);
        echo json_encode($arr);

    }





?>
