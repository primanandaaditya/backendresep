<?php
require_once "../koneksi.php";

if (isset($_POST["name"]) && isset($_POST["id"]) && isset($_POST["description"]) && isset($_POST["ingredient_list"])){

    $id=$_POST["id"];
    $name=$_POST["name"];
    $description=$_POST["description"];
    $ingredientList=$_POST["ingredient_list"];
    
        $sqlb="update recipe SET name = '$name', description='$description' where id = '$id'";
        if (mysqli_query($con,$sqlb)){

            $sqlc="delete from recipejoin where recipe_id = '$id'";
            if (mysqli_query($con,$sqlc)){

                $data = explode(",",$ingredientList);

                $sqld="";
                foreach($data as $item) {
                    $sqld .= "INSERT INTO recipejoin (recipe_id,ingredient_id)
                      VALUES ($id,$item[0]);";
                }
                if (mysqli_multi_query($con, $sqld)) {
                    $status=true;
                    $arr=array("status"=>$status,"message"=>"Update successfully");
                } else {
                    $status=false;
                    $arr=array("status"=>$status,"message"=>"Update failed");
                }
            }else{

                $status=false;
                $arr=array("status"=>$status,"message"=>"Update failed");
            }
        }else{

            $status=false;
            $arr=array("status"=>$status,"message"=>"Update failed");
        }



}else{
    $status=false;
    $arr=array("status"=>$status,"message"=>"Insert failed, missing parameter", "last_id"=>null);
}

echo json_encode($arr);


?>
