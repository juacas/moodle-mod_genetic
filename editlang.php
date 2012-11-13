<?php  // $Id: search.php,v 2.0 2012/06/25 10:45:00 Ana María Lozano de la Fuente Exp $
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

	// File for searching genetic cards by a determined key
	
	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");
	

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	
	// Get the form variables
	$action = optional_param('action','',PARAM_ALPHA);
	$langtype = optional_param('langtype','null',PARAM_TEXT);
	
	
	$idlang = optional_param('idlang',0,PARAM_INT);
	//$term = optional_param('term', '', PARAM_TEXT);
	
	
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
    add_to_log($course->id, "genetic", "add language", "editlang.php?id=$cm->id", "$genetic->id");    
   
   
	//Get the strings wich are necessaries
    $strterminologies = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	
	$striconedit = get_string("edit", "genetic");
	$stricondelete = get_string("delete", "genetic");
	$strnodefined = get_string("nodefined", "genetic");
		

	//Get a short version for the name of the genetic
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
	$SESSION->genetic->current_tab = 'showlang';
	include('tabs.php');    
	
	// Print the main part of the page
	
	/**************
		DELETE
	*****************/
	 if ($action == "delete") {
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
			// delete the entries with this id_language
			$query =genetic_delete_lang_dic($idlang,$genetic->id);
			$result = mysql_query($query,$link);
			$nok = mysql_affected_rows($link);
		
		
		// Delete ok or not?
		if($nok == 0) {
			$redirectmsg = get_string("deletelangnok", "genetic");
			redirect($url="viewlang.php?id={$cm->id}", $redirectmsg, $delay=-1);			
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}
			$redirectmsg = get_string("deletelangok", "genetic")."<BR />";
			redirect($url="viewlang.php?id={$cm->id}", $redirectmsg, $delay=-1);
		// Close the db    
		mysql_close($link);
		// Finish the page
		print_footer($course);
		
		
		}
	
	
	else if($action == ""){
	/**************
	ADD LANGUAGES
	*****************/
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$isolang = genetic_array_isolang();
	$w=count($langtype);
	
	for ($z=0;$z<$w;$z++) {	
					
					//check if exist in genetic_lang			
					$query = genetic_exist_lang($langtype[$z]);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					
						if($n==0)	
						{
							//insert language in table
							$query = genetic_insert_lang($langtype[$z]);
							$result = mysql_query($query,$link);
							$n = mysql_num_rows($result);
							
						}
					
					//search id language
					$query = genetic_search_lang($langtype[$z]);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					$row = mysql_fetch_array($result);
					$idlang = $row['id'];
					
					
					//check if the language is already in the dictionary
					$query = genetic_exist_lang_dic($idlang,$genetic->id);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					
						if($n==0){
						
							//insert relation lang and dictionary
							$query = genetic_insert_lang2($genetic->id,$idlang);
							$result = mysql_query($query,$link);
							$n =  mysql_affected_rows($link);
					
								// There are results?
								if($n == 0) {
									print_box_start($classes='generalbox boxaligncenter boxwidthwide');
									$msg = get_string("noinsertlangdic", "genetic");
									echo $msg;
									print_box_end($return=false);
									echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
									
									$exito=0;	
								}
								else if($n!=0){
									print_box_start($classes='generalbox boxaligncenter boxwidthwide');
									$msg = get_string("insertlangok", "genetic");
									echo "".$str = get_string($langtype[$z], "genetic")."-".$msg;
									print_box_end($return=false);
								}
						
						
					
					
						}
						else{
									print_box_start($classes='generalbox boxaligncenter boxwidthwide');
									$msg = get_string("langdicexist", "genetic");
									echo"".$strlang. " ".$str = get_string($langtype[$z], "genetic")." ".$msg;
									print_box_end($return=false);
									//echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
									$exito=1;
						
						}
					
			
					
	} //End of first language
	
		
		
			echo "<CENTER><a href=\"viewlang.php?id=$id\">".get_string("viewlang", "genetic")."</A></CENTER>";	
			
			
		// Close the db    
		mysql_close($link);	
		// Finish the page
	include('banner_foot.html');
	print_footer($course);
	
	//-----------------------------------
	
	
		
}	

?>
