<?php
/*
Template Name: Forsidelayout
*/
get_header();



// echo "The post thumbnail id = " . $test;
?>

<div class="notification_container">
	<div class="notification">
		<div class="notification_x" style="cursor: pointer;" onclick="toggleBeta();">x</div>
		<h4>Beta-versjon</h4><p>Meir innhald og ferre problem undervegs!&thinsp; :&thinsp;)</p>
	</div>
</div>

<section class="intro_section">
	<div id="intro_container">
		<div id="intro" data-stellar-ratio="0.1">
			<?php
				// if(class_exists("get_featured_images")) { <-- DOESNT WORK
					for($i=0; $i < count($dynamic_featured_image->get_featured_images()); $i++) {
						$dynamicFeaturedImages = false/*$dynamic_featured_image->get_featured_images()[$i]["full"]*/;
						$attachment_id = $dynamic_featured_image->get_featured_images()[$i]["attachment_id"];

						$attribute = "$(window).ready(function() { thisPageTransition() });";

						if($i === 0) {
						?>

						<div class='intro_slideshow' data-bind="css: { intro_slideshow_hidden: !introSlideshow.visiting() }"><?php echo wp_get_attachment_image( $attachment_id, 'full', false, array('onload'=>$attribute) ); ?></div>

						<?php
						} else {
						?>

						<div class='intro_slideshow' data-bind="css: { intro_slideshow_hidden: !introSlideshow.visiting() }"><?php echo wp_get_attachment_image( $attachment_id, 'full', false ); ?></div>

						<?php
						}
					}
				// }
			?>
			<div class="intro_dimmer" data-bind="style: { display: introSlideshow.visiting() ? 'initial' : 'none' }"></div>

			<div id="intro_txt">
				<p id="introduksjons_helsing" data-stellar-ratio="0.95">Vennligst aktiver javascript!</p>
				<h1><?php echo get_bloginfo( 'description', 'display' ); ?></h1>
				<!-- <div class="intro_cta_wrapper"> -->
					<p class="intro_cta" data-stellar-ratio="0.95">↓ Bla for arbeider <span class="separator">|</span><a href="http://erling.tokheim.no/2014/01/25/om-meg/" style="color: #fff; text-decoration-color: #fff;">Les om meg →</a></p>
				<!-- </div> -->
				<!-- <button>Om meg</button> -->
				<!-- <span style="color: #fff; font-size: 1.2rem;">↓</span> -->
			</div>
		</div>
	</div>
</section>

<script type="text/javascript">
	var date = new Date();
	var hours = date.getHours();
	var introduksjons_helsing;

	if(hours >= 6 && hours <= 8) {
		introduksjons_helsing = "God morgon";
	} else if(hours >= 9 && hours <= 11) {
		introduksjons_helsing = "God føremiddag";
	} else if(hours >= 12 && hours <= 18) {
		introduksjons_helsing = "God ettermiddag";
	} else if(hours >= 19 && hours <= 24 || hours >= 0 && hours <= 5) {
		introduksjons_helsing = "God kveld";
	}
	document.getElementById("introduksjons_helsing").innerHTML = introduksjons_helsing + " og velkommen til mi";

</script>

