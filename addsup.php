<?php
include('conn.php');
if (isset($_POST['id']) && isset($_POST['selected']))  
{
    $id = $_POST['id'];
	$selectArray = explode(',', $_POST['selected']);

	foreach ($selectArray as $a)
	{	
		if ($stmt=$conn->prepare("INSERT INTO `reporting` (superior_id,subordinate_id,distance)

								SELECT n.NewSup, n.NewSub, n.depth FROM 
								(
									SELECT ? AS NewSup, subordinate_id AS NewSub, distance+1 AS depth
									FROM `reporting`
									WHERE superior_id = '$id'
									UNION  
									SELECT superior_id, ?, distance+1
									FROM `reporting`
									WHERE subordinate_id = '$a'
									UNION
									SELECT ?, ?, 0
								) AS n
								WHERE NOT EXISTS (SELECT 1 FROM `reporting` WHERE n.NewSup = superior_id AND n.NewSub = subordinate_id)"))
		{	
			$stmt->bind_param('iiii',$a, $id, $a, $a);
			$stmt->execute();

		}
	}
	if (count($selectArray) > 1)
		echo "Superiors have been added successfully.";
	else
		echo "Superior has been added successfully.";	
}
?>	