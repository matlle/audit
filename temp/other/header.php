<?php 
           //require_once 'model.php'; 
           //start_session();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>FAJ-EXPERT AUDIT ET CONTROLE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="MATLLE">
    <link rel="shortcut icon" href="../../assets/img/edchfoods_favicon.ico">
    <!-- Le styles -->
 
    <link href="../assets/css/custom.css" rel="stylesheet">
	<link rel="stylesheet" href="print.css" type="text/css" media="print" />
	<script type="text/javascript" src="assets/js/javascript.js"></script>
	<script type="text/javascript" src="assets/js/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap-dropdown.js"></script>
	
	
	
	 <!-- bootstrap frameworks -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="css/bootstrap-theme.min.css" rel="stylesheet" type="text/css">
    
    <!-- custom style -->
    <link href="css/style.css" rel="stylesheet" type="text/css">
    
    <link href="css/dataTables.bootstrap.css" rel="stylesheet">
    
    <link href="css/bootstrapValidator.min.css" rel="stylesheet" type="text/css">
    
    <link href="css/bootstrap-wysihtml5.css" rel="stylesheet">
    
    <link href="css/jquery.jgrowl.min.css" rel="stylesheet">
	
	
	
  
 </head>
 <body class="bg">
      <center>
         <a href="index.php"><img src="../../assets/img/logo.jpg" style="margin-top: 30px;"></a>
         <h2 style="margin-top: 5px; margin-bottom: 10px;"><?php if(isset($_SESSION['section'])) echo 'Service '.$_SESSION['section']; else echo 'AUDIT ET CONTROLE'; ?></h2>
	</center>

    <!-- </center> -->
