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

get_header('feedback'); ?>

		<div id="primary"> 
 
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
					if(!$_POST){
						//$_POST isn't set, display a form to collect information

						$id = $_GET['id'];
						$nickname = $_GET['nickname'];

						//We've selected an individual user. Show the full form 
						
						?>

						<form class="pure-form pure-form-aligned">
							<fieldset>
								<div class="pure-control-group">
						            <label for="Nickname__c">Nickname</label>
						            <input id="Nickname__c" name="Nickname__c" type="text" readonly value="<?php echo $_GET['nickname'] ;?>">
						        </div>
					        </fieldset>
						</form>
						
						<form name="feedback-form" method="post" class="pure-form pure-form-aligned">
								<div class="pure-control-group">
									<label><strong>All fields are optional</strong></label>
								</div>

								<div class="pure-control-group">
						            <label for="Class__c">Class</label>
						            <select name="Class__c">
										<option value="Select">Select&hellip;</option>
										<option value="English">English</option>
										<option value="Sewing - women">Sewing - women</option>
										<option value="Pattern making">Pattern making</option>
										<option value="Sewing - men">Sewing - men</option>
										<option value="Storytelling">Storytelling</option>
										<option value="Bike maintenance">Bike maintenance</option>
										<option value="Card making">Card making</option>
										<option value="Food hygiene">Food hygiene</option>
										<option value="Pathways project">Pathways project</option> 
										<option value="Dance">Dance</option>
										<option value="Drama">Drama</option>
										<option value="Singing">Singing</option>
										<option value="Cookery">Cookery</option>
										<option value="Gardening">Gardening</option>
										<option value="Volunteering">Volunteering</option>
										<option value="Job club">Job club</option>
										<option value="Orientation">Orientation</option>
										<option value="Play group">Play group</option>
									</select>
						        </div>

								<div class="pure-control-group">
									<label for="Course_Perception__c">How was the class?</label>
								    <span class="fa fa-frown-o"></span>
								    <input type="radio" name="Course_Perception__c" value="1" />
								    <input type="radio" name="Course_Perception__c" value="2" />
								    <input type="radio" name="Course_Perception__c" value="3" />
								    <input type="radio" name="Course_Perception__c" value="4" />
								    <input type="radio" name="Course_Perception__c" value="5" />
								    <span class="fa fa-smile-o"></span>
								</div>
								
								<div class="pure-control-group">
									<label for="Pre_Ability__c">How was your ability <strong>before</strong> the class?</label>
								    <span class="fa fa-frown-o"></span>
								    <input type="radio" name="Pre_Ability__c" value="1" />
								    <input type="radio" name="Pre_Ability__c" value="2" />
								    <input type="radio" name="Pre_Ability__c" value="3" />
								    <input type="radio" name="Pre_Ability__c" value="4" />
								    <input type="radio" name="Pre_Ability__c" value="5" />
								    <span class="fa fa-smile-o"></span>
								</div>
								
								<div class="pure-control-group">
									<label for="Post_Ability__c">How was your ability <strong>after</strong> the class?</label>
								    <span class="fa fa-frown-o"></span>
								    <input type="radio" name="Post_Ability__c" value="1" />
								    <input type="radio" name="Post_Ability__c" value="2" />
								    <input type="radio" name="Post_Ability__c" value="3" />
								    <input type="radio" name="Post_Ability__c" value="4" />
								    <input type="radio" name="Post_Ability__c" value="5" />
								    <span class="fa fa-smile-o"></span>
								</div>

								<div class="pure-control-group">
									<label>Would you recommend the class to others?</label>
									    <input id="Yes" type="radio" name="Recommend_to_others__c" value="Yes">
								        Yes
								        <input id="No" type="radio" name="Recommend_to_others__c" value="No">
								        No
								</div>

								<div class="pure-control-group">
						            <label for="ClassImproved__c">How could the class be improved?</label>
						            <input class="pure-input-1-2" id="ClassImproved__c" name="ClassImproved__c" type="text">
						        </div>
								
								<div class="pure-control-group">
						            <label for="Other_Courses__c">What other classes would you like to see?</label>
						            <input class="pure-input-1-2" id="Other_Courses__c" name="Other_Courses__c" type="text">
						        </div>

						        <div class="pure-control-group">
						            <label for="How_did_you_hear_about_the_class__c">How did you hear about the class?</label>
						            <select name="How_did_you_hear_about_the_class__c">
										<option value="Select">Select&hellip;</option>
										<option value="Welsh Refugee Council">Welsh Refugee Council</option>
										<option value="Space for You">Space for You</option>
										<option value="The Parade">The Parade</option>
										<option value="DPIA">DPIA</option>
										<option value="Friend">Friend</option>
										<option value="Other">Other</option>
									</select>
						        </div>

						        <button type="submit" class="pure-button pure-button-primary">Submit</button>
							</fieldset>
						</form>

						<?php
					}
					else{
						//$_POST is set, so user has completed form, post to SFDC
						//Submit to SFDC and handle the returned result
						
						//get a SFDC connection
						require_once ('inc/sfdc_connection.php');

						//iterate through the $_POST and drop anything that starts with 'select'
						foreach ($_POST as $key => $post) {
							if(substr($post, 0, 6) == 'Select' || $post == ''){
								unset($_POST[$key]);
							}
						}


						//SFDC needs and array of objects
						$records = array();

						//Cast the $_POST array as an object
						$records[0] = (object)$_POST;

						//Add the user ID
						$records[0]->Contact__c = $_GET['id'];
						
						//Create a conection
						$response = $mySforceConnection->create($records, 'Feedback__c');

						if($response[0]->success > 0){
							echo 'Class feedback sumitted. Thank you!';
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
			

		</div><!-- #primary -->

<?php get_footer(); ?>