<?php get_header(); ?>

<div class="Main">
    <div class="Main-wrapper">
        <h1><?php echo wp_get_theme()->get( 'Name' ); ?></h1>
        <p><?php echo wp_get_theme()->get( 'Description' ); ?></p>
        <p>Author: <a href="<?php echo wp_get_theme()->get( 'AuthorURI' ); ?>" target="_blank" rel="noopener noreferrer"><?php echo wp_get_theme()->get( 'Author' ); ?></a></p>
    </div>
</div>

<?php get_footer(); ?>
