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
 * 
 * WebEngine ARENA Premium Template
 * 
 */

if(!isLoggedIn()) redirect(1,'login');

echo '<div class="page-title"><span>'.lang('module_titles_txt_3').'</span></div>';

$cfg = loadConfig('usercp');
if(!is_array($cfg)) throw new Exception('Could not load usercp, please contact support.');

$usercpColSize = 3;

echo '<div class="row">';
	foreach($cfg as $element) {
		if(!is_array($element)) continue;
		if(!$element['active']) continue;
		$link = $element['type'] == 'internal' ? __BASE_URL__ . $element['link'] : $element['link'];
		$title = check_value(lang($element['phrase'], true)) ? lang($element['phrase']) : 'Unk_phrase';
		$icon = check_value($element['icon']) ? __PATH_TEMPLATE_IMG__ . 'icons/' . $element['icon'] : __PATH_TEMPLATE_IMG__ . 'icons/usercp_default.png';
		
		echo '<div class="col-xs-'.$usercpColSize.' text-center usercpElement">';
			echo $element['newtab'] ? '<a href="'.$link.'" target="_blank">' : '<a href="'.$link.'">';
				echo '<img src="'.$icon.'" width="100px" height="auto"/><br />';
				echo $title;
			echo '</a>';
		echo '</div>';
	}
echo '</div>';

