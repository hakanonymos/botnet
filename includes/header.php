<?php
$u = explode(":", $_SESSION['DarkC0ders']);
$username = $u[0];
$userperms = $odb->query("SELECT privileges FROM users WHERE username = '".$username."'")->fetchColumn(0);

include 'includes/stats.php';
include 'includes/geo/geoip.inc';
$gi = geoip_open("includes/geo/GeoIP.dat", "");
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="no" name="msapplication-tap-highlight">
    <title>hakanonymos</title>
    <link href="assets/css/preloader-stage.css" media="screen" rel="stylesheet" type="text/css">
    <link href="assets/css/materialize.css" media="screen" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="assets/css/assistance.css" media="screen" rel="stylesheet" type="text/css">
    <link href="assets/css/styles.css?v=0.1" media="screen" rel="stylesheet" type="text/css">
	    <link rel="shortcut icon" href="assets/images/logo.jpg">
			<link href="assets/css/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />


	<script src='https://www.google.com/jsapi'></script>
      <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
   
</head>
<body >
    <div class="stage-wrapper">
        <div class="stage">
            <div class="preloader-wrapper big active">
                <div class="spinner-layer">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <header>
        <div class="brand-logo hide-on-large-only center-align"><a href="./"><img alt="logo" class="logo responsive-img" src="./assets/images/logo.jpg"></a></div>
        <div class="navbar-fixed hide-on-large-only">
            <nav>
                <div class="nav-wrapper">
                    <ul class="right">
                        <li class="hide-on-small-only">
                            <a href="?p=account"><i class="material-icons">person</i></a>
                        </li>
                        <li class="hide-on-small-only">
                            <a href="?p=logout"><i class="material-icons">exit_to_app</i></a>
                        </li>
                        <li class="toogle-side-nav">
                            <a class="button-collapse" data-activates="slide-menu" href="#"><i class="material-icons">menu</i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="side-nav fixed" data-simplebar-direction="vertical" id="slide-menu">
            <ul class="side-nav-main">
                <li class="logo hide-on-med-and-down" id="logo-link"><img alt="logo" class="logo responsive-img" src="./assets/images/logo.jpg"><b>Botnet </b>	</li>
                <li class="side-nav-inline hide-on-med-only">
                    <a class="inline waves-effect" href="?p=account"><i class="mdi-social-person
"></i></a>
                    <a class="inline waves-effect" href="?p=logout"><i class="mdi-action-exit-to-app"></i></a>
                </li>
                <li>
                    <a class="waves-effect"  href="?p=main"><i class="mdi-action-settings-input-svideo left"></i><span>Tableau de bord</span></a>
                </li>
                <li>
                    <a class="waves-effect" href="?p=bots"><i class="mdi-action-settings-input-composite left"></i><span>Bots</span><span class="neutral badge"><?php echo $online; ?></span></a>
                </li>
               
                <li>
                    <a class="waves-effect" href="?p=tasks"><i class="mdi-action-assessment
 left"></i><span>les tâches</span></a>
                </li>
                 <li class="divider"></li>
				 <?php if ($userperms != "user"){ ?>
                <li>
               
                    <a class="waves-effect" href="?p=settings"><i class="mdi-action-settings
 left"></i><span>Paramètres</span></span></a>
                </li>
                <li>
                    <a class="waves-effect" href="?p=users"><i class="mdi-social-people left"></i><span>Utilisateurs</span></a>
                </li>
				<li>
                    <a class="waves-effect" href="?p=logs"><i class="mdi-action-list left"></i><span>Journaux de panneau</span></a>
                </li>
				
               <li>
                    <a class="waves-effect" href="?p=help"><i class="mdi-action-help left"></i><span>Help</span></a>
                </li>
                <?php }else{ ?>
                
				
               <li>
                    <a class="waves-effect" href="?p=help"><i class="mdi-action-help left"></i><span>Help</span></a>
                </li>
               <?php } ?>
            </ul>
        </div>
    </header>