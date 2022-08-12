<?php 
require_once('config.php');
 $id = $_GET['id'];

 $stm = $pdo->prepare("DELETE FROM teacher WHERE id=?");
 $stm->execute(array($id));
 header('location:teacher-all.php?del=success');

 
?>