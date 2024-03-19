<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.2.1
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2020 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

// Module Title
include('config.php');

if(!isset($_SESSION['username'])) {
	echo '<script language="javascript">';
	echo 'alert("You must be logged in");';
	echo 'document.location = ""';
	echo '</script>';
	die();
}

echo '<div class="page-title"><span>Unban / UnMute Account</span></div>';
if (isset($_POST['submit'])) {

	$checkacc = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" .$_SESSION['username']. "'");
	$rel = odbc_fetch_array($checkacc);
	$cash = $rel['Cash'];
	$rank = $rel['UGradeID'];

	if ($cash <= 999) {
		echo '<script language="javascript">';
		echo 'alert("You dont have enough Cash \n \nBạn không đủ Cash");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}

	if ($rank != 253) {
		echo '<script language="javascript">';
		echo 'alert("Your account is not banned \n \nTài khoản của bạn không bị cấm");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}

	
	$update = odbc_exec($connect, "UPDATE Account SET Cash = (Cash - 1000) WHERE UserID = '".$_SESSION['username']."' ");
	$update1 = odbc_exec($connect, "UPDATE Account SET UGradeID = 0 WHERE UserID = '".$_SESSION['username']."' ");
	echo '<script language="javascript">';
	echo 'alert("Account has been active successfully \n \nUnBan tài khoản thành công");';
	echo 'document.location = ""';
	echo '</script>';
	die();
	
	

}

if (isset($_POST['submit1'])) {

	$checkacc1 = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" .$_SESSION['username']. "'");
	$rel1 = odbc_fetch_array($checkacc1);
	$cash1 = $rel1['Cash'];
	$rank1 = $rel1['UGradeID'];

	if ($cash1 <= 499) {
		echo '<script language="javascript">';
		echo 'alert("You dont have enough Cash \n \nBạn không đủ Cash");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}

	if ($rank1 != 104) {
		echo '<script language="javascript">';
		echo 'alert("Your account is not muted \n \nTài khoản của bạn không bị cấm chat");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}

	$update2 = odbc_exec($connect, "UPDATE Account SET Cash = (Cash - 500) WHERE UserID = '".$_SESSION['username']."' ");
	$update3 = odbc_exec($connect, "UPDATE Account SET UGradeID = 0 WHERE UserID = '".$_SESSION['username']."' ");
	
	echo '<script language="javascript">';
	echo 'alert("Account has been unmute successfully \n \nUnMute tài khoản thành công");';
	echo 'document.location = ""';
	echo '</script>';
	die();

}

	echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
		echo '<form class="form-horizontal" action="" method="post">';
			echo '<div class="form-group">';
				echo '<div class="col-sm-8">';
					echo '<span id="helpBlock" class="help-block">UnBan Account 1000 Cash</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit" name="submit" value="submit" class="btn btn-primary">UnBan</button>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-8">';
					echo '<span id="helpBlock" class="help-block">UnMute Account 500 Cash</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit1" name="submit1" value="submit1" class="btn btn-primary">UnMute</button>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
	echo '</div>';
	

?>