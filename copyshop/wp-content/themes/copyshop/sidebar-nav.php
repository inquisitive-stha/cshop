<div class="product-cat">
	<h1 class="title">Zahlungsmöglichkeiten</h1> 
        <img src="https://www.copyshopffm.de/wp-content/uploads/2016/08/zahlungsart.jpg" alt="Zahlungsart">
	<h1 class="title">Kategorien - Copyshop</h1>
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<?php
			$i=1;
			//list terms in a given taxonomy (useful as a widget for twentyten)
			$taxonomy = 'product_cat';
			$tax_terms = get_terms($taxonomy);
			foreach ($tax_terms as $key):?>
			<div class="panel-heading" role="tab" id="heading<?php echo $i?>">
				<h2 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse-<?php echo $i;?>" aria-expanded="true" aria-controls="collapse-<?php echo $i;?>"><?php echo $key->name?></a>
				</h2>
			</div>

			<div id="collapse-<?php echo $i;?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $i?>">
				<div class="panel-body">
				<ul>
				<?php
				$args = array('post_type' => 'product','product_cat' => $key->slug);
				$query = new WP_Query($args);
				while ($query->have_posts()):$query->the_post(); 
				?>
					<li><a href="<?php the_permalink();?>"><?php the_title()?></a></li>

				<?php endwhile; wp_reset_query();?>
				</ul>
				</div>
			</div>
			<?php $i++;?>
			<?php endforeach;?>
		</div>
	</div>
</div>

<!--

<head>
<meta content="de" http-equiv="Content-Language">
<style type="text/css">
.auto-style1 {
	text-decoration: underline;
}
</style>
</head>

<table style="width: 100%">
	<tr>
		<td class="auto-style1"><strong>Ausdrucken / Binden</strong></td>
	</tr>
	<tr><td>
		<li><a href="http://www.copyshopffm.de/produkt/ausdrucken/">Druck ohne Bindung</a></li>
		<li><a href="http://www.copyshopffm.de/produkt/spiralbindung/">Spiralbindung</a></li>
		<li><a href="http://www.copyshopffm.de/produkt/klebebindung/">Klebebindung</a></li>
		<li><a href="http://www.copyshopffm.de/produkt/hardcover-bindung/">Hardcover Bindung</a></li>
	</td></tr>
	
</table>

-->


















