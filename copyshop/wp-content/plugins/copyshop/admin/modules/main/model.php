<?php

class MainModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_format';
        return $wpdb->get_results($sql);
    }
}
