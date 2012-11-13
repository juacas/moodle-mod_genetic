<?php  // $Id: search_form.php,v 1.0 2012/06/02 13:11:00 Ana María Lozano de la Fuente Exp $
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

	// File with a form for searching genetic cards

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
    require_once("lib.php");
	require_once("selectsubdomains.php");
	
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
    add_to_log($course->id, "genetic", "search cards", "search_form.php?id=$cm->id", "$genetic->id");

	
	// Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");	
	$strauthor = get_string("searchauthor", "genetic");
	$strdom = get_string("searchdom", "genetic");
	$strlanguage = get_string("searchlanguage", "genetic");
	$strterm = get_string("searchterm", "genetic");
	$strgramcat = get_string("gramcat", "genetic");
	$strtype = get_string("searchproyect", "genetic");
	
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

	
	// Print the page header
    print_header_simple(format_string($genetic->name), "", $navigation, "", "", true,
                  update_module_button($cm->id, $course->id, $strgenetic), navmenu($course, $cm));

				  
    // Print Title
	print_heading(get_string('searchcard', 'genetic'), 'center',2);
	
	//Include tabs
	
	// Print the tabs
	$SESSION->genetic->current_tab = 'searchcard';
	include('tabs.php');
	
	// Print the main part of the page

	// Choose kind of search
	echo "<BR />".$str = get_string("seltypesearch", "genetic");
	print_box_start($classes='generalbox boxaligncenter boxwidthwide');	
	echo "<TABLE ALIGN=\"center\"><FORM NAME=\"searchcardform\" METHOD=\"post\" ACTION=\"search.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
	
	// By term
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"term\">&nbsp;".$strterm."&nbsp;</TD>";
	echo "<TD><INPUT TYPE=\"text\" NAME=\"term\" SIZE=\"80\"></TD></TR>";
	
	// By author
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"author\">&nbsp;".$strauthor."&nbsp;</TD>";
	echo "<TD><INPUT TYPE=\"text\" NAME=\"author\" SIZE=\"80\"></TD></TR>";
	
	// By proyect
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"proyects\">&nbsp;".$strtype."&nbsp;</TD>";
	echo "<TD><SELECT NAME=\"proyect\">";
		echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
		// Connect to the database and get domain information
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		 $query2=genetic_show_types();
		 $result2 = mysql_query($query2,$link);
		while ($tyrow = mysql_fetch_array($result2)) {
			$tyid=$tyrow['id'];
			$tyname = $tyrow['name'];
			echo "<OPTION VALUE=\"".$tyid."\">".$tyname;
		}
	echo "</SELECT></TD></TR>";
	
	
	
	
	
	// By language
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"langs\">&nbsp;".$strlanguage."&nbsp;</TD>";
	echo "<TD><SELECT NAME=\"lang\">";
		echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
		$isolang = genetic_array_isolang();
		for ($i=0; $i<count($isolang); $i++) {
			echo "<OPTION VALUE=\"".$isolang[$i]."\">".$str = get_string($isolang[$i], "genetic");
		}
	echo "</SELECT></TD></TR>";
	
	// By gramatic category
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"gramcats\">&nbsp;".$strgramcat."&nbsp;</TD>";
	echo "<TD><SELECT NAME=\"gramcat\">";
		echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
		$gramcat = genetic_array_gramcat();
		for ($i=0; $i<count($gramcat); $i++) {
			echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
		}
	echo "</SELECT></TD></TR>";	

	// By domain
	echo "<TR><TD><INPUT TYPE=\"radio\" NAME=\"search\" VALUE=\"doms\">&nbsp;".$strdom."&nbsp;</TD>";
	/*
	echo "<TD><SELECT NAME=\"dom\">";
		echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
		// Connect to the database and get domain information
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		$query = genetic_show_subdomains();
		$result = mysql_query($query,$link);
		while ($domrow = mysql_fetch_array($result)) {
			$domid = $domrow['id'];
			$domname = $domrow['name'];
			echo "<OPTION VALUE=\"".$domid."\">".$domname;
		}
	echo "</SELECT></TD></TR>";
	*/
	
	echo "<TABLE align=\"center\">";
			genetic_select_subdomains4($nivel=0);
	echo"</TABLE>";
	echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
	echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("search", "genetic")."\" NAME=\"buttonsearch\" />&nbsp;&nbsp;";
	echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
	echo "</TD></TR></FORM></TABLE>";
    print_box_end($return=false);
	// Close the db    
	mysql_close($link);
		
// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>