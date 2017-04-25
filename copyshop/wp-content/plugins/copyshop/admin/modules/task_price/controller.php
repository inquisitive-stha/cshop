<?php
include_once("model.php");



$action = $_REQUEST['action'];
switch($action)
{
    case 'add':
        include_once("view_form.php");
        break;
    
    default:
        $list = TaskPriceModel::getAll();
        include_once("view_list.php");
}

