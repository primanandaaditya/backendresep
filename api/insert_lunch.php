<?php
require_once "../koneksi.php";

if (isset($_POST["ids"])){

    $ids=$_POST["ids"];

    if (isset($_POST["lunch_date"])){
        $lunch_date=$_POST["lunch_date"];
    }else{
        $lunch_date=date('Y-m-d');
    }

    //cek apakah data sudah ada?
    $cek = mysqli_query($con,"select * from lunch_master where lunch_date = '$lunch_date'");
    if (mysqli_num_rows($cek)==0){

        //insert di tabel master
        $sql="insert into lunch_master (lunch_date) VALUES ('$lunch_date')";

        if (mysqli_query($con, $sql)) {
            $last_id = mysqli_insert_id($con);

            $data = explode(",",$ids);

            $sqlb="";
            foreach($data as $item) {
                $sqlb .= "INSERT INTO lunch_detail (lunch_id,recipe_id)
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
