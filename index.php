<?php
use Timber\Post;
use Timber\Timber;

// Get context
$context = Timber::context();

// Get query Post
$post = new Post();

// Add data to context
$context['post'] = $post;

Timber::render( 'templates/index.twig', $context );
