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
	
	if(!mconfig('rankings_enable_master')) throw new Exception(lang('error_44',true));
	if(!mconfig('active')) throw new Exception(lang('error_44',true));
	
	$ranking_data = LoadCacheData('rankings_master.cache');
	if(!is_array($ranking_data)) throw new Exception(lang('error_58',true));
	
	$showPlayerCountry = mconfig('show_country_flags') ? true : false;
	$charactersCountry = loadCache('character_country.cache');
	if(!is_array($charactersCountry)) $showPlayerCountry = false;
	
	if(mconfig('show_online_status')) $onlineCharacters = loadCache('online_characters.cache');
	if(!is_array($onlineCharacters)) $onlineCharacters = array();
	
	if(mconfig('rankings_class_filter')) $Rankings->rankingsFilterMenu();
	
	echo '<table class="rankings-table">';
	echo '<tr>';
	if(mconfig('rankings_show_place_number')) {
		echo '<td style="font-weight:bold;"></td>';
	}
	if($showPlayerCountry) echo '<td style="font-weight:bold;">'.lang('rankings_txt_33').'</td>';
	echo '<td style="font-weight:bold;"></td>';
	echo '<td style="font-weight:bold;">'.lang('rankings_txt_10').'</td>';
	echo '<td style="font-weight:bold;">Level</td>';
	echo '<td style="font-weight:bold;">Ladder Coins</td>';
	echo '<td style="font-weight:bold;">Wins</td>';
	echo '<td style="font-weight:bold;">Losses</td>';
	echo '<td style="font-weight:bold;">Elo</td>';
	echo '<td style="font-weight:bold;">Rank</td>';
	echo '<td style="font-weight:bold;">Score</td>';
	if(mconfig('show_location')) echo '<td style="font-weight:bold;">EXP</td>';
	echo '</tr>';
	$i = 0;
	foreach($ranking_data as $rdata) {
		$characterIMG = getPlayerClassAvatar($rdata[2], true, true, 'rankings-class-image');
		$onlineStatus = mconfig('show_online_status') ? in_array($rdata[0], $onlineCharacters) ? '<img src="'.__PATH_ONLINE_STATUS__.'" class="online-status-indicator"/>' : '<img src="'.__PATH_OFFLINE_STATUS__.'" class="online-status-indicator"/>' : '';
		if($i>=1) {
			echo '<tr data-class-id="'.$rdata[2].'">';
			if(mconfig('rankings_show_place_number')) {
				echo '<td class="rankings-table-place">'.$i.'</td>';
			}
			if($showPlayerCountry) echo '<td><img src="'.getCountryFlag($charactersCountry[$rdata[0]]).'" /></td>';
			echo '<td class="rankings-table-place">'.$i.'</td>';
			echo '<td><b>'.playerProfile($rdata[0]).$onlineStatus.'</b></td>';
			echo '<td>'.number_format($rdata[1]).'</td>';
			echo '<td>'.number_format($rdata[2]).'</td>';
			echo '<td>'.number_format($rdata[7]).'</td>';
			echo '<td>'.number_format($rdata[8]).'</td>';
			//echo '<td>'.number_format(($rdata[7] + $rdata[8]) / 2 * 50).'</td>';
			{
				if ($rdata[9] <= 10)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 10) / 2).'</td>';
				else if ($rdata[9] >= 11 AND $rdata[9] <= 30)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 30) / 2).'</td>';
				else if ($rdata[9] >= 31 AND $rdata[9] <= 50)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 50) / 2).'</td>';
				else if ($rdata[9] >= 51 AND $rdata[9] <= 80)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 80) / 2).'</td>';
				else if ($rdata[9] >= 81 AND $rdata[9] <= 120)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 120) / 2).'</td>';
				else if ($rdata[9] >= 121 AND $rdata[9] <= 170)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 170) / 2).'</td>';
				else if ($rdata[9] >= 171 AND $rdata[9] <= 230)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 230) / 2).'</td>';
				else if ($rdata[9] >= 231)
				echo '<td>'.number_format(($rdata[7] - $rdata[8] + 300) / 2).'</td>';

			}
			{
				if ($rdata[9] <= 10)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_1.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 11 AND $rdata[9] <= 30)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_2.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 31 AND $rdata[9] <= 50)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_3.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 51 AND $rdata[9] <= 80)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_4.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 81 AND $rdata[9] <= 120)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_5.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 121 AND $rdata[9] <= 170)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_5_1.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 171 AND $rdata[9] <= 230)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_5_2.png" class="emblem width="55" height="55""/></td>';
				else if ($rdata[9] >= 231)
				echo '<td><img src="https://gunz.vn/gunz/img/rank_6.png" class="emblem width="55" height="55""/></td>';
			}
			//echo '<td>'.number_format($rdata[7]).'</td>';
			echo '<td style="color:#00e600";><b>'.number_format($rdata[9]).'</b></td>';
			if(mconfig('show_location')) echo '<td>'.number_format($rdata[4]).'</td>';
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