<?php
/*
Template Name: Portfolio
*/
?>

<?php get_header(); ?>

	<div id="primary" class="content-area clearfix">
		<main id="main" class="site-main clearfix" role="main">
			<div class="row" style="min-width: 500px;">

				<!-- CREATE PORTFOLIO MENU BASED ON CATEGORIES -->
				<?php
				//This will pull in a list of categories under the 'genre' taxonomy
				//and add them to an array called $categories
				$args = array(
					'type' => 'post',
					'child_of' => 0,
					'parent' => '',
					'orderby' => 'name',
					'order' => 'ASC',
					'hide_empty' => 0,
					'hierarchical' => 1,
					'exclude' => '',
					'include' => '',
					'number' => '',
					'taxonomy' => 'genre',
					'pad_counts' => false

				);
				$categories = get_categories($args);
				?>

				<ul id="portMenu">

					<?php
					//This will create the first list item 'All' which will remove any variables in the URL
					$permalink = get_permalink();
					$permalink = explode('?', $permalink);
					echo '<li><a href="' . $permalink[0] . '">All</a></li>';

					//This will loop through the array stored in $categories and output each value into a list
					//each list item will be a link that will set a value in the url to be used below.
					foreach ($categories as $category) {
						echo '<li><a href="?category=' . strtolower($category->name) . '">' . $category->name . 's</a></li>';
					}
					?>
				</ul>
				<!-- END CREATE PORTFOLIO MENU BASED ON CATEGORIES -->

				<!-- DISPLAY PORTFOLIO PIECES BASED ON MENU ITEM CLICKED -->
				<?php
				//This will pull in the value set in the url to display certain items in the portfolio

				// WP_Query arguments
				$category = htmlspecialchars($_GET["category"]);

				$args = array(
					'post_type' => 'portfoliopiece',
					'genre' => $category,
					//'posts_per_page'         => '1',
				);
				?>

				<?php
				// The Query
				$portfolio_loop = new WP_Query($args);
				?>


				<!-- PULL IN POST INFO AND CREATE LIST ITEMS -->

				<?php if ($portfolio_loop->have_posts()): ?>

					<ul class="clearing-thumbs" data-clearing>

						<?php while ($portfolio_loop->have_posts()): ?>
							<?php $portfolio_loop->the_post(); ?>

							<li>
								<?php if (has_post_thumbnail()): ?>
									<?php the_post_thumbnail('thumb'); ?>
								<?php endif; ?>
								 data-caption="<?php the_content(); ?>"
							</li>

						<?php endwhile; ?>

					</ul>

				<?php else: ?>

					<p>No Portfolio Pieces Found</p>

				<?php endif; ?>

				<?php
				// Restore original Post Data
				wp_reset_postdata();
				?>

				<!-- END DISPLAY PORTFOLIO PIECES -->

			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>