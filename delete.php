<?php
include('conn.php');
if (isset($_POST['id']))
{
    $id = $_POST['id'];

/****	METHOD I  ****/
/*
	$stmt=$conn->query("START TRANSACTION");
	$query = "UPDATE `reporting`
				SET distance = distance-1
					WHERE subordinate_id IN
					(
						SELECT s1.NewSub FROM 
						(
							SELECT subordinate_id AS NewSub FROM `reporting` WHERE superior_id=? AND distance>0
						) AS s1
					)
					AND superior_id IN
					(
						SELECT s2.OldSup FROM
						(
							SELECT superior_id AS OldSup FROM `reporting` WHERE subordinate_id=? AND distance>0
						) AS s2
					)";
	if ($stmt1=$conn->prepare($query))
	{
		$stmt1->bind_param('ii',$id, $id);
		$stmt1->execute();
		$stmt1->close();
	}
	else
	{
		echo "Error is ".$conn->errno.":".$conn->error;
		$conn->query("ROLLBACK");
	}
	if ($stmt2=$conn->prepare("DELETE FROM bas_user WHERE user_id=?"))
	{
		$stmt2->bind_param('i',$id);
		$stmt2->execute();
		$stmt2->close();
		echo "User record has been deleted successfully.";
		//header( "refresh:0.1 ; url=index.php" );
	}
	else
	{
		echo "Error is ".$conn->errno.":".$conn->error;
		$conn->query("ROLLBACK");
	}
	if ($stmt1 and $stmt2)
		$conn->query("COMMIT"); 
		
		
*/		
/**** METHOD II ****/	
	
	try 
	{
		/* switch autocommit status to FALSE. Actually, it starts transaction */
		$conn->autocommit(FALSE);
 
		$stmt=$conn->query("START TRANSACTION");
		if($stmt === false)
			throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $conn->error);
 
		$query = "UPDATE `reporting`
				SET distance = distance-1
					WHERE subordinate_id IN
					(
						SELECT s1.NewSub FROM 
						(
							SELECT subordinate_id AS NewSub FROM `reporting` WHERE superior_id=? AND distance>0
						) AS s1
					)
					AND superior_id IN
					(
						SELECT s2.OldSup FROM
						(
							SELECT superior_id AS OldSup FROM `reporting` WHERE subordinate_id=? AND distance>0
						) AS s2
					)";
		if ($stmt1=$conn->prepare($query))
		{
			$stmt1->bind_param('ii',$id, $id);
			$stmt1->execute();
			$stmt1->close();
		}
		else
			throw new Exception('Wrong SQL: ' . $query . ' Error: ' . $conn->error);
 
		$sql = "DELETE FROM bas_user WHERE user_id=?";
		if ($stmt2=$conn->prepare($sql))
		{
			$stmt2->bind_param('i',$id);
			$stmt2->execute();
			$stmt2->close();
			echo "User record has been deleted successfully.";
			//header( "refresh:0.1 ; url=index.php" );
		}
		else
			throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $conn->error);
 
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