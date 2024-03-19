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

try {
	
	echo '<div class="page-title"><span>'.lang('module_titles_txt_10',true).'</span></div>';
	
	$Rankings = new Rankings();
	$Rankings->rankingsMenu();
	loadModuleConfigs('rankings');
	
	if(!mconfig('rankings_enable_level')) throw new Exception(lang('error_44',true));
	if(!mconfig('active')) throw new Exception(lang('error_44',true));
	
	$ranking_data = LoadCacheData('rankings_level.cache');
	if(!is_array($ranking_data)) throw new Exception(lang('error_58',true));
	
	$showPlayerCountry = mconfig('show_country_flags') ? true : false;
	$charactersCountry = loadCache('character_country.cache');
	if(!is_array($charactersCountry)) $showPlayerCountry = false;
	
	if(mconfig('show_online_status')) $onlineCharacters = loadCache('online_characters.cache');
	if(!is_array($onlineCharacters)) $onlineCharacters = array();
	
	if(mconfig('rankings_class_filter')) $Rankings->rankingsFilterMenu();
	
	echo '<table class="table rankings-table">';
	echo '<tr>';
	if(mconfig('rankings_show_place_number')) {
		echo '<td style="font-weight:bold;"></td>';
	}
	if($showPlayerCountry) echo '<td style="font-weight:bold;">'.lang('rankings_txt_33').'</td>';
	echo '<td style="font-weight:bold;"> </td>';
	echo '<td style="font-weight:bold;">'.lang('rankings_txt_10').'</td>';
	echo '<td style="font-weight:bold;">Gender</td>';
	echo '<td style="font-weight:bold;">Level</td>';
	echo '<td style="font-weight:bold;">XP</td>';
	if(mconfig('show_location')) echo '<td style="font-weight:bold;">'.lang('rankings_txt_34').'</td>';
	echo '</tr>';
	$i = 0;
	foreach($ranking_data as $rdata) {
		$characterIMG = getPlayerClassAvatar($rdata[1], true, true, 'rankings-class-image');
		$onlineStatus = mconfig('show_online_status') ? in_array($rdata[0], $onlineCharacters) ? '<img src="'.__PATH_ONLINE_STATUS__.'" class="online-status-indicator"/>' : '<img src="'.__PATH_OFFLINE_STATUS__.'" class="online-status-indicator"/>' : '';
		if($i>=1) {
			echo '<tr data-class-id="'.$rdata[1].'">';
			if(mconfig('rankings_show_place_number')) {
				echo '<td class="rankings-table-place">'.$i.'</td>';
			}
			if($showPlayerCountry) echo '<td><img src="'.getCountryFlag($charactersCountry[$rdata[0]]).'" /></td>';
			echo '<td class="rankings-table-place">'.$i.'</td>';
			echo '<td>'.playerProfile($rdata[0]).$onlineStatus.'</td>';
			{
				if ($rdata[4] == 0)
				echo '<td><img src="'.__BASE_URL__.'./img/male.png" class="emblem width="25" height="25""/></td>';
				else if ($rdata[4] == 1)
				echo '<td><img src="'.__BASE_URL__.'./img/female.png" class="emblem width="25" height="25""/></td>';
			}
			echo '<td style="color:#00e600";>'.number_format($rdata[1]).'</td>';
			echo '<td>'.number_format($rdata[3]).'</td>';
			echo '</tr>';
		}
		$i++;
	}
	echo '</table>';
	if(mconfig('rankings_show_date')) {
		echo '<div class="rankings-update-time">';
		echo ''.lang('rankings_txt_20',true).' ' . date("m/d/Y - h:i A",$ranking_data[0][0]);
		echo '</div>';
	}
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}