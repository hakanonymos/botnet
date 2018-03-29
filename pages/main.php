<?php
include_once("./includes/header.php"); 
?>
    <main>
        <div class="container">
            <h1 class="thin">Tableau de bord</h1>
            <div id="dashboard">
           <div class="row"> 
            <div class="col s12 m6 l3">
             <div class="card blue lighten-1 hoverable">
            <div class="card-content center-align" style="word-wrap: break-word;">
              <span class="white-text thin" style="font-size: 30px;"><?php echo $online; ?></span>
              <p class="white-text" style="font-size: 15px;"><i class="mdi-action-settings-input-antenna"></i>&nbsp;&nbsp;Bots en ligne</p>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="card purple lighten-1 hoverable">
            <div class="card-content center-align" style="word-wrap: break-word;">
              <span class="white-text thin" style="font-size: 30px;"><?php echo $dead; ?></span>
              <p class="white-text" style="font-size: 15px;"><i class="mdi-communication-portable-wifi-off"></i>&nbsp;&nbsp;Bots morts</p>
            </div>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="card orange lighten-1 hoverable">
            <div class="card-content center-align" style="word-wrap: break-word;">
              <span class="white-text thin" style="font-size: 30px;"><?php echo $total; ?></span>
              <p class="white-text" style="font-size: 15px;"><i class="mdi-action-settings-input-composite"></i>&nbsp;&nbsp;Total des Bots</p>
            </div>
          </div>
        </div>
       <div class="col s12 m6 l3">
          <div class="card green lighten-1 hoverable">
            <div class="card-content center-align" style="word-wrap: break-word;">
              <span class="white-text thin" style="font-size:30px;"><?php echo $total_users; ?></span>
              <p class="white-text" style="font-size: 15px;"><i class="mdi-social-people-outline"></i>&nbsp;&nbsp;Utilisateurs</p>
            </div>
          </div>
        </div>
            </div>
          </div>
		   <div class="col s12 m6 l6">
          <div class="card">
            <div class="card-content ersr">
              <span class="purple-text card-title">Les 5 dernières installations</span>
              <div class="divider"></div>
              <table id="lastfive" class="table ">
							<thead>
								<tr>
									<th>#</th>
									<th>Adresse IP</th>
									<th>Pays</th>
									<th>Date d'installation</th>
									<th>Système d'exploitation</th>
									<th>Privilèges</th>
									<th>Version Bot</th>
								</tr>
							</thead>
							<tbody>
								<?php
								if ($total != "0")
								{
									$bots = $odb->query("SELECT * FROM bots ORDER BY installdate DESC LIMIT 5");
									while ($b = $bots->fetch(PDO::FETCH_ASSOC))
									{
										$id = $b['id'];
										$ip = $b['ipaddress'];
										$cn = geoip_country_name_by_id($gi, $b['country']);
										$fl = strtolower(geoip_country_code_by_id($gi, $b['country']));
										$in = date("m-d-Y, h:i A", $b['installdate']);
										$os = $b['operatingsys'];
										$pv = $b['privileges'];
										$bv = $b['botversion'];
										echo '<tr><td>'.$id.'</td><td>'.$ip.'</td><td>'.$cn.'&nbsp;&nbsp;<img src="./assets/images/flags/'.$fl.'.png" /></td><td>'.$in.'</td><td>'.$os.'</td><td>'.$pv.'</td><td>'.$bv.'</td></tr>';
									}
								}else{
									echo '<tr class="odd"><td colspan="8">No data to display</td></tr>';
								}
								?>
							</tbody>
						</table>
            </div>
          </div>
        </div>
	<div class="row">
	<div class="col s12 m6 l6">
          <div class="card">
            <div class="card-content ersr">
              <span class="purple-text card-title">Top 10 des systèmes d'exploitation</span>
              <div class="divider"></div>              
              <canvas id="os" height="200px" />
              <div class="center">
                 
                </div>
              
            </div>
          </div>
       

        </div>
