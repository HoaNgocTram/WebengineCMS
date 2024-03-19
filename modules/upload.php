<?php
include('config.php');
if(!isset($_SESSION['username'])) {
	echo '<script language="javascript">';
	echo 'alert("You must be logged in");';
	echo 'document.location = ""';
	echo '</script>';
	die();
}
$res1 = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" .$_SESSION['username']. "'");
	$usr1 = odbc_fetch_array($res1);
	$aid = $usr1['AID'];

$re = odbc_exec($connect, "SELECT CID FROM Character(nolock) WHERE AID = '$aid' AND DeleteFlag = 0 ORDER BY CharNum asc");   //Character

if( odbc_num_rows($re) > 0 ){
  while($char = odbc_fetch_array($re)){
  	$queryc = odbc_exec($connect, "SELECT * FROM ClanMember(nolock) WHERE CID = '" . $char['CID'] . "'"); //ClanMember
  		if( odbc_num_rows($queryc) > 0 ){
    		$a = odbc_fetch_array($queryc);
    		$b = odbc_fetch_array(odbc_exec($connect, "SELECT * FROM Clan(nolock) WHERE CLID = '" . $a['CLID'] . "' AND DeleteFlag = 0"));  //Clan
    		$C_CLID       = $a['CLID'];
			$C_MemCID	  = $a['CID'];
			$C_Name       = $b['Name'];
			$C_MasterCID  = $b['MasterCID'];
    		$C_Emblem     = ($b['EmblemUrl'] == "") ? "./clan/emblem/no_emblem.png" : $b['EmblemUrl'];
  		}
  	}
}

/*if ( $C_MemCID != $C_MasterCID ) {
	echo '<script language="javascript">';
	echo 'alert("You are not Clan Master \n \nBạn không phải chủ Clan");';
	echo 'document.location = "usercp/myaccount"';
	echo '</script>';
	die();
}*/

if (isset($_POST['submit'])) {      
  $CLID = $_POST['clan'];
	$target = "./clan/emblem/";
	$target = $target . basename( $_FILES['uploaded']['name']) ;
  $up1 = odbc_exec($connect, "UPDATE Clan SET EmblemChecksum = EmblemChecksum + 1 WHERE Name = '$CLID'");
	$up2 = odbc_exec($connect, "UPDATE Clan SET EmblemUrl = '".$target."' WHERE Name = '$CLID'");
	$ok=1;
  
  
	if (!($_FILES['uploaded']['size']  > '204000')){
	  $ok=1;
	  if(($_FILES['uploaded']['type'] == "image/jpeg")){
		$ok=1;
	  }
	  if(($_FILES['uploaded']['type'] == "image/GIF")){ 
		$ok=1;
	  }
	  if(($_FILES['uploaded']['type'] == "image/PNG")){ 
		$ok=1;
	  }
	}
	else { 
	  $ok=0;
	}

	if ($ok==0){
	    echo '<script language="javascript">';
		  echo 'alert("Sorry, the file has not been sent \nPlease check your icon size.  \n \nHình ảnh chưa được tải lên \nKiểm tra lại dung lượng ảnh");';
		  echo 'document.location = ""';
		  echo '</script>';
		  die();
	}
	else {
	  if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)){
		  echo '<script language="javascript">';
			echo 'alert("File uploaded successfully! \nGunZ The Duel  \n \nFile upload thành công! \nGunZ The Duel");';
			echo 'document.location = ""';
			echo '</script>';
			die();
		
	  }
	}
}
echo '<div class="page-title"><span>'.lang('emblem_txt_1',true).'</span></div>';	echo '<td><img src="'.__BASE_URL__.''.$C_Emblem.'" class="emblem width="50" height="50""/></td>';		
  echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
		echo '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">';
			echo '<div class="form-group">';
				echo '<label for="webengineRegistration1" class="col-sm-4 control-label">Clan</label>';
				echo '<select name="clan" class="login">'; 
					echo '<option value="'.$C_Name.'">';echo $C_Name;echo'</option>'; 
				echo '</select>';
			echo '</div>';
      echo '<div class="form-group">';
				echo '<label for="webengineRegistration2" class="col-sm-4 control-label">Image File</label>';
				echo '<div class="col-sm-8">';
					echo '<input type="file" class="form-control" id="webengineRegistration2" name="uploaded" accept="image/png, image/gif, image/jpeg" required>';
					echo '<span id="helpBlock" class="help-block">JPEG, PNG, GIF Size 100x100</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="form-group">';
				echo '<div class="col-sm-offset-4 col-sm-8">';
					echo '<button type="submit" name="submit" value="upload" class="btn btn-primary">Upload</button>';
				echo '</div>';
			echo '</div>';
		echo '</form>';
	echo '</div>';
?>


