<?php require_once('header.php') ;?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
     Assigined Class 
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
                        <th>Class Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php
                        $teacher_id = $_SESSION['teacher_logedin'][0]["id"];
                        $stm = $pdo->prepare("SELECT DISTINCT class_name FROM class_routine WHERE teacher_id =?");
                        $stm->execute(array($teacher_id));
                        $i=1;
                        $classList=$stm->fetchAll(PDO::FETCH_ASSOC);

                        foreach($classList as $list) :?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo getClassName($list['class_name'],'class_name')  ;?></td>
                         <td>
                            <a href="class-details.php?id=<?php echo $list['class_name'];?>" class="btn btn-sm btn-success"><i class="mdi mdi-eye "></i>Veiw Class Details</a>
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