<?php
echo html::begin_form('admin/save_user', array('method'=>'post','enctype'=>'multipart/form-data'));
    echo html::input('id_user',array('type'=>'hidden','value'=>$user->id_user));
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('name', array());
        echo html::input('use_name', array('class'=>'form-control','value'=>$user->use_name));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('surname', array());
        echo html::input('use_surname', array('class'=>'form-control','value'=>$user->use_surname));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('login', array());
        echo html::input('use_login', array('class'=>'form-control','value'=>$user->use_login));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('password', array());
        echo html::input('use_password', array('class'=>'form-control','value'=>$user->use_password,'type'=>'password'));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('address', array());
        echo html::input('use_address', array('class'=>'form-control','value'=>$user->use_address));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('locality', array());
        echo html::input('use_locality', array('class'=>'form-control','value'=>$user->use_locality));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('NPA', array());
        echo html::input('use_NPA', array('class'=>'form-control','value'=>$user->use_NPA,'size'=>'5','type'=>'number'));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('mail', array());
        echo html::input('use_mail', array('class'=>'form-control','value'=>$user->use_mail));
    echo html::end_div();
    echo html::begin_div(array('class'=>'form-group'));
        echo html::label('right', array());
        echo html::input('idx_right', array('class'=>'form-control','value'=>$user->idx_right,'type'=>'number'));
    echo html::end_div();
    echo html::input('submit',array('type'=>'submit','class'=>'btn btn-default'));
echo html::end_form('admin/modify_user');