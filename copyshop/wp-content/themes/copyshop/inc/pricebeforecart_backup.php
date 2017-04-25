<?php 
/* Add custom price */
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );
function add_custom_price( $cart_object ) {
	
	foreach($cart_object->cart_contents as $cart){
	  /*//echo "<pre>";
	  print_r($cart);
	  //echo "</pre>";*/
	  $total_pages 				= 0;
	  /*$bw_pages	   				= 0; 													// no of bw pages
	  $color_pages 				= 0;	*/												// no of color pages 
	  $new_color_price 			= 0;
	  $new_bw_price    			= 0;
	  $side = '';
	  $reducedAmountBlack 		= 0;
	  $reducedAmountColor 		= 0;
	  $qty = $cart['quantity'];
	  $color_pages_ss 			= 0;
	  $bw_pages_ss    			= 0;
	  if($cart['product_id']==58){

	  	$variation_id = $cart['variation_id'];
	  	$paper_type = $cart['variation']['attribute_paper-type'];
	  	$paper_format = $cart['variation']['attribute_paper-format'];
	  	$paper_price_array = array(
	  		'80g'  => 0.01,
	  		'100g' => 0.02, 
	  		'120g' => 0.04, 
	  		'160g' => 0.05, 
	  		'210g' => 0.06, 
	  		'250g' => 0.07, 
	  		'300g' => 0.1,
	  		);
	  	
	  	$a3_bw_price = array(
  			'80g'   => 0.22,
  			'100g'  => 0.24,
  			'120g'  => 0.28, 
  			'160g'  => 0.30, 
  			'210g'  => 0.32, 
  			'250'   => 0.34, 
  			'300g'  => 0.4,
  			);
	  	$a3_color_price = array(
  			'80g'   => 1.82,
  			'100g'  => 1.84,
  			'120g'  => 1.88, 
  			'160g'  => 1.9, 
  			'210g'  => 1.92, 
  			'250'   => 1.94, 
  			'300g'  => 2,
  			);

	  	$a4_bw_price = array(
  			'80g'   => 0.11,
  			'100g'  => 0.12,
  			'120g'  => 0.14, 
  			'160g'  => 0.15, 
  			'210g'  => 0.16, 
  			'250'   => 0.17, 
  			'300g'  => 0.2,
  			);
	  	$a4_color_price = array(
  			'80g'   => 0.91,
  			'100g'  => 0.92,
  			'120g'  => 0.94, 
  			'160g'  => 0.95, 
  			'210g'  => 0.96, 
  			'250'   => 0.97, 
  			'300g'  => 1,
  			);


		$blacknwhite_ink= array(
				'1-99'          => 0.10,
				'100-199'       => 0.08,
				'200-499'       => 0.04,
				'500-1499'      => 0.035,
				'1500-2999'     => 0.03,
				'3000-9999'     => 0.02,
				'10000-49999'   => 0.018,
				'50000-99999'   => 0.015,
				'100000+'       => 0.012,
				);
		$color_ink= array(
				'1-9' 		=> 0.90,
				'10-29' 	=> 0.60,
				'30-49' 	=> 0.35,
				'50-99' 	=> 0.25,
				'100-499' 	=> 0.20,
				'500-999' 	=> 0.15,
				'1000-1999' => 0.09,
				'2000-2999' => 0.08,
				'3000-3999' => 0.075,
				'4000+' 	=> 0.07,
				);
	  	if($paper_format=="A3"){
	  		$new_color_price = $a3_color_price[$paper_type];
	  		$new_bw_price    = $a3_bw_price[$paper_type];
	  		//echo "new color price=".$new_color_price.' new bw price='.$new_bw_price;

	  	}else if($paper_format=="A4"){
	  		$new_color_price = $a4_color_price[$paper_type];
	  		$new_bw_price    = $a4_bw_price[$paper_type];
	  	}
	  	
	  	//echo 'paper_format='.$paper_format.' paper_type='.$paper_type;
	  	if(isset($cart['addons'])&&!empty($cart['addons'])){

	  		foreach ($cart['addons'] as $c => $value) {
	  			if ($value['name']=='No. Of Black/White Pages - No. Of Black/White Pages') {
  					$bw_pages_ss = $value['value'];
	  				//echo " bw_pages=".$bw_pages_ss;

	  			}
  				if ($value['name']=='No. Of Color Pages - No. Of Color Pages') {
  					$color_pages_ss = $value['value'];
  					//echo "color_pages=".$color_pages_ss;
  				}
	  			
	  			if($value['name']=='Settings'){
	  				$side=$value['value'];
	  				//echo " side=".$side;
	  			}

  			}
  			$no_bw_pages = $qty * $bw_pages_ss;
	  		$no_color_pages = $qty * $color_pages_ss;
	  		//echo "no of bw pages=".$no_bw_pages.'no of color_pages='.$no_color_pages;

  			////echo "side====".$side;
  			if($side=='single side'){
	  			$num1 = 0;								// no black and white pages for deduction
	  			$num2 = 0;				                //no color pages for deduction
								
	  		} else if($side=='double side'){
	  			$num1 = floor($no_bw_pages /2);          // no black and white pages for deduction
	  			$num2 = floor($no_color_pages /2);	    //no color pages for deduction
	  								
	  		}
	  		
  			if($paper_format=='A4'||$paper_format=='A5'){
				/*if(colorselection=='schwarz-weis'){*/
					if($no_bw_pages>99 && $no_bw_pages<200){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['100-199']);
						//echo "reducedAmountBlack[100-199]=".$reducedAmountBlack;
					}else if($no_bw_pages>199 && $no_bw_pages<500){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['200-499']);
						//echo "reducedAmountBlack[200-499]=".$reducedAmountBlack;

					}else if($no_bw_pages>499 && $no_bw_pages<1500){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['500-1499']);
						//echo "reducedAmountBlack[500-1499]=".$reducedAmountBlack;
						
					}else if($no_bw_pages>1499 && $no_bw_pages<3000){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['1500-2999']);
						//echo "reducedAmountBlack[1500-2999]=".$reducedAmountBlack;
					}else if($no_bw_pages>2999 && $no_bw_pages<10000){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['3000-9999']);
						//echo "reducedAmountBlack[3000-9999]=".$reducedAmountBlack;
					}else if($no_bw_pages>9999 && $no_bw_pages<50000){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['10000-49999']);
						//echo "reducedAmountBlack[10000-49999]=".$reducedAmountBlack;
					}else if($no_bw_pages>49999 && $no_bw_pages<100000){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['50000-99999']);
						//echo "reducedAmountBlack[50000-99999]=".$reducedAmountBlack;
					}else if($no_bw_pages>99999){
						$reducedAmountBlack = $no_bw_pages*(0.10-$blacknwhite_ink['100000+']);
						
					}	

					
				/*}else if(colorselection=='farbig'){*/
					if($no_color_pages>9 && $no_color_pages<30){
						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['10-29']);

					}else if($no_color_pages>29 && $no_color_pages<50){
						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['30-49']);

					}else if($no_color_pages>49 && $no_color_pages<100){
						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['50-99']);

					}else if($no_color_pages>99 && $no_color_pages<500){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['100-499']);

					}else if($no_color_pages>499 && $no_color_pages<1000){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['500-999']);

					}else if($no_color_pages>999 && $no_color_pages<2000){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['1000-1999']);

					}else if($no_color_pages>1999 && $no_color_pages<3000){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['2000-2999']);

					}else if($no_color_pages>2999 && $no_color_pages<4000){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['3000-3999']);

					}else if($no_color_pages>3999){

						$reducedAmountColor = $no_color_pages*( 0.9 - $color_ink['4000+']);

					}
				/*}*/

			}else if($paper_format='A3'){
									/*if(colorselection=='schwarz-weis'){*/
					if($no_bw_pages>99 && $no_bw_pages<200){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['100-199']);
					}else if($no_bw_pages>199 && $no_bw_pages<500){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['200-499']);
					
					}else if($no_bw_pages>499 && $no_bw_pages<1500){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['500-1499']);
						
					}else if($no_bw_pages>1499 && $no_bw_pages<3000){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['1500-2999']);
						
					}else if($no_bw_pages>2999 && $no_bw_pages<10000){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['3000-9999']);
						
					}else if($no_bw_pages>9999 && $no_bw_pages<50000){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['10000-49999']);
						
					}else if($no_bw_pages>49999 && $no_bw_pages<100000){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['50000-99999']);
						
					}else if($no_bw_pages>99999){
						$reducedAmountBlack = $no_bw_pages*(0.20 - 2 * $blacknwhite_ink['100000+']);
						
					}	

					
				/*}else if(colorselection=='farbig'){*/
					if($no_color_pages>9 && $no_color_pages<30){
						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['10-29']);

					}else if($no_color_pages>29 && $no_color_pages<50){
						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['30-49']);

					}else if($no_color_pages>49 && $no_color_pages<100){
						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['50-99']);

					}else if($no_color_pages>99 && $no_color_pages<500){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['100-499']);

					}else if($no_color_pages>499 && $no_color_pages<1000){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['500-999']);

					}else if($no_color_pages>999 && $no_color_pages<2000){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['1000-1999']);

					}else if($no_color_pages>1999 && $no_color_pages<3000){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['2000-2999']);

					}else if($no_color_pages>2999 && $no_color_pages<4000){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['3000-3999']);

					}else if($no_color_pages>3999){

						$reducedAmountColor = $no_color_pages*( 1.80-2 * $color_ink['4000+']);

					}
				/*}*/
			}				
		
		  		
  			$total_pages = $num1 + $num2;
  			//echo "   toooooooooootal Page=  ".$total_pages.'  ';
		  	$paperprice = $paper_price_array[$paper_type]*$total_pages; 
		  	$product = new WC_Product($variation_id);
		  	$price = $product->price; // product variation price to be reduced
		  	$calc_error = 0.91 * $color_pages_ss + 0.11 * $bw_pages_ss; // multiplier default deduction
		  	$new_price = $new_color_price * $color_pages_ss +$new_bw_price * $bw_pages_ss; //total price of the combination including paper number
		  	$new_price = $new_price * $qty;
			//echo " bw_pages=".$bw_pages_ss.' color_pages='.$color_pages_ss." price=".$price." paperprice=".$paperprice.' cart='.$cart['data']->price.' calc_err='.$calc_error.' new_price='.$new_price.' paper_price='.$paperprice;
			//echo " reducedAmountBlack=".$reducedAmountBlack.' reducedAmountColor='.$reducedAmountColor;
		  	$cart['data']->price = ($cart['data']->price + $new_price - $calc_error - $paperprice - $price - $reducedAmountBlack - $reducedAmountColor)/$qty;

	  		
	  	}
	  	

	  }

	}
}