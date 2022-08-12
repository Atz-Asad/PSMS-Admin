<?php 
require_once('header.php') ;

$user_id = $_SESSION['teacher_logedin'][0]["id"]; 

        $stm=$pdo->prepare("SELECT * FROM teacher WHERE id=?");
        $stm->execute(array($user_id));
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);

        $name=$result[0]["name"];
        $email=$result[0]["email"];
        $mobile=$result[0]["mobile"];
        $gender=$result[0]["gender"];
        $address=$result[0]["address"];
        $regi_date=$result[0]["created_at"];
        $photo=$result[0]["photo"];
?>

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-lock"></i>                 
    </span>
    Profile
  </h3>
</div>
 <div class="row">
 <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td><b>Name:</b></td>
                        <td><?php echo $name ;?></td>
                    </tr>
                    <tr>
                        <td><b>Email:</b></td>
                        <td><?php echo $email;?></td>
                    </tr>
                    <tr>
                        <td><b>Mobile:</b></td>
                        <td><?php echo $mobile ;?></td>
                    </tr>
                    <tr>
                        <td><b>Gender:</b></td>
                        <td><?php echo $gender ;?></td>
                    </tr>
                    <tr>
                        <td><b>Adress:</b></td>
                        <td><?php echo $address ;?></td>
                    </tr>
                    <tr>
                        <td><b>Registration Date:</b></td>
                         <td><?php echo $regi_date ;?></td>
                     </tr>
                    <tr>
                        <td><b>Profile:</b></td>
                        <td>
                        <?php if($photo != null) :?>
                        <img style="height:100px;width:auto;" src="<?php echo $photo;?>"></span></a>
                        <?php else :?>
                        <img alt="" src="assets/images/testimonials/pic3.jpg" width="32" height="32"></span></a>
                        <?php endif;?>
                        </td>
                    </tr>
                    <tr>
                        <td><a href="teacher-edit-profile.php" class="btn btn-warning">Edit Profile</a></td>
                    </tr>
                </table>
            </div>
        </div>
     </div>
 </div>
<?php require_once('footer.php') ;?>