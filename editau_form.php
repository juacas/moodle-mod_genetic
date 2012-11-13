<?php  // $Id: editau_form.php,v 1.0 2010/01/12 16:40:00 Irene Fernández Ramírez Exp $
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

	// File with a form for add, edit or delete Card types.
	
	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Necessary parameters to add/edit/delete types
	$idau = optional_param('idau',0,PARAM_INT);
	$name = optional_param('name',0,PARAM_TEXT);
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
    add_to_log($course->id, "genetic", "edit audio", "editau.php?id=$cm->id&idau=$idau&action=$action", "$genetic->id");
	
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
    $strcat  = get_string("category", "genetic");	
    $straudio  = get_string("addaudio", "genetic");
	$strterm = get_string("term", "genetic");
	$strsrc  = get_string("src", "genetic");
	$strmodau = get_string("modau", "genetic");
	$stradv = get_string("advaudio", "genetic");
	$strlang = get_string("lang", "genetic");
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
	
	
	// Check the URL parameters (action: add, edit, delete)
	
	// Add
	if ($action == "") {	
		// Print Title
		print_heading(get_string('addau', 'genetic'), 'center',2);
		//echo "<TR><TD ALIGN=\"right\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/Info.gif\"> ".$stradv."</TD></TR>";			
		// Form to add a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"addauform\" METHOD=\"post\" ACTION=\"editau.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
			
		echo "<TR><TD ><BR /></TD></TR>";
			echo"<div id=\"employees3\" NAME=\"employees4\">";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"center\">".$straudio."&nbsp;</TD><TD><dd><div id=\"adjuntos\"><INPUT TYPE=\"file\" NAME=\"audio\" SIZE=\"63\"></div></dd></TD></TR>";
			
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"center\">".$strlang."&nbsp;</TD><TD><SELECT NAME=\"lang\" ALIGN=\"right\">";
			echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			$isolang = genetic_array_isolang();
			for ($i=0; $i<count($isolang); $i++) {
				echo "<OPTION VALUE=\"".$isolang[$i]."\">".$str = get_string($isolang[$i], "genetic");
			}
			echo "</SELECT></TD></TR>";
		
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"center\">".$strsrc."&nbsp;</TD><TD><dd><div id=\"adjuntos3\"><INPUT TYPE=\"text\" NAME=\"srcau\" SIZE=\"63\"></div></dd></TD></TR>";
			echo"</div>";
			
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='addcard_form.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Edit
	else if ($action == "edit") {	
		// Print Title
		print_heading(get_string('editau', 'genetic'), 'center',2);

		// Get the card type fields from the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		$query = genetic_choose_au($idau);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$prename = $row['fileaudio'];
		$idcard= $row['idcard'];
		$name3 = $row ['srcaudio'];
		//get the language of the idcard
		$query = genetic_choose_audiolang($idcard);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$language = $row['isolang'];
		// Close the db    
		mysql_close($link);
				
		
		// Form to edit a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editauform\" METHOD=\"post\" ACTION=\"editau.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idau\" VALUE=\"".$idau."\">";
		//echo "<INPUT TYPE=\"hidden\" NAME=\"idcard\" VALUE=\"".$idcard."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"prename\" VALUE=\"".$prename."\">";
		echo "<TR><TD>".$strmodau."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$name."\"></TD></TR>";
		//modificar audio
		
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"center\">".$strlang."&nbsp;</TD><TD><SELECT NAME=\"lang\" ALIGN=\"right\">";
			
			echo "<OPTION VALUE=\"".$language."\">".$language;
			echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			$isolang = genetic_array_isolang();
			for ($i=0; $i<count($isolang); $i++) {
				echo "<OPTION VALUE=\"".$isolang[$i]."\">".$str = get_string($isolang[$i], "genetic");
			}
			echo "</SELECT></TD></TR>";
		
		echo "<TR><TD>".$strsrc."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name3\" SIZE=\"80\" VALUE=\"".$name3."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewau.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Delete
	else if ($action == "delete") {
	
		// Print Title
		print_heading(get_string('deleteau', 'genetic'), 'center',2);
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		// Check if the audio is being used in any genetic card.
		$name2=substr($name,0,-7);
		$query = genetic_use_au($name2);
		$result = mysql_query($query, $link);
		$n = mysql_num_rows($result);
		if($n != 0) {
			$redirectmsg = get_string("deleteauused", "genetic");
			redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}

		else {
		// Get the audio fields from the database
		$query = genetic_choose_au($idau);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['fileaudio'];
		$idcard = $row['idcard'];
		// Close the db    
		mysql_close($link);
		
		// Form to delete a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deleteauform\" METHOD=\"post\" ACTION=\"editau.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idau\" VALUE=\"".$idau."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idcard\" VALUE=\"".$idcard."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"name\" VALUE=\"".$name."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deleteausure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewau.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
		}
	}
	
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>