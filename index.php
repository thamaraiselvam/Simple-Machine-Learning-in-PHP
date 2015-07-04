<script type="text/javascript">
	
function ajax(){

//alert(document.getElementById('result').value);
var checkedValue = document.getElementById('check').checked;
alert(checkedValue);
var result = document.getElementById("result").innerText;
alert(result);

}

</script>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="style/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="style/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="style/js/bootstrap.min.js"></script>
 
<?php

// echo "<pre>";
// print_r($_POST);
// echo "</pre>";
?>
 <form action="#" method = "post">
 	<textarea placeholder="Enter about Apple product or fruit" style="margin: 50px; height: 209px; width: 520px;margin-left: 600px;border-color: lightpink;" name="text"><?php if(isset($_POST['text'])) echo $_POST['text']; ?></textarea>
 	<br>
 	<br>
 	
 	<input style="margin-left: 764px;width: 200px;background-color: lightpink;border-radius: 10px;border-color: green;" name="submit" type="submit">
 </form>
 	<br>
 	<br>
 	<br>
 	<br>
<?php if (isset($_POST['submit'])) { ?>
 <div class="row">
  <div class="col-md-4" style="margin-left: 573px;">

<div class="progress">
  <div class="progress-bar progress-bar-success" id='companyResult' style="width: 0%">
    
  </div>
  <div class="progress-bar progress-bar-warning " id='fruitResult' style="width: 0%">
    
  </div>
  <div class="progress-bar progress-bar-danger" id='neutralResult' style="width: 0%">
    
  </div>
</div>
 </div>


</div>

<?php
}


$con = mysqli_connect("localhost","root","","machine");

if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
$companyPoints=0;
$applePoints=0;
$neutralPoints=0;	
if (isset($_POST['submit'])) {
	$words = explode(" ", $_POST['text']);
		foreach ($words as $word) {
			$word=strtolower($word);
			$points=0;
			$keywords='';
			$sql="SELECT * FROM keywords WHERE keywords='".$word."'"; 
			$result = $con->query($sql);
			if(!empty($result)){


					foreach ($result as $key => $value) 
					{
						$points= $value['points'];
						$keywords= $value['type'];
						if($keywords=='company'){
						$companyPoints=$companyPoints+$points;
					}
					else if($keywords=='fruit'){
						$applePoints=$applePoints+$points;
					}

					else if($keywords=='neutral'){
						$neutralPoints=$neutralPoints+$points;
					}
					}
				}
		}

echo "<button type='button' style='margin-left: 647px;'class='btn btn-success'>Points For Company :<span id='company'>$companyPoints</span></button>";
//echo "Points for company:<span id='company'>$companyPoints</span><br>";
echo "<button type='button' class='btn btn-warning'>Points For Fruit :<span id='fruit'>$applePoints</span></button>";
echo "<button type='button' class='btn btn-danger'>Points For Neutral :<span id='neutral'>$neutralPoints</span></button>";

// echo "Points for Fruit:<span id='fruit'>$applePoints</span><br>";
// echo "Points for Neutral:<span id='neutral'>$neutralPoints</span><br>";

	if ($companyPoints>$applePoints && $companyPoints >$applePoints) {
		echo "<h1  style='text-align: center;margin-right: 200px;'>You are talking about <span style='color: green;'>COMPANY</span></h1>";
		$result='company';
	}
	else if($applePoints>$neutralPoints){
		echo "<h1  style='text-align: center;margin-right: 200px;'>You are talking about <span style='color: orange;'>FRUIT</span></h1>";
		$result='fruit';
	}
	

	else  {
		echo "<h1  style='text-align: center;margin-right: 200px;'>Oops this is <span style='color: red;'>neutral</span></h1>";
		$result='neutral';
	}


?>
<script type="text/javascript">
	var company=document.getElementById('company').innerHTML;
	var fruit=document.getElementById('fruit').innerHTML;
	var neutral=document.getElementById('neutral').innerHTML;

	var total=parseInt(company)+parseInt(fruit)+parseInt(neutral);
	console.log(total);

	var muliplier=100/total;
	console.log(muliplier);
	
	company=company*muliplier;
	fruit=fruit*muliplier;
	neutral=neutral*muliplier;
	 //document.getElementById("companyResult").css('width',company+"%");
	document.getElementById("companyResult").style["width"] = company+"%";
	document.getElementById("fruitResult").style["width"] = fruit+"%";
	document.getElementById("neutralResult").style["width"] = neutral+"%";
	
</script>
<form class="feedback" method="POST" style="width: 299px;height: 100px;border-width: 5px;border-color: red;background: lightblue; margin-left: 750px;" action="thankyou.php">
<input style="display:none" type="input" name="result" value="<?php echo $result?>">
<label style="margin-left: 60px;" >Please Give us Feedback</label><br>

<input style="display:none"  name="input" type="text" value="<?php echo $_POST['text']?>">

<input style="margin-left: 92px;" type="checkbox" name="review" id="check" value="1" >Answer is wrong
<br>
<input class="btn btn-primary"  style="margin-left: 45px;width: 200px;/* margin-bottom: -22px; */"type="submit" value="Submit Feedback">
</form>

<?php

}