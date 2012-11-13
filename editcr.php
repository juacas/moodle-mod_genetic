<?php  // $Id: editty.php,v 1.0 2012/06/14 10:45:00 Ana María Lozano de la Fuente Exp $

	// File for managing the card types (add new ones, edit or delete them).

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Param to know what doing with card types 
	$action = optional_param('action','',PARAM_ALPHA);
	
	// Get the form variables	
	$idcr = optional_param('idcr', 0, PARAM_INT);
	$name = optional_param('name', '', PARAM_TEXT);
	$language = optional_param('language', '', PARAM_TEXT);


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
    add_to_log($course->id, "genetic", "edit crossrelated term", "editcr.php?id=$cm->id&idcr=$idcr&action=$action", "$genetic->id");
    
    
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");

	
	//Get a short version for the name of the genetic module
	$geneticname = format_string($genetic->name);
	$namelenght = strlen($geneticname);
	if ($namelenght > 40) {
		$geneticname = substr($geneticname, 0, 40)."...";
	}
	
    $navlinks = array();
    $navlinks[] = array('name' => $strgenetics, 'link' => "index.php?id=$course->id", 'type' => 'activity');
    $navlinks[] = array('name' => format_string($genetic->name), 'link' => '', 'type' => 'activityinstance');
    $navigation = build_navigation($navlinks);

	
	//Print the page header
    print_header_simple(format_string($genetic->name), "", $navigation, "", "", true,
                  update_module_button($cm->id, $course->id, $strgenetic), navmenu($course, $cm));

	// Print the tabs
	$SESSION->genetic->current_tab = 'showcr';
	include('tabs.php');

	
	// Print the main part of the page    
	
	// Delete
	if ($action == "delete") {
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		// Select the relatedterm (id)
		$query = genetic_delete_cr($idcr);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);
		
		// Delete ok or not?
		if($nok == 0) {
			$redirectmsg = get_string("deletecrnok", "genetic");
			redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);			
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}
		$redirectmsg = get_string("deletecrok", "genetic")."<BR />";
		redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);
		// Close the db    
		mysql_close($link);
		// Finish the page
		print_footer($course);
	}
	
	// Add or Edit
	else {		
		// Check if there is any obligatory field empty   
		if ($name == "")  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
	
		else {
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			// Add
			if ($action == "") {
			
			
						//Comprobar si el sinónimo ya existe en ese idioma
				
							$query = genetic_crossrelated_exists($name,$language);			
							$result=mysql_query($query,$link);
							$nok = mysql_affected_rows($link);				
							
							if($nok==0){	
			
			
			
								$query = genetic_insert_cr($name,$language);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);

								// Insert ok or not?
								if($nok == 0) {
								$redirectmsg = get_string("insertcrnok", "genetic");
								redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);					
								// Close the db    
								mysql_close($link);
								// Finish the page
								print_footer($course);
								}				
								$redirectmsg = get_string("insertcrok", "genetic");
								redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
								// Close the db    
								mysql_close($link);
								// Finish the page
								print_footer($course);
				
							}
				
							else{
							$redirectmsg = get_string("insertcrused", "genetic");
																	
							redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);
							// Close the db    
							mysql_close($link);
							// Finish the page
							print_footer($course);

							}
				
			}
			
			// Edit
			else if ($action == "edit") {
				$query = genetic_update_cr($idcr, $name);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);

				// Update ok or not?
				if($nok == 0) {
					$redirectmsg = get_string("updatertnok", "genetic");
					redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);					
					// Close the db    
					mysql_close($link);
					// Finish the page
					print_footer($course);
				}
				$redirectmsg = get_string("updatecrok", "genetic");
				redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);
				// Close the db 
				mysql_close($link);
			}
		}
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>