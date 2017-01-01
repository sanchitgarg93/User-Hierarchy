<?php
include('conn.php');
if (isset($_POST['supid']) && isset($_POST['supid']))
{
    $supid = $_POST['supid'];	
    $subid = $_POST['subid'];
	
	try 
	{
		/* switch autocommit status to FALSE. Actually, it starts transaction */
		$conn->autocommit(FALSE);
 
		$stmt0 = $conn->query("START TRANSACTION");
		if (!$stmt0)
			throw new Exception('Wrong SQL: ' . 'START TRANSACTION' . ' Error: ' . $conn->error);
		
		$sql = "DELETE FROM `reporting` WHERE subordinate_id=? AND superior_id=?";
		if ($stmt=$conn->prepare($sql))
		{
			$stmt->bind_param('ii',$subid, $supid);
			$stmt->execute();
			$stmt->close();
			
			//header( "refresh:0.1 ; url=index.php" );
		}
		else
			throw new Exception('Wrong SQL: ' . $sql . ' Error: ' . $conn->error);
 
		
		
		$query1 = "UPDATE `reporting`
					SET distance = distance-1
					WHERE subordinate_id = '$subid'
					AND superior_id IN
					(
						SELECT s1.parent FROM
						(
							SELECT superior_id AS parent FROM `reporting` WHERE subordinate_id='$supid' AND distance>0
						) AS s1
					)";
		$query2 = "UPDATE `reporting`
					SET distance = distance-1
					WHERE superior_id = '$supid'
					AND subordinate_id IN 
					(
						SELECT s2.child FROM
						(
							SELECT subordinate_id AS child FROM `reporting` WHERE superior_id='$subid' AND distance>0
						) AS s2
					)";
		$query3 = "UPDATE `reporting`
					SET distance = distance-1
					WHERE superior_id IN
					(
						SELECT s3.parent FROM
						(
							SELECT superior_id AS parent FROM `reporting` WHERE subordinate_id='$supid' AND distance>0
						) AS s3
					)
					AND subordinate_id IN 
					(
						SELECT s4.child FROM
						(
							SELECT subordinate_id AS child FROM `reporting` WHERE superior_id='$subid' AND distance>0
						) AS s4
					)";
		
		if ($stmt1 = $conn->query($query1))
			if ($stmt2 = $conn->query($query2))
				if ($stmt3 = $conn->query($query3))
					echo "User record has been deleted successfully.";
				else
					throw new Exception('Wrong SQL: ' . $query1 . ' Error: ' . $conn->error);
			else
				throw new Exception('Wrong SQL: ' . $query2. ' Error: ' . $conn->error);
		else
			throw new Exception('Wrong SQL: ' . $query3 . ' Error: ' . $conn->error);
			
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