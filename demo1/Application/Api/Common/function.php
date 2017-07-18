<?php
//权限判断
function quanx($name,$type='1'){
$uid=session('USER')?:'';
if(!$uid){session('HTQX',null);header("location:/user");}
$quanx1= new\Think\Auth();	
$quanx2= $quanx1->check($name,$uid);
switch($type){case 1:return $quanx2?:tiaoc();break;case 2:return $quanx2;break;}}
//跳出规则
function tiaoc(){
    header("location:/Admin/public/error1");
}
//左侧显示隐藏
function qx_amdin($name,$type='1'){
    $uid=session('QX_ADMIN');   
    $quanx1= new\Think\Auth();
    $quanx2= $quanx1->check($name,$uid);
    switch($type){case 1:return $quanx2?:tiaoc();break;case 2:return $quanx2;break;}}




