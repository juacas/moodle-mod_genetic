<?php  // $Id: image_form.php,v 1.0 2012/06/12 16:40:00 Ana María Lozano de la Fuente Exp $
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
	$idvi = optional_param('idvi',0,PARAM_INT);
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
    add_to_log($course->id, "genetic", "edit videos", "editvideo.php?id=$cm->id&idvi=$idvi&action=$action", "$genetic->id");
	
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
    $strname  = get_string("name", "genetic");
	$strpievideo = get_string("pievideo", "genetic");
	$strpievideo_de = get_string("pievideo_de", "genetic");
	$strpievideo_fr = get_string("pievideo_fr", "genetic");
	$strpievideo_en = get_string("pievideo_en", "genetic");
	$strvideo = get_string("selvideo", "genetic");
	$strsrcvideo = get_string("src_video", "genetic");
	$strtitlevideo= get_string("title_video", "genetic");
	$straudiovideo_de= get_string("audio_video", "genetic");
	
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
		print_heading(get_string('addvi', 'genetic'), 'center',2);
		
		print_container(get_string("requiredfields", "genetic"), $clearfix=false, $classes='generalbox boxaligncenter boxwidthwide', '', $return=false);	
							
		// Form to add a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"addviform\" METHOD=\"post\" ACTION=\"editvi.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		
		
			echo"<div id=\"employees3\" NAME=\"employees4\">";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strvideo."&nbsp;</TD><TD><dd><div id=\"adjuntos\"><INPUT TYPE=\"file\" NAME=\"video\" SIZE=\"63\"accept=\"avi|wav|wmv\"></div></dd></TD></TR>";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$straudiovideo_de."*&nbsp;</NOBR></TD>";
			
			echo "<TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<SELECT NAME=\"lang\">";
			echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			$isolang = genetic_array_isolang();
			for ($i=0; $i<count($isolang); $i++) {
			echo "<OPTION VALUE=\"".$isolang[$i]."\">".$str = get_string($isolang[$i], "genetic");
			}
			echo "</SELECT></TD></TR>";
			
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strpievideo."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"pievideo\" SIZE=\"63\"></div></dd></TD></TR>";

			
			
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strpievideo_de."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"pievideo_de\" SIZE=\"63\"></div></dd></TD></TR>";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strpievideo_fr."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"pievideo_fr\" SIZE=\"63\"></div></dd></TD></TR>";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strpievideo_en."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"pievideo_en\" SIZE=\"63\"></div></dd></TD></TR>";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strsrcvideo."&nbsp;</TD><TD><dd><div id=\"adjuntos3\"><INPUT TYPE=\"text\" NAME=\"srcvideo\" SIZE=\"63\"></div></dd></TD></TR>";
			//echo "<TD align=\"left\"><dt><a href=\"#\" onClick=\"addCampo()\">Subir otro video</a></dt></TD>";
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
		print_heading(get_string('editvi', 'genetic'), 'center',2);

		// Get the card type fields from the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		$query = genetic_choose_vi($idvi);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['filevideo'];
		$name2 = $row['titlevideo_es'];
		$name_de = $row ['titlevideo_de'];
		$name_fr = $row ['titlevideo_fr'];
		$name_en = $row ['titlevideo_en'];
		$name3 = $row['srcvideo'];
		$name4= $row['audiolang'];
		$prename=$row['filevideo'];
		// Close the db    
		mysql_close($link);
				
		// Form to edit a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editviform\" METHOD=\"post\" ACTION=\"editvi.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idvi\" VALUE=\"".$idvi."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"prename\" VALUE=\"".$prename."\">";
		echo "<TR><TD>".$strtitlevideo."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$name."\"></TD></TR>";
		echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$straudiovideo_de."&nbsp;</NOBR></TD>";
			
			echo "<TD><SELECT NAME=\"lang\">";			
					
				echo "<OPTION VALUE=\"".$name4."\">".$name4;
				echo "<OPTION VALUE=\"0\">";
				echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			$isolang = genetic_array_isolang();
			for ($i=0; $i<count($isolang); $i++) {
			echo "<OPTION VALUE=\"".$isolang[$i]."\">".$str = get_string($isolang[$i], "genetic");
			}
				
			echo "</SELECT>";
			
		echo "<TR><TD>".$strpievideo."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name2\" SIZE=\"80\" VALUE=\"".$name2."\"></TD></TR>";
		echo "<TR><TD>".$strpievideo_de."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name_de\" SIZE=\"80\" VALUE=\"".$name_de."\"></TD></TR>";
		echo "<TR><TD>".$strpievideo_fr."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name_fr\" SIZE=\"80\" VALUE=\"".$name_fr."\"></TD></TR>";
		echo "<TR><TD>".$strpievideo_en."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name_en\" SIZE=\"80\" VALUE=\"".$name_en."\"></TD></TR>";
		echo "<TR><TD>".$strsrcvideo."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name3\" SIZE=\"80\" VALUE=\"".$name3."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewvi.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Delete
	else if ($action == "delete") {
	
		// Print Title
		print_heading(get_string('deletevi', 'genetic'), 'center',2);
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		// Check if the video is being used in any genetic card.
		$query = genetic_use_vi($idvi);
		$result = mysql_query($query, $link);
		$n = mysql_num_rows($result);
		if($n != 0) {
			$redirectmsg = get_string("deleteviused", "genetic");
			redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}

		else {
		// Get the image fields from the database
		$query = genetic_choose_vi($idvi);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['filevideo'];
		// Close the db    
		mysql_close($link);
		
		// Form to delete a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deleteviform\" METHOD=\"post\" ACTION=\"editvi.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idvi\" VALUE=\"".$idvi."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"name\" VALUE=\"".$name."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deletevisure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewvi.php?id=$id'\"/>";
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