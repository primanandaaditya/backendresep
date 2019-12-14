<?php
require_once "../koneksi.php";

if (isset($_POST["name"]) && isset($_POST["useby"]) && isset($_POST["id"]) ){

    $name = $_POST["name"];
    $useby = $_POST["useby"];
    $id = $_POST["id"];

    //update di tabel master
    $sql="update ingredient set name = '$name',useby = '$useby' where id = '$id'";

    if (mysqli_query($con, $sql)) {

        $status=true;
        $arr=array("status"=>$status,"message"=>"Update successfully");
    } else {

        $status=false;
        $arr=array("status"=>$status,"message"=>"Update failed");
    }
    mysqli_close($con);

}else{
    $status=false;
    $arr=array("status"=>$status,"message"=>"Update failed, missing parameter");
}

echo json_encode($arr);


?>
