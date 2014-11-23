<ul class="post-list">
<?php while (have_posts()) : the_post() ?>
<li><a class="post-list__item" href="<?php the_permalink() ?>"><?php the_title() ?></a></li>
<?php endwhile ?>
<!-- /.post-list --></ul>
<?php echo get_previous_posts_link(); ?>
<?php echo get_next_posts_link() ?>
