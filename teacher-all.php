<?php
require_once('header.php');


?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus"></i>                 
    </span>
   All Teachers
  </h3>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered" id="table_teacher_list">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stm = $pdo->prepare("SELECT * FROM teachers ORDER BY id DESC");
                        $stm->execute();
                        $teacherlist = $stm->fetchAll(PDO::FETCH_ASSOC);
                        $i=1;
                        foreach($teacherlist as $teacher):
                        ?>
                        <tr>
                            <td><?php echo $i;$i++;?></td>
                            <td><?php echo $teacher['name'];?></td>   
                            <td><?php echo $teacher['email'];?></td>   
                            <td><?php echo $teacher['mobile'];?></td>   
                            <td><?php echo $teacher['gender'];?></td>   
                            <td>
                                <a href="" title="edit" class="btn btn-sm btn-warning"><i class="mdi mdi-table-edit"></i></a>&nbsp;
                                <a href="" title="delate"  class="btn btn-sm btn-danger"><i class="mdi mdi-delete"></i></a>
                            </td>   
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php require_once('footer.php'); ?> 