
<link rel="stylesheet" href="style/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="style/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="style/js/bootstrap.min.js"></script>
 
<?php


$con = mysqli_connect("localhost", "root", "", "machine");

if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST['input'])) {
		$input = $_POST['input'];
}
if (isset($_POST['result'])) {
		$result = $_POST['result'];
}
if (isset($_POST['review'])) {
		$review = $_POST['review'];
}

if (isset($review)) {//Cheking whether answer is wrong clicked
		$changed    = 1;
		$tempResult = $result;
		if ($result == 'company') {
				$result = "fruit";
		} else if ($result == 'fruit') {
				$result = "company";
		}
}

if (isset($input) && $result) {
		$words = explode(" ", $input); //split sentence into words
		foreach ($words as $word) {
				$word     = strtolower($word);
				$points   = 0;
				$select   = "SELECT * FROM keywords WHERE keywords='" . $word . "'"; //get the word from database
				$checking = mysqli_query($con, $select);
				
				if (!empty($checking))
						if (!$checking->num_rows) { //if new word add them into database
								$sql = "INSERT INTO keywords VALUES(NULL,'$word', '$result','2')"; 
								$con->query($sql);
								
						} else {
								foreach ($checking as $key => $value) {
										$points = $value['points'];
										
								}
								
								if (isset($changed)) { //If answer is wrong decreasing points for keywords 
										
										$pointsDuplicate = $points + 1;
										$points          = $points - 1;
										if ($points > 1) {
												$sql = "UPDATE keywords SET points='$points' WHERE keywords='" . $word . "' AND type = '" . $tempResult . "'";
												$con->query($sql);
										}
										$sql = "UPDATE keywords SET points='$pointsDuplicate' WHERE keywords='" . $word . "' AND type = '" . $result . "'";
										$con->query($sql);
										
								} else { //if answer is right increasing points for keywords
										$pointsDuplicate = $points;
										$points          = $points + 1;
										if ($points < 10) {
												
												
												$sql = "UPDATE keywords SET points='$points' WHERE keywords='" . $word . "' AND type = '" . $result . "'";
												$con->query($sql);
												
										}
										
								}
								
						}
		}
		
?>
<!-- back button again -->
<br>
<form style="margin: 300px 700px;"method="POST" action="index.php">
	

<div style="width: 500px;text-align: center; " class="alert alert-success" role="alert">
  Thank you for your feedback !
</div>
<input style='display:none' type="text" name="text" value="<?php
		echo $input;
?>">
<input style="margin-left:200px" type="submit" class="btn btn-info" value="Go Back">
</form>
<?php
}