<?php

class DeliveryCostModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_delivery_cost';
        return $wpdb->get_results($sql);
    }
}
