<?php  // $Id: viewbe.php,v 1.0 2012/06/26 19:40:00 Ana Maria Lozano de la Fuente Exp $

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
    add_to_log($course->id, "genetic", "view synonyms (syn)", "viewsyn.php?id=$cm->id", "$genetic->id");

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
	print_heading(get_string('showsyn', 'genetic'), 'center',2);	

	
	// Print Tabs
	$SESSION->genetic->current_tab = 'showsyn';
	include('tabs.php');
	
	
	// Print the main part of the page	
	
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/de.png\"> ".$strde."</B></NOBR>&nbsp;</TD></TR>";
	//Show a table with departments
	$table->head  = array ($strname, $straction);
	$table->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="de";
	$query = genetic_show_synonyms($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idsyn = $row['id'];
		$name = $row['name'];
		//$link = $row['link'];
		$action = "<A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
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
	
	$table2->head  = array ($strname, $straction);
	$table2->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="es";
	$query2 = genetic_show_synonyms($lang);
	$result2 = mysql_query($query2,$link);
	$nok2 = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result2)) {
	
		$idsyn = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
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
	
	$table3->head  = array ($strname, $straction);
	$table3->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="fr";
	$query = genetic_show_synonyms($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idsyn = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
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
	
	$table4->head  = array ($strname, $straction);
	$table4->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="en";
	$query2 = genetic_show_synonyms($lang);
	$result2 = mysql_query($query2,$link);
	$nok2 = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result2)) {
	
		$idsyn = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editsynonym_form.php?id={$cm->id}&idsyn=$idsyn&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
        $table4->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table4);
    echo "<BR />";
    echo "<BR />";
	$origen="add_synonym";
	// Check if the user has permission in this activity to add synonyms
	if (has_capability('mod/genetic:manageentries', $context)) {
		// Form to add synonyms
		echo "<TABLE WIDTH=\"100%\">";
		echo "<FORM NAME=\"addsynform\" METHOD=\"post\" ACTION=\"editsynonym_form.php?id=$id&origen=$origen\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("buttonaddsyn", "genetic")."\" NAME=\"buttonadd\" />&nbsp;&nbsp;";
		//echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
	}
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>