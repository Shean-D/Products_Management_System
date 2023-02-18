<?php
include '../header.php';
include '../nav.php';
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">User</a></li>
                        <li class="breadcrumb-item active">View</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <?php
            $db= dbConn();
            $sql="SELECT * FROM tbl_users";
            $result=$db->query($sql);
            ?>
            
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($result->num_rows>0){
                        while ($row=$result->fetch_assoc()){
                            ?>
                    <tr>
                        <td><?php echo $row['UserId'];?></td>
                        <td><?php echo $row['FirstName'];?></td>
                        <td><?php echo $row['LastName'];?></td>
                    </tr>
                    <?php
                        }
                    }
                            ?>
                </tbody>
            </table>
        </div>
    </section>
</div>
<?php
include '../footer.php';
