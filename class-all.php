<?php require_once('header.php') ;

?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-airballoon"></i>                 
    </span>
     All Class
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
                        <th style="width:20px;"># </th>
                        <th>Class Name </th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Subject</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stm = $pdo->prepare("SELECT * FROM class");
                        $stm->execute();
                        $i=1;
                        $subjectList=$stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach($subjectList as $sub) :?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo $sub['class_name'] ;?></td>
                         <td><?php echo date('d-m-Y', strtotime($sub['start_date'])) ;?></td>
                         <td><?php echo date('d-m-Y', strtotime($sub['end_date'])) ;?></td>
                         <td><?php
                         // Get Subject Name and Code
                         $subjectList = json_decode($sub['subjects']);
                         foreach($subjectList as $new_sub){
                             echo getSubjectName($new_sub).'<br>';
                         }
                         ?></td>
                         <td>
                            <a href="class-edit-new-add.php?id=<?php echo $sub['id'] ;?>" class="btn btn-sm btn-success"><i class="mdi mdi-credit-card-multiple "></i>Edit Routine</a>&nbsp;
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