<?php

class PrintingCostModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_printing_cost';
        return $wpdb->get_results($sql);
    }
}
