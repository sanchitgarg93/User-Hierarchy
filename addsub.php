<?php
include('conn.php');
if (isset($_POST['id']) && isset($_POST['selected']))  
{
    $id = $_POST['id'];
	$selectArray = explode(',', $_POST['selected']);
	//if(isset($_POST['submit']))

	foreach ($selectArray as $a)
	{	//SET @nodeId='$a', @parentId = '$id';
		if ($stmt=$conn->prepare("INSERT INTO `reporting` (superior_id,subordinate_id,distance)

								SELECT n.NewSup, n.NewSub, n.depth FROM 
								(
									SELECT superior_id AS NewSup, ? AS NewSub, distance+1 AS depth
									FROM `reporting`
									WHERE subordinate_id = '$id'
									UNION 
									SELECT ?, subordinate_id, distance+1
									FROM `reporting`
									WHERE superior_id = '$a'
									UNION
									SELECT ?, ?, 0
								) AS n
								WHERE NOT EXISTS (SELECT 1 FROM `reporting` WHERE n.NewSup = superior_id AND n.NewSub = subordinate_id)"))
		{	
			$stmt->bind_param('iiii',$a, $id, $a, $a);
			$stmt->execute();
			//$recordUpdated = "true";
			
			//header( "refresh:0.1 ; url=index.php" );
		}
	}
	if (count($selectArray) > 1)
		echo "Subordinates have been added successfully.";
	else
		echo "Subordinate has been added successfully.";	
}
?>	