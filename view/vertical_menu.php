<?php
$session = session::get('username');

if(empty($session)){
    $array_vertical_menu = array(html::a('test/db', 'Base de données'), html::a('test/html', 'HTML'),  html::a('test/orm','ORM'));
}
else{
    $right = session::get('userright');
    
    $array_vertical_menu = array(html::a('user/show_profile', 'Show profile'),html::a('user/modify_password', 'Modify password'));
    
    if($right == 1){
        $admin_menu = array(html::a('admin/show_users','Show users'));
        $array_vertical_menu = array_merge($array_vertical_menu,$admin_menu);
    }
}

echo html::ul($array_vertical_menu, 'list-group', 'list-group-item');