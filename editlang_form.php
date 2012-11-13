<?php  // $Id: editbe_form.php,v 1.0 2012/06/13 21:40:00 Ana María Lozano de la Fuente Exp $
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

	// File with a form for add or edit Departments.

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	 require_once("lib.php");
	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Parameters to manage a department
	$idlang = optional_param('idlang',0,PARAM_INT);
	$action = optional_param('action','',PARAM_ALPHA);
	
	
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
    add_to_log($course->id, "genetic", "edit departments", "editbe_form.php?id=$cm->id&idbe=$idbe&action=$action", "$genetic->id");
	
	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	// Check if the user has permission in this activity
	if (! has_capability('mod/genetic:manageentries', $context)) {
		error('Sin permisos');
	}

	else {
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");	
    $strlang  = get_string("lang", "genetic");
	$strchooselang= get_string("chooselang", "genetic");
	
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
	
	
	// Check the URL parameter (action: add, edit or delete)
	
	// Add
	if ($action == "") {	
		// Print Title
		print_heading(get_string('addlang', 'genetic'), 'center',2);
							
		// Print the main part of the page	
	
	
			$isolang = genetic_array_isolang();
		
			$numlang=count ($isolang);
			
	
			// Choose languages for the dictionary
	
			print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
			echo "<TABLE ALIGN=\"center\" ><FORM NAME=\"searchcardform\" METHOD=\"post\" ACTION=\"editlang.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
	
			echo "<TR><TD></TD><TD></TD>&nbsp;&nbsp;&nbsp;&nbsp;<TD>&nbsp;&nbsp;<font color=\"black\">".$strchooselang." </font></TD></TR><BR>&nbsp;&nbsp;&nbsp;&nbsp;";
			
			for($i=0;$i<$numlang;$i++){
					
					$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
				//search id language
					$query = genetic_search_lang($isolang[$i]);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					$row = mysql_fetch_array($result);
					$idlang = $row['id'];
			
				//check if the language is already in the dictionary
					$query = genetic_exist_lang_dic($idlang,$genetic->id);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					
					if($n!=0){
					echo "<TR><TD></TD><TD></TD>&nbsp;&nbsp;&nbsp;&nbsp;<TD><INPUT TYPE=\"checkbox\" NAME=\"langtype[]\" VALUE=\"".$isolang[$i]."\" checked disabled>&nbsp;<img src=\"images/".$isolang[$i].".png\"'>".$str = get_string($isolang[$i], "genetic")."&nbsp;</TD></TR><BR>";
					}
					else{
					echo "<TR><TD></TD><TD></TD>&nbsp;&nbsp;&nbsp;&nbsp;<TD><INPUT TYPE=\"checkbox\" NAME=\"langtype[]\" VALUE=\"".$isolang[$i]."\">&nbsp;<img src=\"images/".$isolang[$i].".png\"'>".$str = get_string($isolang[$i], "genetic")."&nbsp;</TD></TR><BR>";
					}
			}
			
			// Close the db    
			mysql_close($link);
			echo "<TR><TD></TD><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;</TD>";
			echo "<TD><INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewlang.php?id=$id'\"/></TD></TR><BR>";
			echo "</FORM></TABLE>";
			print_box_end($return=false);
			
			
	
	
	}
	
	
	
	// Delete
	else if ($action == "delete") {
		
		// Print Title
		print_heading(get_string('delete', 'genetic'), 'center',2);
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		//Search the name of the language
		$query =genetic_search_lang_name($idlang);
		$result = mysql_query($query, $link);
		$row = mysql_fetch_array($result);
		$n = mysql_num_rows($result);
		$language = $row['language'];
		
		// Check if the language is being used in any genetic card in this dictionary
		
		$query =genetic_use_lang($language,$genetic->id);
		$result = mysql_query($query, $link);
		$row = mysql_fetch_array($result);
		$n = mysql_num_rows($result);
		
		if($n != 0) {
			$redirectmsg = get_string("deletelangused", "genetic");
			redirect($url="viewlang.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}

		else {
		
		
		
		// Form to delete a language
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deletelangform\" METHOD=\"post\" ACTION=\"editlang.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idlang\" VALUE=\"".$idlang."\">";
		echo "<TR><TD>".$strlang." :&nbsp;<img src=\"images/".$language.".png\"'>&nbsp;&nbsp;<font color=\"red\">".$language."</font></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deletelangsure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewlang.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
		}
		// Close the db    
		mysql_close($link);
		
		
	}
	
	} // Close caps ELSE
	// Finish the page
		include('banner_foot.html');
		print_footer($course);
	

?>