<?php
/**
 * Redeem Code
 * https://webenginecms.org/
 * 
 * @version 1.2.0
 * @author Lautaro Angelico <http://lautaroangelico.com/>
 * @copyright (c) 2013-2020 Lautaro Angelico, All Rights Reserved
 * @build w641ba01901cb0925ec50f543e59acbd
 */

try {
	
	if(!class_exists('Plugin\RedeemCode\RedeemCode')) throw new Exception('Plugin disabled.');
	$RedeemCode = new \Plugin\RedeemCode\RedeemCode();
	$RedeemCode->loadModule('code');
	
} catch(Exception $ex) {
	message('error', $ex->getMessage());
}