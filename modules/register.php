<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.2.2
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2020 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */
include('config.php');
if(isLoggedIn()) redirect();

echo '<div class="page-title"><span>'.lang('module_titles_txt_1',true).'</span></div>';

try {
	
	if(!mconfig('active')) throw new Exception(lang('error_17',true));
	
	// Register Process
	if(check_value($_POST['webengineRegister_submit'])) {
			$webengineRegister_user           = $_POST['webengineRegister_user'];
	 		$webengineRegister_pwd           = $_POST['webengineRegister_pwd'];
	 		$webengineRegister_pwdc           = $_POST['webengineRegister_pwdc'];
	 		$webengineRegister_email           = test_input($_POST['webengineRegister_email']);

			 $res = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" . $webengineRegister_user . "'");
			 if (odbc_num_rows($res) >= 1) {
				 echo '<script language="javascript">';
				 echo 'alert("Username already exist \n \nTài khoản này đã tồn tại");';
				 echo 'document.location = ""';
				 echo '</script>';
				 die();
			 }
			 $checkmail = odbc_exec($connect, "SELECT * FROM Account WHERE Email = '" . $webengineRegister_email . "'");
			 if (odbc_num_rows($checkmail) >= 1) {
				 echo '<script language="javascript">';
				 echo 'alert("E-mail is being used \n \nEmail này đã được sử dụng");';
				 echo 'document.location = ""';
				 echo '</script>';
				 die();
			 }
			 if (!filter_var($webengineRegister_email, FILTER_VALIDATE_EMAIL)) {
				echo '<script language="javascript">';
				echo 'alert("E-mail Invalid \n \nEmail không hợp lệ");';
				echo 'document.location = ""';
				echo '</script>';
				die();
			 }
			 if (isset($webengineRegister_user[10])) {
				echo '<script language="javascript">';
				echo 'alert("Account is too long (Max 10 Characters)\n \nTài khoản quá dài (tối đa 10 ký tự)");';
				echo 'document.location = ""';
				echo '</script>';
				die();
			 }
			 if (isset($webengineRegister_pwd[20])) {
				echo '<script language="javascript">';
				echo 'alert("Password is too long (Max 20 Characters)\n \nMật khẩu quá dài (tối đa 20 ký tự)");';
				echo 'document.location = ""';
				echo '</script>';
				die();
			 }
			 function test_input($data) {
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			 }

			$regacc =  odbc_exec($connect, "INSERT INTO Account (UserID, Name, Email, UGradeID, PGradeID, RegDate) VALUES ('$webengineRegister_user', '$webengineRegister_user', '$webengineRegister_email', 0, 0, GETDATE())");
	 		$res3 = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '$webengineRegister_user'");
	 		$usr = odbc_fetch_array($res3);
	 		$aid = $usr['AID'];
	 		odbc_exec($connect, "INSERT INTO Login (UserID, AID, Password) VALUES ('$webengineRegister_user', '$aid', '$webengineRegister_pwd')");
		try {
			$Account = new Account();
			
			if(mconfig('register_enable_recaptcha')) {
				if(!@include_once(__PATH_CLASSES__ . 'recaptcha/autoload.php')) throw new Exception(lang('error_60'));
				$recaptcha = new \ReCaptcha\ReCaptcha(mconfig('register_recaptcha_secret_key'));
				
				$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
				if(!$resp->isSuccess()) {
					# recaptcha failed
					$errors = $resp->getErrorCodes();
					throw new Exception(lang('error_18',true));
				}
			}
			
			$Account->registerAccount($_POST['webengineRegister_user'], $_POST['webengineRegister_pwd'], $_POST['webengineRegister_pwdc'], $_POST['webengineRegister_email']);
			
		} catch (Exception $ex) {
			message('error', $ex->getMessage());
		}
	}
	
	echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
		echo '<form class="form-horizontal" action="" method="post">';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration1" class="col-sm-4 control-label">'.lang('register_txt_1',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="text" class="form-control" id="webengineRegistration1" name="webengineRegister_user" required>';
					echo '<span id="helpBlock" class="help-block">'.langf('register_txt_6', array(config('username_min_len', true), config('username_max_len', true))).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration2" class="col-sm-4 control-label">'.lang('register_txt_2',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webengineRegistration2" name="webengineRegister_pwd" required>';
					echo '<span id="helpBlock" class="help-block">'.langf('register_txt_7', array(config('password_min_len', true), config('password_max_len', true))).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration3" class="col-sm-4 control-label">'.lang('register_txt_3',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webengineRegistration3" name="webengineRegister_pwdc" required>';
					echo '<span id="helpBlock" class="help-block">'.lang('register_txt_8',true).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration4" class="col-sm-4 control-label">'.lang('register_txt_4',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="text" class="form-control" id="webengineRegistration4" name="webengineRegister_email" required>';
					echo '<span id="helpBlock" class="help-block">'.lang('register_txt_9',true).'</span>';
				echo '</div>';
			echo '</div>';
			
			if(mconfig('register_enable_recaptcha')) {
				# recaptcha v2
				echo '<div class="form-group">';
					echo '<div class="col-sm-offset-4 col-sm-8">';
						echo '<div class="g-recaptcha" data-sitekey="'.mconfig('register_recaptcha_site_key').'"></div>';
					echo '</div>';
				echo '</div>';
				echo '<script src=\'https://www.google.com/recaptcha/api.js\'></script>';
			}
			
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo langf('register_txt_10', array(__BASE_URL__.'tos'));
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit" name="webengineRegister_submit" value="submit" class="btn btn-primary">'.lang('register_txt_5',true).'</button>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
	echo '</div>';

} catch(Exception $ex) {
	message('error', $ex->getMessage());
}
