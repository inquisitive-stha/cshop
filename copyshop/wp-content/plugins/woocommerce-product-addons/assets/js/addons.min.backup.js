jQuery( document ).ready( function($) {

	$.fn.init_addon_totals = function(){

		var $cart = $( this );

		// Clear all values on variable product when clear selection is clicked
		$( this ).on( 'click', '.reset_variations', function() {

			$.each( $cart.find( '.product-addon' ), function() {
				var element = $( this ).find( '.addon' );

				if ( element.is( ':checkbox' ) || element.is( ':radio' ) ) {
					element.prop( 'checked', false );
				}

				if ( element.is( 'select' ) ) {
					element.prop( 'selectedIndex', 0 );
				}

				if ( element.is( ':text' ) || element.is( 'textarea' ) || element.is( 'input[type="number"]' ) || element.is( 'input[type="file"]' ) ) {
					element.val( '' );
				}
			});

			$cart.trigger( 'woocommerce-product-addons-update' );
		});

		$( this ).on( 'keyup change', '.product-addon input, .product-addon textarea', function() {

			if ( $( this ).attr( 'maxlength' ) > 0 ) {

				var value = $( this ).val();
				var remaining = $( this ).attr( 'maxlength' ) - value.length;

				$( this ).next( '.chars_remaining' ).find( 'span' ).text( remaining );
			}

		});

		$( this ).find( ' .addon-custom, .addon-custom-textarea' ).each( function() {

			if ( $( this ).attr( 'maxlength' ) > 0 ) {

				$( this ).after( '<small class="chars_remaining"><span>' + $( this ).attr( 'maxlength' ) + '</span> ' + woocommerce_addons_params.i18n_remaining + '</small>' );

			}
		});
/*custom keyup function*/

$(".addon-input_multiplier").bind("keyup change", function(e) {
	var name = $(this).attr('name');
	//jQuery('select#pa_farbauswahl option:contains("farbig")').prop('selected',true);  /*first run ma price update huncha but if pachi update garda price update hudaina*/
	//console.log(name);
	/*if(name=='addon-58-no-of-color-pages-1[no-of-color-pages]'){
	console.log(name);

	   jQuery('select#pa_farbauswahl option:contains("farbig")').prop('selected',true).trigger('change');

	}else if(name=='addon-58-no-of-blackwhite-pages-0[no-of-blackwhite-pages]'){
	console.log('name');
	   
	   jQuery('select#pa_farbauswahl option:contains("schwarz / weiß")').prop('selected',true).trigger('change');

	} 
	*/
	//$(this).focus();

	if(name=='addon-58-no-of-color-pages-1[no-of-color-pages]'){
		
	   jQuery('select#pa_farbauswahl').val('farbig').trigger('change');

	}else if(name=='addon-58-no-of-blackwhite-pages-0[no-of-blackwhite-pages]'){
		
	   jQuery('select#pa_farbauswahl').val('schwarz-weis').trigger('change');

	} 
	
})


/*end*/
		$( this ).on( 'change', '.product-addon input, .product-addon textarea, .product-addon select, input.qty', function() {
			
			/*jQuery('select#pa_farbauswahl option:contains("farbig")').prop('selected',true);*/
					
			$( this ).trigger( 'woocommerce-product-addons-update' );

		});

		/* to add default value to input  field of addon */

		$( this ).on( 'change', '.product-addon input',function(){
			if($(this).val() == ''){
				$(this).val(0);
				$(this).attr('min',0);
			}
		});
		/* to make choose an option disabled */
		/*$('form select option').each( function(){
			if($(this).text() == 'Choose an option'){
				$(this).attr('disabled','disabled');
			}
		});*/

$('#paper-format,#paper-type').on('change',function(){
	$('#pa_farbauswahl').focus();
	//var val = $('#pa_farbauswahl option:selected').val();
	$('#pa_farbauswahl').val('schwarz-weis').trigger('change');

	$('#pa_farbauswahl').val('farbig').trigger('change');
	// if(val == 'farbig'){
	// $('#pa_farbauswahl').val('schwarz-weis').trigger('change');

	// }else if(val == 'schwarz-weis'){
	// $('#pa_farbauswahl').val('farbig').trigger('change');

	// }
	//$('#pa_farbauswahl').focus();
});


		$( this ).on( 'found_variation', function( event, variation ) {
						
			var $variation_form = $( this );
			var $totals         = $variation_form.find( '#product-addons-total' );

			if ( typeof( variation.display_price ) !== 'undefined' ) {

				$totals.data( 'price', variation.display_price );

			} else if ( $( variation.price_html ).find( '.amount:last' ).size() ) {

				product_price = $( variation.price_html ).find( '.amount:last' ).text();
				product_price = product_price.replace( woocommerce_addons_params.currency_format_symbol, '' );
				product_price = product_price.replace( woocommerce_addons_params.currency_format_thousand_sep, '' );
				product_price = product_price.replace( woocommerce_addons_params.currency_format_decimal_sep, '.' );
				product_price = product_price.replace(/[^0-9\.]/g, '' );
				product_price = parseFloat( product_price );

				$totals.data( 'price', product_price );
			}

			$variation_form.trigger( 'woocommerce-product-addons-update' );
		});

		$( this ).on( 'woocommerce-product-addons-update', function() {

			var total         = 0;
			var $totals       = $cart.find( '#product-addons-total' );
			var product_price = $totals.data( 'price' );
			var product_type  = $totals.data( 'type' );
			var product_id    = $totals.data( 'product-id' );
			// We will need some data about tax modes (both store and display)
			// and 'raw prices' (prices that don't take into account taxes) so we can use them in some
			// instances without making an ajax call to calculate taxes
			var product_raw      = $totals.data( 'raw-price' );
			var tax_mode         = $totals.data( 'tax-mode' );
			var tax_display_mode = $totals.data( 'tax-display-mode' );
			var total_raw        = 0;
			var initial_price = product_price;
			//console.log('raw price ='+product_raw+" product price="+product_price);
			// Move totals
			if ( product_type == 'variable' || product_type == 'variable-subscription' ) {
				$cart.find( '.single_variation' ).after( $totals );
			}
  
  			var val = $('#pa_farbauswahl option:selected').val();
			if(val == 'farbig'){
				//console.log("h"+ ' '+product_price);
				$("input[name='addon-58-no-of-color-pages-1[no-of-color-pages]'").attr('data-p',product_price);

			} else if(val == 'schwarz-weis'){
				$("input[name='addon-58-no-of-blackwhite-pages-0[no-of-blackwhite-pages]'").attr('data-p',product_price);	
			}
			/*Double side price reduction*/
			//$('.addon-select').change(function(){
				
			//});

			$cart.find( '.addon' ).each( function() {	
				//console.log(this);

			/*var a4 = $('input[name="addon-198-simple-product-0[a4]"]').val();
			var a3 = $('input[name="addon-198-simple-product-0[a3]"]').val();
			*/
				var addon_cost = 0;
				var addon_cost_raw = 0;
				
				//console.log(name);
				
				if ( $( this ).is( '.addon-custom-price' ) ) {
					addon_cost = $( this ).val();
				} else if ( $( this ).is( '.addon-input_multiplier' ) ) {

					if( isNaN( $( this ).val() ) || $( this ).val() == "" ) { // Number inputs return blank when invalid
						$( this ).val( '' );
						$( this ).closest( 'p' ).find( '.addon-alert' ).show();
					} else {
						if( $( this ).val() != "" ){
							$( this ).val( Math.ceil( $( this ).val() ) );
						}
						$( this ).closest( 'p' ).find( '.addon-alert' ).hide();
					}
				var paperprice = 0;	
				var cost =new Array();
				cost['80g']  = 0.01;
				cost['100g'] = 0.02;
				cost['120g'] = 0.04;
				cost['160g'] = 0.05;
				cost['200g'] = 0.06;
				cost['250g'] = 0.07;
				cost['300g'] = 0.10;

				var blacknwhite= new Array();
				blacknwhite['1-99'] 		= 0.10;
				blacknwhite['100-199'] 		= 0.08;
				blacknwhite['200-499'] 		= 0.04;
				blacknwhite['500-1499'] 	= 0.035;
				blacknwhite['1500-2999'] 	= 0.03;
				blacknwhite['3000-9999'] 	= 0.02;
				blacknwhite['10000-49999'] 	= 0.018;
				blacknwhite['50000-99999'] 	= 0.015;
				blacknwhite['100000+'] 		= 0.012;

				var color= new Array();
				color['1-9'] 		= 0.90;
				color['10-29'] 		= 0.60;
				color['30-49'] 		= 0.35;
				color['50-99'] 		= 0.25;
				color['100-499'] 	= 0.20;
				color['500-999'] 	= 0.15;
				color['1000-1999'] 	= 0.09;
				color['2000-2999'] 	= 0.08;
				color['3000-3999'] 	= 0.075;
				color['4000+']		= 0.07;
				var reducedAmountBlack =0;
				var reducedAmountColor =0;
				inputQuantity =$('.quantity input').val();
				var selectedpaper = $("#paper-format").val();
				var noofpagesblack =$('.addon-wrap-58-no-of-blackwhite-pages-0 input').val();
				var colorselection = $('#pa_farbauswahl').val();
				var noofpagescolor =$('.addon-wrap-58-no-of-color-pages-1 input').val();
				noofpagesblack=noofpagesblack*inputQuantity;
				noofpagescolor=noofpagescolor*inputQuantity;
				
				if(selectedpaper=='A4'||selectedpaper=='A5'){
					/*if(colorselection=='schwarz-weis'){*/
						if(noofpagesblack>99 && noofpagesblack<200){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['100-199']);
						//console.log('reduced amount black='+reducedAmountBlack);

						}else if(noofpagesblack>199 && noofpagesblack<500){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['200-499']);
						//console.log('reduced amount black='+reducedAmountBlack);
						}else if(noofpagesblack>499 && noofpagesblack<1500){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['500-1499']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}else if(noofpagesblack>1499 && noofpagesblack<3000){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['1500-2999']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}else if(noofpagesblack>2999 && noofpagesblack<10000){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['3000-9999']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}else if(noofpagesblack>9999 && noofpagesblack<50000){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['10000-49999']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}else if(noofpagesblack>49999 && noofpagesblack<100000){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['50000-99999']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}else if(noofpagesblack>99999){
							reducedAmountBlack = noofpagesblack*(0.10-blacknwhite['100000+']);
						//console.log('reduced amount black='+reducedAmountBlack);
							
						}	

						
					/*}else if(colorselection=='farbig'){*/
						if(noofpagescolor>9 && noofpagescolor<30){
							reducedAmountColor = noofpagescolor*( 0.9-color['10-29']);

						}else if(noofpagescolor>29 && noofpagescolor<50){
							reducedAmountColor = noofpagescolor*( 0.9-color['30-49']);

						}else if(noofpagescolor>49 && noofpagescolor<100){
							reducedAmountColor = noofpagescolor*( 0.9-color['50-99']);

						}else if(noofpagescolor>99 && noofpagescolor<500){

							reducedAmountColor = noofpagescolor*( 0.9-color['100-499']);

						}else if(noofpagescolor>499 && noofpagescolor<1000){

							reducedAmountColor = noofpagescolor*( 0.9-color['500-999']);

						}else if(noofpagescolor>999 && noofpagescolor<2000){

							reducedAmountColor = noofpagescolor*( 0.9-color['1000-1999']);

						}else if(noofpagescolor>1999 && noofpagescolor<3000){

							reducedAmountColor = noofpagescolor*( 0.9-color['2000-2999']);

						}else if(noofpagescolor>2999 && noofpagescolor<4000){

							reducedAmountColor = noofpagescolor*( 0.9-color['3000-3999']);

						}else if(noofpagescolor>3999){

							reducedAmountColor = noofpagescolor*( 0.9-color['4000+']);

						}
					/*}*/

				}else if(selectedpaper='A3'){
										/*if(colorselection=='schwarz-weis'){*/
						if(noofpagesblack>99 && noofpagesblack<200){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['100-199']);
						}else if(noofpagesblack>199 && noofpagesblack<500){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['200-499']);
						
						}else if(noofpagesblack>499 && noofpagesblack<1500){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['500-1499']);
							
						}else if(noofpagesblack>1499 && noofpagesblack<3000){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['1500-2999']);
							
						}else if(noofpagesblack>2999 && noofpagesblack<10000){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['3000-9999']);
							
						}else if(noofpagesblack>9999 && noofpagesblack<50000){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['10000-49999']);
							
						}else if(noofpagesblack>49999 && noofpagesblack<100000){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['50000-99999']);
							
						}else if(noofpagesblack>99999){
							reducedAmountBlack = noofpagesblack*(0.20-2*blacknwhite['100000+']);
							
						}	

						
					/*}else if(colorselection=='farbig'){*/
						if(noofpagescolor>9 && noofpagescolor<30){
							reducedAmountColor = noofpagescolor*( 1.80-2*color['10-29']);

						}else if(noofpagescolor>29 && noofpagescolor<50){
							reducedAmountColor = noofpagescolor*( 1.80-2*color['30-49']);

						}else if(noofpagescolor>49 && noofpagescolor<100){
							reducedAmountColor = noofpagescolor*( 1.80-2*color['50-99']);

						}else if(noofpagescolor>99 && noofpagescolor<500){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['100-499']);

						}else if(noofpagescolor>499 && noofpagescolor<1000){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['500-999']);

						}else if(noofpagescolor>999 && noofpagescolor<2000){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['1000-1999']);

						}else if(noofpagescolor>1999 && noofpagescolor<3000){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['2000-2999']);

						}else if(noofpagescolor>2999 && noofpagescolor<4000){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['3000-3999']);

						}else if(noofpagescolor>3999){

							reducedAmountColor = noofpagescolor*( 1.80-2*color['4000+']);

						}
					/*}*/
				}				
			

				if($(".addon-wrap-58-settings-2 .addon-select").val()=='double-side-2'){
					var key = $('#paper-type').val();
					$('.addon-wrap-58-turn-at-3').closest('div').show();
					var noofpaper = $( this ).val();
					
					paperprice = Math.floor(noofpaper/2) * cost[key];
					//console.log(paperprice);
					
				}else{
					$('.addon-wrap-58-turn-at-3').closest('div').hide();

				}
				var truncated = Math.floor((reducedAmountColor +reducedAmountBlack)/2 * 1000) / 1000;
					addon_cost = $( this ).attr( 'data-p' ) * $( this ).val()-parseFloat(paperprice)-truncated/inputQuantity ;
					
					//addon_cost_raw = $( this ).data( 'raw-price' ) * $( this ).val();
					//console.log(addon_cost+' '+product_price);
					/*addon_cost = $( this ).data( 'price' ) * $( this ).val();
					addon_cost_raw = $( this ).data( 'raw-price' ) * $( this ).val();*/
					//console.log(addon_cost);

						//console.log('a4 value = '+a4+ ' '+'a3 value = '+a3);
					
					/*var reduce_amount = 0;
					if(a4 > 10 && a4 <= 20){
						reduce_amount = a4*(1-0.90);
					} else if(a4 > 20){
						reduce_amount = a4*(1-0.80);
					}

					console.log(reduce_amount);*/

				} else if ( $( this ).is( '.addon-checkbox, .addon-radio' ) ) {

					if ( $( this ).is( ':checked' ) ) {
						addon_cost = $( this ).data( 'price' );
						addon_cost_raw = $( this ).data( 'raw-price' );
					}
				} else if ( $( this ).is( '.addon-select' ) ) {

					if ( $( this ).val() ) {
						addon_cost = $( this ).find( 'option:selected' ).data( 'price' );
						addon_cost_raw = $( this ).find( 'option:selected' ).data( 'raw-price' );
					}
				} else {
					if ( $( this ).val() ) {
						addon_cost = $( this ).data( 'price' );
						addon_cost_raw = $( this ).data( 'raw-price' );
					}
				}

				if ( ! addon_cost ) {
					addon_cost = 0;
				}
				if ( ! addon_cost_raw ) {
					addon_cost_raw = 0;
				}

				total = parseFloat( total ) + parseFloat( addon_cost );// - parseFloat(reduce_amount/2);
				total_raw = parseFloat( total_raw ) + parseFloat( addon_cost_raw );
				
			} );

			$totals.data( 'addons-price', total );
			$totals.data( 'addons-raw-price', total_raw );

			if ( $cart.find( 'input.qty' ).size() ) {
				var qty = parseFloat( $cart.find( 'input.qty' ).val() );
			} else {
				var qty = 1;
			}


			if(total == 0  ){

				if($('.woocommerce-page').hasClass('postid-9')){

				var formatted_initial_price = accounting.formatMoney( initial_price, {
					symbol 		: woocommerce_addons_params.currency_format_symbol,
					decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
					thousand	: woocommerce_addons_params.currency_format_thousand_sep,
					precision 	: woocommerce_addons_params.currency_format_num_decimals,
					format		: woocommerce_addons_params.currency_format
				});					
				}else{
					//	console.log(initial_price);
				var formatted_initial_price = accounting.formatMoney( initial_price-product_price, {
					symbol 		: woocommerce_addons_params.currency_format_symbol,
					decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
					thousand	: woocommerce_addons_params.currency_format_thousand_sep,
					precision 	: woocommerce_addons_params.currency_format_num_decimals,
					format		: woocommerce_addons_params.currency_format
				});
				}
				$('#grandtotal').html(formatted_initial_price);
			
			}

			//console.log(total);
			if ( total > 0 && qty > 0 ) {

				var product_total_price, product_total_raw_price;

				total     = parseFloat( total * qty );
				total_raw = parseFloat( total_raw * qty );

				var formatted_addon_total = accounting.formatMoney( total, {
					symbol 		: woocommerce_addons_params.currency_format_symbol,
					decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
					thousand	: woocommerce_addons_params.currency_format_thousand_sep,
					precision 	: woocommerce_addons_params.currency_format_num_decimals,
					format		: woocommerce_addons_params.currency_format
				});

				if ( 'undefined' !== typeof product_price ) {

					var id=$('.product').attr('id');
					if(id=='product-58'){
											product_total_price = 0;

					}else{
						product_total_price = parseFloat( product_price * qty );

					}

					//console.log(product_total_price+' '+product_price);
					var formatted_grand_total = accounting.formatMoney( product_total_price + total, {
						symbol 		: woocommerce_addons_params.currency_format_symbol,
						decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
						thousand	: woocommerce_addons_params.currency_format_thousand_sep,
						precision 	: woocommerce_addons_params.currency_format_num_decimals,
						format		: woocommerce_addons_params.currency_format
					});

				}

				product_total_raw_price = parseFloat( product_raw * qty );

				var formatted_raw_total = accounting.formatMoney( product_total_raw_price + total_raw, {
					symbol 		: woocommerce_addons_params.currency_format_symbol,
					decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
					thousand	: woocommerce_addons_params.currency_format_thousand_sep,
					precision 	: woocommerce_addons_params.currency_format_num_decimals,
					format		: woocommerce_addons_params.currency_format
				});

				var subscription_details = false;

				if ( $( '.entry-summary .subscription-details' ).length ) {
					subscription_details = $( '.entry-summary .subscription-details' ).clone().wrap( '<p>' ).parent().html();
				}

				if ( subscription_details ) {
					formatted_addon_total += subscription_details;
					if ( formatted_grand_total ) {
						formatted_grand_total += subscription_details;
					}
				}
				$('#grandtotal').html(formatted_grand_total);
				var html = '<dl class="product-addon-totals"><dt>' + woocommerce_addons_params.i18n_addon_total + '</dt><dd><strong><span class="amount">' + formatted_addon_total + '</span></strong></dd>';

				if ( formatted_grand_total && '1' == $totals.data( 'show-grand-total' ) ) {

					// To show our "price display suffix" we have to do some magic since the string can contain variables (excl/incl tax values)
					// so we have to take our grand total and find out what the tax value is, which we can do via an ajax call
					// if its a simple string, or no string at all, we can output the string without an extra call
					var price_display_suffix = '';

					// no sufix is present, so we can just output the total
					if ( ! woocommerce_addons_params.price_display_suffix ) {
						html = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span></strong></dd></dl>';
						$totals.html( html );
						$cart.trigger( 'updated_addons' );
						return;
					}

					// a suffix is present, but no special labels are used - meaning we don't need to figure out any other special values - just display the playintext value
					if ( false === ( woocommerce_addons_params.price_display_suffix.indexOf( '{price_including_tax}' ) > -1 ) && false === ( woocommerce_addons_params.price_display_suffix.indexOf( '{price_excluding_tax}' ) > -1 ) ) {
						html = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span> ' + woocommerce_addons_params.price_display_suffix + '</strong></dd></dl>';
						$totals.html( html );
						$cart.trigger( 'updated_addons' );
						return;
					}

					// If prices are entered exclusive of tax but display inclusive, we have enough data from our totals above
					// to do a simple replacement and output the totals string
					if (  'excl' === tax_mode && 'incl' === tax_display_mode ) {
						price_display_suffix = '<small class="woocommerce-price-suffix">' + woocommerce_addons_params.price_display_suffix + '</small>';
						price_display_suffix = price_display_suffix.replace( '{price_including_tax}', formatted_grand_total );
						price_display_suffix = price_display_suffix.replace( '{price_excluding_tax}', formatted_raw_total );
						html                 = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span> ' + price_display_suffix + ' </strong></dd></dl>';
						$totals.html( html );
						$cart.trigger( 'updated_addons' );
						return;
					}

					// Prices are entered inclusive of tax mode but displayed exclusive, we have enough data from our totals above
					// to do a simple replacement and output the totals string.
					if ( 'incl' === tax_mode && 'excl' === tax_display_mode ) {
						price_display_suffix = '<small class="woocommerce-price-suffix">' + woocommerce_addons_params.price_display_suffix + '</small>';
						price_display_suffix = price_display_suffix.replace( '{price_including_tax}', formatted_raw_total );
						price_display_suffix = price_display_suffix.replace( '{price_excluding_tax}', formatted_grand_total );
						html                 = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span> ' + price_display_suffix + ' </strong></dd></dl>';
						$totals.html( html );
						$cart.trigger( 'updated_addons' );
						return;
					}

					// Based on the totals/info and settings we have, we need to use the get_price_*_tax functions
					// to get accurate totals. We can get these values with a special Ajax function
					$.ajax( {
						type: 'POST',
						url:  woocommerce_addons_params.ajax_url,
						data: {
							action: 'wc_product_addons_calculate_tax',
							total:  product_total_price + total,
							product_id: product_id
						},
						success: 	function( code ) {
							result = $.parseJSON( code );
							if ( result.result == 'SUCCESS' ) {
								price_display_suffix = '<small class="woocommerce-price-suffix">' + woocommerce_addons_params.price_display_suffix + '</small>';
								var formatted_price_including_tax = accounting.formatMoney( result.price_including_tax, {
									symbol 		: woocommerce_addons_params.currency_format_symbol,
									decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
									thousand	: woocommerce_addons_params.currency_format_thousand_sep,
									precision 	: woocommerce_addons_params.currency_format_num_decimals,
									format		: woocommerce_addons_params.currency_format
								} );
								var formatted_price_excluding_tax = accounting.formatMoney( result.price_excluding_tax, {
									symbol 		: woocommerce_addons_params.currency_format_symbol,
									decimal 	: woocommerce_addons_params.currency_format_decimal_sep,
									thousand	: woocommerce_addons_params.currency_format_thousand_sep,
									precision 	: woocommerce_addons_params.currency_format_num_decimals,
									format		: woocommerce_addons_params.currency_format
								} );
								price_display_suffix = price_display_suffix.replace( '{price_including_tax}', formatted_price_including_tax );
								price_display_suffix = price_display_suffix.replace( '{price_excluding_tax}', formatted_price_excluding_tax );
								html                 = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span> ' + price_display_suffix + ' </strong></dd></dl>';
								$totals.html( html );
								$cart.trigger( 'updated_addons' );
							} else {
								html = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span></strong></dd></dl>';
								$totals.html( html );
								$cart.trigger( 'updated_addons' );
							}
						},
						error: function() {
							html = html + '<dt>' + woocommerce_addons_params.i18n_grand_total + '</dt><dd><strong><span class="amount">' + formatted_grand_total + '</span></strong></dd></dl>';
							$totals.html( html );
							$cart.trigger( 'updated_addons' );
						}
					});
				} else {
					$totals.empty();
					$cart.trigger( 'updated_addons' );
				}
			} else {
				$totals.empty();
				$cart.trigger( 'updated_addons' );
			}

		});

		$( this ).find( '.addon-custom, .addon-custom-textarea, .product-addon input, .product-addon textarea, .product-addon select, input.qty' ).change();

		// When default variation exists, 'found_variation' must be triggered
		$( this ).find( '.variations select' ).change();
	}

	// Quick view
	$( 'body' ).on( 'quick-view-displayed', function() {
		$( this ).find( '.cart:not(.cart_group)' ).each( function() {
			$( this ).init_addon_totals();
		});
	});

	// Composites
	$( 'body .component' ).on( 'wc-composite-component-loaded', function() {
		$( this ).find( '.cart' ).each( function() {
			$( this ).init_addon_totals();
		});
	});

	// Initialize
	$( 'body' ).find( '.cart:not(.cart_group)' ).each( function() {
		$( this ).init_addon_totals();
	});

});
