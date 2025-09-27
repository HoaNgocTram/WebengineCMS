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

// File Name
$file_name = basename(__FILE__);

// connect DB Gunz
$db = Connection::Database('Me_MuOnline');

// load cache (character -> country)
$characterCountryCache = loadCache('character_country.cache');

// lấy danh sách nhân vật và AID
$characters = $db->query_fetch("SELECT Name, AID FROM Character");
$result = $characterCountryCache;

if(is_array($characters)) {
    foreach($characters as $row) {
        $charName = $row['Name'];
        $aid      = $row['AID'];

        // nếu cache đã có thì bỏ qua
        if(array_key_exists($charName, $characterCountryCache)) continue;

        // tìm IP theo AID
        $acc = $db->query_fetch_single("SELECT LastIP FROM Login WHERE AID = ?", [$aid]);
        if(!$acc || empty($acc['LastIP'])) continue;

        // convert IP → country code
        $countryCode = getCountryCodeFromIp($acc['LastIP']);
        if(!check_value($countryCode)) continue;

        // lưu vào result
        $result[$charName] = $countryCode;
    }
}

// nếu có dữ liệu mới thì update cache
if(is_array($result)) {
    $cacheData = encodeCache($result);
    updateCacheFile('character_country.cache', $cacheData);
}
