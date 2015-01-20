<?php

if (isset($_FILES['xlsfile']) && count($_FILES)) {
	
	//echo "<pre>";	print_r($_FILES);echo "</pre>";

	if(!preg_match("/\.xlsx?$/i",$_FILES['xlsfile']['name'])){
		die("Error: please upload a xls file");
	}

	if (move_uploaded_file($_FILES["xlsfile"]["tmp_name"], "/tmp/tmp.xls")) {
		
		$data = new Spreadsheet_Excel_Reader('/tmp/tmp.xls');
		
		//echo "<li>".count($data->sheets)." sheets";
		//echo "<li>".count($cols=$data->sheets[0]['cells'][1])." cols";
		//echo "<li>".count($data->sheets[0]['cells'])." cells";

		
		$cols=$data->sheets[0]['cells'][1];
		$cells=$data->sheets[0]['cells'];

		//col mapping
		//echo "<pre>cols:";print_r($cols);echo "</pre>";
		$map=['email'=>0,'first_name'=>0,'last_name'=>0];
		foreach($cols as $k=>$col){
			if(isset($map["$col"]))$map["$col"]=$k;
		}

		//echo "<pre>colmap:";print_r($map);echo "</pre>";
		
		// Clear student_bulk_import
		$sql = "DELETE FROM edxcrm.student_bulk_import WHERE 1;";
        $q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));


		for ($i=2; $i<count($cells); $i++) {
		
			$r=$cells[$i];
			
			$email=@$r[$map['email']];
			$first_name=@$r[$map['first_name']];
			$last_name=@$r[$map['last_name']];
			//$email=$row[0];

			$first_name=utf8_decode($first_name);
			$last_name=utf8_decode($last_name);

			$password=md5(rand(1,9999999999));
        	$password=substr($password,0,8);
        	
        	$login=explode('@', $email)[0];

        	$sql = "INSERT INTO edxcrm.student_bulk_import (sbi_email, sbi_login, sbi_first_name, sbi_last_name, sbi_password) ";
        	$sql.= "VALUES (".$admin->db()->quote($email).", '$login', ".$admin->db()->quote($first_name).", ".$admin->db()->quote($last_name).", '$password');";

        	$q=$admin->db()->query($sql) or die(print_r($admin->db()->errorInfo(), true));
		}
		echo "<script>document.location.href='index.php';</script>";

	} else {
		echo "Error uploading file";
	}
	
	
}