<div class="col s12 m6 l6">
          <div class="card">
            <div class="card-content ersr">
              <span class="purple-text card-title">Privileges</span>
              <div class="divider"></div>
              <canvas id="crawler_chart" height="200px" />
                <div class="center">
                  
                </div>
            </div>
          </div>
        </div>		
		</div>

          <div class="col s12 m6 l6">
          <div class="card">
            <div class="card-content ersr">
              <span class="purple-text card-title">Meilleurs pays   
     			 </span>
              <div class="divider" ></div>
			          <div id="regions_div" style=" height: 350px;"></div>
               
            </div>
          </div>
        </div>
		  
        </div>
		
		
		
      
    </main>
<?php include_once("includes/footer.php"); 
 ?>
 
 <script type="text/javascript" src="assets/js/chart.min.js?v=2.6.0"></script>
    <script type="text/javascript">
	
     google.charts.load('current', {
        'packages':['geochart'],
        
        'mapsApiKey': 'AIzaSyD-9tSrke72PouQMnMX-a7eZSW0jkFMBWY'
      });
      google.charts.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
         ['Country', 'Visits'],
		   <?php
								
									$csel = $odb->query("SELECT country, COUNT(*) AS cnt FROM bots GROUP BY country ORDER BY cnt");
									while ($c = $csel->fetch())
									{
										$country_name=geoip_country_name_by_id($gi, $c[0]);$name_count=number_format($c[1]);
									
										echo "['".$country_name."','".$name_count."'],";
									}
								
								?>
           
     ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));

        chart.draw(data, options);
      }
      $(window).resize(function(){
  drawRegionsMap();
 
});

 var ctx = document.getElementById('os').getContext('2d');
      var IpsCount = [ <?php 
									$osel = $odb->query("SELECT operatingsys, COUNT(*) AS cnt FROM bots GROUP BY operatingsys ORDER BY cnt DESC LIMIT 10");
									while ($o = $osel->fetch())
									{
									$count= '"'.number_format($o[1]).'",';
									$browser_name='"'.$o[0].'",';
									echo $count ;
									}
						 ?>];

      var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: [
             <?php 
									$osel = $odb->query("SELECT operatingsys, COUNT(*) AS cnt FROM bots GROUP BY operatingsys ORDER BY cnt DESC LIMIT 10");
									while ($o = $osel->fetch())
									{
									$count= '"'.number_format($o[1]).'",';
									$browser_name='"'.$o[0].'",';
									echo $browser_name ;
									}
				 ?>],
            datasets: [{
                label: "Public IP",
                data: IpsCount,
                backgroundColor: ['#ffb74d','#e57373','#ba68c8','#7986cb','#64b5f6','#4dd0e1','#4db6ac','#81c784','#dce775', '#ffd54f'],
            }]
          },
        options: {
          responsive: true,
          legend: {
            display: true
          }
        }
      });
	
var ctx = document.getElementById('crawler_chart').getContext('2d');
      var IpsCount = [<?php $psel = $odb->query("SELECT privileges, COUNT(*) AS cnt FROM bots GROUP BY privileges ORDER BY cnt DESC");
									while ($p = $psel->fetch())
									{
									 $privileges='"'.$p[0].'",';
									 $count= '"'.number_format($p[1]).'",';
									 echo $count ;
									}?>];

      var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [<?php $psel = $odb->query("SELECT privileges, COUNT(*) AS cnt FROM bots GROUP BY privileges ORDER BY cnt DESC");
									while ($p = $psel->fetch())
									{
									 $privileges='"'.$p[0].'",';
									 $count= '"'.number_format($p[1]).'",';
									 echo $privileges ;
									}?>],
            datasets: [{
                label: "Bot Count:",
                data: IpsCount,
                backgroundColor: ['#4db6ac', '#ffb74d','#e57373','#ba68c8','#7986cb','#64b5f6','#4dd0e1','#81c784','#dce775', '#ffd54f'],
            }]
          },
        options: {
          responsive: true,
          legend: {
            display: false
          }
        }
      });	
</script>