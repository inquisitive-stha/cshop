<?php

function p($r)
{
    echo '<pre>';
    print_r($r);
    echo '</pre>';
}

function template_start($title, $button_title = '', $button_link = '')
{
    ?>
    <div class="wrap">
            <h1 class="wp-heading-inline"><?php echo $title; ?></h1>
            <?php
            if(trim($button_title) != '')
            {
                ?>
                <a href="<?php echo $button_link; ?>" class="btn btn-success"><?php echo $button_title; ?></a>
                <?php
            }
            ?>
    <?php
}

function template_end()
{
    ?>
    </div>
    <?php
}