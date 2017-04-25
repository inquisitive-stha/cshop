<?php get_header();?>
<div class="container">
	<div class="col-md-3">
		<?php get_sidebar('nav');?>
	</div>
	<div class="col-md-9">
		<h3><?php the_title();?></h3>
		<?php the_content();?>
	</div>
</div>
<?php get_footer()?>