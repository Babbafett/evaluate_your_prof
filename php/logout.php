<?php
if (isset($_POST['logout_y']) == TRUE and isset($_POST['logout_x']) == TRUE) {
	session_destroy();
	header("Location: ../html/admin.html");
}
?>