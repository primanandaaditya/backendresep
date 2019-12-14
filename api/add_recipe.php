<?php
require_once "../koneksi.php";

if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["ingredient_list"])){

    $name=$_POST["name"];
    $description=$_POST["description"];
    $ingredientList=$_POST["ingredient_list"];


    //cek apakah data sudah ada?
    $cek = mysqli_query($con,"select * from recipe where name = '$name'");
    if (mysqli_num_rows($cek)==0){

        //insert di tabel master
        $sql="insert into recipe (name,description) VALUES ('$name','$description')";

        if (mysqli_query($con, $sql)) {
            $last_id = mysqli_insert_id($con);

            $data = explode(",",$ingredientList);

            $sqlb="";
            foreach($data as $item) {
                $sqlb .= "INSERT INTO recipejoin (recipe_id,ingredient_id)
                      VALUES ($last_id,$item[0]);";
            }
            if (mysqli_multi_query($con, $sqlb)) {
                $status=true;
                $arr=array("status"=>$status,"message"=>"Insert successfully", "last_id"=>$last_id);
            } else {
                $status=false;
                $arr=array("status"=>$status,"message"=>"Insert failed", "last_id"=>null);
            }

        } else {
            $status=false;
            $arr=array("status"=>$status,"message"=>"Insert failed", "last_id"=>null);
        }
        mysqli_close($con);

    }else{
        $status=false;
        $arr=array("status"=>$status,"message"=>"Data already exist", "last_id"=>null);
    }


}else{
    $status=false;
    $arr=array("status"=>$status,"message"=>"Insert failed, missing parameter", "last_id"=>null);
}

echo json_encode($arr);


?>
