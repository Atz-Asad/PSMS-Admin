<?php require_once('header.php') ;
 
 if(isset($_POST['add_teacher_btn'])){
    $sub_name= $_POST['sub_name'];
    $sub_code= $_POST['sub_code'];
    $sub_type= $_POST['sub_type'];

    // Count Subject Code 
    $codeCount = getCount('subjects','code',$sub_code);

    if(empty($sub_name)){
        $error = "Subject Name is Required!";
    }
    else if(empty($sub_code)){
        $error = "Subject Code is Required!";
    }
    else if(empty($sub_type)){
        $error = "Subject Type is Required!";
    }  
    else if($codeCount != 0){
        $error = "Subject Code Allready Used,Try Another Code!";
    }
    else{
        $insert=$pdo->prepare("INSERT INTO subjects(name,code,type) VALUES (?,?,?)" );
        $insert->execute(array(
            $sub_name,
            $sub_code,
            $sub_type,
        ));
        $success = "Subject Create Succedssfully!";

    }

 }


?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-airballoon "></i>                 
    </span>
    Add New Subject
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
                <label for="sub_name">Subject Name:</label>
                <input type="text" name="sub_name" class="form-control" id="sub_name" placeholder="Subject Name">
            </div>
            <div class="form-group">
                <label for="sub_code">Subject Code:</label>
                <input type="text" name="sub_code" class="form-control" id="sub_code" placeholder=" Subject Code">
            </div>
            <div class="form-group">
                <label for="t_adress">Subject Type:</label><br>
                <label ><input type="radio" name="sub_type" value="Theory"> Theory</label>&nbsp; &nbsp;
                <label ><input type="radio" name="sub_type" value="Practical" > Practical</label>
            </div>
            <button type="submit" name="add_teacher_btn" class="btn btn-gradient-primary mr-2">Create Subject </button>
            </form>
        </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  