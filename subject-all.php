<?php require_once('header.php') ;

?>


<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-airballoon"></i>                 
    </span>
     All Subject
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
                        <th>Subject Name </th>
                        <th>Subject Code </th>
                        <th>Subject Type</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $stm = $pdo->prepare("SELECT * FROM subjects");
                        $stm->execute();
                        $i=1;
                        $subjectList=$stm->fetchAll(PDO::FETCH_ASSOC);
                        foreach($subjectList as $subject) :?>
                       <tr>
                         <td><?php echo $i; $i++;?></td>
                         <td><?php echo $subject['name'] ;?></td>
                         <td><?php echo $subject['code'] ;?></td>
                         <td><?php echo $subject['type'] ;?></td>
                         <td>
                            <a href="?id=<?php echo $teacher['id'] ;?>" class="btn btn-sm btn-warning"><i class="mdi mdi-credit-card-multiple "></i></a>&nbsp;
                            <a href="?id=<?php echo $teacher['id'] ;?>" class="btn btn-sm btn-success"><i class="mdi mdi-eye "></i></a>&nbsp;
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