<?php  // $Id: viewty.php,v 1.0 2012/106/26 19:40:00 Ana María Lozano de la Fuente Exp $

	// This file shows Card types and give options to add, edit or delete them

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
    add_to_log($course->id, "genetic", "view related terms", "viewrt.php?id=$cm->id", "$genetic->id");

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
	
	
    // Print Title
	print_heading(get_string('showrt', 'genetic'), 'center',2);	

	
	// Print Tabs
	$SESSION->genetic->current_tab = 'showrt';
	include('tabs.php');
	
	
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/de.png\"> ".$strde."</B></NOBR>&nbsp;</TD></TR>";
	
	$table->head  = array ($strname, $straction);
	$table->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="de";
	$query = genetic_show_related($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idrt = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
        $table->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table);
    echo "<BR />";
    echo "<BR />";
	
	//OTROS IDIOMAS 
	//ESPAÑOL
	
echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/es.png\"> ".$stres."</B></NOBR>&nbsp;</TD></TR>";
	
	$table2->head  = array ($strname, $straction);
	$table2->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="es";
	$query = genetic_show_related($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idrt = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
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
	
	echo "<TR><TD ALIGN=\"left\"><NOBR><B>&nbsp;&nbsp;&nbsp;&nbsp;<IMG SRC=\"images/fr.png\"> ".$strfr."</B></NOBR>&nbsp;</TD></TR>";
	
	$table3->head  = array ($strname, $straction);
	$table3->align = array ("LEFT", "CENTER");
	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	// Get the synonyms fields
	$lang="fr";
	$query = genetic_show_related($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idrt = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
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
	$query = genetic_show_related($lang);
	$result = mysql_query($query,$link);
	$nok = mysql_affected_rows($link);			
	
	while ($row = mysql_fetch_array($result)) {
	
		$idrt = $row['id'];
		$name = $row['name'];
		
		$action = "<A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=edit\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;
				   <A HREF=\"editrt_form.php?id={$cm->id}&idrt=$idrt&action=delete\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A>";
				
		$linedata = array ($name, $action);
        $table4->data[] = $linedata;
	}
	
	// Close the db    
	mysql_close($link);
	
    echo "<BR />";
    print_table($table4);
    echo "<BR />";
    echo "<BR />";
	
	// Check if the user has permission in this activity to add card types
	if (has_capability('mod/genetic:manageentries', $context)) {
		// Form to add a Card type
		echo "<TABLE WIDTH=\"100%\">";
		echo "<FORM NAME=\"addrtform\" METHOD=\"post\" ACTION=\"editrt_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("buttonaddrt", "genetic")."\" NAME=\"buttonadd\" />&nbsp;&nbsp;";
		//echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
	}
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>