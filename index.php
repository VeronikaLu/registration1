<?php 
	require_once 'db.php';
    session_start();

	$req = "/login";

	Router::getPage($req);
?>

<?php if ( isset ($_SESSION['logged_user']) ) : ?>
	Авторизован! <br/>
	Привет, <?php echo $_SESSION['logged_user']->login; ?>!<br/>

<?php else {
new MenuLoader();	
} 
?>
