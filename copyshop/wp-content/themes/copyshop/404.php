<?php get_header();?>
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<div align="center" class="pagenotfound">
				<h2><?php echo 'Hoppla!! 404 Seite nicht gefunden.';?></h2>
				<h3><?php echo 'stattdessen suchen';?></h3>
				<div class="drop-search">
				<?php get_product_search_form();?>
				</div>
			</div>
			
		</div>
		<div class="col-md-2"></div>
		
	</div>
	
</div>
<?php get_footer();?>