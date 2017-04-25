<?php

class PaperWeightModel
{
    static function getAll()
    {
        global $wpdb;
        $sql = 'SELECT * FROM copy_paper_weight';
        return $wpdb->get_results($sql);
    }
}
