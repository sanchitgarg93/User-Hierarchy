<?php
session_start();

include('conn.php');

if (isset($_SESSION['id']))
{
	$id = $_SESSION['id'];
	if ($stmt = $conn->query("SELECT * FROM bas_user WHERE user_id = '$id'"))
	{
		$row = $stmt->fetch_array(MYSQL_BOTH);
		echo "<a href = 'logout.php' style='float:right'>Logout</a>";
		echo "<h2><em> Hello, ".$row['user_name']."</em></h2>";
	}
}
else
	header('Location: index.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>ALL USERS</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Include Twitter Bootstrap and jQuery: -->
<!--
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
-->

<!-- Include Twitter Bootstrap and jQuery: -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="css/bootstrap.min.css" rel="stylesheet">

<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!-- Include Bootstrap Multiselect plugin's CSS and JS: -->
<link rel="stylesheet" href="css/bootstrap-multiselect.css">
<script src="js/bootstrap-multiselect.js"></script>


<style>
.success {
    width:300px;
    height:20px;
    height:auto;
    position:absolute;
    left:50%;
    margin-left:-100px;
    top:300px;
    background-color: #383838;
    color: #F0F0F0;
    font-family: Calibri;
    font-size: 15px;
    padding:10px;
    text-align:center;
    border-radius: 5px;
    -webkit-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
    -moz-box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
    box-shadow: 0px 0px 24px -1px rgba(56, 56, 56, 1);
}

</style>

<script>

$( document ).ready(function() {
	$('#select_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
	
	
	$('[data-toggle="tooltip"]').tooltip();   
	
	var message = '<?php if (isset($_SESSION['message']))	echo $_SESSION['message']; ?>';
	console.log(message);
	if ( message == true)
		$('.success').fadeIn(400).delay(3000).fadeOut(400);
	flag = 0;
	$("#alldelete").click(function(){
		atLeastOneIsChecked	= $('input:checkbox').is(':checked');
		
		if(!(atLeastOneIsChecked))
		{
			document.getElementById('checkerror').innerHTML = "Please select atleast one user.";
			flag = 1;
		}
		$(".checkbox").click(function(){
			document.getElementById('checkerror').innerHTML = "";
		});	
	});
	$('#myModal').on('show.bs.modal', function (e) { //Modal Event
		if (flag == 1)
			e.preventDefault();
		flag = 0;
			
        var id = $(e.relatedTarget).data('id'); //Fetch id from modal trigger button
		var name = $(e.relatedTarget).data('name'); //Fetch name from modal trigger button
		var option = $(e.relatedTarget).data('option');
		var vals = [];
		$('input:checkbox[name="ch_box[]"]').each(function() {
			if (this.checked) {
				vals.push(this.value);
			}
		});
		
		$('#heading').html(name);
		
	$.ajax({
      type : 'post',
      url : 'file.php', //File that will fetch records 
	  data : 'post_id='+id+'&post_name='+name+'&post_option='+option+'&vals='+vals,	//Pass id and name
      success : function(data){
         $('.form-data').html(data);//Show fetched data from database
       }
    });
    });
	
});
</script>
</head>
<body>
<div class = "success" style='display:none'> All selected users have been deleted successfully. </div>
<?php if (isset($_SESSION['message']))	unset($_SESSION['message']); ?>
<table class = "table" width="100%" border = "1px" >
<tr>
	<th style="text-align: center;">S.no.</th>
	<th style="text-align: center;">Id</th>
	<th style="text-align: center;">Name</th>
	<th style="text-align: center;">Set Reporting Rights</th>
	<th style="text-align: center;">Edit</th>
	<th style="text-align: center;">Delete</th>
	<th style="text-align: center;">Delete All
	<input style="float:left;" type="checkbox" name="select_all" id="select_all" value="" class="checkbox"/></th>
</tr>
<?php
include('conn.php');
if ($stmt = $conn->query("SELECT user_id, user_name FROM bas_user"))
{	
	$ctr=0;
	//while ($row = $stmt->fetch_array(MYSQL_BOTH))
	foreach ($stmt as $row){
		$ctr++;//echo '<pre>';print_r($row);
?>
			<tr>
				<td style="text-align: center;"><?php echo $ctr ?></td>
				<td style="text-align: center;"><?php echo $row['user_id'] ?></td>
				<td style="text-align: center;"><?php echo $row['user_name'] ?></td>
				
				<!-- Set Reporting Rights -->
				<td style="text-align: center;">
					<span data-toggle="tooltip" title="Set Reporting Rights for <?php echo $row['user_name'] ?> ">
						<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-option="1" data-id="<?php echo $row['user_id']?>" data-name="Set reporting rights for <?php echo $row['user_name'] ?>">
							<span class="glyphicon glyphicon-transfer"></span>
						</a>
					</span>
				</td>
				<!-- Edit-->
				<td style="text-align: center;">
					<span data-toggle="tooltip" title="Edit <?php echo $row['user_name'] ?> ">
						<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-option="2" data-id="<?php echo $row['user_id']?>" data-name="Modify user data for <?php echo $row['user_name'] ?>">
							<span class="glyphicon glyphicon-pencil"></span>
						</a>
					</span>
				</td>
				<!-- Delete -->
				<td style="text-align: center;">
					<span data-toggle="tooltip" title="Delete <?php echo $row['user_name'] ?> ">
						<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal" data-option="3" data-id="<?php echo $row['user_id']?>" data-name="Delete user data for <?php echo $row['user_name'] ?>">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</span>
				</td>
				<td style="text-align: center;">
					<!--<form action="multipledelete.php" method="post" onsubmit="return deleteConfirm();"	>-->
						Check to delete
						<input style="float:left;" type = "checkbox" name="ch_box[]" value="<?php echo $row['user_id'] ?>" class="checkbox">
				</td>
<?php			 
	}
}
?>
							
</table>	
<div class= "row">
	<div class= "col-sm-6">
		<span style="float:right" data-toggle="tooltip" title="Add new user">
			<a class="btn btn-danger btn-md" data-toggle="modal" data-target="#myModal" data-option="4" data-id="" data-name="Add New User" >
				<span class="glyphicon glyphicon-plus"></span>
			</a>
		</span>
	</div>
	<div class= "col-sm-6" >	
		<span data-toggle="tooltip" title="Delete all users">	
			<a class="btn btn-primary btn-md" id = "alldelete" data-toggle="modal" data-target="#myModal" data-option="5" data-id="" data-name="Delete user data for" >Delete All</a>
			<span id = "checkerror" style="color:red"> </span>
		</span>
	</div>
</div>
<br/>
<a href= "login.php">Facebook Login Demo<a/><br/>
<!--<a href= "curlex.php">Curl example</a>-->


<!-- Modal -->
<div class="modal" id="myModal" role="dialog">
	<div class="modal-dialog">
    
    <!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title">
						<span id="heading"> </span>
					</h3>
			</div>
			<div class="modal-body">
			<!-- Show the Data returned by file.php-->
				<div class="form-data"></div> 
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<span id = "showButton"> </span>
			</div>
		</div>
    </div>
</div>



</body>
</html>