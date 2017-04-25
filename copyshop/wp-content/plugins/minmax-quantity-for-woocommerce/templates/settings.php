<?php 
$dplugin_name = 'WooCommerce Min/Max Quantity';
$dplugin_link = 'http://berocket.com/product/woocommerce-minmax-quantity';
$dplugin_price = 18;
@ include 'discount.php';
?>
<div class="wrap br_settings br_mm_quantity_settings">
    <div id="icon-themes" class="icon32"></div>
    <h2>Min/Max Quantity</h2>
    <?php settings_errors(); ?>

    <h2 class="nav-tab-wrapper">
        <a href="#currencies" class="nav-tab nav-tab-active general-tab" data-block="general"><?php _e('General', 'BeRocket_MM_Quantity_domain') ?></a>
        <a href="#css" class="nav-tab css-tab" data-block="css"><?php _e('CSS', 'BeRocket_MM_Quantity_domain') ?></a>
    </h2>

    <form class="mm_quantity_submit_form" method="post" action="options.php">
        <?php 
        $options = BeRocket_MM_Quantity::get_mm_quantity_option(); ?>
        <div class="nav-block general-block nav-block-active">
            <table class="form-table license">
                <tr>
                    <th scope="row"><?php _e('Hide Checkout button', 'BeRocket_MM_Quantity_domain') ?></th>
                    <td>
                        <label>
                            <input type="checkbox" name="br_mm_quantity_options[hide_checkout]" value="1"<?php if( $options['hide_checkout'] ) echo ' checked'; ?>>
                            <?php _e('if min/max requirements no passed hide checkout button.', 'BeRocket_MM_Quantity_domain') ?>
                        </label>
                        <div>
                            <span style="display: inline-block;min-width:250px;"><?php _e('Checkout cart button class: ', 'BeRocket_MM_Quantity_domain') ?></span>
                            <input type="text" name="br_mm_quantity_options[checkout_class]" value="<?php echo $options['checkout_class']; ?>">
                        </div>
                        <div>
                            <span style="display: inline-block;min-width:250px;"><?php _e('Checkout widget cart button class: ', 'BeRocket_MM_Quantity_domain') ?></span>
                            <input type="text" name="br_mm_quantity_options[checkout_mini_class]" value="<?php echo $options['checkout_mini_class']; ?>">
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Products in cart cost', 'BeRocket_MM_Quantity_domain') ?></th>
                    <td>
                        <?php _e('Minimum: ', 'BeRocket_MM_Quantity_domain') ?><input type="number" min="0" name="br_mm_quantity_options[cart_min_price]" value="<?php echo $options['cart_min_price']; ?>">
                        <?php _e('Maximum: ', 'BeRocket_MM_Quantity_domain') ?><input type="number" min="0" name="br_mm_quantity_options[cart_max_price]" value="<?php echo $options['cart_max_price']; ?>">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Quantity of products in cart', 'BeRocket_MM_Quantity_domain') ?></th>
                    <td>
                        <?php _e('Minimum: ', 'BeRocket_MM_Quantity_domain') ?><input type="number" min="0" name="br_mm_quantity_options[cart_min_quantity]" value="<?php echo $options['cart_min_quantity']; ?>">
                        <?php _e('Maximum: ', 'BeRocket_MM_Quantity_domain') ?><input type="number" min="0" name="br_mm_quantity_options[cart_max_quantity]" value="<?php echo $options['cart_max_quantity']; ?>">
                    </td>
                </tr>
            </table>
        </div>
        <div class="nav-block css-block">
            <table class="form-table license">
                <tr>
                    <th scope="row"><?php _e('Custom CSS', 'BeRocket_MM_Quantity_domain') ?></th>
                    <td>
                        <textarea name="br_mm_quantity_options[custom_css]"><?php echo $options['custom_css']?></textarea>
                    </td>
                </tr>
            </table>
        </div>
        <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'BeRocket_MM_Quantity_domain') ?>" />
    </form>

    <h4><?php _e('WooCommerce Min and Max Quantities developed by', 'BeRocket_MM_Quantity_domain') ?> <a href="http://berocket.com" target="_blank">BeRocket</a></h4>
</div>