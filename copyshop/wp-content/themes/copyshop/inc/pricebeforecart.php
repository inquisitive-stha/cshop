<?php 
/* Add custom price */
add_action( 'woocommerce_before_calculate_totals', 'add_custom_price' );
function add_custom_price( $cart_object ) {
	
	foreach($cart_object->cart_contents as $cart){
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
	  $bindungCost = 0;
	 //echo "string=".$cart['product_id'];
	  if($cart['product_id']==58 || $cart['product_id'] == 54 || $cart['product_id'] == 129 || $cart['product_id'] == 189 || $cart['product_id'] == 190 || $cart['product_id'] == 191 || $cart['product_id'] == 192 || $cart['product_id'] == 193 || $cart['product_id'] == 194){
	  	$variation_id = $cart['variation_id'];
	  	$paper_type = $cart['variation']['attribute_pa_papier-grammatur'];
	  	$paper_format = $cart['variation']['attribute_pa_papier-format'];
	  	$paper_price_array = array(
	  		'farbiges-papier' => 0.02,
	  		'80g'  => 0.01,
	  		'100g' => 0.04, 
	  		'120g' => 0.1, 
	  		'160g' => 0.2, 
	  		'210g' => 0.4, 
	  		'250g' => 0.5, 
	  		'300g' => 0.6,
	  		);
	  	
	  	$a3_bw_price = array(
	  		'farbiges-papier' => 0.09,
  			'80g'   => 0.08,
  			'100g'  => 0.14,
  			'120g'  => 0.26, 
  			'160g'  => 0.46, 
  			'210g'  => 0.86, 
  			'250'   => 1.06, 
  			'300g'  => 1.26,
  			);
	  	$a3_color_price = array(
	  		'farbiges-papier' => 0.34,
  			'80g'   => 0.32,
  			'100g'  => 0.38,
  			'120g'  => 0.50, 
  			'160g'  => 0.70, 
  			'210g'  => 1.10, 
  			'250'   => 1.30, 
  			'300g'  => 1.50,
  			);

	  	$a4_bw_price = array(
	  		'farbiges-papier' => 0.045,
  			'80g'   => 0.04,
  			'100g'  => 0.07,
  			'120g'  => 0.13, 
  			'160g'  => 0.23, 
  			'210g'  => 0.43, 
  			'250'   => 0.53, 
  			'300g'  => 0.63,
  			);
	  	$a4_color_price = array(
	  		'farbiges-papier' => 0.17,
  			'80g'   => 0.16,
  			'100g'  => 0.19,
  			'120g'  => 0.25, 
  			'160g'  => 0.35, 
  			'210g'  => 0.55, 
  			'250'   => 0.65, 
  			'300g'  => 0.75,
  			);


		$blacknwhite_ink = array(
				
				'1-100'		=> 0.03,
				'101-500'     => 0.03,
				'500+'       => 0.03,
				);
		$color_ink = array(
				
				'1-20' 	=> 0.15,
				'21-100' => 0.15,
				'101-200' => 0.15,
				'201-500' => 0.15,
				'500+'		=> 0.15,
				);
	  	if($paper_format =="a3"){
	  		$new_color_price = $a3_color_price[$paper_type];
	  		$new_bw_price    = $a3_bw_price[$paper_type];
	  		//echo "new color price=".$new_color_price.' new bw price='.$new_bw_price;

	  	}else if($paper_format =="a4"){
	  		$new_color_price = $a4_color_price[$paper_type];
	  		$new_bw_price    = $a4_bw_price[$paper_type];
	  	}
	  	
	  	//echo 'paper_format='.$paper_format.' paper_type='.$paper_type;
	  	
	  	if(isset($cart['addons']) && !empty($cart['addons'])){
	  		foreach ($cart['addons'] as $c => $value) {
	  			if ($value['name'] =='SW Seiten - Pages' || $value['name']=='SW Seiten') {
  					$bw_pages_ss = $value['value'];
	  			}
  				if ($value['name'] =='Farbige Seiten' ) {
  					$color_pages_ss = $value['value'];
  					//echo "color_pages=".$color_pages_ss;
  				}
	  			
	  			if($value['name']=='Einstellungen'){
	  				$side=$value['value'];
	  				//echo " side=".$side;
	  			}

  			}
  			$no_bw_pages = $qty * $bw_pages_ss;
	  		$no_color_pages = $qty * $color_pages_ss;
	  		//echo "no of bw pages=".$no_bw_pages.'no of color_pages='.$no_color_pages;

  			//echo "side====".$side;
  			if($side =='Einseitig'){
	  			$num1 = 0;								// no black and white pages for deduction
	  			$num2 = 0;				                //no color pages for deduction
								
	  		} else if($side == 'Doppelseitig'){
	  			$num1 = floor($bw_pages_ss /2);          // no black and white pages for deduction
	  			$num2 = floor($color_pages_ss /2);	    //no color pages for deduction
	  								
	  		}
	  		
  			if($paper_format == 'a4'|| $paper_format == 'a5'){
					if($no_bw_pages>100 && $no_bw_pages<501){
						$reducedAmountBlack = $no_bw_pages*(0.03-$blacknwhite_ink['101-500']);
					}else if($no_bw_pages>500){
						$reducedAmountBlack = $no_bw_pages*(0.03-$blacknwhite_ink['500+']);
						//echo "reducedAmountBlack[500+]=".$reducedAmountBlack;
					}	

					
					if($no_color_pages>20 && $no_color_pages<101){

						$reducedAmountColor = $no_color_pages*(0.15 - $color_ink['21-100']);

					}else if($no_color_pages>100 && $no_color_pages<201){

						$reducedAmountColor = $no_color_pages*(0.15 - $color_ink['101-200']);

					}else if($no_color_pages>200 && $no_color_pages<501){

						$reducedAmountColor = $no_color_pages*(0.15 - $color_ink['201-500']);

					}else if($no_color_pages>500){

						$reducedAmountColor = $no_color_pages*(0.15 - $color_ink['500+']);

					}

			}else if($paper_format='a3'){
					if($no_bw_pages>100 && $no_bw_pages<501){
						$reducedAmountBlack = $no_bw_pages*(0.6 - 2 * $blacknwhite_ink['101-500']);
						
					}else if($no_bw_pages>500){
						$reducedAmountBlack = $no_bw_pages*(0.6 - 2 * $blacknwhite_ink['500+']);
						
					}	

					
				 	if($no_color_pages>20 && $no_color_pages<101){

						$reducedAmountColor = $no_color_pages*( 0.30-2 * $color_ink['21-100']);

					}else if($no_color_pages>100 && $no_color_pages<201){

						$reducedAmountColor = $no_color_pages*( 0.30-2 * $color_ink['101-200']);

					}else if($no_color_pages>200  && $no_color_pages<501){

						$reducedAmountColor = $no_color_pages*( 0.30-2 * $color_ink['201-500']);

					}else if($no_color_pages>500){

						$reducedAmountColor = $no_color_pages*( 0.30-2 * $color_ink['500+']);

					}

				/*}*/
			}				
			//bindung price
			if($side=='Einseitig'){
				$noOfSheets = ceil($bw_pages_ss) + ceil($color_pages_ss) ; // no of sheet for binding
			}elseif ($side=='Doppelseitig') {
				$noOfSheets = ceil($bw_pages_ss/2) + ceil($color_pages_ss/2) ; // no of sheet for binding
			}else{
				$noOfSheets = ceil($bw_pages_ss) + ceil($color_pages_ss) ; // no of sheet for binding
			}
			
			//Spiralbindung 
			if($cart['product_id'] == 54){
				if ($noOfSheets>= 1 && $noOfSheets <= 50) {
					if ($qty>=1 && $qty<=10) {
						$bindungCost = 2.5;

					}else if ($qty>11 && $qty<=50) {
						$bindungCost = 2;

					}else if ($qty>51 && $qty<=100) {
						$bindungCost = 1.7;

					}else if ($qty>100 ) {
						$bindungCost = 1.5;

					}
				}else if ($noOfSheets> 50 && $noOfSheets <= 100) {
					if ($qty>=1 && $qty<=10) {
						$bindungCost = 3;
					}else if ($qty>11 && $qty<=50) {
						$bindungCost = 2.5;
					}else if ($qty>51 && $qty<=100) {
						$bindungCost = 2.3;
					}else if ($qty>100 ) {
						$bindungCost = 2;
					}
				}else if ($noOfSheets> 100 && $noOfSheets <= 150) {
					if ($qty>=1 && $qty<=10) {
						$bindungCost = 3.5;
					}else if ($qty>11 && $qty<=50) {
						$bindungCost = 3;
					}else if ($qty>51 && $qty<=100) {
						$bindungCost = 2.7;
					}else if ($qty>100 ) {
						$bindungCost = 2.5;
					}
				}else if ($noOfSheets> 150 && $noOfSheets <= 200) {
					if ($qty>=1 && $qty<=10) {
						$bindungCost = 4;
					}else if ($qty>11 && $qty<=50) {
						$bindungCost = 3.5;
					}else if ($qty>51 && $qty<=100) {
						$bindungCost = 3.2;
					}else if ($qty>100 ) {
						$bindungCost = 3;
					}
				}else if ($noOfSheets> 200 && $noOfSheets <= 280) {
					if ($qty>=1 && $qty<=10) {
						$bindungCost = 4.5;
					}else if ($qty>11 && $qty<=50) {
						$bindungCost = 4;
					}else if ($qty>51 && $qty<=100) {
						$bindungCost = 3.5;
					}else if ($qty>100 ) {
						$bindungCost = 3.2;
					}
				}else{
					
// bindung not possible




				}

			}	
			//hardcover bindung
			if($cart['product_id'] == 129){ 
				if ($noOfSheets >= 1 && $noOfSheets <= 150) {
					if ($qty >=1 && $qty <=3) {
						$bindungCost = 9;

					}else if ($qty >3 && $qty <=7) {
						$bindungCost = 8;

					}else if ($qty >7 && $qty <= 10) {
						$bindungCost = 7.5;

					}else if ($qty >10 ) {
						$bindungCost = 7;

					}
				}else if ($noOfSheets> 150 && $noOfSheets <= 245) {
					if ($qty >= 1 && $qty <= 3) {
						$bindungCost = 10;
					}else if ($qty > 3 && $qty <=7) {
						$bindungCost = 9;
					}else if ($qty > 7 && $qty <=10) {
						$bindungCost = 8.5;
					}else if ($qty > 10 ) {
						$bindungCost = 8;
					}
				}else{
					
// bindung not possible




				}

			}
			if($cart['product_id'] == 189){ 
				if ($noOfSheets >= 1 && $noOfSheets <= 150) {
					if ($qty >=1 && $qty <=10) {
						$bindungCost = 3.5;

					}else if ($qty >10 && $qty <=50) {
						$bindungCost = 3.3;

					}else if ($qty >50 && $qty <= 100) {
						$bindungCost = 3.2;

					}else if ($qty >100 ) {
						$bindungCost = 3.0;

					}
				}else if ($noOfSheets> 150 && $noOfSheets <= 350) {
					if ($qty >= 1 && $qty <= 10) {
						$bindungCost = 4.0;
					}else if ($qty > 10 && $qty <=50) {
						$bindungCost = 3.7;
					}else if ($qty > 50 && $qty <=100) {
						$bindungCost = 3.4;
					}else if ($qty > 100 ) {
						$bindungCost = 3.2;
					}
				}else{
					
// bindung not possible




				}

			}	
			if($cart['product_id'] == 190){ 
				if ($noOfSheets >= 1 && $noOfSheets <= 150) {
					if ($qty >=1 && $qty <=10) {
						$bindungCost = 4;

					}else if ($qty >10 && $qty <=50) {
						$bindungCost = 3.5;

					}else if ($qty >50 && $qty <= 100) {
						$bindungCost = 3.3;

					}else if ($qty >100 ) {
						$bindungCost = 3.0;

					}
				}else if ($noOfSheets> 150 && $noOfSheets <= 350) {
					if ($qty >= 1 && $qty <= 10) {
						$bindungCost = 5;
					}else if ($qty > 10 && $qty <=50) {
						$bindungCost = 4.5;
					}else if ($qty > 50 && $qty <=100) {
						$bindungCost = 4;
					}else if ($qty > 100 ) {
						$bindungCost = 3.5;
					}
				}else{
					
// bindung not possible




				}

			}
			if($cart['product_id'] == 191){ 
				if( $qty >0 &&  $qty<10 ){
					$bindungCost = 0.60;
				}else if( $qty >9 &&  $qty<50 ){
					$bindungCost = 0.50;
				}else if( $qty >49 &&  $qty<100 ){
					$bindungCost = 0.45;
				}else if( $qty >100){
					$bindungCost = 0.40;
				}

			}	
		  	//	echo 'Binding Cost='.$bindungCost.' no of sheets='.$noOfSheets;

  			$total_pages = $num1 + $num2;
  			//echo "   toooooooooootal Page=  ".$total_pages.'  ';
		  	$paperprice = $paper_price_array[$paper_type]*$total_pages*$qty; 
		  	if ($paper_format == 'a3') {
		  		$paperprice = $paperprice *2;
		  	}
		  	$product = new WC_Product($variation_id);
		  	$price = $product->price; // product variation price to be reduced
		  	$calc_error = 0.16 * $color_pages_ss + 0.04 * $bw_pages_ss; // multiplier default deduction
		  	$new_price = $new_color_price * $color_pages_ss +$new_bw_price * $bw_pages_ss; //total price of the combination including paper number
		  	$new_price = $new_price * $qty;
			//echo " bw_pages=".$bw_pages_ss.' color_pages='.$color_pages_ss." price=".$price." paperprice=".$paperprice.' cart='.$cart['data']->price.' calc_err='.$calc_error.' new_price='.$new_price.' paper_price='.$paperprice;
			//echo " reducedAmountBlack=".$reducedAmountBlack.' reducedAmountColor='.$reducedAmountColor;
		  	
		  	$cart['data']->price = ($cart['data']->price + $new_price - $calc_error - $paperprice - $price - $reducedAmountBlack - $reducedAmountColor)/$qty+$bindungCost;
		  	//echo 'cart='.$cart['data']->price.' bindungCost='.$bindungCost;

	  		
	  	}
	  	

	  }

	}
}