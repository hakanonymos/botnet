<?php
include_once('./includes/header.php');
?><main>
					  <div class="container">  
					   <h1 class="thin">Users</h1>
					  <div id="dashboard">
					  <div class="row">
	
						<?php
						if ($userperms == "user")
						{
							echo '<div class="alert alert-danger">You do not have permission to view this page.</div>';
							die();
						}
						if (isset($_POST['doAdd']))
						{
							$user = $_POST['username'];
							$pass = hash("sha256", $_POST['password']);
							$perm = $_POST['permissions'];
							if (ctype_alnum($user))
							{
								if (ctype_digit($perm))
								{
									switch ($perm)
									{
										case "1":
											$perm = "user";
											break;
										case "2":
											$perm = "moderator";
											break;
										case "3":
											$perm = "admin";
											break;
									}
									$i = $odb->prepare("INSERT INTO users VALUES(NULL, :u, :p, :pr, '1')");
									$i->execute(array(":u" => $user, ":p" => $pass, ":pr" => $perm));
									$i2 = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
									$i2->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":r" => "Created user ".$user));
									echo '<div class="alert alert-success">Successfully added new user. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
								}else{
									echo '<div class="alert alert-danger">Permissions was not a digit.</div>';
								}
							}else{
								echo '<div class="alert alert-danger">Username\'s must be alpha-numeric only.</div>';
							}
						}
						if (isset($_GET['del']))
						{
							
							$del = $_GET['del'];
							if (!ctype_digit($del))
							{
								echo '<div class="alert alert-danger">User ID was not a digit. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
							}else{
								if ($del != "1")
								{
									$un = $odb->query("SELECT username FROM users WHERE id = '".$del."'")->fetchColumn(0);
									$d = $odb->prepare("DELETE FROM users WHERE id = :i LIMIT 1");
									$d->execute(array(":i" => $del));
									$i3 = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
									$i3->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":r" => "Deleted user ".$un));
									echo '<div class="alert alert-success">User has been deleted. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
								}else{
									echo '<div class="alert alert-danger">This user cannot be deleted. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
								}
							}
						}
						if (isset($_GET['ban']))
						{
							$ban = $_GET['ban'];
							if (!ctype_digit($ban))
							{
								echo '<div class="alert alert-danger">User ID was not a digit. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
							}else{
								if ($ban != "1")
								{
									list($st,$un) = $odb->query("SELECT status,username FROM users WHERE id = '".$ban."'")->fetch();
									if ($st == "1")
									{
										$b = $odb->prepare("UPDATE users SET status = '2' WHERE id = :i LIMIT 1");
										$b->execute(array(":i" => $ban));
										$i4 = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
										$i4->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":r" => "Banned user ".$un));
										echo '<div class="alert alert-success">User has been banned. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
									}else{
										$b = $odb->prepare("UPDATE users SET status = '1' WHERE id = :i LIMIT 1");
										$b->execute(array(":i" => $ban));
										$i4 = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
										$i4->execute(array(":u" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":r" => "Unbanned user ".$un));
										echo '<div class="alert alert-success">User has been unbanned. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
									}
								}else{
									echo '<div class="alert alert-danger">This user cannot be banned. Reloading...</div><meta http-equiv="refresh" content="2;url=?p=users">';
								}
							}
						}
						?>
	
 <div class="col s12"> 
		  
		    <ul class="tabs tabs-fixed-width z-depth-1">
                <li class="tab col s3"><a class="active" href="#man">Manage</a></li>
                <li class="tab col s3"><a href="#add">Add User</a></li>
            </ul>
		  </div>
       
<div class="col s12">
 <div class="card-panel no-padding">
		  <!-- Personal tab START -->
	      <div id="man">
							
		<table class="table table-condensed table-bordered table-hover">
										<thead>
											<tr>
												<th>#</th>
												<th>Username</th>
												<th>Permission</th>
												<th>Last Access Date</th>
												<th>Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$users = $odb->query("SELECT * FROM users");
											while ($us = $users->fetch(PDO::FETCH_ASSOC))
											{
												$lds = $odb->prepare("SELECT date FROM plogs WHERE username = :u AND action = 'Logged in' ORDER BY date LIMIT 1");
												$lds->execute(array(":u" => $us['username']));
												$ld = $lds->fetchColumn(0);
												if ($ld == NULL || $ld == "")
												{
													$ld = "Never";
												}else{
													$ld = date("m-d-Y, h:i A", $ld);
												}
												$stat = "";
												if ($us['status'] == "1")
												{
													$stat = '<a href="?p=users&ban='.$us['id'].'" title="Ban User"><i class="mdi-action-lock-outline"></i></a>';
												}else{
													$stat = '<a href="?p=users&ban='.$us['id'].'" title="Unban User"><i class="mdi-action-lock-open"></i></a>';
												}
												echo '<tr><td>'.$us['id'].'</td><td>'.$us['username'].'</td><td>'.ucfirst($us['privileges']).'</td><td>'.$ld.'</td><td><center><a href="?p=edituser&id='.$us['id'].'" title="Edit User"><i class="mdi-editor-border-color"></i></a>&nbsp;'.$stat.'&nbsp;<a href="?p=users&del='.$us['id'].'" title="Delete User"><i class="mdi-action-delete"></i></a></center></td></tr>';
											}
											?>
										</tbody>
									</table>
	</div>
 </div>
</div>
								<div id="add" class="col s12">
      <div class="card">
        <div class="card-content">
        
            <div class="row">
			<div class="tab-pane" id="add">
									<form action="" method="POST" class="col-lg-6">
										<label>Username</label>
										<input type="text" class="form-control" name="username">
										<br>
										<label>Password</label>
										<input type="password" class="form-control" name="password">
										<br>
										<label>Permissions</label>
										<select class="form-control" name="permissions">
											<option value="1">User</option>
											<option value="2">Moderator</option>
											<option value="3">Admin</option>
										</select>
										<br>
										<center><input type="submit" name="doAdd" class="btn btn-danger" value="Add User"></center>
									</form>
									<div class="clearfix"></div>
								</div>
							</div>
						</div>
							</div></div>
							
						
							
					<div class="col s12">
					
					
             <ul class="collapsible" data-collapsible="accordion">
  <li>
    <div class="collapsible-header  ">
      <i class="mdi-action-account-circle"></i>
    <h5><b>User</b></h5>

      </div>
    <div class="collapsible-body ">	<p>The <b>User</b> permission limits the user to view and access bots, but cannot manage the settings, manage other users, view logs, or manage tasks the user did not create. The tasks this user cannot use are <b>Update, and Uninstall</b>.<br/><br/></p></div>
  </li>
   <li>
    <div class="collapsible-header  ">
      <i class="mdi-action-face-unlock"></i>
    <h5><b>Moderator</b></h5>
      </div>
    <div class="collapsible-body"><p>The <b>Moderator</b> permission limits the user to view and access bots, manage other non-admin users, view logs, and manage tasks of other non-admin users, but cannot manage the settings. The tasks this user cannot use are <b>Update, and Uninstall</b>.</p></div>
  </li>
  <li>
    <div class="collapsible-header  active">
      <i class="mdi-image-timer-auto"></i>
    <h5><b>Admin</b></h5>
      </div>
    <div class="collapsible-body"><p>The <b>Admin</b> permission gives a user full access to the panel, allowing full control over other users and their tasks. This user can run any task.</p></div>
  </li>
</ul>
          </div></div></div></div>
		
  <!-- container END --> 
  
</main>
<?php include_once("./includes/footer.php"); 
?>		