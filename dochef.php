<?php 
	require_once 'model.php';
	
	start_session();
    logout_protected();
	expired();
	
	$uid = (int) htmlspecialchars($_GET['uid']);
	$aid = (int) htmlspecialchars($_GET['aid']);
	$pp = (string) htmlspecialchars($_GET['pp']);
	
	if(isset($_GET['paid'])) {
	    $paid = (int) htmlspecialchars($_GET['paid']);
	    $page = $pp.'?aid='.$paid;
	} else {
	     $page = $pp;
	}
	
	$cid = getUserIdByName($_SESSION['login']);
	$cid = $cid['id_utilisateur'];
	
	dochef($aid, $uid, $cid);
	
    header('location: '.$page);
?>