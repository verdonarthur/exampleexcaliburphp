<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class='col-md-2'></div>
<div class='col-md-8'>
    <h2>Connection</h2>
    <?php echo html::begin_form('connection/connect', array('enctype'=>'multipart/form-data','method'=>'post')) ?> 
        <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" id="Username" placeholder="Username" name="username">
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" id="Password" placeholder="Password" name="password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
</div>
<div class='col-md-2'></div>