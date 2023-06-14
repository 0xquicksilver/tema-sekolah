<?php get_header(); ?>

<!-- Konten Utama -->
<main id="main-content" role="main">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h2 class="entry-title"><?php the_title(); ?></h2>
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    </article>
  <?php endwhile; endif; ?>
</main>

<?php get_footer(); ?>
