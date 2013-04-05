<?php  // $Id: editbe.php,v 1.0 2012/06/14 10:45:00 Ana Mar�a Lozano de la Fuente Exp $
/*********************************************************************************

* This file is part of Genetic.

* Genetic is a terminological dictionary developed at the EdUVAlab e-Learning laboratory (University of Valladolid)

* Designed and directed by the ITAST group (http://www.eduvalab.uva.es/contact)

* Implemented by Ana Mar�a Lozano de la Fuente, using the previous software called Terminology, implemented by Irene Fern�ndez Ram�rez (2010)

 

* @ copyright (C) 2012 ITAST group

* @ author:  Ana Mar�a Lozano de la Fuente, Irene Fern�ndez Ram�rez, Mar�a Jes�s Verd� P�rez, Juan Pablo de Castro Fern�ndez, Luisa M. Regueras Santos,  Elena Verd� P�rez and Mar�a �ngeles P�rez Ju�rez

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
    require_once('echo_hidden_form.php');

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

    // parameters (hidden) used to fill in the add_card form with the data the user entered previously
    $originpage = optional_param('originpage',null, PARAM_TEXT);
    $idheader = optional_param('idheader',0,PARAM_INT);
    $bes = optional_param('be', 0, PARAM_INT);
    $ty = optional_param('ty', 0, PARAM_INT);
    $domsubdom = optional_param('domsubdom', 0, PARAM_INT);
    $authors = optional_param('author', 0, PARAM_INT);
    $imagen = optional_param('prevformimagen', 0, PARAM_INT);
    //	$isolang = optional_param('isolang', null, PARAM_TEXT);
    
     // parameter depending on the language
    
    //take the ids of the languages of the dictionary
    $query=genetic_id_lang($genetic->id);
    // Connect to the database
    $link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
    $resultlang = mysql_query($query,$link);
    while($langrow=mysql_fetch_array($resultlang))
    {
    	$idlanguage=$langrow['genetic_lang_id'];
    	$isolang[$idlanguage] = optional_param('isolang'.$idlanguage, null, PARAM_TEXT);
    	$term[$idlanguage] = optional_param('term'.$idlanguage, null, PARAM_TEXT);
    	$gramcat[$idlanguage] = optional_param('gramcat'.$idlanguage, null, PARAM_TEXT);
    	$weight_type[$idlanguage] = optional_param('weight_type'.$idlanguage, null, PARAM_TEXT);
    	$definition[$idlanguage] = optional_param('definition'.$idlanguage, null, PARAM_TEXT);
    	$formcontext[$idlanguage] = optional_param('context'.$idlanguage, null, PARAM_TEXT);
    	$expression[$idlanguage] = optional_param('expression'.$idlanguage, null, PARAM_TEXT);
    	$notes[$idlanguage] = optional_param('notes'.$idlanguage, null, PARAM_TEXT);
    	$sourceterm[$idlanguage] = optional_param('sourceterm'.$idlanguage, null, PARAM_TEXT);
    	$sourcedefinition[$idlanguage] = optional_param('sourcedefinition'.$idlanguage, null, PARAM_TEXT);
    	$sourcecontext[$idlanguage] = optional_param('sourcecontext'.$idlanguage, null, PARAM_TEXT);
    	$sourceexpression[$idlanguage] = optional_param('sourceexpression'.$idlanguage, null, PARAM_TEXT);
    	$sourcerv[$idlanguage] = optional_param('sourcerv'.$idlanguage, null, PARAM_TEXT);
    	$sourcenotes[$idlanguage] = optional_param('sourcenotes'.$idlanguage, null, PARAM_TEXT);
    
    	$numfieldsremission[$idlanguage] = optional_param('numfieldsremission'.$idlanguage,0,PARAM_INT);
    	$j=0;
    	for($i=1;$i<=$numfieldsremission[$idlanguage];$i++){
    		if(optional_param('remission_'.$idlanguage.'_'.$i)!=null){
    			$remission[$idlanguage][$j]=optional_param('remission_'.$idlanguage.'_'.$i);
    			$rem_type[$idlanguage][$j]=optional_param('remtype_'.$idlanguage.'_'.$i);
    			$j++;
    		}
    			
    	}
    		
    		
    	$video[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
    	$audio[$idlanguage] = optional_param('audio'.$idlanguage, null, PARAM_INT);
    }
    // end of the hidden parameters
        
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
			// Close the db
			mysql_close($link);
			
			if($origen=="add_be"){
				$redirectmsg = get_string("emptyfield", "genetic");
				redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);
				// Close the db
			}else{
				echo get_string("emptyfield", "genetic");
				echo_hidden_form($genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$video,$originpage);
			}
			// Finish the page
			print_footer($course);
		}	
		else {
			
			// Check if that name already exists in the database
			$query=genetic_checkname_be($name);
			$result=mysql_query($query,$link);
			$nameexist = mysql_affected_rows($link);
			if($nameexist==0){ 
														
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
						echo get_string("insertbenok", "genetic");
						echo_hidden_form($genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$video,$originpage);
						// Close the db    
						mysql_close($link);
						// Finish the page
						print_footer($course);
					}				
				echo get_string("insertbeok", "genetic");
				echo_hidden_form($genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$video,$originpage);
				}
				// Close the db    
				mysql_close($link);
				// Finish the page
				print_footer($course);
			} // end action add
			
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
			}else{
				if(($origen=="add_be")||($action == "edit")){
						$redirectmsg = get_string("nameexists", "genetic");
						redirect($url="viewbe.php?id={$cm->id}", $redirectmsg, $delay=-1);
						// Close the db
						mysql_close($link);
					}else{
						echo get_string("nameexists", "genetic");
						echo_hidden_form($genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$video,$originpage);
						mysql_close($link);
					}
						
			}
		}
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
