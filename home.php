<?php
session_start();

include('conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Home</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Include Twitter Bootstrap and jQuery: -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>

<?php
if (isset($_SESSION['id']))
{
	$id = $_SESSION['id'];
	if ($stmt = $conn->query("SELECT * FROM bas_user WHERE user_id = '$id'"))
	{
		$row = $stmt->fetch_array(MYSQL_BOTH);
		echo "<a href = 'logout.php' style='float:right'>Logout</a>";
		echo "<h2><em> Hello, ".$row['user_name']."</em></h2>";
		
		if ($stmt1 = $conn->query("SELECT user_id, user_name, email FROM `bas_user` WHERE user_id IN ( SELECT subordinate_id FROM `reporting` WHERE superior_id='$id' AND distance>0 )"))
		{
			if((!$stmt->num_rows>0))
			{
				echo "<br/>Uh. Oh! Looks like no one reports to you currently. Keep working your way up the ladder.<br/>";
			}
			else
			{
				$r1 = $stmt1->fetch_array(MYSQL_BOTH);
				$ctr=0;
?>
<br/>
		<h3> Subordinate(s) </h3>
<table class = "table" width="100%">
	<tr>
		<th style="text-align: center;">S.No.</th>
		<th style="text-align: center;">Id</th>
		<th style="text-align: center;">Name of person(s) reporting to <?php echo $row['user_name'] ?></th>
		<th style="text-align: center;">Email</th>
	
	</tr>
<?php
				while ($r1= $stmt1->fetch_array(MYSQL_BOTH))
				{
					$flag = 1;
					$ctr++;
?>
	<tr>
		<td style="text-align: center;"><?php echo $ctr ?></td>
		<td style="text-align: center;"><?php echo $r1['user_id'] ?></td>
		<td style="text-align: center;"><?php echo $r1['user_name'] ?></td>
		<td style="text-align: center;"><?php echo $r1['email'] ?></td>
<?php	
				}
?>
</table>
<?php
			}
		}
?>
<br/>
		
		
		
<?php
		if ($stmt2 = $conn->query("SELECT user_id, user_name, email FROM `bas_user` WHERE user_id IN ( SELECT superior_id FROM `reporting` WHERE subordinate_id='$id' AND distance=1 )"))
		{
			if((!$stmt->num_rows>0))
			{	
				echo "<br/><br/><br/><p style='margin-left:15px;'>Looks like you don't report to anyone currently. ";
				if (isset($flag))
					if ($flag == 1)
					{
						echo "Hooray! You are the BOSS here.</p>";
						unset($flag);
					}
			}
			else
			{
?>
		
<br/>
<h3> Your immediate superior is :</h3>
<table class = "table" width="100%" >
<tr>
	<th style="text-align: center;">S.no.</th>
	<th style="text-align: center;">Id</th>
	<th style="text-align: center;">Name of person <?php echo $row['user_name'] ?> reports to</th>
	<th style="text-align: center;">Email</th>
</tr>
<?php
				$ctr=0;
				while ($r2 = $stmt2->fetch_array(MYSQL_BOTH))
				{
					$ctr++;
?>
	<tr>
		<td style="text-align: center;"><?php echo $ctr ?></td>
		<td style="text-align: center;"><?php echo $r2['user_id'] ?></td>
		<td style="text-align: center;"><?php echo $r2['user_name'] ?></td>
		<td style="text-align: center;"><?php echo $r2['email'] ?></td>
<?php
				}
			}
		}
	}
}
else
	header('Location: index.php');
?>

</body>
</html>
