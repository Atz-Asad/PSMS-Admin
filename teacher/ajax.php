<?php
 require_once('../config.php');

if(isset($_POST['class_id'])){
    $class_id = $_POST['class_id'];
    $teacher_id = $_POST['teacher_id'];

    $stm =$pdo->prepare("SELECT subjects.name as subject_name,subjects.code as subject_code,subjects.id as subject_id FROM class_routine
    INNER JOIN subjects ON class_routine.subject_id=subjects.id
    WHERE class_routine.class_name=? ");
    $stm->execute(array($class_id));
    $subject_list =$stm->fetchAll(PDO::FETCH_ASSOC);

    // print_r($subject_list);

//     $stm = $pdo->prepare('SELECT subjects  FROM class WHERE id=?');
//     $stm ->execute(array($class_id));
//     $subject_ids = $stm->fetchAll(PDO::FETCH_ASSOC);
//     $subject_ids = $subject_ids[0]['subjects'];

    // $subject_list = json_decode($subject_ids);
    $get_subject_option = '';
    foreach($subject_list as $new_sub){
        $get_subject_option .= '<option value="'.$new_sub['subject_id'].'">'.$new_sub['subject_name'].'-'.$new_sub['subject_code'].'</option>';
    }
   echo $get_subject_option;
}
?>