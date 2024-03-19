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

if(!isLoggedIn()) redirect(1,'login');
if(!mconfig('active')) throw new Exception(lang('error_47'));

// Module title
echo '<div class="page-title"><span>DONATE</span></div>';

// PayPal conversion rate
echo '<iframe height="645" class="errorbox" width="100%" src="https://gunz.vn/napthegunz/index.php"></iframe>';