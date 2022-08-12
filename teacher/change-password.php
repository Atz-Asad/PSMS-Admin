<?php require_once('header.php') ;
 
 if(isset($_POST['change_btn'])){
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_new_password = $_POST["confirm_new_password"];
    
     
    $teacher_id = $_SESSION["teacher_logedin"][0]['id'];
    $statement = $pdo->prepare('SELECT password FROM teacher WHERE id=?');
    $statement->execute(array($teacher_id));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $db_password = $result[0]['password'];

    if(empty($current_password)){
        $error = "Current Password is Reruired !";
    }
     else if(empty($new_password)){
        $error = "New Password is Reruired !";
    }
    else if(empty($confirm_new_password)){
        $error = "Confirm New Password is Reruired !";
    }
    else if($new_password != $confirm_new_password){
        $error = " New Password And Confirm Password does't Match !";
    }
    else if(SHA1($current_password) != $db_password){
       $error = "Current Password And Database Password does't match!";
    }
    else{
        $new__password = SHA1($confirm_new_password);
        $stm=$pdo->prepare("UPDATE teacher SET password=? WHERE id=?");
        $stm->execute(array($new__password,$teacher_id));
        $success = "Password Change Successfully!";
        
    }
 }


?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-lock"></i>                 
    </span>
    Change Password
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
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Username">
            </div>
            <div class="form-group">
                <label for="new_password">Password</label>
                <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Password">
            </div>
            <div class="form-group">
                <label for="confirm_new_password">Confirm Password</label>
                <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password" placeholder="Password">
            </div>
            <button type="submit" name="change_btn" class="btn btn-gradient-primary mr-2">Change Password</button>
            </form>
        </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  