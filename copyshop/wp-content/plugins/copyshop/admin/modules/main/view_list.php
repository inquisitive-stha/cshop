<nav class="nav-tab-wrapper woo-nav-tab-wrapper">
    <a href="?page=copyshop_main&tab=general" class="nav-tab <?php echo (trim($_REQUEST['tab']) == '' || trim($_REQUEST['tab']) == 'general') ? 'nav-tab-active' : ''; ?>">Genral</a>
    <a href="?page=copyshop_main&tab=format" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'format') ? 'nav-tab-active' : ''; ?>">Format</a>
    <a href="?page=copyshop_main&tab=weight" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'weight') ? 'nav-tab-active' : ''; ?>">Weight</a>
    <a href="?page=copyshop_main&tab=printing_cost" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'printing_cost') ? 'nav-tab-active' : ''; ?>">Printing Cost</a>
    <a href="?page=copyshop_main&tab=paper_cost" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'paper_cost') ? 'nav-tab-active' : ''; ?>">Paper Cost</a>
    <a href="?page=copyshop_main&tab=delivery_cost" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'delivery_cost') ? 'nav-tab-active' : ''; ?>">Delivery Cost</a>
    <a href="?page=copyshop_main&tab=task" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'task') ? 'nav-tab-active' : ''; ?>">Task</a>
    <a href="?page=copyshop_main&tab=task_price" class="nav-tab <?php echo (trim($_REQUEST['tab']) == 'task_price') ? 'nav-tab-active' : ''; ?>">Task Price</a>
</nav>

<?php
switch (trim($_REQUEST['tab'])) {
    case 'format':
        copyshop_paper_format();
        break;
    case 'weight':
        copyshop_paper_weight();
        break;
    case 'printing_cost':
        copyshop_printing_cost();
        break;
    case 'paper_cost':
        copyshop_paper_cost();
        break;
    case 'delivery_cost':
        copyshop_delivery_cost();
        break;
    case 'task':
        copyshop_task();
        break;
    case 'task_price':
        copyshop_task_price();
        break;
//    case 'general':
//        copyshop_settings();
//        break;
    default:
        copyshop_settings();
        break;
}
?>