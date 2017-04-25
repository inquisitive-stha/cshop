<?php

class TaskModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_task';
        return $wpdb->get_results($sql);
    }
}
