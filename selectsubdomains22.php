


<?php require_once("../../lib/fpdf/fpdf.php");
include("../../config.php");
require_once("db_functions.php");
require_once("lib.php");
require_once("selectsubdomainspdf.php");


// Get the form variables
$id = optional_param('id',0,PARAM_INT);
$term = optional_param('term', '', PARAM_TEXT);

 if ($id) {
        if (! $cm = get_record("course_modules", "id", $id)) {
            error("Course Module ID was incorrect");
        }
        if (! $course = get_record("course", "id", $cm->course)) {
            error("Course is misconfigured");
        }
        if (! $genetic = get_record("genetic", "id", $cm->instance)) {
            error("Course module is incorrect");
        }
    } else {
        if (! $genetic = get_record("genetic", "id", $t)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $genetic->course)) {
            error("Course is misconfigured");
        }
        if (! $cm = get_coursemodule_from_instance("genetic", $genetic->id, $course->id)) {
            error("Course Module ID was incorrect");
        }
    }
// Check if current user is logged in
    require_login($course->id);
	
// Log table
    add_to_log($course->id, "genetic", "search cards", "search.php?id=$cm->id", "$genetic->id"); 


$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
					$query = genetic_search_domain_h($genetic->id, $dom);
			
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
			
					
			
					// There are results?
					if($n == 0) {
						print_box_start($classes='generalbox boxaligncenter boxwidthwide');
						$msg = get_string("noresultdom", "genetic");
						echo $msg;
						print_box_end($return=false);
						echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
						// Close the db    
						mysql_close($link);
						// Finish the page
						//print_footer($course);
					}
					
					else{
				
					// CALL A RECURSIVE FUNCTION FOR THE MULTIPLE SUBDOMAINS (SONS)
					
						$sql3=genetic_subdomains2($genetic->id,$cm->id,$dom);
					
					}
					
					// Close the db    
						mysql_close($link);
			
	// Finish the page
	include('banner_foot.html');
	print_footer($course);

?>			