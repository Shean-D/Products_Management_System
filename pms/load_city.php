<?php
include 'system/function.php';
$district_code=$_POST['district_code'];
$db= dbConn();
$sql="SELECT * FROM tbl_city WHERE district_code='$district_code'";
$result=$db->query($sql);
?>

<!--//echo $_POST['district_code'];-->
<select class="form-control form-select"  name="City" id="City">
    <option value=""></option>
    <?php
    if($result->num_rows>0){
        while ($row=$result->fetch_assoc()){
    ?>
    <option value="<?php echo $row['city_code'];?>"><?php echo $row['city_name'];?></option>
    <?php
        }
    }
    ?>
</select>

