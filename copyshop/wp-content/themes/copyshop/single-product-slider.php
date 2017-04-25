<?php get_header();?>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<?php get_template_part('sidebar-nav');?>
		</div>
		<div class="col-md-9">
		<?php 
			while(have_posts()):the_post();
                $key = get_post_meta($post->ID);
                if(isset($key['Slide links to'])&&!empty($key['Slide links to'])){
                $key_link_to = $key['Slide links to'];
                	$link = $key_link_to[0];	
                }else{
                	$link="#";
                }
		?>
		<div class="entry-content">
			<h4><a href="<?php echo $link;?>"><?php the_title();?></a></h4>
			<a href="<?php echo $link;?>"><?php the_post_thumbnail('full');?></a>
			<?php the_content();?>
		</div>
		<a href="<?php echo $link;?>" class="btn-log btn">In den Warenkorb</a>
			
		<?php endwhile;?>
		</div>
	</div>

</div>

<?php get_footer();?>