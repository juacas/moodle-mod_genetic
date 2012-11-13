<?php  // $Id: viewdom.php,v 1.0 2012/06/05 19:40:00 Ana María Lozano de la Fuente Exp $
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

	// This file shows subdomains and give options to add, edit or delete them

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	//---añadir el archivo donde se encuentra la funcion visualizar subdominios
	require_once("arbol_sub2.php");
	

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
    add_to_log($course->id, "genetic", "view domains/subdomains", "viewdom.php?id=$cm->id", "$genetic->id");

	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);

	
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	
	$striconedit = get_string("edit", "genetic");
	$stricondelete = get_string("delete", "genetic");
	
    $straction  = get_string("action", "genetic");	
    $strcat  = get_string("category", "genetic");	
    //$strname  = get_string("name", "genetic");
    $strdom  = get_string("dom", "genetic");
    $strsubdom  = get_string("subdom", "genetic");
	$strbelongto = get_string("belongto", "genetic");
	$strsubdomview = get_string("subdomview", "genetic");
	$strlinksubd = get_string("linksubd", "genetic");
	
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
	print_heading(get_string('showsubdoms', 'genetic'), 'center',2);	

	
	// Print the tabs
	$SESSION->genetic->current_tab = 'showdom';
	include('tabs.php');
	
	
	// Print the main part of the page
	
	//Show table 1: domains
	$tabledom->head  = array ($strdom, $straction);
	$tabledom->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	//---añadido----comprobar si hay subdominios
	$query = genetic_dom_null();
	$result = mysql_query($query,$link);
	$n = mysql_num_rows($result);
	//echo "<B>Numero se subdominios "  .$n. "</B> " ;
	if($n!=0){
	echo"<TABLE align=\"center\"><TR><TD>";
	echo '<B>'.$strsubdomview.'</B>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;'.$strlinksubd. '</TD></TR>';
	echo"</TABLE>";
	echo"<BR>";
	echo"<TABLE align=\"center\"><TR><TD>";
	//echo"<TR>";
	$sql =genetic_subdominios2($nivel=0);
	//echo"</TR>";
	echo"</TABLE>";
	echo"<BR>";
	echo"<BR>";
	
	}
	
	
	//MOSTRAR LOS DIFERENTES SUBDOMINIOS Y SUS ACCIONES ADD EDIT DELETE
	;
	//Show table 2: subdomains
	$tablesubdom->head  = array ($strsubdom, $strbelongto, $straction);
	$tablesubdom->align = array ("LEFT", "CENTER", "RIGHT");
	
	//Get subdomains from the database
	$query = genetic_show_subdomains();
	$result = mysql_query($query,$link);
	while ($domrow = mysql_fetch_array($result)) {
		$idsubdom = $domrow['id'];
		$namesubdom = $domrow['name'];
		$idbelongto = $domrow['iddom'];
		//$query2 = terminology_choose_domain($idbelongto);  ya no es valida esta funcion aqui desaparece tabla dominios
		$query2 = genetic_choose_subdomain($idbelongto);
		$result2 = mysql_query($query2, $link);
		$row = mysql_fetch_array($result2);
		$idbelongto2=$row['id'];
		$namebelongto = $row['name'];
		$daction = "<A HREF=\"editdom_form.php?id={$cm->id}&iddom=$idsubdom&action=edit&cat=subdomain\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
		<A HREF=\"editdom_form.php?id={$cm->id}&iddom=$idsubdom&action=delete&cat=subdomain\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ( $namesubdom, $namebelongto, $daction);
        $tablesubdom->data[] = $linedata;
	}
	
	
	// Close the db    
	mysql_close($link);

	
    echo "<BR />";
    print_table($tablesubdom);
    echo "<BR />";
	$origen="add_dom";

	// Check if the user has permission in this activity to add subdomains
	if (has_capability('mod/genetic:manageentries', $context)) {
		// Form to add a subdomain
		echo "<TABLE WIDTH=\"100%\">";
		echo "<FORM NAME=\"adddomform\" METHOD=\"post\" ACTION=\"editdom_form.php?id=$id&cat=subdomain&origen=$origen\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("buttonaddsubdom", "genetic")."\" NAME=\"buttonadd\" />&nbsp;&nbsp;";
		//echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
	}
	
	

	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>