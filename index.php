<?php
session_start();

$conn = new mysqli('localhost','root','','user_hierarchy');

if (isset($_SESSION['id']))
	if ($_SESSION['role']=="admin")
		header('Location: adminHome.php');
	else
		header('Location: home.php');

if (isset($_POST['register']))
{
	if(!(empty($_POST['name'])))
		$name = ucwords($_POST['name']);
	else
		$nameErr = "Please enter your name";
		
	if(!(empty($_POST['email'])))
		$email = $_POST['email'];
	else
		$emailErr = "Please enter your email";
	
	if(!(empty($_POST['password'])))
		$password = $_POST['password'];
	else
		$passwordErr = "Please enter your password";

	if(!(isset($nameErr) || isset($emailErr) || isset($passwordErr)))
	{
			try 
		{
			/* switch autocommit status to FALSE. Actually, it starts transaction */
			$conn->autocommit(FALSE);
 
			$stmt0 = $conn->query("START TRANSACTION");
			if (!$stmt0)
				throw new Exception('Wrong SQL: ' . 'START TRANSACTION' . ' Error: ' . $conn->error);
		
			$sql = "INSERT INTO bas_user (user_name,email,password) VALUES (?,?,?)";
			if ($stmt = $conn->prepare($sql))
			{
				$stmt->bind_param('sss',$name,$email,$password);
				$stmt->execute();
				$success = true;
?>
				<script type="text/javascript">
					var s = <?php echo json_encode($success); ?>;
					alert("User inserted.");
				</script>
<?php
			}
			else
				throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $conn->error);
 		
			$dist = 0;
			$uid = "(SELECT user_id FROM `bas_user` ORDER BY user_id DESC LIMIT 1)";		
			$sql2 = "INSERT INTO `reporting` (superior_id,subordinate_id,distance) VALUES ($uid,$uid,?)";
			if ($stmt2=$conn->prepare($sql2))
			{
				$stmt2->bind_param('i',$dist);
				$stmt2->execute();
				$stmt2->close();
				echo "Record added to reporting table.";
				//header( "refresh:0.1 ; url=index.php" );
			}
			else
				throw new Exception('Wrong SQL: ' . $sql2 . ' Error: ' . $conn->error);
 
			$conn->commit();
 
		} 
		catch (Exception $e)
		{
			echo 'Transaction failed: ' . $e->getMessage();
			$conn->rollback();
		}
 
		/* switch back autocommit status */
		$conn->autocommit(TRUE);
	}
}
if (isset($_POST['login']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];
	
	if ($stmt = $conn->query("SELECT * FROM bas_user WHERE email = '$email' AND password = '$password'"))
	{
		if($stmt->num_rows>0)
		{	
			$row = $stmt->fetch_array(MYSQL_BOTH);
			
			$_SESSION['id']=$row['user_id'];
			$_SESSION['email']=$row['email'];
			$_SESSION['role']=$row['role'];
			
			if ($row['role'] == "admin")
				header('Location: adminHome.php');
			else
				header('Location: home.php');
		}
		else
			$loginErr = "Email or Password is invalid";
		
	}
}

?>


<!DOCTYPE html>
<html>
	<head>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	
	<meta name="viewport" content = "width=device-width, initial-scale=1">
	
	<!--Custom stylesheet -->
	<link href="custom.css" rel="stylesheet">
	
	<!-- Jquery File -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<script src="jquery-2.2.0.min.js"></script>	
	<script src="custom.js"></script>
	
	<script>
	
		function validateForm()
		{
			var name = document.register.name.value;
			var email = document.register.email.value;
			var password = document.register.password.value;
			var atpos = email.indexOf("@");
			var dotpos = email.lastIndexOf(".");
			
			if (name == null || name == "") {
				alert('Name is empty');
				document.register.name.focus();
				return false;
			}
			else if (name.search(/[^A-Za-z\s]/) != -1) {
				alert('Please enter a valid first name.');
				document.register.name.focus();
				return false;
			}
			else if (email == null || email == "") {
				alert('Email is empty');
				document.register.email.focus();
				return false;
			}
		
			else if (atpos<1 || dotpos<atpos+2 || dotpos+2>=email.length) {
				alert("Please enter a valid e-mail address");
				document.register.email.focus(); 
				return false;
			}
		
			else if (password == null || password == "") {
				alert('Password is empty');
				document.register.password.focus();
				return false;
			}
			else if (password.length < 8) {
				alert("Password must contain 8 or more characters.");
				document.register.password.focus(); 
				return false;
			}
			else if (password.length > 30) {
				alert("Password must not contain more than 30 characters.");
				document.register.password.focus(); 
			return false;
			}
		}
	</script>
	
	</head>
	
	
<body>

<div class="login-page">
  <div class="form">
    <form role="form" name="register" class="register-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
      
	  <input type="text" name="name" value="<?php if (isset($name)) echo $name; ?>" placeholder="Enter your name"/><span class="error"> <?php if(isset($nameErr)) echo $nameErr; ?></span>
	  <input type="text" name = "email" value="<?php if (isset($email)) echo $email; ?>" placeholder="Enter your email"/><span class="error"> <?php if(isset($emailErr)) echo $emailErr; ?></span>
      <input type="password" name="password" placeholder="Enter your password"/><span class="error"> <?php if(isset($passwordErr)) echo $passwordErr; ?></span>
      
       <button name="register" type="submit" onClick = "return validateForm();">Register</button>
       
	  
	  <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
	
    <form class="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
	  <div class = "success" style='display:none'> Registered. You can login now.</div>

	  <input type="text" name="email" placeholder="Enter your email"/>
      <input type="password" name="password" placeholder="Enter your password"/>
      <button name="login" type="submit">Login</button>
	  <br/><br/>
      <span style="color:red;"> <?php if (isset($loginErr)) echo $loginErr; ?></span>
	  <p class="message">Not registered? <a href="#">Create an account</a></p>
	</form>
  </div>
</div>

</body>
</html>
