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

echo '<div class="page-title"><span>'.lang('module_titles_txt_8',true).'</span></div>';

try {
	
	if(!mconfig('active')) throw new Exception(lang('error_47',true));
	
	$downloadsCACHE = loadCache('downloads.cache');
	if(is_array($downloadsCACHE)) {
		foreach($downloadsCACHE as $tempDownloadsData) {
			switch($tempDownloadsData['download_type']) {
				case 1:
					$downloadCLIENTS[] = $tempDownloadsData;
				break;
				case 2:
					$downloadPATCHES[] = $tempDownloadsData;
				break;
				case 3:
					$downloadTOOLS[] = $tempDownloadsData;
				break;
			}
		}
	}
	
	if(mconfig('show_client_downloads')) {
		if(is_array($downloadCLIENTS)) {
			echo '<div class="panel panel-downloads">';
				echo '<div class="panel-body">';
					echo '<div class="panel-title">'.lang('downloads_txt_6',true).'</div>';
					echo '<table class="table">';
					foreach($downloadCLIENTS as $download) {
						echo '<tr>';
							echo '<td style="width: 60%">'.$download['download_title'].'<br /><span class="download-description">'.$download['download_description'].'</span></td>';
							echo '<td style="width: 20%"class="text-center">'.round($download['download_size'], 2).' '.lang('downloads_txt_4',true).'</td>';
							echo '<td style="width: 20%"class="text-center"><a href="'.$download['download_link'].'" class="btn btn-primary btn-xs" target="_blank">'.lang('downloads_txt_5',true).'</a></td>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
			echo '</div>';
		}
	}
	
	if(mconfig('show_patch_downloads')) {
		if(is_array($downloadPATCHES)) {
			echo '<div class="panel panel-downloads">';
				echo '<div class="panel-body">';
					echo '<div class="panel-title">'.lang('downloads_txt_7',true).'</div>';
					echo '<table class="table">';
					foreach($downloadPATCHES as $download) {
						echo '<tr>';
							echo '<td style="width: 60%">'.$download['download_title'].'<br /><span class="download-description">'.$download['download_description'].'</span></td>';
							echo '<td style="width: 20%"class="text-center">'.round($download['download_size'], 2).' '.lang('downloads_txt_4',true).'</td>';
							echo '<td style="width: 20%"class="text-center"><a href="'.$download['download_link'].'" class="btn btn-primary btn-xs" target="_blank">'.lang('downloads_txt_5',true).'</a></td>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
			echo '</div>';
		}
	}
	
	if(mconfig('show_tool_downloads')) {
		if(is_array($downloadTOOLS)) {
			echo '<div class="panel panel-downloads">';
				echo '<div class="panel-body">';
					echo '<div class="panel-title">'.lang('downloads_txt_8',true).'</div>';
					echo '<table class="table">';
					foreach($downloadTOOLS as $download) {
						echo '<tr>';
							echo '<td style="width: 60%">'.$download['download_title'].'<br /><span class="download-description">'.$download['download_description'].'</span></td>';
							echo '<td style="width: 20%"class="text-center">'.round($download['download_size'], 2).' '.lang('downloads_txt_4',true).'</td>';
							echo '<td style="width: 20%"class="text-center"><a href="'.$download['download_link'].'" class="btn btn-primary btn-xs" target="_blank">'.lang('downloads_txt_5',true).'</a></td>';
						echo '</tr>';
					}
					echo '</table>';
				echo '</div>';
			echo '</div>';
		}
	}

	echo'<br />
	<h2>System Requirements</h2>
	<table class="table table-condensed table-hover table-striped table-bordered">
		<tbody>
			<tr>
				<td width="10%" rowspan="2" style="vertical-align: middle;">Configuration</td>
			</tr>
			<tr>
				<td width="30%" class="text-center">
					MINIMUM
				</td>
				<td width="30%" class="text-center">
					RECOMMENDED
				</td>
			</tr>
			<tr>
				<td scope="row">OS</td>
				<td class="text-center">
					Windows XP
				</td>
				<td class="text-center">
					Windows 11 (64 bit)
				</td>
			</tr>
			<tr>
				<td scope="row">DirectX</td>
				<td class="text-center">
					DirectX 9.0
				</td>
				<td class="text-center">
					DirectX 9.0
				</td>
			</tr>
			<tr>
				<td scope="row">Processor</td>
				<td class="text-center">
					Dual core from Intel / AMD at 2.4 GHz
				</td>
				<td class="text-center">
					Intel Core i3 2100 / AMD Ryzen 3 1200
				</td>
			</tr>
			<tr>
				<td scope="row">Graphics</td>
				<td class="text-center">
					Intel(R) HD Graphics / Radeon HD2600
				</td>
				<td class="text-center">
					GeForce GTX 260 / Radeon HD 4870
				</td>
			</tr>
			<tr>
				<td scope="row">Memory</td>
				<td class="text-center">
					256 MB RAM
				</td>
				<td class="text-center">
					4 GB RAM
				</td>
			</tr>
			<tr>
				<td scope="row">Storage</td>
				<td class="text-center">
					850 MB HDD
				</td>
				<td class="text-center">
					1 GB SSD
				</td>
			</tr>
		</tbody>
	</table>';
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}