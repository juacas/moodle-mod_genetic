<?php  // $Id: viewau.php,v 1.0 2012/06/26 19:40:00 Ana Maria Lozano de la Fuente Exp $
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

	// This file shows Departaments and allow manage them(add new ones, edit or delete).

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	
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
    add_to_log($course->id, "genetic", "view audio", "viewau.php?id=$cm->id", "$genetic->id");

	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);

	
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");	
	$striconedit = get_string("edit", "genetic");
	$stricondelete = get_string("delete", "genetic");	
    $straction  = get_string("action", "genetic");
    $strname  = get_string("name", "genetic");
	$stres  = get_string("es", "genetic");
	$strfr  = get_string("fr", "genetic");
	$strde  = get_string("de", "genetic");
	$stren  = get_string("en", "genetic");
	$strsrc  = get_string("src", "genetic");
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

				  
    // Print Title
	print_heading(get_string('showau', 'genetic'), 'center',2);	

	
	// Print Tabs
	$SESSION->genetic->current_tab = 'showau';
	include('tabs.php');
	
	
	// Print the main part of the page	
	
	//Show a table with departments
	$table->head  = array ($strname,$strsrc, $straction);
	$table->align = array ("LEFT", "CENTER", "RIGHT");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the audio fields
	
	$querylang=genetic_id_lang($genetic->id);
	$resultlang = mysql_query($querylang,$link);
	while ($langrow = mysql_fetch_array($resultlang)){
		$idlang=$langrow['genetic_lang_id'];
		$queryisolang=genetic_get_isolang($idlang);
		$resultisolang = mysql_query($queryisolang,$link);
		$resultisolangrow=mysql_fetch_array($resultisolang);
		$lang=$resultisolangrow['language'];
		$query = genetic_show_au_lang($lang);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);
			
		if($nok==0){
			echo "<NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/".$lang.".png\"> ".$lang."</B></NOBR>&nbsp;&nbsp;&nbsp;&nbsp;";
			echo get_string('noaudiofound','genetic');
			echo "<BR />";
			echo "<BR />";
				
		}else{
			echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/".$lang.".png\"> ".$lang."</B></NOBR>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</TD></TR>";
				
			while ($row = mysql_fetch_array($result)) {
				$idau = $row['id'];
				$name = $row['fileaudio'];
				$sourceau = $row['srcaudio'];
				//$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				//<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;				<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>&nbsp;";
				$linedata = array ($name,$sourceau,$action);
				$table->data[] = $linedata;
				}
				echo "<BR />";
				print_table($table);
				echo "<BR />";
				echo "<BR />";
					
		}
		}
	
	/*
	$query = genetic_show_au($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);	
	
	
	while ($row = mysql_fetch_array($result)) {
	
		$idau = $row['id'];
		$name = $row['fileaudio'];
		$sourceau = $row['srcaudio'];
		//$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   //<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
		$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   ";		
		$linedata = array ($name,$sourceau,$action);
        $table->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table);
    echo "<BR />";
    echo "<BR />";
	
	
	//RESTO DE LOS IDIOMAS
	
	//ESPA�OL
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/es.png\"> ".$stres."</B></NOBR>&nbsp;</TD></TR>";
	
	$table2->head  = array ($strname, $strsrc, $straction);
	$table2->align = array ("LEFT", "CENTER", "RIGHT");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the audio fields
	$lang="es";
	$query2 = genetic_show_au($lang);
	$result2 = mysql_query($query2,$link);
	$nok2 = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result2)) {
	
		$idau = $row['id'];
		$name = $row['fileaudio'];
		$sourceau = $row['srcaudio'];
		//$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   //<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
		$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   ";		
		$linedata = array ($name, $sourceau, $action);
        $table2->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table2);
    echo "<BR />";
    echo "<BR />";
	
	//FRANCES
	
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/fr.png\">".$strfr."</B></NOBR>&nbsp;</TD></TR>";
	
	$table3->head  = array ($strname, $strsrc, $straction);
	$table3->align = array ("LEFT", "CENTER", "RIGHT");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the audio fields
	$lang="fr";
	$query = genetic_show_au($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idau = $row['id'];
		$name = $row['fileaudio'];
		$sourceau = $row['srcaudio'];
		//$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
			//	   <A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
		$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   ";		
		$linedata = array ($name,$sourceau, $action);
        $table3->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table3);
    echo "<BR />";
    echo "<BR />";
	
	//INGLES
	
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/en.png\"> ".$stren."</B></NOBR>&nbsp;</TD></TR>";
	
	$table4->head  = array ($strname,$strsrc, $straction);
	$table4->align = array ("LEFT", "CENTER", "RIGHT");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the audio fields
	$lang="en";
	$query2 = genetic_show_au($lang);
	$result2 = mysql_query($query2,$link);
	$nok2 = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result2)) {
	
		$idau = $row['id'];
		$name = $row['fileaudio'];
		$sourceau = $row['srcaudio'];
		//$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
			//	   <A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
		$action = "<A HREF=\"editau_form.php?id={$cm->id}&idau=$idau&name=$name&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   ";		
		$linedata = array ($name,$sourceau, $action);
        $table4->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table4);
    echo "<BR />";
    echo "<BR />";
	*/
	// Check if the user has permission in this activity to add audio
	/*if (has_capability('mod/genetic:manageentries', $context)) {
		// Form to add audio
		echo "<TABLE WIDTH=\"100%\">";
		echo "<FORM NAME=\"addauform\" METHOD=\"post\" ACTION=\"editau_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("buttonaddaudio", "genetic")."\" NAME=\"buttonadd\" />&nbsp;&nbsp;";
		//echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
	}*/
	
	// Finish the page
	// Close the db
	mysql_close($link);
	include('banner_foot.html');
    print_footer($course);

?>