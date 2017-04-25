<?php

/**
 * Fired during plugin activation
 *
 * @link       pragtechs.com
 * @since      1.0.0
 *
 * @package    Copyshop
 * @subpackage Copyshop/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Copyshop
 * @subpackage Copyshop/includes
 * @author     Pragmatic Technology <info@pragtechs.com>
 */
class Copyshop_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
            
            $sql = "CREATE TABLE IF NOT EXISTS `copy_delivery_cost` (
`id` int(11) NOT NULL,
  `order_total` int(11) NOT NULL,
  `delivery_charge` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_format` (
`id` int(11) NOT NULL,
  `title` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_paper_cost` (
`id` int(11) NOT NULL,
  `format_id` int(11) NOT NULL,
  `weight_id` int(11) NOT NULL,
  `price` float(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_paper_weight` (
`id` int(11) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_printing_cost` (
`id` int(11) NOT NULL,
  `p_from` int(11) NOT NULL,
  `p_to` int(11) NOT NULL,
  `bw` float(10,5) NOT NULL,
  `color` float(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_task` (
`id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `setup_charge` float(10,5) NOT NULL,
  `attributes` text NOT NULL,
  `options` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `copy_task_price` (
  `id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `sheets_from` int(11) NOT NULL,
  `sheets_to` int(11) NOT NULL,
  `pcs_from` int(11) NOT NULL,
  `pcs_to` int(11) NOT NULL,
  `price` float(10,5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
CREATE TABLE IF NOT EXISTS `copy_settings` (
`c_key` int(11) NOT NULL,
  `c_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
ALTER TABLE `copy_delivery_cost`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_format`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_paper_cost`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_paper_weight`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_printing_cost`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_settings`
 ADD PRIMARY KEY (`c_key`);
ALTER TABLE `copy_task`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_task_price`
 ADD PRIMARY KEY (`id`);
ALTER TABLE `copy_delivery_cost`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_format`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_paper_cost`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_paper_weight`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_printing_cost`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_settings`
MODIFY `c_key` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_task`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `copy_task_price`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;";


        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
            
	}

}
