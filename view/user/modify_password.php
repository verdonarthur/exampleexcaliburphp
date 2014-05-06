
<h2>Change your password</h2>
<br>
<?php
if(!empty($result)){
    if($result != 1)
        echo '<div class="alert alert-success"><trong>Congratulations !</strong> you successfully change your password</div>';
    else
        echo '<div class="alert alert-danger"><strong>Error !</strong>Old password incorrect</div>';
}
echo html::begin_form('user/modify_password',array('method'=>'post','enctype'=>'multipart/form-data'));
echo html::input('oldpassword', array('type'=>"text",'class'=>"form-control","placeholder"=>"old password"));
echo '<br>';
echo html::input('newpassword', array('type'=>"text",'class'=>"form-control","placeholder"=>"new password"));
echo '<br>';
echo html::input('submit',array('type'=>'submit','class'=>'btn btn-default'));
echo html::end_form();