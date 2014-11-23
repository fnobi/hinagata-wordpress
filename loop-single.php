<?php while (have_posts()) : the_post() ?>
<section id="post-<?php the_id() ?>" class="post-detail">
<h1><a class="post-detail__title" href="<?php the_permalink() ?>"><?php the_title() ?></a></h1>
<div class="post-detail__date"><?php the_date('Y.m.d') ?></div>
<div class="post-detail__body">
<?php the_content() ?>
<!-- .post-detail__body --></div>
<!-- /.post-detail --></section>
<?php endwhile ?>
