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

// File Name
$file_name = basename(__FILE__);

// kết nối DB Gunz
$db = Connection::Database('Me_MuOnline');

// lấy 50 account chưa có country
$accountList = $db->query_fetch("
    SELECT TOP 50 * 
    FROM "._TBL_LOGIN_." 
    WHERE "._CLMN_LOGIN_USERID_." NOT IN (
        SELECT account FROM ".WEBENGINE_ACCOUNT_COUNTRY."
    )
    AND "._CLMN_LOGIN_IP_." IS NOT NULL
");

if(is_array($accountList)) {
    $Account = new Account();
    foreach($accountList as $row) {
        $countryCode = getCountryCodeFromIp($row[_CLMN_LOGIN_IP_]);
        if(!check_value($countryCode)) continue;

        $Account->setAccount($row[_CLMN_LOGIN_USERID_]);
        $Account->setCountry($countryCode);
        $Account->insertAccountCountry();
    }
}

// cập nhật thời gian chạy cron
updateCronLastRun($file_name);
