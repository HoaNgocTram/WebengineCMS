<?php
include('config.php');

if(!isset($_SESSION['username'])) {
    echo '<script>alert("You must be logged in");document.location="";</script>';
    die();
}

// Lấy AID của người chơi
$res1 = odbc_exec($connect, "SELECT * FROM Account WHERE UserID = '" .$_SESSION['username']. "'");
$usr1 = odbc_fetch_array($res1);
$aid = $usr1['AID'];

// Lấy danh sách nhân vật
$re = odbc_exec($connect, "SELECT * FROM Character(nolock) WHERE AID = '$aid' AND DeleteFlag = 0 ORDER BY CharNum ASC");

$chars = []; 
while($char = odbc_fetch_array($re)){
    $charInfo = [
        'CID' => $char['CID'],
        'Name' => $char['Name'],
        'Clan' => null
    ];

    $queryc = odbc_exec($connect, "SELECT * FROM ClanMember(nolock) WHERE CID = '" . $char['CID'] . "'");
    if(odbc_num_rows($queryc) > 0){
        $member = odbc_fetch_array($queryc);
        $clan = odbc_fetch_array(odbc_exec($connect, "SELECT * FROM Clan(nolock) WHERE CLID = '" . $member['CLID'] . "' AND DeleteFlag = 0"));
        if($clan){
            $charInfo['Clan'] = [
                'CLID' => $clan['CLID'],
                'Name' => $clan['Name'],
                'MasterCID' => $clan['MasterCID'],
                'Emblem' => ($clan['EmblemUrl'] == "") ? "./clan/emblem/no_emblem.png" : $clan['EmblemUrl']
            ];
        }
    }
    $chars[] = $charInfo;
}

// Xử lý upload
if(isset($_POST['submit'])){
    $selectedCharCID = $_POST['char'];
    $charData = null;

    foreach($chars as $c){
        if($c['CID'] == $selectedCharCID){
            $charData = $c;
            break;
        }
    }

    if(!$charData || !$charData['Clan']){
        echo '<script>alert("This character is not in a clan \nNhân vật này không thuộc clan nào");document.location="";</script>';
        die();
    }

    if($charData['CID'] != $charData['Clan']['MasterCID']){
        echo '<script>alert("You are not the Clan Master \nBạn không phải chủ Clan");document.location="";</script>';
        die();
    }

    $CLID = $charData['Clan']['CLID'];
    $targetDir = "./clan/emblem/";
    $targetFile = $targetDir . basename($_FILES['uploaded']['name']);
    $allowTypes = ['jpg','jpeg','png','gif'];
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    if(!in_array($fileType, $allowTypes) || $_FILES['uploaded']['size'] > 204800){
        echo '<script>alert("Invalid file type or size \nChỉ được upload JPG, PNG, GIF và dung lượng <=200KB");document.location="";</script>';
        die();
    }

    if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $targetFile)){
        odbc_exec($connect, "UPDATE Clan SET EmblemChecksum = EmblemChecksum + 1, EmblemUrl = '$targetFile' WHERE CLID = '$CLID'");
        echo '<script>alert("File uploaded successfully \nUpload thành công!");document.location="";</script>';
        die();
    }
}

// Hiển thị form
echo '<div class="page-title"><span>'.lang('emblem_txt_1',true).'</span></div>';
echo '<div class="col-xs-8 col-xs-offset-2" style="margin-top:30px;">';
echo '<form class="form-horizontal" action="" method="post" enctype="multipart/form-data">';

// chọn nhân vật
echo '<div class="form-group">';
echo '<label class="col-sm-4 control-label">Select Character (Chọn nhân vật)</label>';
echo '<div class="col-sm-8">';
echo '<select name="char" id="charSelect" class="form-control" onchange="updateClanLogo()">';

foreach($chars as $c){
    if($c['Clan']){
        echo '<option value="'.$c['CID'].'" data-emblem="'.$c['Clan']['Emblem'].'">'.$c['Name'].' - Clan: '.$c['Clan']['Name'].'</option>';
    } else {
        echo '<option value="'.$c['CID'].'" data-emblem="">'.$c['Name'].' - NO CLAN</option>';
    }
}
echo '</select>';
echo '</div></div>';

// chỗ hiển thị logo clan
echo '<div class="form-group" id="clanLogoBox" style="display:none;">';
echo '<label class="col-sm-4 control-label">Clan Emblem</label>';
echo '<div class="col-sm-8">';
echo '<img id="clanLogo" src="" alt="Clan Emblem" style="max-height:100px;border:1px solid #ccc;padding:5px;border-radius:5px;">';
echo '</div></div>';

// upload file
echo '<div class="form-group">';
echo '<label class="col-sm-4 control-label">Image File</label>';
echo '<div class="col-sm-8">';
echo '<input type="file" class="form-control" name="uploaded" accept="image/png, image/gif, image/jpeg" required>';
echo '<span class="help-block">JPEG, PNG, GIF Size <=200KB</span>';
echo '</div></div>';

echo '<div class="form-group">';
echo '<div class="col-sm-offset-4 col-sm-8">';
echo '<button type="submit" name="submit" class="btn btn-primary">Upload</button>';
echo '</div></div>';

echo '</form></div>';
?>

<script>
function updateClanLogo(){
    var select = document.getElementById('charSelect');
    var emblem = select.options[select.selectedIndex].getAttribute('data-emblem');
    var logoBox = document.getElementById('clanLogoBox');
    var logoImg = document.getElementById('clanLogo');

    if(emblem && emblem !== ""){
        logoImg.src = emblem;
        logoBox.style.display = "flex";
    } else {
        logoBox.style.display = "none";
    }
}

// Gọi khi load xong để hiện logo mặc định theo nhân vật đầu tiên
window.onload = updateClanLogo;
</script>
