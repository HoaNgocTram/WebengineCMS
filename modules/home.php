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
include('config.php');
?>
<br /><br />
<div class="row">
	<div class="col-xs-6">
		<div class="blockTitle">
			<h2><span>Top</span> Players</h2>
		</div><!-- blockTitle -->
		<?php
		# Top Level
		$levelRankingData = LoadCacheData('rankings_level.cache');
		$topLevelLimit = 5;
		if(is_array($levelRankingData)) {
			$topLevel = array_slice($levelRankingData, 0, $topLevelLimit+1);
			echo '<table class="table">';
				echo '<tr>';
					echo '<th>Player</th>';
					echo '<th class="text-center">Level</th>';
					echo '<th class="text-center">Ladder</th>';
					echo '<th class="text-center">XP</th>';
				echo '</tr>';
				foreach($topLevel as $key => $row) {
					if($key == 0) continue;
					echo '<tr>';
						echo '<td>'.playerProfile($row[0]).'</td>';
						echo '<td class="text-center">'.number_format($row[1]).'</td>';
						echo '<td class="text-center">'.number_format($row[2]).'</td>';
						echo '<td class="text-center">'.number_format($row[4]).'</td>';
					echo '</tr>';
				}
			echo '</table>';
		}
		?>
	</div>
	<div class="col-xs-6">
		<div class="blockTitle">
			<h2><span>Top</span> Clans</h2>
		</div><!-- blockTitle -->
		<?php
		# Top Level
		$guildRankingData = LoadCacheData('rankings_guilds.cache');
		$topGuildLimit = 5;
		if(is_array($guildRankingData)) {
			$topGuild = array_slice($guildRankingData, 0, $topGuildLimit+1);
			echo '<table class="table">';
				echo '<tr>';
					echo '<th>Logo</th>';
					echo '<th class="text-center">Clan</th>';
					echo '<th class="text-center">Win</th>';
					echo '<th class="text-center">Losses</th>';
					echo '<th class="text-center">Score</th>';
				echo '</tr>';
				foreach($topGuild as $key => $row) {
					if($key == 0) continue;
					echo '<tr>';
					{
						if ($row[1] == NULL)
						echo '<td><img src="'.$emblem.'clan/emblem/no_emblem.png" class="emblem width="25" height="25""/></td>';
						else
						echo '<td><img src="'.$emblem.''.guildProfile($row[1]).'" class="emblem width="25" height="25""/></td>';
					}
						echo '<td class="text-center">'.guildProfile($row[0]).'</td>';
						echo '<td class="text-center">'.number_format($row[2]).'</td>';
						echo '<td class="text-center">'.number_format($row[3]).'</td>';
						echo '<td class="text-center">'.number_format($row[4]).'</td>';
					echo '</tr>';
				}
			echo '</table>';
		}
		?>
	</div>
</div>

<div class="infoBlockHome">
	<!-- Swiper -->
	<div class="slider">
		<div class="swiper-container slider gallery-top">
			<div class="swiper-wrapper">
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>rw-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img warrior">
						</div>
						<div class="className">
							<h2>GLADIATOR</h2>
							<span>BATTLE WITH HIGH SKILLS</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type: <b>Solo</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 72%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>mg-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img warrior">
						</div>
						<div class="className">
							<h2>Ladder</h2>
							<span>PLAYER WAR</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type: <b>Solo / Team</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 70%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>rf-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img warrior">
						</div>
						<div class="className">
							<h2>TEAM DEATHMATCH</h2>
							<span>GET A TEAM TO FIGHT</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type: <b>Team</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 100%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>gl-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img warrior">
						</div>
						<div class="className">
							<h2>Clan War</h2>
							<span>WITH OTHER CLAN MEMBERS FIGHT</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type  : <b>Solo / Team</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 70%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>elf-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img warrior">
						</div>
						<div class="className">
							<h2>Duel</h2>
							<span>THE DUEL MATCH</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type : <b>Solo</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 80%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
				<div class="swiper-slide" style="background-image: url(<?php echo __PATH_TEMPLATE_IMG__; ?>dl-hero.png);">
					<div class="classNameBlock flex-c">
						<div class="class-img magic">
						</div>
						<div class="className">
							<h2>Quest</h2>
							<span>PVE MODE</span>
						</div>
					</div><!-- classNameBlock -->
					<div class="skillBlock">
						<p>Type: <b>Team</b></p>
						<p class="flex-c">Classification: <span class="stars"><span style="width: 50%;"></span></span></p> 
					</div><!-- skillBlock -->
					<!--
					<div class="sliderVideo">
						<a href="#modal-video" class="open_modal"></a>
					</div>
					-->
				</div>
			</div>	
		</div>
		<div class="slider-arrow">
			<div class="swiper-button-next"></div>
			<div class="swiper-button-prev"></div>
		</div>
		<div class="swiper-container gallery-thumbs">
			<div class="swiper-wrapper">
				<div class="swiper-slide bk"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>rw-ava.png" alt=""></span></div>
				<div class="swiper-slide mg"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>mg-ava.png" alt=""></span></div>
				<div class="swiper-slide rf"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>rf-ava.png" alt=""></span></div>
				<div class="swiper-slide gl"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>gl-ava.png" alt=""></span></div>
				<div class="swiper-slide elf"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>elf-ava.png" alt=""></span></div>
				<div class="swiper-slide dl"><span><img src="<?php echo __PATH_TEMPLATE_IMG__; ?>dl-ava.png" alt=""></span></div>
			</div>
		</div>
	</div><!-- slider -->
	<div class="gameCenterBlock">
		<h1>GAME <span>CENTER</span></h1>
		<div class="gameBlocks flex-c-c">
			<div class="gameBlock strategy">
				<p class="game-title_1">GAME</p>
				<p class="game-title_2"><?php echo lang('menu_txt_11'); ?></p>
				<a href="<?php echo __BASE_URL__; ?>info"><?php echo lang('home_1'); ?></a>
			</div>
			<div class="gameBlock system">
				<p class="game-title_1"><?php echo lang('menu_txt_8'); ?></p>
				<p class="game-title_2"><?php echo lang('home_2'); ?></p>
				<a href="<?php echo __BASE_URL__; ?>donation"><?php echo lang('home_1'); ?></a>
			</div>
			<div class="gameBlock events">
				<p class="game-title_1">GAME</p>
				<p class="game-title_2"><?php echo lang('menu_txt_10'); ?></p>
				<a href="<?php echo __BASE_URL__; ?>rankings"><?php echo lang('home_1'); ?></a>
			</div>
			<div class="gameBlock pets">
				<p class="game-title_1"><?php echo lang('home_3'); ?></p>
				<p class="game-title_2">PANEL</p>
				<a href="<?php echo __BASE_URL__; ?>usercp"><?php echo lang('home_1'); ?></a>
			</div>
			<div class="gameBlock guides">
				<p class="game-title_1"><?php echo lang('home_4'); ?></p>
				<p class="game-title_2">FACEBOOK</p>
				<a href="<?php echo config('website_forum_link'); ?>"><?php echo lang('home_1'); ?></a>
			</div>
		</div>
	</div><!-- gameCenterBlock -->
</div><!-- infoBlockHome -->

<!--
<div id="modal-video" class="modal_div modal_video"> 
	<span class="modal_close">X</span>
	<div class="modal-title">
		<h2>Video</h2>
	</div>  
	<div class="modal-content">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/SfKvH0-itPg" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
	</div>   
</div>
-->