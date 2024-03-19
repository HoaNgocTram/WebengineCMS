<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.2.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2019 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */
include('../gunz/modules/config.php');
if(!isset($_SESSION['username'])) {
	echo '<script language="javascript">';
	echo 'alert("You must be logged in");';
	echo 'document.location = ""';
	echo '</script>';
	die();
}

if(!isLoggedIn()) redirect(1,'login');

echo '<div class="page-title"><span>'.lang('module_titles_txt_6',true).'</span></div>';

try {
	
	if(!mconfig('active')) throw new Exception(lang('error_47',true));
	
	// common class
	$common = new common();
	
	if(mconfig('change_password_email_verification') && $common->hasActivePasswordChangeRequest($_SESSION['userid'])) {
		throw new Exception(lang('error_19',true));
	}
	
	if(check_value($_POST['webenginePassword_submit'])) {
		$webenginePassword_current           = $_POST['webenginePassword_current'];
		$webenginePassword_new           = $_POST['webenginePassword_new'];
		$webenginePassword_newconfirm           = $_POST['webenginePassword_newconfirm'];
		$updatepassgame = odbc_exec($connect, "UPDATE Login SET Password = '" .$webenginePassword_new. "' WHERE UserID = '" .$_SESSION['username']. "'");
		try {
			$Account = new Account();
			
			if(mconfig('change_password_email_verification')) {
				# verification required
				$Account->changePasswordProcess_verifyEmail($_SESSION['userid'], $_SESSION['username'], $_POST['webenginePassword_current'], $_POST['webenginePassword_new'], $_POST['webenginePassword_newconfirm'], $_SERVER['REMOTE_ADDR']);
			} else {
				# no verification
				$Account->changePasswordProcess($_SESSION['userid'], $_SESSION['username'], $_POST['webenginePassword_current'], $_POST['webenginePassword_new'], $_POST['webenginePassword_newconfirm']);
			}
		} catch (Exception $ex) {
			message('error', $ex->getMessage());
		}
	}

	/*if (isset($_POST['submit'])) {
		$pass           = $_POST['pass'];
		$pass1           = $_POST['pass1'];
		$pass2           = $_POST['pass2'];
	
	
		if ($pass == "" OR $pass1 == "" OR $pass2 == "" ) {
			echo '<script language="javascript">';
			echo 'alert("Fill in all fields \n \nKhông được bỏ trống");';
			echo 'document.location = ""';
			echo '</script>';
			die();
		}
		if ($pass1 != $pass2 ) {
			echo '<script language="javascript">';
			echo 'alert("Confirm new password does not match \n \nXác nhận mật khẩu mới không khớp");';
			echo 'document.location = ""';
			echo '</script>';
			die();
		}
	$res = odbc_exec($connect, "SELECT * FROM Login WHERE UserID = '" .$_SESSION['username']. "'");
    if (odbc_num_rows($res) == 0) {
		echo '<script language="javascript">';
		echo 'alert("Change password failure\nYour account has not been activated \n \nĐổi mật khẩ không thành công\nTài khoản của bạn chưa được kích hoạt");';
		echo 'document.location = ""';
		echo '</script>';
		die();
    }

	$res1 = odbc_exec($connect, "SELECT * FROM MEMB_INFO WHERE memb___id = '" .$_SESSION['username']. "'");
	$usr1 = odbc_fetch_array($res1);
	$pass3 = $usr1['memb__pwd'];
	if ($pass != $pass3) {
		echo '<script language="javascript">';
		echo 'alert("Current password is incorrect \n \nMật khẩu hiện tại không đúng");';
		echo 'document.location = ""';
		echo '</script>';
		die();
    }
	$updatepassgame = odbc_exec($connect, "UPDATE Login SET Password = '" .$pass1. "' WHERE UserID = '" .$_SESSION['username']. "'");
	$updatepassweb = odbc_exec($connect, "UPDATE MEMB_INFO SET memb__pwd = '" .$pass1. "' WHERE memb___id = '" .$_SESSION['username']. "'");
	echo '<script language="javascript">';
	echo 'alert("Change password successfully \n \nĐổi mật khẩu thành công");';
	echo 'document.location = ""';
	echo '</script>';
	die();
}*/
	echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
		echo '<form class="form-horizontal" action="" method="post">';
			echo '<div class="form-group">';
				echo '<label for="webenginePassword" class="col-sm-4 control-label">'.lang('changepassword_txt_1',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webenginePassword" name="webenginePassword_current">';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webenginePassword" class="col-sm-4 control-label">'.lang('changepassword_txt_2',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webenginePassword" name="webenginePassword_new">';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webenginePassword" class="col-sm-4 control-label">'.lang('changepassword_txt_3',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webenginePassword" name="webenginePassword_newconfirm">';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit" name="webenginePassword_submit" value="submit" class="btn btn-primary">'.lang('changepassword_txt_4',true).'</button>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
	echo '</div>';

} catch(Exception $ex) {
	message('error', $ex->getMessage());
}
