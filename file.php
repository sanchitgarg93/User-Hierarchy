<?php 

//$recordUpdated = "false";

?>
<script>
/* must apply only after HTML has loaded */    
$(document).ready(function () {
	
	$("#f5").on("submit", function(e) {
        var postData = $(this).serializeArray();
		console.log(postData[0]['value']);						//		2-d associative array
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#addnew").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
        e.preventDefault();
    });

	$("#f2").on("submit", function(e) {
        var postData = $(this).serializeArray();
		console.log(postData[1]['value']);						//		2-d associative array
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#update").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
        e.preventDefault();
    });
	
    <!-------    Deleting single users -------->
	
	$("#f3").on("submit", function(e) {
        var postData = $(this).serializeArray();
		console.log(postData);						//		2-d associative array
        var formURL = $(this).attr("action");
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#delete").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
        e.preventDefault();
    });
	
	<!-------    Deleting multiple users -------->
	
	$("#f6").on("submit", function(e) {
        var vals = [];
		$('input:hidden[name="ch_box[]"]').each(function() {
			vals.push(this.value);
		});	
        var formURL = $(this).attr("action");
        //alert(vals);
		
		$.ajax({
            url: formURL,
            type: "POST",
            data: 'vals='+vals,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#deleteall").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
		e.preventDefault();
    });
	
	
	
	<!-------    ADD Subordinate(s) -------->
	
	$("#addsub").click(function(){
        $("#addForm").slideToggle(1000);
		$("#addsub").hide(1000);
		$("#cancelbutton").show(1000);
	});
	

	$("#cancelbutton").click(function(){
		$("#addsub").show(1000);
		$("#addForm").slideToggle(1000);
	});
	
	<!-- Initialize the plugin for adding subordinates: -->
	$('#multipleselect').multiselect({
		onChange: function() {
			//alert($('#multipleselect').val());
			window.selected = $('#multipleselect').val();
			if (!( typeof(selected) === "undefined" || selected === null || selected == "" ))
				document.getElementById('addsuberror').innerHTML = "";
	
		}
	});
	
	$("#f1").on("submit", function(e) {
		var id = $("#id").val();
        var formURL = $(this).attr("action");
		//alert(window.selected);
        $.ajax({
            url: formURL,
            type: "POST",
            data: 'id='+id+'&selected='+selected,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#add").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
		e.preventDefault();
    });
	
	<!-------    ADD Superior(s) -------->
	$("#addsup").click(function(){
        $("#addForm2").slideToggle(1000);
		$("#addsup").hide(1000);
		$("#cancelbutton2").show(1000);
	});
	

	$("#cancelbutton2").click(function(){
		$("#addsup").show(1000);
		$("#addForm2").slideToggle(1000);
	});
	
	<!-- Initialize the plugin for adding superiors: -->
	$('#multipleselect2').multiselect({
		onChange: function() {
			//alert($('#multipleselect').val());
			window.selected2 = $('#multipleselect2').val();
			if (!( typeof(selected2) === "undefined" || selected2 === null || selected2 == "" ))
				document.getElementById('addsuperror').innerHTML = "";
	
		}
	});
	
	$("#f4").on("submit", function(e) {
		var id = $("#id").val();
        var formURL = $(this).attr("action");
		//alert(window.selected2);
        $.ajax({
            url: formURL,
            type: "POST",
            data: 'id='+id+'&selected='+selected2,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
                $("#add2").remove();
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
		e.preventDefault();
    });
	
	// Submit form data for deletion in the subordinates section
	var formid;
	
	$(".singledelete").on("click", function(e) {
		//var i = $(this).attr('name');
		//alert(i);
		//var supid = $(this).find("#supid").val();
		//var subid = $(this).find("#subid").val();
		//var formURL = $(this).attr("action");
	if(confirm("Are you sure to delete this relationship ?"))
	{	
		var supid = $("#supid").val();
		var subid = $("#subid").val();
		formURL = "singledelete.php"
		alert("superior id: "+supid);
		alert("subordinate id: "+subid);
		//alert("formURL: "+formURL);
        $.ajax({
            url: formURL,
            type: "POST",
            data: 'supid='+supid+'&subid='+subid,
            success: function(data) {
                $('#myModal .modal-header .modal-title').html("Result");
                $('#myModal .modal-body').html(data);
				$('#myModal').on('hidden.bs.modal', function () {
					window.location.reload(true);
				})
			}
        });
		e.preventDefault();
    }
	});
	
	/* show buttons depending upon option selected */
	
	var a = '<?php echo $_POST['post_option']; ?>'; 
	console.log(a);
	if ( a == 2)
		$('#showButton').html('<button type="button" id="update" class="btn btn-success">Update</button>');
	else if ( a == 3)
		$('#showButton').html('<button type="button" id="delete" class="btn btn-success">Delete</button>');
	else if (a == 4)
		$('#showButton').html('<button type="button" id="addnew" class="btn btn-success">Add</button>');
	else if (a == 5)
		$('#showButton').html('<button type="button" id="deleteall" class="btn btn-success">Delete All</button>');
	else
		$('#showButton').html('');
	
	// Submit form data for Add subordinates
	$("#add").on('click', function() {
	
		if ( typeof(selected) === "undefined" || selected === null || selected == "" )
			document.getElementById('addsuberror').innerHTML = "Please select atleast one subordinate.";
		else
			$("#f1").submit();
    });
	
	// Submit form data for Add superiors
	$("#add2").on('click', function() {
	
		if ( typeof(selected2) === "undefined" || selected2 === null || selected2 == "" )
			document.getElementById('addsuperror').innerHTML = "Please select atleast one superior.";
		else
			$("#f4").submit();
    });
	
/*	$(".singledelete").on('click', function() {
		formid = $(this).parent().attr('id');
		alert(formid);
			$("#"+formid).submit();
    });	*/
	
	
	
	// Submit form data for Update
	$("#update").on('click', function() {
		user_name = $('#user_name').val();
		if ( typeof(user_name) === "undefined" || user_name === null || user_name == "" )
			document.getElementById('updateerror').innerHTML = "Please enter a name.";	
		else
		$("#f2").submit();
		});
	
	// Submit form data for Delete
    $("#delete").on('click', function() {
		if(confirm("Are you sure to delete the user ?"))
			$("#f3").submit();
    });
	
	// Submit form data for Delete All
    $("#deleteall").on('click', function() {
		if(confirm("Are you sure to delete user(s) ?"))
			$("#f6").submit();
    });
	
	// Submit form data for adding new user
    $("#addnew").on('click', function() {
        user_name = $('#user_name').val();
		if ( typeof(user_name) === "undefined" || user_name === null || user_name == "" )
			document.getElementById('adderror').innerHTML = "Please enter a name.";	
		else
			$("#f5").submit();
    });
	
	
});
</script>
<div class = "success" style='display:none'> Your changes have been made successfully. </div>
<?php 
include('conn.php');

if (isset($_POST['post_id']) && isset($_POST['post_option']))  
{
    $id = $_POST['post_id'];	
	// Fetch selected user's id & name
	if ($st = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id='$id'"))
		$r = $st->fetch_array(MYSQL_BOTH);
	
	if ($_POST['post_option'] == 1)
	{
		// Check whether user neither has subordinate nor a superior
		/*if ($statemnt = $conn->query("SELECT * FROM `bas_user` WHERE user_id = '$id' AND EXISTS (SELECT 1 FROM `reporting` WHERE user_id = superior_id OR user_id = subordinate_id)"))
			if(!($statemnt->num_rows>0))	
			{	
				$statemnt->close();
			}
		*/
		
		// Fetch all subordinates
		if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id IN ( SELECT subordinate_id FROM `reporting` WHERE superior_id='$id' AND distance>0 )"))
		{
			// Fetch reporting id
			$stmt2 = $conn->query("SELECT reporting_id FROM `reporting` WHERE superior_id='$id' AND distance>0");
?>			
		<div class="row">
			<div class="col-sm-3">	
				<h4> Subordinate(s) </h4>
			</div>
<?php						
			// Check users which which can become subordinates
			if ($statement = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id NOT IN (SELECT subordinate_id FROM `reporting` WHERE user_id = subordinate_id AND distance > 0 UNION SELECT superior_id FROM `reporting` WHERE subordinate_id = '$id' AND distance > 0 UNION SELECT '$id')")) {
				if($statement->num_rows>0) {
?>	
			<div class="col-sm-3">
				<div id ="addsub" style="line-height:35px;">
					<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Add subordinate(s) for <?php echo $r['user_name'] ?>">&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
					</button>
				</div>
			</div>
			<div class="col-sm-6" id="addForm" style="display:none" > 
				<label for="multipleselect" style="line-height:40px;">Select persons who should report to <?php echo $r['user_name'] ?></label>									
				<div class="row">
					<div class="col-sm-6">
					<form id="f1" name = "f1" method="post" action="addsub.php">
						<input type = "hidden" id="id" name="id" value= "<?php echo $r['user_id'] ?>" />
						<div class="form-group">
							<!--<label for="multipleselect">Press Ctrl to select multiple subordinates</label>									
							<select multiple class="form-control" id="multipleselect">-->
							<select id="multipleselect" name="multiselect[]" multiple="multiple">
<?php				
						foreach ($statement as $result){
?>					
								<option name="optionSelected" value="<?php echo $result['user_id'] ?>" required><?php echo $result['user_name']; ?></option>
<?php 
					}
?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<button type="button" class="btn btn-default" id="cancelbutton">Cancel</button>
					</div>
					<div class="col-sm-3">
						<button id="add" type="button" class="btn btn-success">Add</button>
					</div>
					</form>
				</div>
				<span id = "addsuberror" style="color:red"> </span>
			</div>
<?php		
				}
			}
?>			
		</div>
<?php			
			//	Check whether user has subordinates or not
			if((!$stmt->num_rows>0))
			{
				echo "<br/>Uh. Oh! Looks like no one reports to you currently. Keep working your way up the ladder.<br/>";
			}
			else
			{
				$flag = 1;
				
?>
<br/>
<table class = "table" width="100%">
	<tr>
		<th style="text-align: center;">S.No.</th>
		<th style="text-align: center;">Id</th>
		<th style="text-align: center;">Name of person(s) reporting to <?php echo $r['user_name'] ?></th>
		<th style="text-align: center;">Delete</th>
	</tr>
<?php
				$ctr=0;
				while ($row = $stmt->fetch_array(MYSQL_BOTH))
				{
					$row2 = $stmt2->fetch_array(MYSQL_BOTH);
					$ctr++;
?>
	<tr>
		<td style="text-align: center;"><?php echo $ctr ?></td>
		<td style="text-align: center;"><?php echo $row['user_id'] ?></td>
		<td style="text-align: center;"><?php echo $row['user_name'] ?></td>
		<td style="text-align: center;">
			<input type="hidden" id="subid" value= "<?php echo $row['user_id']; ?>" />
			<input type="hidden" id="supid" value= "<?php echo $r['user_id']; ?>" />
			<button type="button" class="btn btn-sm btn-primary singledelete" name="<?php echo $row2['reporting_id']; ?>" title="Delete the relationship of <?php echo $row['user_name'] ?> reporting to <?php echo $r['user_name'] ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
		</td>
	</tr>

<?php
				}
			}
		}
?>
</table>
<br/>
<?php
		// Fetch all superiors
		if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id IN ( SELECT superior_id FROM `reporting` WHERE subordinate_id='$id' AND distance>0 )"))
		{
			// Fetch reporting id
			$stmt2 = $conn->query("SELECT reporting_id FROM `reporting` WHERE subordinate_id='$id' AND distance>0");

?>			
		<div class="row">
			<div class="col-sm-3">	
				<h4> Superior(s) </h4>
			</div>
<?php						
			
			
			/******				  Checking for superiors			******/
			if((!$stmt->num_rows>0))
			{	
				/****** Checking users which can become superiors *****/
				if ($statement = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id NOT IN (SELECT subordinate_id FROM `reporting` WHERE superior_id = '$id' AND distance > 0 UNION SELECT '$id')")){
					if($statement->num_rows>0) {
?>				
			<div class="col-sm-3">
				<div id ="addsup" style="line-height:35px;">
					<button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Add superior(s) for <?php echo $r['user_name'] ?>">&nbsp;&nbsp;<span class="glyphicon glyphicon-plus"></span>&nbsp;
					</button>
				</div>
			</div>
			<div class="col-sm-6" id="addForm2" style="display:none" > 
				<label for="multipleselect" style="line-height:40px;">Select persons who should report to <?php echo $r['user_name'] ?></label>									
				<div class="row">
					<div class="col-sm-6">
					<form id="f4" name = "f4" method="post" action="addsup.php">
						<input type = "hidden" id="id" name="id" value= "<?php echo $r['user_id'] ?>" />
						<div class="form-group">
							<select id="multipleselect2" name="multiselect2[]" multiple="multiple">
<?php				
						foreach ($statement as $result){
?>					
								<option name="optionSelected" value="<?php echo $result['user_id'] ?>" required><?php echo $result['user_name']; ?></option>
<?php 
						}
?>
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<button type="button" class="btn btn-default" id="cancelbutton2">Cancel</button>
					</div>
					<div class="col-sm-3">
						<button id="add2" type="button" class="btn btn-success">Add</button>
					</div>
					</form>
				</div>
				<span id = "addsuperror" style="color:red"> </span>
			</div>
		
<?php		
				
					}
				}
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
		</div>
<br/>
<table class = "table" width="100%" >
<tr>
	<th style="text-align: center;">S.no.</th>
	<th style="text-align: center;">Id</th>
	<th style="text-align: center;">Name of person(s) <?php echo $r['user_name'] ?> reports to</th>
	<th style="text-align: center;">Delete</th>
</tr>
<?php
				$ctr=0;
				while ($row = $stmt->fetch_array(MYSQL_BOTH))
				{
					$row2 = $stmt2->fetch_array(MYSQL_BOTH);
					$ctr++;
?>
	<tr>
		<td style="text-align: center;"><?php echo $ctr ?></td>
		<td style="text-align: center;"><?php echo $row['user_id'] ?></td>
		<td style="text-align: center;"><?php echo $row['user_name'] ?></td>
		<td style="text-align: center;">
			<input type="hidden" id="subid" value= "<?php echo $r['user_id'] ?>" />
			<input type="hidden" id="supid" value= "<?php echo $row['user_id'] ?>" />
			<button type="button" class="btn btn-sm btn-primary singledelete" name = "<?php echo $row2['reporting_id']; ?>" title="Delete the relationship of <?php echo $r['user_name'] ?> reporting to <?php echo $row['user_name'] ?>">
				<span class="glyphicon glyphicon-trash"></span>
			</button>
		</td>
	</tr>
	
<?php
				}
			}
		}
?>
</table>
<?php
	}

	if ($_POST['post_option'] == 2)
	{
		if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id='$id'"))
		{
			$row = $stmt->fetch_array(MYSQL_BOTH)
?>
	<form id="f2" name = "f2" method="post" action="edit.php" class="form-horizontal">
		<input type = "hidden" id="id" name="id" value= "<?php echo $row['user_id'] ?>" />
		
		<div class="form-group">
            <label class="col-xs-3 control-label">Username</label>
                <div class="col-xs-5">
                    <input type = "text" class="form-control" id="user_name" name="user_name" value = "<?php echo $row['user_name'] ?>" />
				</div>
				<div class="col-xs-5 col-xs-offset-3">
					<span id = "updateerror" style="color:red"> </span>
				</div>
		</div>

		<div class="form-group">
            <div class="col-xs-5 col-xs-offset-3">
				<!--<input type="submit" class="btn btn-success" id="submit" name="submit" value="Update" />-->

			</div>
		</div>
		
	</form>
	
			
	 			
	<!--</form>-->
<?php
		}
	}
	
	if ($_POST['post_option'] == 3)
	{
		if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id='$id'"))
		{
			$row = $stmt->fetch_array(MYSQL_BOTH)
?>
	<form id="f3" name ="f3" method="post" action="delete.php" class="form-horizontal">
		<input type = "hidden" id="id" name="id" value= "<?php echo $row['user_id'] ?>" />
		
		<div class="row">
			<div class="col-sm-2 col-sm-offset-1">
				<strong>Username</strong>
			</div>
			<div class="col-sm-9">
				<p class="text-info"><?php echo $row['user_name'] ?></p>
			</div>
		</div>
	</form>
<?php
		}
	}
	
	if ($_POST['post_option'] == 4)
	{
		if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id='$id'"))
		{
			$row = $stmt->fetch_array(MYSQL_BOTH)
?>
	<form id="f5" name ="f5" method="post" action="add.php" class="form-horizontal">
		<div class="form-group">
            <label class="col-xs-3 control-label">Username</label>
                <div class="col-xs-5">
                    <input type = "text" class="form-control" id="user_name" name="user_name" value = "" />
				</div>
				<div class="col-xs-5 col-xs-offset-3">
					<span id = "adderror" style="color:red"> </span>
				</div>
		</div>

		<div class="form-group">
            <div class="col-xs-5 col-xs-offset-3">
				<!--<input type="submit" class="btn btn-success" id="submit" name="submit" value="Add" />-->
			</div>
		</div>
		
	</form>
<?php
		}
	}
	
	if ($_POST['post_option'] == 5)
	{
		$checkedArray = explode(',', $_POST['vals']);
?>
	<form id="f6" name ="f6" method="post" action="multipledelete.php" class="form-horizontal">
		<div class="row">
			<div class="col-sm-2 col-sm-offset-1">	
				<strong>Usernames</strong>
			</div>
			<div class="col-sm-9">
<?php
		foreach ($checkedArray as $i)
		{
			echo '<input type="hidden" name="ch_box[]" value="'. $i. '">';
			if ($stmt = $conn->query("SELECT user_id, user_name FROM `bas_user` WHERE user_id='$i'"))
			{
				$row = $stmt->fetch_array(MYSQL_BOTH)
?>
				<p class="text-info"><?php echo $row['user_name'] ?></p>
<?php 
			}
		}
?>
			</div>
		</div>
	</form>
<?php 
	}
}	
?>