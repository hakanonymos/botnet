<?php
include_once('./includes/header.php');
?>
<main>
		 <div class="container">
   <h1 class="thin">Edit User</h1>
    <div id="dashboard">
           <div class="row">	
						<?php
						if ($userperms == "user")
						{
							echo '<div class="alert alert-danger">You do not have permission to view this page.</div>';
							die();
						}
						if (!isset($_GET['id']))
						{
							echo '<div class="alert alert-danger">No ID provided. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=users">';
							die();
						}else{
							if (!ctype_digit($_GET['id']))
							{
								echo '<div class="alert alert-danger">ID was not a digit. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=users">';
								die();
							}
						}
						$uid = $_GET['id'];
						$cnt = $odb->prepare("SELECT COUNT(*) FROM users WHERE id = :i");
						$cnt->execute(array(":i" => $uid));
						if ($cnt->fetchColumn(0) == "0")
						{
							echo '<div class="alert alert-danger">User was not found in database. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=users">';
							die();
						}
						if ($uid == "1")
						{
							echo '<div class="alert alert-danger">This user cannot be modified. Redirecting...</div><meta http-equiv="refresh" content="2;url=?p=users">';
							die();
						}
						$uss = $odb->prepare("SELECT * FROM users WHERE id = :i");
						$uss->execute(array(":i" => $uid));
						$us = $uss->fetch(PDO::FETCH_ASSOC);
						if (isset($_POST['doEdit']))
						{
							$npass = $_POST['newpass'];
							$npcon = $_POST['newpass2'];
							$newpe = $_POST['perms'];
							$newst = $_POST['status'];
							if (empty($npass) || empty($npcon) || empty($newpe) || empty($newst))
							{
								echo '<div class="alert alert-danger">One of the fields were empty.</div>';
							}else{
								if ($npass == $npcon)
								{
									if (ctype_digit($newpe))
									{
										if (ctype_digit($newst))
										{
											$newperm = "";
											switch ($newpe)
											{
												case "1":
													$newperm = "user";
													break;
												case "2":
													$newperm = "moderator";
													break;
												case "3":
													$newperm = "admin";
													break;
											}
											if ($userperms == "moderator" && $us['privileges'] != "admin")
											{
												if ($npass != "" || $npass != NULL)
												{
													$hashed = hash("sha256", $npass);
													$up = $odb->prepare("UPDATE users SET password = :p, privileges = :pm, status = :s WHERE id = :i");
													$up->execute(array(":p" => $hashed, ":pm" => $newperm, ":s" => $newst, ":i" => $uid));
													$in = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
													$in->execute(array(":u" => $username, ":ip" => $_SESSION['REMOTE_ADDR'], ":r" => "Edited user ".$us['username']));
													echo '<div class="alert alert-success">Successfully updated user. Reloading...</div><meta http-equiv="refresh" content="2">';
												}else{
													$up = $odb->prepare("UPDATE users SET privileges = :p, status = :s WHERE id = :i");
													$up->execute(array(":p" => $newperm, ":s" => $newst, ":i" => $uid));
													$in = $odb->prepare("INSERT INTO plogs VALUES(NULL, :u, :ip, :r, UNIX_TIMESTAMP())");
													$in->execute(array(":u" => $username, ":ip" => $_SESSION['REMOTE_ADDR'], ":r" => "Edited user ".$us['username']));
													echo '<div class="alert alert-success">Successfully updated user. Reloading...</div><meta http-equiv="refresh" content="2">';
												}
											}else{
												echo '<div class="alert alert-danger">You cannot edit administrative users.</div>';
											}
										}else{
											echo '<div class="alert alert-danger">Status was not a digit.</div>';
										}
									}else{
										echo '<div class="alert alert-danger">Permissions was not a digit.</div>';
									}
								}else{
									echo '<div class="alert alert-danger">Passwords did not match.</div>';
								}
							}
						}
						?>
				
					<div id="main" class="col s12">
						<div class="card">
        <div class="card-content">
								<a href="?p=users"><i class="mdi-content-backspace"></i> Go Back</a>
								<center><h5>Editing user <b><?php echo $us['username']; ?></b></h5></center>
								<br>
								<form action="" method="POST" class="col-lg-8">
									<label>New Password</label>
									<input type="password" class="form-control" name="newpass" placeholder="Leave blank for old password">
									<br>
									<label>New Password Confirm</label>
									<input type="password" class="form-control" name="newpass2" placeholder="Leave blank for old password">
									<br>
									<label>Permissions</label>
									<select class="form-control" name="perms">
										<?php
										switch ($us['privileges'])
										{
											case "user":
												echo '<option value="1" selected>User</option><option value="2">Moderator</option><option value="3">Admin</option>';
												break;
											case "moderator":
												echo '<option value="1">User</option><option value="2" selected>Moderator</option><option value="3">Admin</option>';
												break;
											case "admin":
												echo '<option value="1">User</option><option value="2">Moderator</option><option value="3" selected>Admin</option>';
												break;
										}
										?>
									</select>
									<br>
									<label>Status</label>
									<select class="form-control" name="status">
										<?php
										if ($us['status'] == "1")
										{
											echo '<option value="1" selected>Active</option><option value="2">Banned</option>';
										}else{
											echo '<option value="1">Active</option><option value="2" selected>Banned</option>';
										}
										?>
									</select>
									<br>
									<center><input type="submit" class="btn btn-success" name="doEdit" value="Edit User"></center>
								</form>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			
			</main>
<?php include_once('includes/footer.php'); ?>