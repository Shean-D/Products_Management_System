<?php

$server="localhost";
$user="root";
$password="";
$db="pms";

$conn=new mysqli($server,$user,$password,$db);

if($conn->connect_error){
    die("Database connection error".$conn->connect_error);
} 

$sql="SELECT * FROM tbl_customers";
$result=$conn->query($sql);

while ($row=$result->fetch_assoc()){
    echo $row['FirstName'];
}