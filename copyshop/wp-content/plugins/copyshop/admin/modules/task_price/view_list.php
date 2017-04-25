<?php
template_start('Printing Cost', 'Add New', 'javascript: doAddNew();');
?>
<table class="wp-list-table widefat fixed striped pages table-responsive">
    <thead>
        <tr>
            <td>
                Task
            </td>
            <td>
                Sheets From
            </td>
            <td>
                Sheets To
            </td>
            <td>
                Piece From
            </td>
            <td>
                Piece To
            </td>
            <td>
                Price
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
                <input type="text" disabled class="db_task_id form-control percent_50" value="<?php echo $l->task_id; ?>" />
            </th>
            <th>
                <input type="text" disabled class="db_sheets_from form-control percent_50" value="<?php echo $l->sheets_from; ?>" />
            </th>
            <th>
                <input type="text" disabled class="db_sheets_to form-control percent_50" value="<?php echo $l->sheets_to; ?>" />
            </th>
            <th>
                <input type="text" disabled class="db_pcs_from form-control percent_50" value="<?php echo $l->pcs_from; ?>" />
            </th>
            <th>
                <input type="text" disabled class="db_pcs_to form-control percent_50" value="<?php echo $l->pcs_to; ?>" />
            </th>
            <th>
                <input type="text" disabled class="db_price form-control percent_50" value="<?php echo $l->price; ?>" />
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
                <input type="text" class="db_task_id form-control percent_50" value="" />
            </th>
            <th>
                <input type="text" class="db_sheets_from form-control percent_50" value="" />
            </th>
            <th>
                <input type="text" class="db_sheets_to form-control percent_50" value="" />
            </th>
            <th>
                <input type="text" class="db_pcs_from form-control percent_50" value="" />
            </th>
            <th>
                <input type="text" class="db_pcs_to form-control percent_50" value="" />
            </th>
            <th>
                <input type="text" class="db_price form-control percent_50" value="" />
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
            
            jQuery(tr).find('.db_task_id').removeAttr('disabled');
            jQuery(tr).find('.db_sheets_from').removeAttr('disabled');
            jQuery(tr).find('.db_sheets_to').removeAttr('disabled');
            jQuery(tr).find('.db_pcs_from').removeAttr('disabled');
            jQuery(tr).find('.db_pcs_to').removeAttr('disabled');
            jQuery(tr).find('.db_price').removeAttr('disabled');
            jQuery(b).html('Save');
            return;
        } 
        
        task_id = jQuery(tr).find('.db_task_id').val();
        sheets_from = jQuery(tr).find('.db_sheets_from').val();
        sheets_to = jQuery(tr).find('.db_sheets_to').val();
        pcs_from = jQuery(tr).find('.db_pcs_from').val();
        pcs_to = jQuery(tr).find('.db_pcs_to').val();
        price = jQuery(tr).find('.db_price').val();
        id = jQuery(tr).find('.db_id').val();
        
        jQuery(tr).find('input[type="text"]').hide();
        jQuery(tr).find('.db_task_id').after('<span class="loading">Processing...</span>');
        
        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "savetaskprice", task_id: task_id,sheets_from: sheets_from,sheets_to: sheets_to,pcs_from: pcs_from,pcs_to:pcs_to,price:price,id:id}
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
        
        task_id = jQuery(tr).find('.db_task_id').val();
        sheets_from = jQuery(tr).find('.db_sheets_from').val();
        sheets_to = jQuery(tr).find('.db_sheets_to').val();
        pcs_from = jQuery(tr).find('.db_pcs_from').val();
        pcs_to = jQuery(tr).find('.db_pcs_to').val();
        price = jQuery(tr).find('.db_price').val();
        
        jQuery(tr).find('input[type="text"]').hide();
        jQuery(tr).find('.db_task_id').after('<span class="loading">Processing...</span>');
        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "savetaskprice", task_id: task_id,sheets_from: sheets_from,sheets_to: sheets_to,pcs_from: pcs_from,pcs_to:pcs_to,price:price}
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
        jQuery(tr).find('.db_task_id').after('<span class="loading">Processing...</span>');
        
        jQuery.ajax({
                method: "POST",
                dataType: "json",
                url: "<?php echo admin_url('admin-ajax.php'); ?>",
                data: { action: "deletetaskprice", id: id}
              })
                .done(function( msg ) {
                    if(msg.success == '1')
                    { BootstrapDialog.show({
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