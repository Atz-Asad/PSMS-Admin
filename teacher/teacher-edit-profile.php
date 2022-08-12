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
	$created_at=$result[0]["created_at"];
	$photo=$result[0]["photo"];


// Teacher details Update
if(isset($_POST['save_change'])){
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $photo_name = $_FILES["photo"]["name"];


    if(empty($name)){
        $error = "Name is required!";
    }
     else if(empty($address)){
        $error = "Address is required!";
    }
    else{
        
        if(!empty($photo_name)){
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $extension= strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if($extension != "jpg" && $extension != "png" && $extension != "jpeg"){
                $error = "Photo Must be jpg or png or jepg!";

            }
            else{
                $temp_name =$_FILES["photo"]["tmp_name"];
                $final_path =$target_dir ."user_id_". $user_id.".".$extension;
                move_uploaded_file($temp_name, $final_path);    
            } 
        }
        else{
            $final_path = teacher('photo',$user_id);
        }
        // Update data
        $update = $pdo->prepare("UPDATE teacher SET name=?,email=?,mobile=?,address=?,gender=?,created_at=?,photo=? WHERE id=? ");
        $update->execute(array(
            $name,
            $email,
            $mobile,
            $address,
            $gender,
            $created_at,
            $final_path,
            $user_id
        ));
        $success = "profile update succesfully!";
    } 
}
?>

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-lock"></i>                 
    </span>
    Teacher Edit Profile
  </h3>
</div>

<div class="row">
    <!-- Your Profile Views Chart -->
    <div class="col-lg-12 m-b30">
       <div class="card">
            <div class="card-body">
                    <div class="widget-box">
                    <div class="widget-inner">
                        <form class="edit-profile m-b30" method="POST" enctype="multipart/form-data">
                            <div class="">
                            <?php if(isset($error)):?>
                                <div class="alert alert-danger">
                                    <?php echo $error;?>
                                </div>
                                <?php endif;?>

                                <?php if(isset($success)):?>
                                <div class="alert alert-success">
                                    <?php echo $success;?>
                                </div>
                                <?php endif;?>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Name</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" name="name" type="text" value="<?php echo $name ;?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="email" value="<?php echo $email ;?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Mobile Number</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" type="text" value="<?php echo $mobile ;?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Gender</label>
                                    <div class="col-sm-7">
                                        <label><input
                                        <?php 
                                            if($gender == 'Male'){echo "checked";}
                                        ?>
                                        type="radio" value="Male" name="gender"  id=""> Male</label>
                                        <br>
                                        <label><input
                                        <?php 
                                            if($gender == 'Female'){echo "checked";}
                                        ?>
                                        type="radio" value="Female" name="gender" id=""> Female</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Adress</label>
                                    <div class="col-sm-7">
                                        <input class="form-control" name="address" type="text" value="<?php echo $address ;?>">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Profile Photo</label>
                                    <div class="col-sm-7">
                                        <?php if($photo != null) :?>
                                        <div class="profile-photo">
                                            <a target="_blank" href="<?php echo $photo ;?>"><img style="height:100px; width=auto;" src="<?php echo $photo ;?>" ></a>
                                        </div>
                                        <?php endif;?>
                                        <mark><small>If won't change photo , skip the input field.</small></mark>
                                        <input class="form-control" name="photo" type="file">
                                    </div>
                                </div>
                            <div class="seperator"></div>
                            <div class="">
                                <div class="">
                                    <div class="row">
                                        <div class="col-sm-2">
                                        </div>
                                        <div class="col-sm-7">
                                            <button type="submit" name="save_change" class="btn btn-warning">Save changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>  
          </div>
       </div>
    <!-- Your Profile Views Chart END-->
  </div>
</div>
















<?php require_once('footer.php') ;?>