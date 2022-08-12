<?php require_once('header.php') ;
 
 if(isset($_POST['create_btn'])){
    $teacher= $_POST['teacher'];
    $subject= $_POST['subject'];

    // Subject Assign Count
    $subjectCount = getCount('assign_teacher','subject_id',$subject);

     if($subjectCount != 0){
        $error = "Allready Assign Teacher for this Subject!";
    }
    else{
        $insert=$pdo->prepare("INSERT INTO assign_teacher(teacher_id,subject_id) VALUES (?,?)" );
        $insert->execute(array($teacher, $subject ));
        $success = "Teacher Assign Succedssfully!";
    }
 }
?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
    New Subject Assign
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
                <label for="teacher">Teachers:</label>
                <?php 
                 $stm=$pdo->prepare("SELECT id,name FROM teacher");
                 $stm->execute();
                 $tlists=$stm->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <select name="teacher" id="teacher" class="form-control">
                <option value=""></option>
                    <?php 
                     foreach($tlists as $tlist):
                    ?>
                    <option value="<?php echo $tlist['id'];?>"><?php echo $tlist['name'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="form-group">
                <label for="subject">Subject:</label>
                    <?php 
                    $stm=$pdo->prepare("SELECT id,name,code FROM subjects");
                    $stm->execute();
                    $slists=$stm->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                <select name="subject" id="subject" class="form-control">
                <option value=""></option>
                  <?php 
                     foreach($slists as $slist):
                    ?>
                    <option value="<?php echo $slist['id'];?>"><?php echo $slist['name']." - ".$slist['code'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <button type="submit" name="create_btn" class="btn btn-gradient-primary mr-2">Assign Subject</button>
            </form>
        </div>
        </div>
    </div>
 </div>
<?php require_once('footer.php') ;?>  