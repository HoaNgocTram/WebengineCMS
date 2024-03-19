<?php
/**
 * WebEngine CMS
 * https://webenginecms.org/
 * 
 * @version 1.0.9.8
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2017 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */
include('../modules/config.php');
?>
<h1 class="page-header">Search Character</h1>
<form class="form-inline" role="form" method="post">
	<div class="form-group">
		<input type="text" class="form-control" id="input_1" name="search_request" placeholder="Character name"/>
	</div>
	<button type="submit" class="btn btn-primary" name="search_character" value="ok">Search</button>
</form>
<br />
<?php
	if(check_value($_POST['search_character']) && check_value($_POST['search_request'])) {
		try {
			if(!Validator::AlphaNumeric($_POST['search_request'])) throw new Exception("The name entered must contain alpha-numeric characters only.");
			if(!Validator::Length($_POST['search_request'], 11, 2)) throw new Exception("The name can be 3 to 10 characters long.");
			$searchdb = $dB;
			$nameS = $_POST['search_request'];
			$searchRequest = '%'.$_POST['search_request'].'%';
			$res1 = odbc_exec($connect, "SELECT * FROM Character WHERE Name = '".$nameS."'");
			$usr1 = odbc_fetch_array($res1);
			$name = ($usr1['Name'] =='') ? "No Data" : $usr1['Name'];
			$aid = ($usr1['AID'] =='') ? "No Data" : $usr1['AID'];
			$res2 = odbc_exec($connect, "SELECT * FROM Account WHERE AID = '".$aid."'");
			$usr2 = odbc_fetch_array($res2);
			$acc = $usr2['UserID'];
			$res3 = odbc_exec($connect, "SELECT * FROM MEMB_INFO WHERE memb___id = '".$acc."'");
			$usr3 = odbc_fetch_array($res3);
			$ID = ($usr3['memb_guid'] =='') ? "No Data" : $usr3['memb_guid'];
			$searchResults = $searchdb->query_fetch("SELECT TOP 10 NAME, AID FROM Character WHERE Name LIKE ?", array($searchRequest));
			if(!$searchResults) throw new Exception("No results found.");
			
			if(is_array($searchResults)) {
				echo '<div class="row">';
				echo '<div class="col-md-6">';
				echo '<table class="table table-striped table-condensed table-hover">';
					echo '<thead>';
						echo '<tr>';
							echo '<th colspan="2">Search Results for <span style="color:red;"><i>'.$name.' , AID: '.$aid.', ID: '.$ID.'</i></span></th>';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
				foreach($searchResults as $character) {
					echo '<tr>';
						echo '<td>'.$name.'</td>';
						echo '<td style="text-align:right;">';
							echo '<a href="'.admincp_base("accountinfo&id=".$ID).'" class="btn btn-xs btn-default">Account Information</a> ';
							echo '<a href="'.admincp_base("editcharacter&name=".$name).'" class="btn btn-xs btn-warning">Edit Character</a>';
						echo '</td>';
					echo '</tr>';
				}
					echo '</tbody>';
				echo '</table>';
				echo '</div>';
				echo '<div class="col-md-6"></div>';
				echo '</div>';
			}
		} catch(Exception $ex) {
			message('error', $ex->getMessage());
		}
	}
?>