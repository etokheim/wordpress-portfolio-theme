<?php
/*
Template Name: Forsidelayout
*/
get_header();



// echo "The post thumbnail id = " . $test;
?>
<!-- The embarassment is huge in this one -->
<div class="noMobile">
	<p><span style="font-size: 4rem;">😱</span><br><span style="font-size: 4rem; font-weight: 800;">SMERTE!</span><br>Pinlig, mobilversjonen er ikkje klar... Men ver snill og besøk meg via ein større skjerm! &thinsp;:&thinsp;)</p>
</div>
<div class="notification_container">
	<div class="notification">
		<div class="notification_x" style="cursor: pointer;" onclick="toggleBeta();">x</div>
		<h4>Beta-versjon</h4><p>Meir innhald og ferre problem undervegs!&thinsp; :&thinsp;)</p>
	</div>
</div>

<section>
	<div id="intro_container">
		<div id="intro" data-stellar-ratio="0.1" style="background-image: url('<?php // echo get_header_image(); ?>');">
			<?php
				// if(class_exists("get_featured_images")) { <-- DOESNT WORK
					for($i=0; $i < count($dynamic_featured_image->get_featured_images()); $i++) {
						$dynamicFeaturedImages = false/*$dynamic_featured_image->get_featured_images()[$i]["full"]*/;
						$attachment_id = $dynamic_featured_image->get_featured_images()[$i]["attachment_id"];

						?>

						<div class='intro_slideshow'><?php echo wp_get_attachment_image( $attachment_id, 'full', false ); ?></div>

						<?php
					}
				// }
			?>
			<div class="intro_dimmer"></div>

			<div id="intro_txt" data-stellar-ratio="0.95">
				<p id="introduksjons_helsing">Vennligst aktiver javascript!</p>
				<h1><?php echo get_bloginfo( 'description', 'display' ); ?></h1>
				<!-- <div class="intro_cta_wrapper"> -->
					<p class="intro_cta">↓ Bla for arbeider <span class="separator">|</span><a href="http://erling.tokheim.no/2014/01/25/om-meg/" style="color: #fff; text-decoration-color: #fff;">Les om meg →</a></p>
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
				$args = array(
					'posts_per_page'   => 3,
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
				$postLoopIndex = 0;
				if($getOthers -> have_posts()) :
					while($getOthers -> have_posts()) : $getOthers -> the_post();
						$postLoopIndex++;
						// Output here
						if(get_the_category() !== "Featured" && $featuredFilteredOut < 3) {

						}
						// echo get_the_title();
						// $categories = get_the_terms( $post->ID, 'taxonomy' );
						if (class_exists('MultiPostThumbnails')) {
							$employersLogo = MultiPostThumbnails::get_post_thumbnail_url(get_post_type(),'employers-logo');
						}

						$contentArray = array("title" => get_the_title(), "excerpt" => get_the_excerpt(), "category" => get_the_category( $id = false )[0]->name, "permalink" => get_the_permalink(), "image" => wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'other_projects' )[0], "employersLogo" => $employersLogo);
						array_push($otherProjectsPosts, $contentArray);


						$categories = get_the_category( $id = false );
						// echo "<strong>Length before = " . count($categories) . "</strong>";



						// echo "<strong>Category: " . get_the_category( $id = false )[0]->name . "</strong>";
						// var_dump(get_the_category( $id = false ));
					endwhile;

				endif;
				wp_reset_postdata();

				$categoriesToRemove = array("Featured");
				$categoriesRemoved = 0;
				foreach ( $otherProjectsPosts as $index => $single_cat ) {
					if($categoriesRemoved < 3) {
						if ( in_array( $otherProjectsPosts[$index]["category"], $categoriesToRemove ) ) {
							// echo "<strong> / Just removed: " . $otherProjectsPosts[$index]["title"] . "</strong>";
							unset( $otherProjectsPosts[ $index ] ); // Remove the category.

							$categoriesRemoved++;
						}
					}
				}

				// To reset the indexes. In example i deleted number 3 in the array, so it will return null.
				// This function re arranges the array.
				$otherProjectsPosts = array_values($otherProjectsPosts);
			?>

