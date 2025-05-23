<?php

/**
 * Front user center
 */
defined('EMLOG_ROOT') || exit('access denied!');

/*

The user center template tutorial for the foreground is as follows：

Judge whether to log in
if (ISLOGIN) {
    //do something
}

Get the information of the current login user
$userData['photo']
$userData['nickname']
$userData['description']
$userData['email']

Get the current route path
The variable $routerPath stores the routing path of the current request, such as：/user/profile，$routerPath 值为 profile

Import the header template file (whether to import it can be determined according to the route)
if (in_array($routerPath, ['', 'order', 'account', 'profile', 'weiyu'])) {
    include View::getView('header');
}

Realize routing correspondence function
if ($routerPath === 'profile') {
    //Display profile page
} elseif ($routerPath === 'weiyu') {
    // Display Noted Page
} elseif ($routerPath === 'order_calback') {
    // Processing payment callback logic
} else {
    show_404_page();
}

Import footer template file
include View::getView('footer')

*/

emDirect('/');
