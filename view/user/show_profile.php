<?php 
echo  html::begin_div();
foreach($user as $properties=>$value){
    echo html::begin_div();
        echo html::label($properties.' : '.$value);
    echo html::end_div();
}
echo html::end_div();

?>