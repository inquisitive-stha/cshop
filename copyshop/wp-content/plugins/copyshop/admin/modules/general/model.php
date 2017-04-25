<?php

class GeneralModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_settings';
        return $wpdb->get_results($sql);
    }
}
