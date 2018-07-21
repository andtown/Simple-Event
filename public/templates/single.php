<?php get_header(); ?>

	<main role="main">
	<!-- section -->
	<section>

	<?php if (have_posts()): while (have_posts()) : the_post(); ?>

		<!-- article -->
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

			<!-- event thumbnail -->
			<?php if ( has_post_thumbnail()) :  ?>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
					<?php the_post_thumbnail();  ?>
				</a>
			<?php endif; ?>
			<!-- /event thumbnail -->

			<!-- event title -->
			<h1>
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>
			<!-- /event title -->

			<!-- event details -->
			<span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
			<span class="author"><?php _e( 'Published by', 'simple-event' ); ?> <?php the_author_posts_link(); ?></span>
			<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'simple-event' ), __( '1 Comment', 'simple-event' ), __( '% Comments', 'simple-event' )); ?></span>
			<!-- /event details -->

			<!-- event content -->
			<p><?php the_content();  ?></p>
			<p> 
				Event Date : <?=date('F j, Y',strtotime(get_post_meta(get_the_id(),'event_date_time',true)))?>
			</p>
			<p>
				Event Location : <?=get_post_meta(get_the_id(),'event_location_address',true)?>
			</p>
			<p>
				Event URL : <?=get_post_meta(get_the_id(),'event_url',true)?>
			</p>
			<!-- /event content -->

			<!--

			<?php /*
			<?php the_tags( __( 'Tags: ', 'simple-event' ), ', ', '<br>'); ?>

			<p><?php _e( 'Categorised in: ', 'simple-event' ); the_category(', '); ?></p>
			*/ ?>

			<p><?php _e( 'This event was written by ', 'simple-event' ); the_author(); ?></p>

		</article>
		<!-- /article -->

	<?php endwhile; ?>

	<?php else: ?>

		<!-- article -->
		<article>

			<h1><?php _e( 'Sorry, nothing to display.', 'simple-event' ); ?></h1>

		</article>
		<!-- /article -->

	<?php endif; ?>

	</section>
	<!-- /section -->
	</main>

<?php get_sidebar(); ?>

<?php get_footer();