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
echo '<div class="page-title"><span>'.lang('module_titles_txt_17').'</span></div>';

?>

<!-- SERVER STATISTICS -->
<table class="table table-condensed table-hover table-striped table-bordered">
	<thead>
		<tr>
			<th colspan="2">General Information</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width:50%;">Server Version</td>
			<td style="width:50%;"><?php echo config('server_info_season'); ?></td>
		</tr>
		<tr>
			<td style="width:50%;">Experience</td>
			<td style="width:50%;"><?php echo config('server_info_exp'); ?></td>
		</tr>
		<tr>
			<td style="width:50%;">Quest Experience</td>
			<td style="width:50%;"><?php echo config('server_info_masterexp'); ?></td>
		</tr>
		<tr>
			<td style="width:50%;">Drop item form Quest</td>
			<td style="width:50%;"><?php echo config('server_info_drop'); ?></td>
		</tr>
	</tbody>
</table>

<br />

<!-- Mode Game -->
<h2>Modes Game</h2>
<table class="table table-condensed table-hover table-striped table-bordered">
<tbody>
		<tr>
			<td style="width:50%;">Deadhmatch</td>
			<td style="width:50%;">Deadhmatch + Berserker</td>
		</tr>
		<tr>
			<td style="width:50%;">Team Deadhmatch</td>
			<td style="width:50%;">Team Deadhmatch + Extreme</td>
		</tr>
		<tr>
			<td style="width:50%;">The Duel match</td>
			<td style="width:50%;">Assassination</td>
		</tr>
		<tr>
			<td style="width:50%;">Gladiator</td>
			<td style="width:50%;">Team Gladiator</td>
		</tr>
		<tr>
			<td style="width:50%;">Training</td>
			<td style="width:50%;">Team Training</td>
		</tr>
		<tr>
			<td style="width:50%;">Survival</td>
			<td style="width:50%;">Capture The Flag</td>
		</tr>
		<tr>
			<td style="width:50%;">Quest</td>
			<td style="width:50%;">Challenge Quest</td>
		</tr>
		<tr>
			<td style="width:50%;">Infnected</td>
			<td style="width:50%;">Gun Game</td>
		</tr>
		<tr>
			<td style="width:50%;">Spy Mode</td>
			<td style="width:50%;">Turbo Mode</td>
		</tr>
		<tr>
			<td style="width:50%;">Skill Map</td>
			<td style="width:50%;">BLITZKRIEG</td>
		</tr>
		<tr>
			<td style="width:50%;">Clans War</td>
			<td style="width:50%;">Ladder War</td>
		</tr>
	</tbody>
</table>



<br />

<!-- COMMANDS -->
<h2>Room TAG</h2>
<table class="table table-condensed table-hover table-striped table-bordered">
	<tbody>
		<tr>
			<td>[LEAD]</td>
			<td>Disables the Anti-Lead system</td>
		</tr>
		<tr>
			<td>[TELE]</td>
			<td>Save position NUMPAD 1 - Load position NUMPAD 2</td>
		</tr>
		<tr>
			<td>[V]</td>
			<td>Vanilla Mode. HP/AP is capped to default (125/100).</td>
		</tr>
		<tr>
			<td>[R]</td>
			<td>Instant reloading</td>
		</tr>
		<tr>
			<td>[IA]</td>
			<td>Infinite Ammo</td>
		</tr>
		<tr>
			<td>[EX]</td>
			<td>Ignore explosion damage, flashbangs and smoke grenades.</td>
		</tr>
		<tr>
			<td>[FPS]</td>
			<td>FPS mode. Press shift to sprint!</td>
		</tr>
		<tr>
			<td>[DMG2] / [DMG3]</td>
			<td>Damage Multiplier for 'Infected' mode.</td>
		</tr>
		<tr>
			<td>[GLA]</td>
			<td>Only Melee</td>
		</tr>
		<tr>
			<td>[SGO]</td>
			<td>Shotguns only.</td>
		</tr>
		<tr>
			<td>[SNO]</td>
			<td>Snipers only</td>
		</tr>
		<tr>
			<td>[RVO]</td>
			<td>Revolvers only</td>
		</tr>
		<tr>
			<td>[RTD]</td>
			<td>Roll The Dice mode.</td>
		</tr>
		<tr>
			<td>[VAMP]</td>
			<td>Mode Vampire</td>
		</tr>
		<tr>
			<td>[PAINT]</td>
			<td>Paint Mode</td>
		</tr>
		<tr>
			<td>[F]</td>
			<td>No Flip.</td>
		</tr>
		<tr>
			<td>[M]</td>
			<td>No Massive</td>
		</tr>
		<tr>
			<td>[N]</td>
			<td>Ninja Jump</td>
		</tr>
		<tr>
			<td>[WIW]</td>
			<td>No Spawn World Items, HP, AP and Bullets!</td>
		</tr>
		<tr>
			<td>[G]</td>
			<td>Gravity</td>
		</tr>
		<tr>
			<td>[S]</td>
			<td>Speed</td>
		</tr>
		<tr>
			<td>[J]</td>
			<td>Jump!</td>
		</tr>
	</tbody>
</table>
<!-- VIDEO -->
<h2>Video</h2>
<iframe width="560" height="315" src="https://www.youtube.com/embed/5TTyE7cjDJ8?si=wbNvt8FVYMxx8tDy" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>