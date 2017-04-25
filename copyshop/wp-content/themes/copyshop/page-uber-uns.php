<?php get_header();?>
<div class="container">
	<div class="row">
		<div class="col-md-3 col-sm-3 col-xs-12">
			<?php get_sidebar('nav');?>
		</div>
		<div class="col-md-9 col-sm-9 col-xs-12">
			<h4><?php the_title();?></h4>
			<p><?php the_content();?></p>

		</div>
	</div>
</div>

<?php get_footer();?>