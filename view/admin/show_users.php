<h2>List of users</h2>
<br>
<?php
echo html::begin_table(array('class'=>'table table-hover'));
echo html::tr(
        html::th('#').
        html::th('name').
        html::th('surname').
        html::th('login').
        html::th('address').
        html::th('mail').
        html::th('').
        html::th(''));
foreach ($users as $row=>$value) {
    echo html::tr(
            html::td($value->id_user)
            .html::td($value->use_name)
            .html::td($value->use_surname)
            .html::td($value->use_login)
            .html::td($value->use_address.' '.$value->use_NPA.' '.$value->use_locality)
            .html::td($value->use_mail)
            .html::td(html::a('admin/modify_user?id_user='.$value->id_user,html::span('', array('class'=>'glyphicon glyphicon-pencil'))))
            .html::td(html::a('admin/delete_user?id_user='.$value->id_user,html::span('', array('class'=>'glyphicon glyphicon-remove')))));
}
echo html::end_table();

echo html::a('admin/add_user', html::button('add user',array('class'=>'btn btn-default')));