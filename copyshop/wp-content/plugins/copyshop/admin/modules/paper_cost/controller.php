<?php
include_once("model.php");
include_once(COPYSHOP_ROOT."admin/modules/paper_format/model.php");
include_once(COPYSHOP_ROOT."admin/modules/paper_weight/model.php");

//echo COPYSHOP_ROOT;

$action = $_REQUEST['action'];
switch($action)
{
    case 'add':
        include_once("view_form.php");
        break;
    
    default:
        $list = PaperCostModel::getAll();
        
        $format = PaperFormatModel::getAll();
        $weight = PaperWeightModel::getAll();
        
        include_once("view_list.php");
}

