<?php require_once('header.php');?>
<?php

    $user_id = $_SESSION['teacher_loggedin'][0]['id'];

    $stm=$pdo->prepare("SELECT * FROM teachers WHERE id=?");
    $stm->execute(array($user_id));
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);

	
    $name = $result[0]['name'];
    $email = $result[0]['email'];
    $mobile = $result[0]['mobile'];
    $gender = $result[0]['gender'];
    $address = $result[0]['address'];
    $ragi_date = $result[0]['created_ad'];
    $photo = $result[0]['photo'];


	// update teachers profile
	if(isset($_POST['profile_update_btn'])){
		$name = $_POST['name'];
		$gender = $_POST['gender'];
		$address = $_POST['address'];
		$photo_name = $_FILES['photo']['name'];

		if(empty($name)){
			$error = " name is Required";
		}
		else if(empty($address)){
			$error = "Address is Required";
		}
		else{

			if(!empty($photo_name)){
				$target_dir = "../images/teachers/";
				$target_file = $target_dir . basename($_FILES["photo"]["name"]);
				$extention = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if($extention != 'png' AND $extention != 'jpg'){
					$error = "photo must jpg or png";
				}
				else{
					$temp_name = $_FILES["photo"]["tmp_name"];
					$final_path =  $target_dir . "user_id". $user_id.".".$extention;
					move_uploaded_file ($temp_name, $final_path);
				}
			}
			else{
				$final_path =  Teacher('photo',$user_id);
			}
			$update = $pdo->prepare("UPDATE teachers SET name=?,email=?,mobile=?,address=?,gender=?,created_ad=?,photo=? WHERE id=? ");
			$update->execute(array(
				$name,
				$email,
				$mobile,
				$address,														
				$gender,
				$ragi_date,
				$final_path,
				$user_id
			));
			$success = "profile update sucessfully!";

		}
	}

?>
<!--Main container start -->
<main class="ttr-wrapper">
	<div class="container-fluid">
		<div class="container-fluid">
			<div class="page-header">
			<h3 class="page-title">
				<span class="page-title-icon bg-gradient-primary text-white mr-2">
				<i class="mdi mdi-account"></i>                 
				</span>
				Update Profile
			</h3>
		</div>
		<div class="row">
			<!-- Your Profile Views Chart -->
			<div class="col-lg-12 m-b30">
				<div class="widget-box">
					<!-- <div class="wc-title">
						<h4>Update Profile</h4>
					</div> -->
					<div class="widget-inner">
						<form class="edit-profile m-b30" method="POST" action="" enctype="multipart/form-data">
							<div class="">
								<?php if(isset($error)) :?>
									<div class="alert alert-danger"><?php echo $error ;?></div>
								<?php endif ;?>

								<?php if(isset($success)) :?>
									<div class="alert alert-success"><?php echo $success ;?></div>
								<?php endif ;?>

								<div class="form-group row">
									<div class="col-sm-10  ml-auto">
										<h3>Your Details</h3>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Name:</label>
									<div class="col-sm-7">
										<input class="form-control" name="name" type="text" value="<?php echo $name ;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Email:</label>
									<div class="col-sm-7">
										<input class="form-control" type="email" value="<?php echo $email;?> "readonly>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Mobile Nmber:</label>
									<div class="col-sm-7">
										<input class="form-control"  type="text" value="<?php echo $mobile;?>"readonly>
									</div>
								</div>
								
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Gender:</label>
									<div class="col-sm-7">
										<label><input 
										<?php
											if($gender =='Male'){echo "checked";}
										?>											
										type="radio" value="Male" name="gender" id=""> Male</label>
										<br>
										<label><input 
										<?php
											if($gender =='Female'){echo "checked";}
										?>
										type="radio" value="Female" name="gender" id=""> Female</label>
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Address:</label>
									<div class="col-sm-7">
										<input class="form-control"  name="address" type="text" value="<?php echo $address ;?>">
									</div>
								</div>
								<div class="form-group row">
									<label class="col-sm-2 col-form-label">Photo:</label>
									<div class="col-sm-7">
										<?php if($photo != null) :?>
										<div class="profile_photo">
											<a target="_blank" href="<?php echo $photo ;?>">
												<img style="height:100px;width:auto;" src="<?php echo $photo ;?>"> 
											</a>
										</div>
										<mark><smal>If won't change photo,skip the photo field.<smal></mark>
										<?php endif ;?>
										<input class="form-control" type="file" name="photo">
									</div>
								</div>
							</div>
							<div class="">
								<div class="">
									<div class="row">
										<div class="col-sm-2">												
										</div>
										<div class="col-sm-7">
											<button type="submit" name="profile_update_btn" class="btn btn-gradient-primary mr-2">Save changes</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- Your Profile Views Chart END-->
		</div>
	</div>
</main>

<?php require_once('footer.php');?>