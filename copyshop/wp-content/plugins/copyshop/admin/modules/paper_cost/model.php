<?php

class PaperCostModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_paper_cost';
        return $wpdb->get_results($sql);
    }
}
