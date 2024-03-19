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

echo '<div class="page-title"><span>News</span></div>';

try {
	loadModuleConfigs('news');
	
	// Module status
	if(!mconfig('active')) throw new Exception(lang('error_47',true));
	
	// News object
	$News = new News();
	$cachedNews = loadCache('news.cache');
	if(!is_array($cachedNews)) throw new Exception(lang('error_61'));
	
	// Set news language
	if(config('language_switch_active',true)) {
		if(check_value($_SESSION['language_display'])) {
			$News->setLanguage($_SESSION['language_display']);
		}
	}
	
	// Single news
	$requestedNewsId = $_GET['subpage'];
	if(check_value($requestedNewsId) && $News->newsIdExists($requestedNewsId)) {
		$showSingleNews = true;
		$newsID = $requestedNewsId;
	}
	
	// News list
	$i = 0;
	foreach($cachedNews as $newsArticle) {
		if($showSingleNews) if($newsArticle['news_id'] != $newsID) continue;
		$News->setId($newsArticle['news_id']);
		
		if($i > mconfig('news_list_limit')) continue;
		
		$news_id = $newsArticle['news_id'];
		$news_title = base64_decode($newsArticle['news_title']);
		$news_author = $newsArticle['news_author'];
		$news_date = $newsArticle['news_date'];
		$news_url = __BASE_URL__.'news/'.$news_id.'/';
		
		// translated news title
		if(config('language_switch_active',true)) {
			if(check_value($_SESSION['language_display']) && is_array($newsArticle['translations'])) {
				if(array_key_exists($_SESSION['language_display'], $newsArticle['translations'])) {
					$news_title = base64_decode($newsArticle['translations'][$_SESSION['language_display']]);
				}
			}
		}
		
		if(mconfig('news_short')) {
			if($showSingleNews) {
				$loadNewsCache = $News->LoadCachedNews();
			} else {
				$loadNewsCache = $News->LoadCachedNews(true);
				$loadNewsCache .= '<br /><a href="'.$news_url.'" class="btn btn-primary">' . lang('news_txt_3') . '</a>';
			}
		} else {
			$loadNewsCache = $News->LoadCachedNews();
		}
		
		if(mconfig('news_expanded') > $i) {
			
			if($showSingleNews) {
				
				// single news (expanded)
				echo '<div class="row news-article">';
					echo '<div class="col-xs-12 news-content">';
						echo '<h3><a href="'.$news_url.'">'.$news_title.'</a></h3>';
						echo $loadNewsCache;
						echo '<span class="news-date pull-right">'.langf('news_txt_1', array($news_author, date("F j, Y",$news_date))).'</span>';
					echo '</div>';
				echo '</div>';
				
			} else {
				
				// news list
				
				$newsImagePath = __PATH_TEMPLATE_IMG__ . 'news/'.$news_id.'.jpg';
				if(!file_exists(__PATH_TEMPLATE_ROOT__ . 'img/news/'.$news_id.'.jpg')) {
					$newsImagePath = __PATH_TEMPLATE_IMG__ . 'news/news-default.jpg';
				}
				
				// expanded news
				echo '<div class="row news-article">';
					echo '<div class="col-xs-5 news-image">';
						echo '<a href="'.$news_url.'"><img src="'.$newsImagePath.'" /></a>';
					echo '</div>';
					echo '<div class="col-xs-7 news-content">';
						echo '<h3><a href="'.$news_url.'">'.$news_title.'</a></h3>';
						echo $loadNewsCache;
						echo '<span class="news-date pull-right">'.langf('news_txt_1', array($news_author, date("F j, Y",$news_date))).'</span>';
					echo '</div>';
				echo '</div>';
			}
		} else {
			// non expanded news
			echo '<div class="row news-article">';
				echo '<div class="col-xs-12 news-content">';
					echo '<h3><a href="'.$news_url.'">'.$news_title.'</a></h3>';
				echo '</div>';
			echo '</div>';
		}
		
		$i++;
	}

} catch(Exception $ex) {
	message('warning', $ex->getMessage());
}