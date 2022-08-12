<?php require_once('header.php') ;
 
 if(isset($_POST['add_teacher_btn'])){
    $t_name= $_POST['t_name'];
    $t_email= $_POST['t_email'];
    $t_mobile= $_POST['t_mobile'];
    $t_address= $_POST['t_address'];
    $t_gender= $_POST['t_gender'];
    $t_password= $_POST['t_password'];

    // Count Email And Mobile
    $countEmail = getCount('teacher','email',$t_email);
    $countMobile = getCount('teacher','email',$t_mobile);



    if(empty($t_name)){
        $error = "Name is Required!";
    }
    else if(empty($t_email)){
        $error = "Email is Required!";
    }
    else if(!filter_var($t_email, FILTER_VALIDATE_EMAIL)){
        $error = "Email not Valid!";
    }
    else if($countEmail != 0){
        $error = "Email Already Used,Try Another Email!";
    } 
    else if(empty($t_mobile)){
        $error = "Mobile Number is Required!";
    } 
    else if(!is_numeric ($t_mobile)){
        $error = "Mobile Number Must be Number!";
    } 
    else if(strlen($t_mobile) != 11){
        $error = "Mobile Number Must be 11 Digit!";
    } 
    else if($countMobile != 0){
        $error = "Mobile Number Already Used,Try Another Number!";
    }
    else if(empty($t_address)) {
        $error = "Address is Rerquired!";
    }
    else if(empty($t_password)) {
        $error = "Password is Rerquired!";
    }
    else{
        $created_at = date ("Y-m-d h:i:s");
        $password = SHA1($t_password);

        $insert=$pdo->prepare("INSERT INTO teacher(name,email,mobile,address,gender,password,created_at) VALUES (?,?,?,?,?,?,?)" );
        $insert->execute(array(
            $t_name,
            $t_email,
            $t_mobile,
            $t_address,
            $t_gender,
            $password,
            $created_at
        ));
        // $result = $insert->rowCount();
        $success = "Teacher Account Create Succedssfully!";

    }

 }


?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
    Add New Teacher
  </h3>
</div>
   <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
        <div class="card-body">
            <?php if(isset($error)) :?>
                <div class="alert alert-danger">
                    <?php echo $error ;?>
                </div>   
            <?php endif;?>
            <?php if(isset($success)) :?>
                <div class="alert alert-success">
                    <?php echo $success ;?>
                </div>   
            <?php endif;?>
            <form class="forms-sample" method="POST" action="">
            <div class="form-group">
                <label for="t_name">Teacher Name:</label>
                <input type="text" name="t_name" class="form-control" id="t_name" placeholder="Teacher Name">
            </div>
            <div class="form-group">
                <label for="t_email">Teacher Email:</label>
                <input type="email" name="t_email" class="form-control" id="t_email" placeholder="Teacher Email">
            </div>
            <div class="form-group">
                <label for="t_mobile">Teacher Mobile:</label>
                <input type="text" name="t_mobile" class="form-control" id="t_mobile" placeholder="Teacher Mobile">
            </div>
            <div class="form-group">
                <label for="t_adress">Address:</label>
                <input type="text" name="t_address" class="form-control" id="t_adress" placeholder="Address">
            </div>
            <div class="form-group">
                <label for="t_adress">Gender:</label><br>
                <label ><input type="radio" name="t_gender" value="Male" checked> Male</label>&nbsp; &nbsp;
                <label ><input type="radio" name="t_gender" value="Female" > Female</label>
            </div>
            <div class="form-group">
                <label for="t_password">Password:</label>
                <input type="password" name="t_password" class="form-control" id="t_password" placeholder="Password">
            </div>
            
            <button type="submit" name="add_teacher_btn" class="btn btn-gradient-primary mr-2">Create Teacher Account</button>
            </form>
        </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  