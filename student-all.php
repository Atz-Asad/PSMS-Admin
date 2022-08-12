<?php require_once('header.php') ;

  $stm = $pdo->prepare("SELECT * FROM students ORDER BY id DESC");
  $stm->execute();
  $i=1;
  $studentList=$stm->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
    All Students
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
                        <th> # </th>
                        <th> Name </th>
                        <th>Roll </th>
                        <th>Class</th>
                        <th>Mobile</th>
                        <th>Gender</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach($studentList as $student) :?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo $student['name'] ;?></td>
                         <td><?php echo $student['roll'] ;?></td>
                         <td><?php echo $student['current_class'] ;?></td>
                         <td><?php echo $student['mobile'] ;?></td>
                         <td><?php echo $student['gender'] ;?></td>
                         <td>
                            <a href="teacher-edit.php?id=<?php echo $student['id'] ;?>" class="btn btn-sm btn-warning"><i class="mdi mdi-credit-card-multiple "></i></a>&nbsp;
                            <a href="teacher-details-veiw.php?id=<?php echo $student['id'] ;?>" class="btn btn-sm btn-success"><i class="mdi mdi-eye "></i></a>&nbsp;
                            <a onclick="return confirm('Are You Sure?')" href="teacher-delet.php?id=<?php echo $student['id'] ;?>" class="btn btn-sm btn-danger"><i class=" mdi mdi-delete  "></i></a>
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