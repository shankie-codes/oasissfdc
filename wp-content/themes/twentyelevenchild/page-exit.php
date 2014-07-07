<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Eleven
 * @since Twenty Eleven 1.0
 */
add_filter('show_admin_bar', '__return_false');
get_header('minimal'); ?>

		<div id="primary"> 

			<?php if(is_user_logged_in()): ?>
 
				<?php while ( have_posts() ) : the_post(); ?>
					
					<header class="entry-header">
						<h1 class="entry-title"><?php echo the_title();?></h1>
					</header>

					<?php
					if(!$_GET['exit']){
						//If we have no query string...
						//Get a list of contacts who have entered today who have not yet exited
						//get a SFDC connection
						require_once ('inc/sfdc_connection.php');

						//Get the entries
						$query = "SELECT Id, User__r.FirstName, User__r.LastName, User__r.Nickname__c, Exit_time__c, CreatedDate FROM Entry__c WHERE CreatedDate = TODAY AND Exit_time__c = NULL";
						$response = $mySforceConnection->query($query);

						//Check that we got something back
						if($response->size > 0){
							echo '<ul class="entry-list">';
							foreach ($response->records as $record) {
								//Compose a query string
								$url = add_query_arg('exit', $record->Id, get_the_permalink());
								$url = add_query_arg('nickname', $record->User__r->Nickname__c, $url);
								echo '<a href="' . $url . '"><li class="entry-list-item">';

									//Convert SFDC's datetime into something more usable
									$date = new DateTime($record->CreatedDate);
									
									
									echo '<strong>' . $record->User__r->Nickname__c . '</strong><br/>' ;
									echo $date->format('H:i');
								echo '</li></a>';
							}
							echo '</ul>';
						}
						else{
							echo '<p>No-one left in the centre</p>';
						}
					}
					else{
						$exit = $_GET['exit'];
						$nickname = $_GET['nickname'];

						//Append an exit date to Entry record in SFDC
						require_once ('inc/sfdc_connection.php');

						//get the date/time
						$datetime = new DateTime();

						//Create an array to do the update
						$records = array();
						$records[0] = new stdclass();
						$records[0]->Id = $exit;
						$records[0]->Exit_time__c = $datetime->format('Y-m-d\TH:i:s.000\Z');

						//run the update
						$response = $mySforceConnection->update($records, 'Entry__c');

						echo '<p>' . $nickname . ' marked exited at ' . $datetime->format('H:i') . '</p>';
					}
					?>


				<?php endwhile; // end of the loop. ?>
			
			<?php else: ?>
				Please log in as admin to view this page.
			<?php endif; ?>

		</div><!-- #primary -->

<?php get_footer(); ?>