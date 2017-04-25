<?php

class TaskPriceModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_task_price';
        return $wpdb->get_results($sql);
    }
}