<div class="other_projects_container content_section_wrapper">
	<div class="content_section">
		<?php
		// var_dump($otherProjectsPosts);

			$otherProjectsCustomSorting = [
											[0.5, 0.5, 1,   1,   1  ],
											[1,   1,   1,   2,   1  ],
											[1,   0.5, 0.5, 2,   1  ],
											[1,   1,   2,   2,   1  ],
											[1,   0.5, 0.5, 1,   1  ],
											[1,   2,   2,   1,   1  ],
											[0.5, 0.5, 1,   2,   1  ],
											[2,   1,   1,   1,   1  ],
											[1,   1,   1,   0.5, 0.5],
											[1,   0.5, 0.5, 1,   1  ],
											[1,   1,   1,   2,   1  ],
											[1,   0.5, 0.5, 2,   1  ],
											[1,   1,   2,   2,   1  ],
											[1,   0.5, 0.5, 1,   1  ],
											[1,   2,   2,   1,   1  ],
											[0.5, 0.5, 1,   2,   1  ],
											[2,   1,   1,   1,   1  ],
											[1,   1,   1,   0.5, 0.5],
											[0.5, 0.5, 1,   1,   1  ]
										]; // 48 * 2 + 4 = 100 -> I made 48 and just duplicated them.

			// echo 'count($otherProjectsPosts) = ' . count($otherProjectsPosts) . "<br>";

			$otherProjectsRemainingPosts = count($otherProjectsPosts) - 4; // minus the first row of posts
			$otherProjectsCustomSortingNew = [$otherProjectsCustomSorting[0]];

			for ($i=1; $i < count($otherProjectsCustomSorting); $i++) {

				$postsInNextRow = $otherProjectsCustomSorting[$i][0] + $otherProjectsCustomSorting[$i][1] + $otherProjectsCustomSorting[$i][2] + $otherProjectsCustomSorting[$i][3] + $otherProjectsCustomSorting[$i][4];

				if($otherProjectsRemainingPosts > 0) {
					if($otherProjectsRemainingPosts < 15) {
						// echo "<br>Less than 15 posts left (" . ($otherProjectsRemainingPosts) . ")";

						if($otherProjectsRemainingPosts < 8) {
							// echo "<br>Less than 8 posts! (" . $otherProjectsRemainingPosts . ")";
							// echo "<br><br>Previous post setup = ";
							for ($j=0; $j < count($otherProjectsCustomSortingNew[$i - 1]); $j++) {
								// echo $otherProjectsCustomSortingNew[$i - 1][$j] . " ";
							}

							if($otherProjectsRemainingPosts == 7) {
								$addToArray = [2, 2, 1, 1, 1];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 7;

							} else if($otherProjectsRemainingPosts == 6) {
								$addToArray = [1, 0.5, 0.5, 2, 2];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 6;

							} else if($otherProjectsRemainingPosts == 5) {
								$addToArray = [1, 0.5, 0.5, 2, 1];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 5;

							} else if ($otherProjectsRemainingPosts == 4) {
								$addToArray = [1, 0.5, 0.5, 1, 1];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 4;

							} else if ($otherProjectsRemainingPosts == 3) {
								$addToArray = [0.5, 0.5, 1, 0.5, 0.5];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 3;

							} else if ($otherProjectsRemainingPosts == 2) {
								$addToArray = [0.5, 0.5, 1, 0, 0];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 2;

							} else if ($otherProjectsRemainingPosts == 1) {
								$addToArray = [0.5, 0.5, 0, 0, 0];
								array_push($otherProjectsCustomSortingNew, $addToArray);
								$otherProjectsRemainingPosts -= 1;

							}

							// echo "<br><br><br><br>";

						} else if($otherProjectsRemainingPosts == 8) {
							$addToArray = [1, 1, 1, 0.5, 0.5];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 4;

						} else if($otherProjectsRemainingPosts == 9) {
							$addToArray = [0.5, 0.5, 1, 1, 1];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 4;

						} else if($otherProjectsRemainingPosts == 10) {
							$addToArray = [0.5, 0.5, 1, 0.5, 0.5];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 3;

						} else if ($otherProjectsRemainingPosts == 11) {
							$addToArray = [1, 0.5, 0.5, 1, 1];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 4;

						} else if ($otherProjectsRemainingPosts == 12) {
							$addToArray = [1, 0.5, 0.5, 2, 1];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 5;

						} else if ($otherProjectsRemainingPosts == 13) {
							$addToArray = [1, 0.5, 0.5, 2, 2];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 6;

						} else if ($otherProjectsRemainingPosts == 14) {
							$addToArray = [2, 2, 1, 1, 1];
							array_push($otherProjectsCustomSortingNew, $addToArray);
							$otherProjectsRemainingPosts -= 7;

						}
					} else {
						// Else (it is more then 15 posts left to render) use the custom array.
						// echo "<br>Posts in next row = " . $postsInNextRow;
						$otherProjectsRemainingPosts -= $postsInNextRow;
						array_push($otherProjectsCustomSortingNew, $otherProjectsCustomSorting[$i]);
					}
				}
			}


			//
			// echo "<br><br>The array format:<br>";
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
			if(count($otherProjectsPosts) < 10) {
				$multiplier = count($otherProjectsPosts);
			} else {
				$multiplier = (count($otherProjectsCustomSortingNew)) * 5;
			}
			$otherProjectsSkipNext = false;
			$otherProjectsIndex = 0;
			$doublePost = [];

			if(1+1==2) {
				for ($i=0; $i < $multiplier; $i++) { // Rows * columns
					// echo "RUNNING ($i)";
					// if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] !== 0) {

						// For every fifth loop, change row (5 columns per row).
						if($i%5 === 0 && $i !== 0) {
							$otherProjectsRowNumber++;
							// echo "<br>";
						}

						$foasd = count($otherProjectsPosts);

						// echo "<script>console.log('Loop $multiplier times, Post $otherProjectsIndex/$foasd, Row ($i%5): $otherProjectsRowNumber, column: $otherProjectsColumnNumber');</script>";

						if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] == 0) {
							$otherProjectsPosts[$otherProjectsIndex] = [];
						}
						if(!$otherProjectsSkipNext) {

							if ($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] == 2) {
								$doublePost = [$otherProjectsPosts[$otherProjectsIndex], $otherProjectsPosts[$otherProjectsIndex + 1]];
								otherProjectsRender($doublePost, $otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber], $otherProjectsRowNumber, $otherProjectsColumnNumber);
								$doublePost = [];
								$otherProjectsIndex++;
							} else {
								otherProjectsRender($otherProjectsPosts[$otherProjectsIndex], $otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber], $otherProjectsRowNumber, $otherProjectsColumnNumber);
							}
						}
						if($otherProjectsCustomSortingNew[$otherProjectsRowNumber][$otherProjectsColumnNumber] == 0.5 && !$otherProjectsSkipNext) {
							$otherProjectsSkipNext = true;
							if(count($otherProjectsPosts) < 10) {$multiplier++;}
							// echo "<script>console.log('skipped one');</script>";
						} else {
							$otherProjectsSkipNext = false;
							$otherProjectsIndex++;
						}

						if($otherProjectsColumnNumber == 4) {
							$otherProjectsColumnNumber = 0;
						} else {
							$otherProjectsColumnNumber++;
						}
					// }
				}
			} else {
				echo "Fallback - No posts available. Try refresh the scroll. If the problem persists, please contact me at erling@tokheim.no";
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
									<h3><?php echo $postObject["title"]; ?></h3>
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
									<h3><?php echo $postObject["title"]; ?></h3>
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
								</div>
							</div>
						</a>
					</div>

					<?php
				}
			}
		?>
		<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>