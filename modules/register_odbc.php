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
session_start();
 include('config.php');

 echo '<div class="page-title"><span>'.lang('module_titles_txt_1',true).'</span></div>';
 if (isset($_POST['submit'])) {
	 $user           = $_POST['user'];
	 $pass           = $_POST['pass'];
	 $pass1           = $_POST['pass1'];
	 $mail           = $_POST['mail'];
 
	if ($user == "" OR $pass == "" OR $pass1 == "" OR $mail == "") {
		 echo '<script language="javascript">';
		 echo 'alert("Fill in all fields \n \nKhông được để trống");';
		 echo 'document.location = ""';
		 echo '</script>';
		 die();
	}
	
	if ($pass != $pass1) {
		echo '<script language="javascript">';
		echo 'alert("Password does not match \n \nMật khẩu không khớp");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}
	 
 
	$res = odbc_exec($connect, "SELECT * FROM Login WHERE UserID = '" . $user . "'");
	if (odbc_num_rows($res) >= 1) {
		 echo '<script language="javascript">';
		 echo 'alert("Username already exist \n \nTài khoản này đã tồn tại");';
		 echo 'document.location = ""';
		 echo '</script>';
		 die();
	}
	$res2 = odbc_exec($connect, "SELECT * FROM MEMB_INFO WHERE mail_addr = '" .$mail . "'");
	if (odbc_num_rows($res2) >= 1) {
		 echo '<script language="javascript">';
		 echo 'alert("Email already exist \n \nEmail này đã được sử dụng");';
		 echo 'document.location = ""';
		 echo '</script>';
		 die();
	}

	if (isset($user[10])) {
		echo '<script language="javascript">';
		echo 'alert("Account is too long (Max 10 Characters)\n \nTài khoản quá dài (tối đa 10 ký tự)");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}

	if (isset($pass[20])) {
		echo '<script language="javascript">';
		echo 'alert("Password is too long (Max 20 Characters)\n \nMật khẩu quá dài (tối đa 20 ký tự)");';
		echo 'document.location = ""';
		echo '</script>';
		die();
	}
		
	 $regacc =  odbc_exec($connect, "INSERT INTO Account (UserID, Name, Email, UGradeID, PGradeID, Cash, Event, RegDate) VALUES ('$user', '$user', '$mail', 0, 0, 0, 0, GETDATE())");
	 $res3 = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '$user'");
	 $usr = odbc_fetch_array($res3);
	 $aid = $usr['AID'];
	 odbc_exec($connect, "INSERT INTO Login (UserID, AID, Password) VALUES ('$user', '$aid', '$pass')");
 
	 
	 $res4 = odbc_exec($connect, "INSERT INTO MEMB_INFO (memb___id, memb_name, memb__pwd, mail_addr, bloc_code, ctl1_code, sno__numb) VALUES ('$user', '$user', '$pass', '$mail', '0','0','1111111111111')");
	 
	 echo '<script language="javascript">';
	 echo 'alert("Account created successfully \n \nTạo tài khoản thành công");';
	 echo 'document.location = ""';
	 echo '</script>';
	 die();
 
 }
	
	echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
		echo '<form class="form-horizontal" action="" method="post">';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration1" class="col-sm-4 control-label">'.lang('register_txt_1',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="text" class="form-control" id="webengineRegistration1" name="user" required>';
					echo '<span id="helpBlock" class="help-block">'.langf('register_txt_6', array(config('username_min_len', true), config('username_max_len', true))).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration2" class="col-sm-4 control-label">'.lang('register_txt_2',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webengineRegistration2" name="pass" required>';
					echo '<span id="helpBlock" class="help-block">'.langf('register_txt_7', array(config('password_min_len', true), config('password_max_len', true))).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration3" class="col-sm-4 control-label">'.lang('register_txt_3',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="password" class="form-control" id="webengineRegistration3" name="pass1" required>';
					echo '<span id="helpBlock" class="help-block">'.lang('register_txt_8',true).'</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration4" class="col-sm-4 control-label">'.lang('register_txt_4',true).'</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="text" class="form-control" id="webengineRegistration4" name="mail" required>';
					echo '<span id="helpBlock" class="help-block">'.lang('register_txt_9',true).'</span>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo langf('register_txt_10', array(__BASE_URL__.'tos'));
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit" name="submit" value="submit" class="btn btn-primary">'.lang('register_txt_5',true).'</button>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
	echo '</div>';
