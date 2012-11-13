<?php  // $Id: editbe.php,v 1.0 2012/06/14 10:45:00 Ana María Lozano de la Fuente Exp $
/*********************************************************************************

* This file is part of Genetic.

* Genetic is a terminological dictionary developed at the EdUVAlab e-Learning laboratory (University of Valladolid)

* Designed and directed by the ITAST group (http://www.eduvalab.uva.es/contact)

* Implemented by Ana María Lozano de la Fuente, using the previous software called Terminology, implemented by Irene Fernández Ramírez (2010)

 

* @ copyright (C) 2012 ITAST group

* @ author:  Ana María Lozano de la Fuente, Irene Fernández Ramírez, María Jesús Verdú Pérez, Juan Pablo de Castro Fernández, Luisa M. Regueras Santos,  Elena Verdú Pérez and María Ángeles Pérez Juárez

* @ package genetic

* @ license: GNU General Public License (GPL) http://www.gnu.org/copyleft/gpl.html

 

* Genetic is free software; you can redistribute it and/or modify

* it under the terms of the GNU General Public License as published by

* the Free Software Foundation; either version 3 of the License, or

* (at your option) any later version.

 

*  This program is distributed in the hope that it will be useful,

*  but WITHOUT ANY WARRANTY; without even the implied warranty of

*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the

*  GNU General Public License for more details.

 

*  You should have received a copy of the GNU General Public License

*  along with Genetic.  If not, see <http://www.gnu.org/licenses/>.

*********************************************************************************/

	// File for managing the Departments (add new ones, edit or delete them).

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Param to know what doing with departments 
	$action = optional_param('action','',PARAM_ALPHA);
	
	// Get the form variables	
	$idbe = optional_param('idbe', 0, PARAM_INT);
	$name = optional_param('name', '', PARAM_TEXT);
	$origen = optional_param('origen', '', PARAM_TEXT);

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
    add_to_log($course->id, "genetic", "edit departments", "editbe.php?id=$cm->id&idbe=$idbe&action=$action", "$genetic->id");
    
    
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

	// Print Tabs
	$SESSION->genetic->current_tab = 'showbe';
	include('tabs.php');

    
	// Print the main part of the page	
	
	// Delete department
	if ($action == "delete") {
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		// Select the department (id)
		$query = genetic_delete_be($idbe);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);

		// Delete ok or not?
		if($nok == 0) {
			$redirectmsg = get_string("deletebenok", "genetic");
			redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);			
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}
		$redirectmsg = get_string("deletebeok", "genetic")."<BR />";
		redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);
		// Close the db    
		mysql_close($link);
		// Finish the page
		print_footer($course);
	}
	
	// Add or Edit
	else {		
		//Check if there is any obligatory field empty   
		if ($name == ""){
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}	
		else {
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			
			// Add department
			if ($action == "") {
				$query = genetic_insert_be($name);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
				if($origen=="add_be"){
				
					// Insert ok or not?
					if($nok == 0) {
						$redirectmsg = get_string("insertbenok", "genetic");
						redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);					
						// Close the db    
						mysql_close($link);
						// Finish the page
						print_footer($course);
					}				
				$redirectmsg = get_string("insertbeok", "genetic");
				redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);
				}
				
				
				
				else if($origen==""){
				
					// Insert ok or not?
					if($nok == 0) {
						$redirectmsg = get_string("insertbenok", "genetic");
						redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);					
						// Close the db    
						mysql_close($link);
						// Finish the page
						print_footer($course);
					}				
				$redirectmsg = get_string("insertbeok", "genetic");
				redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
				}
				// Close the db    
				mysql_close($link);
				// Finish the page
				print_footer($course);
			}
			
			// Edit department
			else if ($action == "edit") {
				$query = genetic_update_be($idbe, $name);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);

				// Update ok or not?
				if($nok == 0) {
					$redirectmsg = get_string("updatebenok", "genetic");
					redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);					
					// Close the db    
					mysql_close($link);
					// Finish the page
					print_footer($course);
				}
				$redirectmsg = get_string("updatebeok", "genetic");
				redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);
				// Close the db 
				mysql_close($link);
			}
		}
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
