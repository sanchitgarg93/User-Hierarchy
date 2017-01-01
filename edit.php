<?php
include('conn.php');
if (isset($_POST['id']) && isset($_POST['user_name']))  
{
    $id = $_POST['id'];
	$user_name = $_POST['user_name'];
	//if(isset($_POST['submit']))

	$user_name=ucwords(strtolower(trim($_POST['user_name'])));
	if((empty($user_name)) || (!(ctype_alpha($user_name))) || ($user_name===null))			//or if($name=='')	;when not using trim->if(ctype_space($name))
	{	
		echo "Enter only alphabets \n";			
		exit();
	}
	if ($stmt=$conn->prepare("UPDATE bas_user SET user_name=? WHERE user_id='$id'"))
	{	
		$stmt->bind_param('s',$user_name);
		$stmt->execute();
		//$recordUpdated = "true";
		echo "Your changes have been made successfully.";
		
		//header( "refresh:0.1 ; url=index.php" );
	}	
}
?>	