<section class="featured_posts filled">
	<div class="contain">
		<div class="feature_background_container">
			<div class="feature_background_color_overlay"></div>
			<!-- ko foreach: feature.slide.backgrounds -->
				<div class="feature_background" data-bind="html: $data.img, css: { feature_background_hidden: !$data.visible() }"></div>
			<!-- /ko -->
		</div>

		<div class="feature_container">
			<?php
				$featuredPosts = [];
				$numberOfFeaturedPosts = 3;
				$args = array(
					'posts_per_page'   => $numberOfFeaturedPosts,
					'offset'           => 0,
					'category'         => '',
					'category_name'    => 'Featured',
					'orderby'          => 'date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => 'post',
					'post_mime_type'	=> '',
					'post_parent'		=> '',
					'post_status'		=> 'publish',
					'suppress_filters'	=> true,
					'terms'				=> 'Forsidenyhet'
				);
				$getFeatured = new WP_Query($args);
				if($getFeatured -> have_posts()) :
					$backgrounds = [];
					while($getFeatured -> have_posts()) : $getFeatured -> the_post();
						// Output here
					echo "<script>console.log('$post->ID');</script>";
					array_push($featuredPosts, $post->ID);
					// Remember the posts (In order to exclude them later)
						?>
						<?php array_push($backgrounds, wp_get_attachment_image( get_post_thumbnail_id($post->ID), 'full', false )); ?>
						<div class="feature_instance">
							<div class="feature_heading_container">
								<a href="<?php the_permalink() ?>">
									<h1><?php the_title(); ?></h1>
								</a>
							</div>

							<div class="feature_paragraph_container ingress">
								<a href="<?php the_permalink() ?>">
									<?php the_excerpt(); // The excerpt comes with a <p>-tag ?>
								</a>
							</div>

							<a href="<?php the_permalink() ?>">
								<button class="feature_button">Les meir →</button>
							</a>
						</div>
						<?php
					endwhile;

					else :
						// fallback, display no content message here
						echo "fallback, no posts";
				endif;

				$backgroundsFormatted = "'" . $backgrounds[0] . "'";

				for($i = 1; $i < count($backgrounds); $i++) {
					$backgroundsFormatted .=  ", '" . $backgrounds[$i] . "'";
				}

				?>

				<script>
					// $(window).ready(function() {
						var featureBackgrounds = [<?php echo $backgroundsFormatted; ?>];
					// });
				</script>

				<?php
				wp_reset_postdata();
			?>
		</div>
	</div>
</section>

			<?php
				$featuredFilteredOut = 0; // Filter out already displayed posts.
				$normalPostsToDisplay = array();
				$args = array(
					'posts_per_page'   => 100, // Three of the posts are only displayed in the featured section, the rest in "other projects"
					'offset'           => 0,
					'category'         => '',
					'category_name'    => '',
					'orderby'          => 'date',
					'order'            => 'DESC',
					'include'          => '',
					'exclude'          => '',
					'meta_key'         => '',
					'meta_value'       => '',
					'post_type'        => 'post',
					'post_mime_type'	=> '',
					'post_parent'		=> '',
					'post_status'		=> 'publish',
					'suppress_filters'	=> true,
					'terms'				=> ''
				);

				$otherProjectsPosts = array();

				$getOthers = new WP_Query($args);
				if($getOthers -> have_posts()) :
					while($getOthers -> have_posts()) : $getOthers -> the_post();

						// Filter out the already displayed posts (3 first featured posts)
						$alreadyDisplayed = false;
						$currentPostId = $post->ID;
						for ($i=0; $i < $numberOfFeaturedPosts; $i++) {
							if($currentPostId === $featuredPosts[$i]) {
								$alreadyDisplayed = true;
							}
						}

						// If not already displayed; add them to the array
						if(!$alreadyDisplayed) {
							if (class_exists('MultiPostThumbnails')) {
								$employersLogo = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(), 'employers-logo');
							}

							$contentArray = array("title" => get_the_title(), "excerpt" => get_the_excerpt(), "category" => get_the_category( $id = false )[0]->name, "permalink" => get_the_permalink(), "image" => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'other_projects' )[0], "employersLogo" => $employersLogo);
							array_push($otherProjectsPosts, $contentArray);


							$categories = get_the_category( $id = false );
						}

					endwhile;

				endif;
				wp_reset_postdata();

				// $categoriesToRemove = array("Featured");
				// $categoriesRemoved = 0;
				// foreach ( $otherProjectsPosts as $index => $single_cat ) {
				// 	if($categoriesRemoved < 3) {
				// 		if ( in_array( $otherProjectsPosts[$index]["category"], $categoriesToRemove ) ) {
				// 			// echo "<strong> / Just removed: " . $otherProjectsPosts[$index]["title"] . "</strong>";
				// 			unset( $otherProjectsPosts[ $index ] ); // Remove the category.

				// 			$categoriesRemoved++;
				// 		}
				// 	}
				// }

				// To reset the indexes. In example i deleted number 3 in the array, so it will return null.
				// This function re arranges the array.
				$otherProjectsPosts = array_values($otherProjectsPosts);
			?>

