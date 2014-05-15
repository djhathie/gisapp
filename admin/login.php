<?php

$server_os = php_uname('s');

session_start();

require_once("class.php");

$login = new OneFileLoginApplication();

$pp='';
if (isset($_SESSION['project'])) {
	$pp = $_SESSION['project'];
}

//check action parameter
if (isset($_GET["action"])) { 
	if($_GET["action"] == "logout") {
		//logout
		$login->doLogout();
		if($server_os=='Windows NT') {
			header("Location: ../index.php?map=".PROJECT_PATH.$pp.'.qgs');
		}
		else {
			header("Location: ../".$pp);
		}
		exit();
	}
}
else {
	//login   				
	$loginUsername = isset($_POST["user_name"]) ? $_POST["user_name"] : "";
	$loginPass = isset($_POST["user_password"]) ? $_POST["user_password"] : ""; 
	
	$login->doLoginWithPostData();
	 
	$result["success"] = $login->getUserLoginStatus();
	$result["message"] = $login->feedback;

	echo json_encode($result);
}
?>