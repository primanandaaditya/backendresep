<?php
require_once "../koneksi.php";

if (isset($_POST["name"]) && isset($_POST["useby"]) ){

    $name = $_POST["name"];
    $useby = $_POST["useby"];


    //cek apakah data sudah ada?
    $cek = mysqli_query($con,"select * from ingredient where name = '$name'");
    if (mysqli_num_rows($cek)==0){

        //insert di tabel master
        $sql="insert into ingredient (name,useby) VALUES ('$name','$useby')";

        if (mysqli_query($con, $sql)) {

            $status=true;
            $arr=array("status"=>$status,"message"=>"Insert successfully");

        } else {
            $status=false;
            $arr=array("status"=>$status,"message"=>"Insert failed");
        }
        mysqli_close($con);

    }else{
        $status=false;
        $arr=array("status"=>$status,"message"=>"Data already exist");
    }
    
}else{
    $status=false;
    $arr=array("status"=>$status,"message"=>"Insert failed, missing parameter");
}

echo json_encode($arr);


?>
