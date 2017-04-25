<?php
template_start('Paper Format', 'Add New', 'javascript: doAddNew();');
?>
<table class="wp-list-table widefat fixed striped pages">
    <thead>
        <tr>
            <td>
                Title
            </td>
            <td style="width:200px;">
                Action
            </td>
        </tr>
    </thead>
    <tbody id="nrow">
        <?php
        foreach($list as $l)
        {
            ?>
        <tr id="tr-<?php echo $l->id; ?>">
            <th>                
                <input type="text" disabled class="db_title form-control percent_50" value="<?php echo $l->title; ?>" />
                <input type="hidden" class="db_id" value="<?php echo $l->id; ?>" />
            </th>
            <th>
                <a href="#" onclick="doEdit(this); return false;" class="btn btn-info" tr_id="tr-<?php echo $l->id; ?>">Edit</a>
                &nbsp;|&nbsp;
                <a href="#" onclick="doDelete(this); return false;" class="btn btn-danger" tr_id="tr-<?php echo $l->id; ?>">Delete</a>
            </th>
        </tr>
            <?php
        }
        ?>
        <tr id="add_tmpl" style="display: none;">
            <th>                
                <input type="text" class="db_title form-control percent_50" value="" />
            </th>
            <th>
                <a href="#" onclick="doAdd(this); return false;" class="btn btn-info" tr_id="tr-<?php echo $l->id; ?>">Add</a>
                &nbsp;|&nbsp;
                <a href="#" onclick="doRemoveRow(this); return false;" class="btn btn-danger" tr_id="tr-<?php echo $l->id; ?>">Delete</a>
            </th>
        </tr>
    </tbody>
</table>

<script type="text/javascript">
    
    function doRemoveRow(t)
    {
        jQuery(t).parent().parent().remove();
    }
    
    function doAddNew()
    {
        html_str = '<tr>'+jQuery('#add_tmpl').html()+'</tr>';
        
        jQuery('#nrow').append(html_str);
    }
    
    function doEdit(b)
    {
        tr_id = jQuery(b).attr('tr_id');
        tr = jQuery("#"+tr_id);
        
        if(jQuery(b).html() == 'Edit')
        {
            
            jQuery('#nrow input[type="text"]').attr('disabled', 'disabled');
            jQuery('#nrow .btn-info').html('Edit');
            
            jQuery(tr).find('.db_title').removeAttr('disabled');
            jQuery(b).html('Save');
            return;
        }        
        
        
        title = jQuery(tr).find('.db_title').val();
        id = jQuery(tr).find('.db_id').val();
        
        
        jQuery(tr).find('input[type="text"]').hide();
        jQuery(tr).find('.db_title').after('<span class="loading">Processing...</span>');

        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "saveformat", title: title, id: id}
              })
                .done(function( msg ) {
                    if(msg.success == '1')
                    {
                        BootstrapDialog.show({
					        title: 'System Message',
					        message: msg.message,
					        type: BootstrapDialog.TYPE_SUCCESS,
					    });
                        
                        jQuery('#nrow input[type="text"]').show();
                        jQuery('.loading').remove();
                        jQuery('#nrow .btn-info').html('Edit');
                        jQuery('#nrow input[type="text"]').attr('disabled', 'disabled');

                    }
                    
                });
        
        
    }
    
    function doAdd(b)
    {
        tr = jQuery(b).parent().parent();
        
        title = jQuery(tr).find('.db_title').val();
        
        
        jQuery(tr).find('input[type="text"]').hide();
        jQuery(tr).find('.db_title').after('<span class="loading">Processing...</span>');
        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "saveformat", title: title}
              })
                .done(function( msg ) {
                    if(msg.success == '1')
                    {
                        document.location = document.location;
                    }
                    
                });
        
        
    }
    
    function doDelete(b)
    {
        tr_id = jQuery(b).attr('tr_id');
        tr = jQuery("#"+tr_id);
        
        id = jQuery(tr).find('.db_id').val();
        
        
        jQuery(tr).find('input[type="text"]').hide();
        jQuery(tr).find('.db_title').after('<span class="loading">Processing...</span>');
        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "deleteformat", id: id}
              })
                .done(function( msg ) {
                    if(msg.success == '1')
                    {
                        BootstrapDialog.show({
					        title: 'System Message',
					        message: msg.message,
					        type: BootstrapDialog.TYPE_SUCCESS,
					    });
                                            
                        jQuery('#'+tr_id).fadeOut('fast', function(){
                            jQuery('#'+tr_id).remove();
                        });
                    }
                    
                });
        
        
    }
</script>

<?php
template_end();
?>