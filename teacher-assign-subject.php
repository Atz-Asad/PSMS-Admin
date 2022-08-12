<?php require_once('header.php') ;?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
    Assign Subject &nbsp;&nbsp; <a href="teacher-new-assign.php" class="btn btn-sm btn-info">New Assign</a>
  </h3>
</div>
   <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
              <?php if(isset($_GET['del'])=='success'):?>
                <div class="alert alert-success">Data Delete Successfully</div>
              <?php endif;?>
            <table class="table table-bordered" id="data_table_control">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Teacher Name</th>
                        <th>Subject Name</th>
                        <th>Subject Code</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        // $stm = $pdo->prepare("SELECT * FROM teacher");
                        $stm = $pdo->prepare("SELECT assign_teacher.id , teacher_id,subject_id,teacher.name as teacher_name,subjects.name as subject_name ,code FROM assign_teacher
                         INNER JOIN teacher ON assign_teacher.teacher_id = teacher.id
                         INNER JOIN subjects ON assign_teacher.subject_id = subjects.id
                         ");
                        $stm->execute();
                        $assignList=$stm->fetchAll(PDO::FETCH_ASSOC);
                        $i=1;
                        foreach($assignList as $list) :
                        ?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo $list['teacher_name'] ;?></td>
                         <td><?php echo $list['subject_name'] ;?></td>
                         <td><?php echo $list['code'] ;?></td>
                         <td>
                            <a href="teacher-edit.php?id=<?php echo $list['id'] ;?>" class="btn btn-sm btn-warning"><i class="mdi mdi-credit-card-multiple "></i></a>&nbsp;
                            <a onclick="return confirm('Are You Sure?')" href="teacher-delet.php?id=<?php echo $list['id'] ;?>" class="btn btn-sm btn-danger"><i class=" mdi mdi-delete  "></i></a>
                        </td>
                       </tr> 
                       <?php endforeach ;?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  