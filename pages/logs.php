<?php
include_once("./includes/header.php"); 
?>
	<main>
        <div class="container">
						<div id="alerts">
							<?php
							if ($userperms == "user")
							{
								echo '<div class="alert alert-danger">You do not have permission to view this page.</div>';
								die();
							}
							if (isset($_POST['doClear']))
							{
								$odb->query("TRUNCATE plogs");
								echo '<div class="alert alert-success">All logs have been cleared.</div>';
							}
							?>
						</div>
						<table id="botlist" class="table table-condensed table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>IP Address</th>
									<th>Action</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$logs = $odb->query("SELECT * FROM plogs ORDER BY date DESC");
								while ($l = $logs->fetch(PDO::FETCH_ASSOC))
								{
									$id = $l['id'];
									$user = $l['username'];
									$ip = $l['ipaddress'];
									$action = $l['action'];
									$ldate = $l['date'];
									$date = date("m-d-Y, h:i A", $ldate);
									$flag = strtolower(geoip_country_code_by_addr($gi, $ip));
									echo '<tr><td>'.$id.'</td><td>'.$user.'</td><td>'.$ip.'&nbsp;<img src="assets/images/flags/'.$flag.'.png" /></td><td>'.$action.'</td><td data-order="'.$ldate.'">'.$date.'</td></tr>';
								}
								?>
							</tbody>
						</table>
					</div>
				
			
		
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="assets/js/dataTables.bootstrap.js" type="text/javascript"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$("#botlist").dataTable({
				"order": [[ 4, "desc" ]],
				"iDisplayLength": 25,
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				"sDom": '<"ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"lfr>R<C><"#clearall">T<"clear">t<"ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"p>',
				"oLanguage": {
					"sEmptyTable": "No data to display"
				}
			});
			$("#clearall").html('<center><form action="" method="POST"><input type="submit" class="btn btn-danger" name="doClear" value="Clear All Logs"></form></center>');
		});
	</script></div>
	 </main>
<footer class="page-footer grey lighten-3 z-depth-2">
		<div class="footer-copyright grey-text text-darken-3 center-align">
			<div class="container">&copy; 2018 DarkCoders.world</div>
		</div>
	</footer>
