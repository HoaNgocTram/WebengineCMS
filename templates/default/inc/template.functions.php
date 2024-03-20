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

function templateBuildNavbar() {
	$cfg = loadConfig('navbar');
	if(!is_array($cfg)) return;
	
	echo '<ul>';
	foreach($cfg as $element) {
		if(!is_array($element)) continue;
		
		# active
		if(!$element['active']) continue;
		
		# type
		$link = ($element['type'] == 'internal' ? __BASE_URL__ . $element['link'] : $element['link']);
		
		# title
		$title = (check_value(lang($element['phrase'], true)) ? lang($element['phrase'], true) : 'Unk_phrase');
		
		# visibility
		if($element['visibility'] == 'guest') if(isLoggedIn()) continue;
		if($element['visibility'] == 'user') if(!isLoggedIn()) continue;
		
		# print
		if($element['newtab']) {
			echo '<li><a href="'.$link.'" target="_blank">'.$title.'</a></li>';
		} else {
			echo '<li><a href="'.$link.'">'.$title.'</a></li>';
		}
	}
	echo '</ul>';
}

function templateBuildUsercp() {
	$cfg = loadConfig('usercp');
	if(!is_array($cfg)) return;
	
	echo '<ul>';
	foreach($cfg as $element) {
		if(!is_array($element)) continue;
		
		# active
		if(!$element['active']) continue;
		
		# type
		$link = ($element['type'] == 'internal' ? __BASE_URL__ . $element['link'] : $element['link']);
		
		# title
		$title = (check_value(lang($element['phrase'], true)) ? lang($element['phrase'], true) : 'Unk_phrase');
		
		# icon
		$icon = (check_value($element['icon']) ? __PATH_TEMPLATE_IMG__ . 'icons/' . $element['icon'] : __PATH_TEMPLATE_IMG__ . 'icons/usercp_default.png');
		
		# visibility
		if($element['visibility'] == 'guest') if(isLoggedIn()) continue;
		if($element['visibility'] == 'user') if(!isLoggedIn()) continue;
		
		# print
		if($element['newtab']) {
			echo '<li><img src="'.$icon.'"><a href="'.$link.'" target="_blank">'.$title.'</a></li>';
		} else {
			echo '<li><img src="'.$icon.'"><a href="'.$link.'">'.$title.'</a></li>';
		}
	}
	echo '</ul>';
}

