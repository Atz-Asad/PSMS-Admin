<?php require_once('header.php') ;

 if(isset($_POST['submit_btn'])){
    $class_id = $_POST["select_class"];

    //  by Default
    $markstCount = NULL;

    if(empty($class_id)){
        $error = "Select Class is Required!";
    }
    else{
        // get class all subject
        $allSubject = $pdo->prepare("SELECT subjects FROM class WHERE id=?");
        $allSubject ->execute(array($class_id));
        $allSubjectList = $allSubject->fetchAll(PDO::FETCH_ASSOC);
        $allSubjectList = $allSubjectList[0]['subjects'];
        $allSubjectArray = json_decode( $allSubjectList);
        // get submit marks list
        $stm = $pdo->prepare("SELECT exam_marks_3.id,exam_marks_3.class_id,exam_marks_3.teacher_id,exam_marks_3.subject_id,exam_marks_3.exam_id,teacher.name as teacher_name, subjects.name as subject_name ,subjects.code as subject_code FROM exam_marks_3 
         INNER JOIN teacher ON exam_marks_3.teacher_id = teacher.id 
         INNER JOIN subjects ON exam_marks_3.subject_id = subjects.id 
         WHERE exam_marks_3.class_id = ?");
        $stm ->execute(array($class_id));
        $markstCount = $stm->rowCount();
        $marksList = $stm->fetchAll(PDO::FETCH_ASSOC);

        $marksubArray =[];
        foreach($marksList as $submark){
            $marksubArray[] = $submark['subject_id'];
        }
        $notSubmited = array_diff($allSubjectArray,$marksubArray);
    }
   
 }

  if(isset($_POST['attendance_submit'])){
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $status = $_POST['status'];
    
    $length = count($student_id) ;
    $studentData=[];
    for($i=0;$i<$length;$i++){
        $studentData[$i]['id']=$student_id[$i];
        $studentData[$i]['name']=$student_name[$i];
        $studentData[$i]['status']=$status[$i];
    }

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
    Student Marks 
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
                           $stm = $pdo->prepare("SELECT id,class_name FROM class ORDER BY class_name ASC");
                           $stm->execute();
                           $i=1;
                           $a=0;
                           $classList=$stm->fetchAll(PDO::FETCH_ASSOC);

                           foreach($classList as $list) :?>
                            <option 
                            <?php 
                             if(isset($_POST['select_class'] ) AND $_POST['select_class'] == $list['id']){
                                echo 'selected';               
                             }
                            ?>
                            value="<?php echo $list['id'];?>"><?php echo $list['class_name'];?></option>
                            <?php endforeach;?>
                         </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                      <button type="submit" name="submit_btn" class="btn btn-gradient-primary mr-2">Check Submit Marks</button>
                    </div>
                </div>
            </div>
            
            </form>
        </div>
        </div>
    </div>

  <?php if(isset($_POST['submit_btn'])):?>

    <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                
                <table class="table table-borderd">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Teacher Name:</th>
                            <th>Subject Name</th>
                            <th>Exam Type</th>
                            <th>Marks Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1; 
                            foreach($marksList as $mark):
                        ?>
                        <tr>
                            <td><?php echo $i;?></td>
                            <td><?php echo $mark['teacher_name'] ;?></td> 
                            <td><?php echo $mark['subject_name']. '-'.$mark['subject_code'] ;?></td> 
                            <td><?php echo getExamName($mark['exam_id']);?></td> 
                            <td><span class="badge badge-success">Submited</td>
                        </tr>
                        <?php $i++; endforeach;

                         foreach($notSubmited as $notSubmit):
                       ?>
                     <tr>
                         <td><?php echo $i;?></td>
                         <td><?php echo getSubjectTeacherName($notSubmit);?></td>
                         <td><?php echo getSubjectName($notSubmit);?></td>
                         <td></td>
                         <td><span class="badge badge-danger">Not  Submited </span></td>
                     </tr>
                     <?php $i++;  endforeach; ?>
                    </tbody>
                </table>
                   
                <?php if(count($notSubmited)== 0) :?>
                    <br>
                    <br>
                    <a href="student-marks-details.php?class=<?php echo $_POST['select_class'];?>" class="btn btn-info">Get Marks Calculation</a>
                 <?php endif;?>  

            </div> 
        </div> 
        <?php endif;?>

     </div>  
 

<?php require_once('footer.php') ;?>  
<script>
    $('#select_class').change(function(){
       let att_class_id = $(this).val();

       $.ajax({
        type: 'POST',
        url: 'ajax.php',
        data:{
            att_class_id:att_class_id
        },
        success:function(response){
            let data = response;
            // console.log(data);
            $('#select_subject').html(data);
        }
       })
    });
</script>