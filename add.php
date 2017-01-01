<?php
include('conn.php');
if (isset($_POST['user_name']))  
{
	$user_name = $_POST['user_name'];
	$user_name=ucwords(strtolower(trim($_POST['user_name'])));
	if((empty($user_name)) || (!(ctype_alpha($user_name))) || ($user_name===null))			//or if($name=='')	;when not using trim->if(ctype_space($name))
	{	
		echo "Enter only alphabets \n";			
		exit();
	}
	try 
	{
		/* switch autocommit status to FALSE. Actually, it starts transaction */
		$conn->autocommit(FALSE);
 
		$stmt0 = $conn->query("START TRANSACTION");
		if (!$stmt0)
			throw new Exception('Wrong SQL: ' . 'START TRANSACTION' . ' Error: ' . $conn->error);
		
		$sql = "INSERT INTO `bas_user` (user_name) VALUES (?)";
		if ($stmt=$conn->prepare($sql))
		{	
			$stmt->bind_param('s',$user_name);
			$stmt->execute();
			//$recordUpdated = "true";
			echo "New user has been added successfully. ";
			//header( "refresh:0.1 ; url=index.php" );
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
?>	