<?php
global $wpdb;
$emp = $wpdb->prefix . "employee";
if(isset($_POST['emp_save']) && $_POST['emp_save']!=""){
	$name=$_POST['name'];
	$email=$_POST['email'];
	$phone=$_POST['phone'];
	$address=$_POST['address'];
	$dep_id=$_POST['dep_id'];
	if(file_exists("images/".$_FILES['image']['name'])){
		$fileimage=time()."_".str_replace("", "",basename($_FILES['image']['name']));
	}else{
		$fileimage=$_FILES['image']['name'];
	}
	$temp=$_FILES['image']['tmp_name'];
	if(move_uploaded_file($temp,"image/".$fileimage)){
		$sql="INSERT INTO ".$emp."(`name`,`image`,`email`,`phone`,`address`,`dep_id`) VALUES($name,$fileimage,$email,$phone,$address,$dep_id)";
		$wpdb->get_results($sql,ARRAY_A);
	}	
}

?>
<div class="container">
	<h2>Employment Add</h2>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="name">Name:</label>
		    <input type="text" class="form-control" name="name">
		</div>
		<div class="form-group">
		    <label for="image">Image:</label>
		    <input type="file" class="form-control" name="image">
		</div>
		<div class="form-group">
		    <label for="email">Email:</label>
		    <input type="email" class="form-control" name="email">
		</div>
		<div class="form-group">
		    <label for="phone">Phone:</label>
		    <input type="text" class="form-control" name="phone">
		</div>
		<div class="form-group">
			<label for="address">Address:</label>
			<textarea class="form-control" rows="5" name="address"></textarea>
		</div>
		<div class="form-group">
			<label for="">Department Name</label>
			<select class="form-control" name="dep_id">
				<option></option>
				<?php
				global $wpdb;
				$dep = $wpdb->prefix . "department";
				$sql="SELECT * FROM '".$dep."'";
				$dep=$wpdb->get_results($sql);
				foreach ($dep as $row) 
				{
				?>
				<option name="<?php echo $row['dep_id'];?>"><?php echo $row['dep_name']; ?></option>
				<?php 
				} 
				?>
			</select>
		</div>
		<button type="submit" class="btn btn-default" name="emp_save">Employment Save</button>
	</form>
</div>