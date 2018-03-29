<?php
include_once("includes/header.php"); 
?>
<main>
<div class="container">
<h1 class="thin">My Account</h1>
				<?php
				if (isset($_POST['doChange']))
				{
					$oldpass = $_POST['oldpass'];
					$newpass = $_POST['newpass'];
					$newpas2 = $_POST['newpass2'];
					if (empty($oldpass) || empty($newpass) || empty($newpas2))
					{
						echo '<div class="card col s12 m10 l8 offset-m1 offset-l2 red white-text"><div class="card-content center-align">One of the fields were empty.</div></div><meta http-equiv="refresh" content="2">';
					}else{
						if ($newpass == $newpas2)
						{
							$oh = hash("sha256", $oldpass);
							$op_sql = $odb->prepare("SELECT password FROM users WHERE username = :u");
							$op_sql->execute(array(":u" => $username));
							$op = $op_sql->fetchColumn(0);
							if ($oh == $op)
							{
								$nh = hash("sha256", $newpass);
								$up = $odb->prepare("UPDATE users SET password = :p WHERE username = :u");
								$up->execute(array(":p" => $nh, ":u" => $username));
								echo '<div class="card col s12 m10 l8 offset-m1 offset-l2 red white-text"><div class="card-content center-align">Password has been changed successfully. Reloading...</div></div><meta http-equiv="refresh" content="2">';
								
							}else{
								echo '<div class="card col s12 m10 l8 offset-m1 offset-l2 red white-text"><div class="card-content center-align">Current password was incorrect.</div></div><meta http-equiv="refresh" content="2">';
							}
						}else{
							echo '<div class="card col s12 m10 l8 offset-m1 offset-l2 red white-text"><div class="card-content center-align">New password did not match.</div></div><meta http-equiv="refresh" content="2">';
						}
					}
				}
				
				?>
		
		
				<div class="row">
				 <div class="col s12">  
						
							<?php
							$ls = $odb->prepare("SELECT ipaddress FROM plogs WHERE username = :u AND action = 'Logged in' ORDER BY date DESC LIMIT 1,1");
							$ls->execute(array(":u" => $username));
							$l = $ls->fetchColumn(0);
							if ($l == "" || $l == NULL)
							{
								$l = "Unknown";
							}else{
								$l .= '&nbsp;<img src="img/flags/'.strtolower(geoip_country_code_by_addr($gi, $l)).'.png">';
							}
							?>
							<i class="material-icons">fingerprint</i> <?php echo $username; ?>
							<small class="pull-right right"><i class="material-icons">swap_vert</i>Last Known IP: <b><?php echo $l; ?></b></small>
						
					
				</div>
			</div>
  <div class="row">
    <div class="col s12">  
      <ul class="tabs tabs-fixed-width z-depth-1">
	       

        <li class="tab col s3"><a href="#password">Change Password</a></li>
        <li class="tab col s3"><a href="#profile">Last 5 Logs</a></li>
      </ul>
    </div>
 <div id="password" class="col s12">			
	<div class="card">
       <div class="card-content">
        
            <div class="row">		
						<form action="" method="POST">
							<label>Current Password</label>
							<input type="password" class="form-control" name="oldpass">
							<br>
							<label>New Password</label>
							<input type="password" class="form-control" name="newpass">
							<br>
							<label>New Password Confirm</label>
							<input type="password" class="form-control" name="newpass2">
							<br>
							<input type="submit" class="btn btn-danger right" name="doChange" value="Change Password">
						</form>
					
		    </div>
		</div>
	</div>
</div>		
    <div id="profile" class="col s12">
      <div class="card">
        <div class="card-content">
        
            <div class="row">
			
               
						
						<table class="table table-condensed table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>IP Address</th>
									<th>Action</th>
									<th>Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$lgs = $odb->prepare("SELECT * FROM plogs WHERE username = :u ORDER BY date DESC LIMIT 5");
								$lgs->execute(array(":u" => $username));
								while ($lg = $lgs->fetch(PDO::FETCH_ASSOC))
								{
									echo '<tr><td>'.$lg['id'].'</td><td>'.$lg['ipaddress'].'&nbsp;<img src="img/flags/'.strtolower(geoip_country_code_by_addr($gi, $lg['ipaddress'])).'.png"></td><td>'.$lg['action'].'</td><td>'.date("m-d-Y, h:i A", $lg['date']).'</td></tr>';
								}
								?>
							</tbody>
						</table>
                
            
              
              
            </div>
           
      
        </div>
      </div>
    </div>

</div>
</div>
</main>
<?php include_once('includes/footer.php');
?>