<section class="other_projects filled">
	<div class="contain">
		<div class="other_projects_intro">
			<h2>Fleire arbeid</h2>
			<p>
				<img class="arrow_medium" src="<?php echo get_template_directory_uri() ?>/img/arrow.svg" alt="">
			</p>
		</div>

		<?php
		// var_dump($otherProjectsPosts);

			$otherProjectsCustomSorting = [
											[0.5, 0.5, 1,   1,  ],
											[1,   1,   1,   2,  ],
											[1,   0.5, 0.5, 2,  ],
											[1,   1,   2,   2,  ],
											[1,   0.5, 0.5, 1,  ],
											[1,   2,   2,   1,  ],
											[0.5, 0.5, 1,   2,  ],
											[2,   1,   1,   1,  ],
											[1,   1,   1,   1,  ],
											[1,   0.5, 0.5, 1,  ],
											[1,   1,   1,   2,  ],
											[1,   0.5, 0.5, 2,  ],
											[1,   1,   2,   2,  ],
											[1,   0.5, 0.5, 1,  ],
											[1,   2,   2,   1,  ],
											[0.5, 0.5, 1,   2,  ],
											[2,   1,   1,   1,  ],
											[1,   1,   0.5, 0.5,],
											[0.5, 0.5, 1,   1,  ]
										]; // 48 * 2 + 4 = 100 -> I made 48 and just duplicated them.

			// echo '$otherProjectsPostsLength = ' . $otherProjectsPostsLength . "<br>";

			$otherProjectsPostsLength = count($otherProjectsPosts);
			$otherProjectsRemainingPosts = $otherProjectsPostsLength - 3; // minus the first row of posts
			$otherProjectsCustomSortingNew = [$otherProjectsCustomSorting[0]];

			for ($i=1; $i < count($otherProjectsCustomSorting); $i++) {

				$postsInNextRow = $otherProjectsCustomSorting[$i][0] + $otherProjectsCustomSorting[$i][1] + $otherProjectsCustomSorting[$i][2] + $otherProjectsCustomSorting[$i][3];

				if($otherProjectsRemainingPosts < 7 && $otherProjectsRemainingPosts > 0) {
					// echo "<script>console.log('Less than 7 posts $otherProjectsRemainingPosts');</script>";
					// echo "<br><br>Previous post setup = ";
					for ($j=0; $j < count($otherProjectsCustomSortingNew[$i - 1]); $j++) {
						// echo $otherProjectsCustomSortingNew[$i - 1][$j] . " ";
					}

					if($otherProjectsRemainingPosts == 6) {
						$addToArray = [1, 2, 1, 2];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 6;

					} else if($otherProjectsRemainingPosts == 5) {
						$addToArray = [1, 1, 1, 2];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 5;

					} else if ($otherProjectsRemainingPosts == 4) {
						$addToArray = [1, 1, 1, 1];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 4;

					} else if ($otherProjectsRemainingPosts == 3) {
						$addToArray = [0.5, 0.5, 1, 1];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 3;

					} else if ($otherProjectsRemainingPosts == 2) {
						$addToArray = [0.5, 0.5, 1, 0];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 2;

					} else if ($otherProjectsRemainingPosts == 1) {
						$addToArray = [0.5, 0.5, 0, 0];
						array_push($otherProjectsCustomSortingNew, $addToArray);
						$otherProjectsRemainingPosts -= 1;

					}

					// echo "<br><br><br><br>";

				} else if($otherProjectsRemainingPosts > 0) {
					// Else (it is more then 7 posts left to render) use the custom array.
					// echo "<br>Posts in next row = " . $postsInNextRow;
					$otherProjectsRemainingPosts -= $postsInNextRow;
					array_push($otherProjectsCustomSortingNew, $otherProjectsCustomSorting[$i]);

				}
			}




			// echo "<br><br>The array format:<br>";
			// echo "Number of posts: $otherProjectsPostsLength <br><br>";
			// for ($i=0; $i < count($otherProjectsCustomSortingNew); $i++) {
			// 	for ($j=0; $j < count($otherProjectsCustomSortingNew[$i]); $j++) {
			// 		if($otherProjectsCustomSortingNew[$i][$j] == 0.5) {
			// 			echo "½ ";
			// 		} else {
			// 			echo $otherProjectsCustomSortingNew[$i][$j] . "&thinsp;&thinsp;&thinsp;";
			// 		}
			// 	}
			// 	echo "<br>";
			// }
			// echo "<br>";


			$otherProjectsRowNumber = 0;
			$otherProjectsColumnNumber = 0;

			$multiplier = 5;
			if($otherProjectsPostsLength < 10) {
				$multiplier = $otherProjectsPostsLength;
			} else {
				$multiplier = (count($otherProjectsCustomSortingNew)) * 4;
			}
			$otherProjectsSkipNext = false;
			$otherProjectsIndex = 0;
			$doublePost = [];

			if($otherProjectsPostsLength > 1) {
				for ($i=0; $i < $multiplier; $i++) { // Rows * columns
					// echo "RUNNING ($i)";
					// if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] !== 0) {

						// For every fourth loop, change row (4 cells per row).
						if($i%4 === 0 && $i !== 0) {
							$otherProjectsRowNumber++;
							echo "<script>console.log('Changing row');</script>";
						}


						// echo "<script>console.log('Loop $multiplier times, Post $otherProjectsIndex/$otherProjectsPostsLength, Row ($i%5): $otherProjectsRowNumber, column: $otherProjectsColumnNumber');</script>";

						$size = $otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber];
						$loopNumber = $i + 1;
						echo "<script>console.log('Loop number $loopNumber/$multiplier, Post $otherProjectsIndex/$otherProjectsPostsLength, size: $size, Row ($i%4): $otherProjectsRowNumber, column: $otherProjectsColumnNumber');</script>";
						if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] == 0) {
							$otherProjectsPosts[$otherProjectsIndex] = [];
						}
						if(!$otherProjectsSkipNext) {
							if($size == 2) {
								$doublePost = [$otherProjectsPosts[$otherProjectsIndex], $otherProjectsPosts[$otherProjectsIndex + 1]];
								otherProjectsRender($doublePost, $size, $otherProjectsRowNumber, $otherProjectsColumnNumber);
								$doublePost = [];
								$otherProjectsIndex++;
								// Loop once less (This is a double post)
								$multiplier--;
								$otherProjectsSkipNext = true;
							} else {
								otherProjectsRender($otherProjectsPosts[$otherProjectsIndex], $size, $otherProjectsRowNumber, $otherProjectsColumnNumber);
							}
						}

						// If this post is a 0.5-post && it's the first half of it; don't count the other half and loop one more time
						if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] == 0.5 && !$otherProjectsSkipNext) {
							$otherProjectsSkipNext = true;
							// Loop one more time (Takes two loops to output 0.5-posts (they take two columns))
							if($otherProjectsPostsLength < 10) {$multiplier++;}
							// echo "<script>console.log('skipped one');</script>";
						} else {
							$otherProjectsSkipNext = false;
							$otherProjectsIndex++;
						}

						if($otherProjectsColumnNumber == 3) {
							$otherProjectsColumnNumber = 0;
						} else {
							$otherProjectsColumnNumber++;
						}
					// }
				}
			} else {
				echo "Fallback - No posts available. Try to refresh the page. If the problem persists, please contact me at erling@tokheim.no";
			}

			function otherProjectsRender($postObject, $postSize, $rowNumber, $columnNumber) {
				// echo "$postSize ";

				// Determines post position
				$postPosition = "";
				if($columnNumber == 0) {
					$postPosition = "other_projects_column_num_1";
				} else if($columnNumber == 4) {
					$postPosition = "other_projects_column_num_5";
				}

				// Outputs post depending on size
				if($postSize == 0) {

				} else if($postSize == 0.5) {
					?>

					<a href="<?php echo $postObject['permalink']; ?>">
						<!-- A div to detemine the width -->
						<div class="col-md-4 col-lg-6 other_projects_padding<?php echo " $postPosition"; ?>" onmouseover="other_projects_hover($(this));" onmouseout="other_projects_hover($(this));">
							<!--
								A div for effects - the col-classes uses paddings to separate content
								which means we can't add the shadow to the columns. (The shadow would
								display ouside the padding, while the content inside the padding.)
							-->
							<div class="other_pojects">
								<div class="other_projects_big_img_wrapper">
									<div class="other_projects_img_overlay"></div>
									<div class="other_projects_logo" style="background-image: url('<?php echo $postObject['employersLogo']; ?>');"></div>
									<div class="other_projects_img" style="background-image: url('<?php echo $postObject['image']; ?>');"></div>
								</div>
								<div class="other_projects_text_wrapper">
									<h2><?php echo $postObject["title"]; ?></h2>
									<p><?php echo $postObject["excerpt"]; ?></p>
								</div>
							</div>
						</div>
					</a>

					<?php
				} else if($postSize == 1) {
					?>

					<a href="<?php echo $postObject['permalink']; ?>">
						<div class="col-md-4 col-lg-3 other_projects_padding<?php echo " $postPosition"; ?>" onmouseover="other_projects_hover($(this));" onmouseout="other_projects_hover($(this));">
							<div class="other_pojects">
								<div class="other_projects_big_img_wrapper">
									<div class="other_projects_img_overlay"></div>
									<div class="other_projects_logo" style="background-image: url('<?php echo $postObject['employersLogo']; ?>');"></div>
									<div class="other_projects_img" style="background-image: url('<?php echo $postObject['image']; ?>');"></div>
								</div>
								<div class="other_projects_text_wrapper">
									<h2><?php echo $postObject["title"]; ?></h2>
									<p><?php echo $postObject["excerpt"]; ?></p>
								</div>
							</div>
						</div>
					</a>

					<?php
				} else if($postSize == 2) {
					// var_dump($postObject);
					?>
					<div class="col-md-4 col-lg-3 other_projects_padding<?php echo " $postPosition"; ?>">
						<a class="other_projects_2_container" href="<?php echo $postObject[0]['permalink']; ?>" onmouseover="other_projects_hover($(this));" onmouseout="other_projects_hover($(this));">
							<div class="other_pojects_2 other_pojects">
								<div class="other_projects_big_img_wrapper">
									<div class="other_projects_img_overlay"></div>
									<div class="other_projects_logo" style="background-image: url('<?php echo $postObject[0]['employersLogo']; ?>');"></div>
									<div class="other_projects_img" style="background-image: url('<?php echo $postObject[0]['image']; ?>');"></div>
								</div>
								<div class="other_projects_text_wrapper">
									<h3><?php echo $postObject[0]["title"]; ?></h3>
									<p><?php echo $postObject[0]["excerpt"]; ?></p>
								</div>
							</div>
						</a>
						<a class="other_projects_2_container" href="<?php echo $postObject[1]['permalink']; ?>" onmouseover="other_projects_hover($(this));" onmouseout="other_projects_hover($(this));">
							<div class="other_pojects_2 other_pojects">
								<div class="other_projects_big_img_wrapper">
									<div class="other_projects_img_overlay"></div>
									<div class="other_projects_logo" style="background-image: url('<?php echo $postObject[1]['employersLogo']; ?>');"></div>
									<div class="other_projects_img" style="background-image: url('<?php echo $postObject[1]['image']; ?>');"></div>
								</div>
								<div class="other_projects_text_wrapper">
									<h3><?php echo $postObject[1]["title"]; ?></h3>
									<p><?php echo $postObject[1]["excerpt"]; ?></p>
								</div>
							</div>
						</a>
						<!-- Clearing - important -->
						<div class="clear"></div>
					</div>

					<?php
				}
			}
		?>
		<div class="clear"></div>
	</div>
</section>

<?php get_footer(); ?>