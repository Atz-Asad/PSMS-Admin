<?php require_once('header.php') ;
    $id=$_GET['id'];
    $stm=$pdo->prepare("SELECT * FROM teacher WHERE id=?");
    $stm->execute(array($id));
    $result =$stm->fetchAll(PDO::FETCH_ASSOC);

?> 

<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-gradient-primary text-white mr-2">
      <i class="mdi mdi-account-multiple-plus "></i>                 
    </span>
    Teacher Data Veiw
  </h3>
</div>
   <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <table class="table table-bordered table-success" id="data_table_control">
                    <thead>
                      <tr>
                        <th> Name </th>
                        <th>Email </th>
                        <th>Mobile</th>
                        <th>Gender</th>
                      </tr>
                    </thead>
                    <tbody>
                       <tr>
                         <td><?php echo $result[0]['name'] ;?></td>
                         <td><?php echo $result[0]['email'] ;?></td>
                         <td><?php echo $result[0]['mobile'] ;?></td>
                         <td><?php echo $result[0]['gender'] ;?></td>
                       </tr> 
                    </tbody>
                  </table>
            </div>
        </div>
    </div>
 </div>


<?php require_once('footer.php') ;?>  