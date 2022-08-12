<?php require_once('header.php') ;?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
     Assigined Subject 
  </h3>
</div>
   <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
              <?php if(isset($_GET['del'])=='success'):?>
                <div class="alert alert-success">Data Delete Successfully</div>
              <?php endif;?>
            <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th style="width:40px;">#</th>
                        <th>Subject Name</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $teacher_id = $_SESSION['teacher_logedin'][0]["id"];
                        $stm = $pdo->prepare("SELECT * FROM assign_teacher WHERE teacher_id=?");
                        $stm->execute(array($teacher_id));
                        $i=1;
                        $lists=$stm->fetchAll(PDO::FETCH_ASSOC);

                        foreach($lists as $list) :?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo getSubjectName($list['subject_id']) ;?></td>
                       </tr> 
                       <?php endforeach ;?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  