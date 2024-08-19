<?php 
session_start();
if(!isset($_SESSION['grado'])){
    header('location:../login.php');
}else{
    if($_SESSION['grado'] !=2){
        header('location:../login.php');
    }
}
	include_once '../DATABASE.php';
	$db = new Database();
	if(isset($_GET['folio'])){
		$folio=(int) $_GET['folio'];
		$delete=$db->connect()->prepare('DELETE FROM rentas WHERE folio=:folio');
		$delete->execute(array(
			':folio'=>$folio
		));
		header('Location: menu.php');
	}else{
		header('Location: menu.php');
	}
 ?>