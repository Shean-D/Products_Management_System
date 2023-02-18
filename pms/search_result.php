<?php

//extract($_POST);
//print_r($Subject);
include 'system/function.php';
extract($_POST);
$s="'".implode("','", $Subject)."'";
$db= dbConn();
$sql="SELECT * FROM tbl_courses WHERE CourseCode IN($s)";

$result=$db->query($sql);

echo "Found".$result->num_rows;

if($result->num_rows>0){
    while ($row=$result->fetch_assoc()){
        echo $row['CourseName']."<br>";
    }
}


