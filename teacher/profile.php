<?php require_once('header.php');?>
<?php

    $user_id = $_SESSION['teacher_loggedin'][0]['id'];

    $stm=$pdo->prepare("SELECT * FROM teachers WHERE id=?");
    $stm->execute(array($user_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

    $name = $result[0]['name'];
    $email = $result[0]['email'];
    $mobile = $result[0]['mobile'];
    $gender = $result[0]['gender'];
    $address = $result[0]['address'];
    $ragi_date = $result[0]['created_ad'];
    $photo = $result[0]['photo'];

?>
<!--Main container start -->
<main class="ttr-wrapper">
    <div class="container-fluid">
        <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white mr-2">
            <i class="mdi mdi-account"></i>                 
            </span>
            Profile
        </h3>
    </div>
    <!-- Card -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <?php if(isset($error)) :?>
                    <div class="alert alert-danger">
                        <?php  echo $error ;?>
                    </div>
                    <?php endif ;?>

                    <?php if(isset($success)) :?>
                    <div class="alert alert-success">
                        <?php  echo $success ;?>
                    </div>
                    <?php endif ;?>
                    <table class="table">
                        <tr>
                            <td><b>Name :</b></td>
                            <td><?php echo $name;?></td>
                        </tr>
                        <tr>
                            <td><b>Email :</b></td>
                            <td><?php echo $email; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Mobile :</b></td>
                            <td><?php echo $mobile; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Gender :</b></td>
                            <td><?php echo $gender;?></td>
                        </tr>
                        <tr>
                            <td><b>Address :</b></td>
                            <td><?php echo $address;?></td>
                            
                        </tr>
                        <tr>
                            <td><b>Registration date :</b></td>
                            <td><?php echo $ragi_date;?></td>                          
                        </tr>
                        <tr>
                            <td><b>Profile Photo :</b></td>
                            
                            <td>
                                <?php if($photo !=null):?>
                                    <img style="width:100px;height:100px;border-radius:0;" src="<?php echo $photo ;?>">
                                <?php else :?>
                                    <img alt="" src="assets/images/testimonials/pic3.jpg" width="32" height="32">
                                <?php endif;?>
                            </td>                          
                        </tr>
                        <tr>
                            <td><a href="edit-profile.php" class="btn btn-warning">Edit profile</a></td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Card END -->
        
    </div>
</main>

<?php require_once('footer.php');?>