<?php require_once('header.php') ;

$teacher_id = $_SESSION['teacher_logedin'][0]["id"];
 
 if(isset($_POST['submit_btn'])){
    $class_id = $_POST["select_class"];
    if(isset($_POST["select_subject"])){
        $subject_id = $_POST["select_subject"];
    }
    else{
        $subject_id ='';
    }
    $att_date = $_POST["att_date"];

    // Attendance Count
     $stm =$pdo->prepare("SELECT * FROM attendance WHERE class_id=? AND subject_id=? AND teacher_id=? AND attendance_date=?");
     $stm->execute(array($class_id,$subject_id,$teacher_id,$att_date));
     $attCount = $stm->rowCount();

    //  $today = date('Y-m-d');
    
    //  by Default
     $studentCount = NULL;
    
    if(empty($class_id)){
        $error = "Select Class is Required!";
    }
    else if(empty($subject_id)){
        $error = "Select Subject is Required!";
    }
    else if(empty($att_date)){
        $error = "Date  is Required!";
    }
    // else if( $att_date != $today){
    //     $error = "Attandance Date is Wrong!";
    // }
    else if( $attCount == 1 ){
        $error = "Attandace Not Fount";
    }
    else{
        $stm = $pdo->prepare("SELECT * FROM attendance WHERE class_id=? AND subject_id=? AND attendance_date=?");
        $stm ->execute(array($class_id,$subject_id,$att_date));
        $studentCount = $stm->rowCount();
        $studentList = $stm->fetchAll(PDO::FETCH_ASSOC);

        // print_r($studentList);
    }
   
 }

  if(isset($_POST['attendance_submit'])){
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $status = $_POST['status'];

    // print_r($student_id);
    // print_r($student_name);
    // print_r($status);
    $length = count($student_id) ;
    $studentData=[];
    for($i=0;$i<$length;$i++){
        $studentData[$i]['id']=$student_id[$i];
        $studentData[$i]['name']=$student_name[$i];
        $studentData[$i]['status']=$status[$i];
    }
    // echo "<pre>";
    // print_r($studentData);
    // echo "</pre>";



    $final_st_data = json_encode($studentData);
    $class_id = $_POST["class_id"];
    $subject_id = $_POST["subject_id"];
    $att_date = $_POST["attandence_date"];
     
    $insert = $pdo->prepare("INSERT INTO attendance (class_id,subject_id,attendance_date,student_data,teacher_id)VALUES (?,?,?,?,?)");
    $insert ->execute(array($class_id,$subject_id,$att_date,$final_st_data,$teacher_id));
    $success ="Attendance Submit success!";


  }




?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account"></i>                 
    </span>
    Attendance History
  </h3>
</div>
   <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
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
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="select_class">Select Class:</label>
                         <select name="select_class" class="form-control" id="select_class">
                         <option value="">Select Class</option>
                        <?php
                           $stm = $pdo->prepare("SELECT DISTINCT class_name FROM class_routine WHERE teacher_id =?");
                           $stm->execute(array($teacher_id));
                           $i=1;
                           $a=0;
                           $classList=$stm->fetchAll(PDO::FETCH_ASSOC);

                           foreach($classList as $list) :?>
                            <option 
                            <?php 
                             if(isset($_POST['select_class'] ) AND $_POST['select_class'] == $list['class_name']){
                                echo 'selected';               
                             }
                            ?>
                            value="<?php echo $list['class_name'];?>"><?php echo getClassName($list['class_name'],'class_name');?></option>
                            <?php endforeach;?>
                            
                         </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="select_subject">Select Subject:</label>
                        <select name="select_subject" class="form-control" id="select_subject"> 
                            <?php 
                            if(isset($_POST['select_subject'])){
                                echo '<option value="'.$_POST['select_subject'].'">'.getSubjectName($_POST['select_subject']).'</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="att_date">Select Date:</label>
                        <input type="date" name="att_date" value="<?php 
                            if(isset($_POST['att_date'])){
                               echo $_POST['att_date'];
                            }
                            ?>" class="form-control" id="att_date">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <button type="submit" name="submit_btn" class="btn btn-gradient-primary mr-2">Search</button>
                    </div>
                </div>
            </div>
            
            </form>
        </div>
        </div>
    </div>

  <?php if(isset($_POST['submit_btn']) AND $studentCount != NULL):?>

    <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <table class="table table-borderd">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student Name:</th>
                            <th>Absent</th>
                            <th>Present</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1; 
                        
                            $stList = $studentList[0]['student_data'];
                            $stList = json_decode($stList , true);
                            foreach($stList as $newList):
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $newList['name'] ;?></td>
                            <td><?php
                            if($newList['status'] == 0){
                                echo'<i class="mdi mdi-window-close"></i>';
                            }
                           ?></td>   
                            <td><?php  if($newList['status'] == 1){
                                echo'<i class="mdi mdi-check"></i>';
                            }
                            else{
                                echo'<i class="mdi mdi-window-close"></i>';
                            }?></td>   
                        </tr>
                        <?php $i++;  endforeach; ?>
                    </tbody>
                </table>
            </div> 
        </div> 
        <?php endif;?>

     </div>  
 

<?php require_once('footer.php') ;?>  
<script>
    $('#select_class').change(function(){
       let class_id = $(this).val();
       let teacher_id = '<?php echo $teacher_id; ?>';

       $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data:{
            teacher_id:teacher_id,
            class_id:class_id
        },
        success:function(response){
            let data = response;
            // console.log(data);
            $('#select_subject').html(data);
        }
       })
    });
</script>