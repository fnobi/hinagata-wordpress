<!DOCTYPE html>
<html lang="ja">
<head>
<!-- meta -->
<meta charset="<?php bloginfo('charset') ?>" />
<meta name="description" content="<?php bloginfo('description') ?>" />
<title><?php echo get_title_element_text() ?></title>

<!-- ios meta -->
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="apple-mobile-web-app-capable" content="no" />
<meta name="apple-mobile-web-app-status-bar-style" content="default" />

<!-- ogp -->
<meta property="og:url" content="<?php echo is_front_page() ? home_url() : the_permalink() ?>" />
<meta property="og:type" content="<?php echo is_front_page() ? 'website' : 'article' ?>" />
<?php if (is_front_page()) : ?>
<meta property="og:image" content="<?php echo bloginfo('template_url') ?>/images/ogp.jpg" />
<?php endif ?>
<?php if ($url = get_thumbnail_url()) : ?>
<meta property="og:image" content="<?php echo $url ?>" />
<?php endif ?>
<meta property="og:title" content="<?php echo get_title_element_text() ?>" />
<meta property="og:site_name" content="<?php bloginfo('name') ?>" />
<meta property="og:description" content="<?php bloginfo('description') ?>" />
<meta property="og:locale" content="ja_JP" />

<!-- stylesheets -->
<script src="<?php echo bloginfo('template_url') ?>/js/lib/html5shiv.js"></script>
<link rel="stylesheet" href="<?php echo bloginfo('template_url') ?>/style.css" />

<!-- wp head -->
<?php wp_head() ?>
</head>
<body>
<section class="wrapper">
