<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.2.4
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2022 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */
include('./modules/config.php');
if(!isLoggedIn()) redirect(1,'login');

echo '<div class="page-title"><span>'.lang('module_titles_txt_4').'</span></div>';

// module status
if(!mconfig('active')) throw new Exception(lang('error_47'));
	
// common class
$common = new common();

// Retrieve Account Information
$accountInfo = $common->accountInformation($_SESSION['userid']);
if(!is_array($accountInfo)) throw new Exception(lang('error_12'));

# account online status
$onlineStatus = ($common->accountOnline($_SESSION['username']) ? '<span class="label label-success">'.lang('myaccount_txt_9').'</span>' : '<span class="label label-danger">'.lang('myaccount_txt_10').'</span>');

# account status
$checkuser = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" .$_SESSION['username']. "'");
$usr = odbc_fetch_array($checkuser);
$aid = $usr['AID'];
$accountStatus = ($usr['UGradeID'] == "253") ? '<span class="label label-danger">'.lang('myaccount_txt_8').'</span>' : '<span class="label label-success">'.lang('myaccount_txt_7').'</span>';
//$accountStatus = ($accountInfo[_CLMN_BLOCCODE_] == 1 ? '<span class="label label-danger">'.lang('myaccount_txt_8').'</span>' : '<span class="label label-default">'.lang('myaccount_txt_7').'</span>');

# characters info
$Character = new Character();
$AccountCharacters = $Character->AccountCharacter($_SESSION['username']);

// Account Information
echo '<table class="table myaccount-table">';
	echo '<tr>';
		echo '<td>'.lang('myaccount_txt_1').'</td>';
		echo '<td>'.$accountStatus.'</td>';
	echo '</tr>';
	
	echo '<tr>';
		echo '<td>'.lang('myaccount_txt_2').'</td>';
		echo '<td>'.$accountInfo[_CLMN_USERNM_].'</td>';
	echo '</tr>';
	
	echo '<tr>';
		echo '<td>'.lang('myaccount_txt_3').'</td>';
		echo '<td>'.$accountInfo[_CLMN_EMAIL_].' <a href="'.__BASE_URL__.'usercp/myemail/" class="btn btn-xs btn-primary pull-right">'.lang('myaccount_txt_6').'</a></td>';
	echo '</tr>';
	
	echo '<tr>';
		echo '<td>'.lang('myaccount_txt_4').'</td>';
		echo '<td>&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226; <a href="'.__BASE_URL__.'usercp/mypassword/" class="btn btn-xs btn-primary pull-right">'.lang('myaccount_txt_6').'</a></td>';
	echo '</tr>';
	
	// echo '<tr>';
	// 	echo '<td>'.lang('myaccount_txt_5').'</td>';
	// 	echo '<td>'.$onlineStatus.'</td>';
	// echo '</tr>';
	
	try {
		$creditSystem = new CreditSystem();
		$creditCofigList = $creditSystem->showConfigs();
		if(is_array($creditCofigList)) {
			foreach($creditCofigList as $myCredits) {
				if(!$myCredits['config_display']) continue;
				
				$creditSystem->setConfigId($myCredits['config_id']);
				switch($myCredits['config_user_col_id']) {
					case 'userid':
						$creditSystem->setIdentifier($accountInfo[_CLMN_MEMBID_]);
						break;
					case 'username':
						$creditSystem->setIdentifier($accountInfo[_CLMN_USERNM_]);
						break;
					case 'email':
						$creditSystem->setIdentifier($accountInfo[_CLMN_EMAIL_]);
						break;
					default:
						continue 2;
				}
				
				$configCredits = $creditSystem->getCredits();
				
				echo '<tr>';
					echo '<td>'.$myCredits['config_title'].'</td>';
					echo '<td>'.number_format($configCredits).'</td>';
				echo '</tr>';
			}
		}
	} catch(Exception $ex) {}
echo '</table>';

// Account Characters
$query = odbc_exec($connect, "SELECT * FROM Character(nolock) WHERE AID = '" .$aid. "' AND DeleteFlag = 0 ORDER BY CharNum ASC");
    if ( odbc_num_rows($query) < 1 ) {
echo '<table class="table table-condensed table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th colspan="1">'.lang('myaccount_txt_15').'</th>
			</tr>
		</thead>
		<tbody>
			<form class="form-horizontal" action="" method="post">
				<tr>
					<td style="width:100%;">'.lang('error_46').'</td>
				<tr>
			</form>
		</tbody>
	</table>';
    } else {
	echo '<table class="table table-condensed table-hover table-striped table-bordered">
		<thead>
			<tr>
				<th colspan="5">'.lang('myaccount_txt_15').'</th>
			</tr>
		</thead>
		<tbody>
			<form class="form-horizontal" action="" method="post">
				<tr>
					<td style="width:20%;">Name</td>
					<td style="width:20%;">Level</td>
					<td style="width:20%;">Exp</td>
					<td style="width:20%;">BP</td>
					<td style="width:20%;">K/D</td>
				</tr>';
				$i = 1;
        		while ($i <= odbc_num_rows($query) ){
        		$chars = odbc_fetch_array($query);
        		echo '
				<tr>
					<td style="width:20%;">' . $chars['Name']. '</td>
					<td style="width:20%;">' . $chars['Level'] . '</td>
					<td style="width:20%;">' . $chars['XP'] . '</td>
					<td style="width:20%;">' . $chars['BP'] . '</td>
					<td style="width:20%;">' . $chars['KillCount'] . ' / ' . $chars['DeathCount'] . '</td>
				</tr>';
				$i++;
        }
		echo '</form>
		</tbody>
	</table>';
}

// Connection History (IGCN)
if(defined('_TBL_CH_')) {
	echo '<div class="page-title"><span>'.lang('myaccount_txt_16').'</span></div>';
	$me = Connection::Database('Me_MuOnline');
	$connectionHistory = $me->query_fetch("SELECT TOP 10 * FROM Login WHERE UserID = ? ORDER BY AID DESC", array($_SESSION['username']));
	if(is_array($connectionHistory)) {
		echo '<table class="table table-condensed general-table-ui">';
			echo '<tr>';
				echo '<td>'.lang('myaccount_txt_13').'</td>';
				//echo '<td>'.lang('myaccount_txt_17').'</td>';
				echo '<td>'.lang('myaccount_txt_18').'</td>';
				echo '<td>'.lang('myaccount_txt_20').'</td>';
			echo '</tr>';
			foreach($connectionHistory as $row) {
				echo '<tr>';
					echo '<td>'.$row[_CLMN_CH_DATE_].'</td>';
					//echo '<td>'.$row[_CLMN_CH_SRVNM_].'</td>';
					echo '<td>'.$row[_CLMN_CH_IP_].'</td>';
					echo '<td>'.$row[_CLMN_CH_HWID_].'</td>';
				echo '</tr>';
			}
		echo '</table>';
	}
}