function templateCastleSiegeWidget() {
	include('./modules/config.php');
	$res = odbc_exec($connect,"SELECT TOP 1 * FROM Clan WHERE DeleteFlag=0 AND Ranking != 0 ORDER BY TotalPoint DESC");
	$FirstClan = odbc_fetch_array($res);
		$firstclanemb0 = $FirstClan['EmblemUrl'];
		$firstclanname0 = ($FirstClan['Name'] == "") ? "No Data" : $FirstClan['Name'];

	$clan = odbc_exec($connect,"SELECT * FROM Clan WHERE DeleteFlag=0 AND Name = '" .$firstclanname0."' ");
	$clan1 = odbc_fetch_array($clan);
	$masterCID = $clan1['MasterCID'];

	$master = odbc_exec($connect,"SELECT * FROM Character WHERE CID = '" .$masterCID."' ");
	$master1 = odbc_fetch_array($master);
	$masterclan = ($master1['Name'] == "") ? "No Data" : $master1['Name'];

	$war = odbc_exec($connect,"SELECT TOP 1 * FROM ClanGameLog WHERE WinnerClanName = '" .$firstclanname0."' ORDER BY RegDate DESC");
	$war1 =  odbc_fetch_array($war);
	$enemyclan = $war1['LoserClanName']; 
	$win = ($war1['RoundWins'] == "") ? "No Data" : $war1['RoundWins'];
	$lose = ($war1['RoundLosses']  == "") ? "No Data" : $war1['RoundLosses'];
	$mapname = ($war1['MapID'] == "") ? "No Data" : $war1['MapID'];
	if($war1['MapID'] == 0){
		$mapname = "Mansion";
	}elseif($war1['MapID'] == 1){
		$mapname = "Prison";
	}elseif($war1['MapID'] == 2){
		$mapname = "Station";
	}elseif($war1['MapID'] == 3){
		$mapname = "Station II";
	}elseif($war1['MapID'] == 4){
		$mapname = "Battle Arena";
	}elseif($war1['MapID'] == 5){
		$mapname = "Town";
	}elseif($war1['MapID'] == 6){
		$mapname = "Dungeon";
	}elseif($war1['MapID'] == 7){
		$mapname = "Dungeon II";
	}elseif($war1['MapID'] == 8){
		$mapname = "Ruin";
	}elseif($war1['MapID'] == 9){
		$mapname = "Island";
	}elseif($war1['MapID'] == 10){
		$mapname = "Garden";
	}elseif($war1['MapID'] == 11){
		$mapname = "Castle";
	}elseif($war1['MapID'] == 12){
		$mapname = "Factory";
	}elseif($war1['MapID'] == 13){
		$mapname = "Port";
	}elseif($war1['MapID'] == 14){
		$mapname = "Lost Shrine";
	}elseif($war1['MapID'] == 15){
		$mapname = "Stairway";
	}elseif($war1['MapID'] == 16){
		$mapname = "Snow Town";
	}elseif($war1['MapID'] == 17){
		$mapname = "Hall";
	}elseif($war1['MapID'] == 18){
		$mapname = "Catacomb";
	}elseif($war1['MapID'] == 19){
		$mapname = "Jail";
	}elseif($war1['MapID'] == 20){
		$mapname = "Shower Room";
	}elseif($war1['MapID'] == 21){
		$mapname = "High Haven";
	}elseif($war1['MapID'] == 22){
		$mapname = "Citadel";
	}elseif($war1['MapID'] == 23){
		$mapname = "RelayMap";
	}elseif($war1['MapID'] == 24){
		$mapname = "Halloween Town";
	}elseif($war1['MapID'] == 25){
		$mapname = "Weapon Shop";
	}
	
	echo '<div class="panel castle-owner-widget">';
		echo '<div class="panel-heading">';
			echo '<h3 class="panel-title">'.lang('castlesiege_widget_title').'</h3>';
		echo '</div>';
		echo '<div class="panel-body">';
			echo '<div class="row">';
				echo '<div class="col-sm-6 text-center">';
				if ($firstclanemb0 == NULL)
				echo '<td><img src="'.__BASE_URL__.'/clan/emblem/no_emblem.png" class="emblem width="100" height="100""/></td>';
				else
				echo '<td><img src="'.__BASE_URL__.''.$firstclanemb0.'" class="emblem width="100" height="100""/></td>';
				echo '</div>';
				echo '<div class="col-sm-6">';
					echo '<span class="alt">Clan Name</span><br /><b>';
					echo $firstclanname0 . '<b><br /><br />';
					echo '<span class="alt">'.lang('castlesiege_txt_12').'</span><br />';
					echo $masterclan;
				echo '</div>';
			echo '</div>';
			echo '<div class="row" style="margin-top: 20px;">';
				echo '<div class="col-sm-12 text-center">';
					echo '<span class="alt">Last War Win Clan</span><br />';
					echo '<span style="font-size:20px;"><span style="color:red">'.$enemyclan.'</span> at map <span style="color:red">'.$mapname.'</span></br>';
					echo '<span class="alt">War History</span><br />';
					echo '<span style="font-size:20px;"><span style="color:#71F253">Win</span> : '.$win.' | <span style="color:red">Lose</span> : '.$lose.'</span></br>';
					//echo '<a href="'.__BASE_URL__.'castlesiege" class="btn btn-castlewidget btn-xs">'.lang('castlesiege_txt_7').'</a>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

function templateLanguageSelector() {
	$langList = array(
		'en' => array('English', 'US'),
		'es' => array('Español', 'ES'),
		'ph' => array('Filipino', 'PH'),
		'br' => array('Português', 'BR'),
		'ro' => array('Romanian', 'RO'),
		'cn' => array('Simplified Chinese', 'CN'),
		'ru' => array('Russian', 'RU'),
		//'lt' => array('Lithuanian', 'LT'),
		'vn' => array('Việt Nam', 'VN'),
	);
	
	if(isset($_SESSION['language_display'])) {
		$lang = $_SESSION['language_display'];
	} else {
		$lang = config('language_default', true);
	}
	
	echo '<ul class="webengine-language-switcher">';
		echo '<li><a href="'.__BASE_URL__.'language/switch/to/'.strtolower($lang).'" title="'.$langList[$lang][0].'"><img src="'.getCountryFlag($langList[$lang][1]).'" /> '.strtoupper($lang).'</a></li>&nbsp;';
		foreach($langList as $language => $languageInfo) {
			if($language == $lang) continue;
			echo '<li><a href="'.__BASE_URL__.'language/switch/to/'.strtolower($language).'" title="'.$languageInfo[0].'"><img src="'.getCountryFlag($languageInfo[1]).'" /> '.strtoupper($language).'</a></li>&nbsp;';
		}
	echo '</ul>';
}
