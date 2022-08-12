<?php require_once('header.php') ;
    $id =$_GET['id'];
    $stm=$pdo->prepare("SELECT * FROM teacher WHERE id=?");
    $stm->execute(array($id));
    $result=$stm->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['add_teacher_btn'])){
        $t_name= $_POST['t_name'];
        $t_address= $_POST['t_address'];
        $t_gender= $_POST['t_gender'];
    
    
        if(empty($t_name)){
            $error = "Name is Required!";
        }
        else if(empty($t_address)) {
            $error = "Address is Required!";
        }
        else{
    
            $insert=$pdo->prepare("UPDATE teacher SET name=?,address=?,gender=? WHERE id=?" );
            $insert->execute(array(
                $t_name,
                $t_address,
                $t_gender,
                $id
            ));
            $success = "Teacher Account Update Succedssfully!";
    
        }
    
     }
    


?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
     Update Teacher Data:
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
                <input type="text" name="t_name" class="form-control" id="t_name" placeholder="Teacher Name" value="<?php echo $result [0]['name']?>">
            </div>
            <div class="form-group">
                <label for="t_email">Teacher Email:</label>
                <input type="email" name="t_email" class="form-control" id="t_email" placeholder="Teacher Email" value="<?php echo $result [0]['email']?>" readonly>
            </div>
            <div class="form-group">
                <label for="t_mobile">Teacher Mobile:</label>
                <input type="text" name="t_mobile" class="form-control" id="t_mobile" placeholder="Teacher Mobile" value="<?php echo $result [0]['mobile']?>" readonly>
            </div>
            <div class="form-group">
                <label for="t_adress">Address:</label>
                <input type="text" name="t_address" class="form-control" id="t_adress" placeholder="Address" value="<?php echo $result [0]['address']?>">
            </div>
            <div class="form-group">
                <label for="t_adress">Gender:</label><br>
                <label ><input type="radio" name="t_gender" value="Male" checked> Male</label>&nbsp; &nbsp;
                <label ><input type="radio" name="t_gender" value="Female" > Female</label>
            </div>
            <button type="submit" name="add_teacher_btn" class="btn btn-gradient-primary mr-2">Update Teacher Account</button>
            </form>
        </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  