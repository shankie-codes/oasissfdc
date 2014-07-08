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


					//Check if we searched for something
					if($_GET['search']){

						//define our search term
						$search = $_GET['search'];

						//get a SFDC connection
						require_once ('inc/sfdc_connection.php');

						$query = "SELECT Id, FirstName, LastName, Nickname__c from Contact WHERE Nickname__c LIKE '%" . $search . "%'";
						$response = $mySforceConnection->query($query);

						// echo "Results of query '$query'<br/><br/>\n";

						//Check to see if we have any records
						if($response->size > 0){
							//Create a list
							echo 'Select nickname:<br/>';
							foreach ($response->records as $record) {
							    // echo $record->Id . ": " . $record->FirstName . " "
							        // . $record->LastName . " " . $record->Nickname__c . "<br/>\n";
							    	$url = add_query_arg('id', $record->Id, get_the_permalink());
							    	$url = add_query_arg('nickname', $record->Nickname__c, $url);

							    echo '<a class="pure-button pure-button-primary" href="' . $url . '">';
							    	echo '<strong>' . $record->Nickname__c . '</strong><br/>';
							    	echo $record->FirstName . ' ' . $record->LastName ;
							    echo '</a>';
							}


						}
						else{
							echo 'No results';
						}

					}
					elseif ($_GET['id']) {
						$id = $_GET['id'];
						$nickname = $_GET['nickname'];

						//We've selected an individual user. 
						echo '<h1>' . $nickname . '</h1>';

						if(!$_GET['activity']){
							//Select the activity type
							?>
							<ul class="entry-list">
								Select entrance type:
								<a href="<?php echo add_query_arg('activity', 'social');?>"><li><span>Social</span></li></a>
								<a href="<?php echo add_query_arg('activity', 'class');?>"><li><span>Class/Course</span></li></a>
								<a href="<?php echo add_query_arg('activity', 'appointment');?>"><li><span>Appointment</span></li></a>
								
							</ul>
							<?php
						}
						else{
							//Submit the entry to SFDC
							//id, activity

							//get a SFDC connection
							require_once ('inc/sfdc_connection.php');

							//Put the info into an array of objects to submit
							$records = array();
							$records[0] = new stdclass();
							$records[0]->User__c = $id;
							$records[0]->Activity__c = $_GET['activity'];

							$response = $mySforceConnection->create($records, 'Entry__c');

							if($response[0]->success > 0){
								echo '<p>Entry submitted</p>';
							}
						}
					}
					else{
						//Show a form to search for a nickname
						?>
						
						<form name="search-form" method="get" class="pure-form pure-form-aligned">
							<fieldset>
								<div class="pure-control-group">
									<label for="search">Nickname</label>
									<input type="text" name="search">
									<button type="submit" class="pure-button pure-button-primary">Search</button>
								</div>
							</fieldset>
						</form>
						<?php
					}
					
					?>
				
				<?php endwhile; // end of the loop. ?>
			
			<?php else: ?>
				Please log in as admin to view this page.
			<?php endif; ?>

		</div><!-- #primary -->

<?php get_footer(); ?>