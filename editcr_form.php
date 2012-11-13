<?php  // $Id: editty_form.php,v 1.0 2012/06/12 16:40:00 Ana María Lozano de la Fuente Exp $

	// File with a form for add, edit or delete Card types.
	
	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Necessary parameters to add/edit/delete types
	$idcr = optional_param('idcr',0,PARAM_INT);
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
    add_to_log($course->id, "genetic", "edit related terms", "editcr.php?id=$cm->id&idcr=$idcr&action=$action", "$genetic->id");
	
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
	
	$strlink = get_string("link", "genetic");
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
		print_heading(get_string('addcr', 'genetic'), 'center',2);
							
		// Form to add a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"addcrform\" METHOD=\"post\" ACTION=\"editcr.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		
		//SINONIMOS
			
			
			echo "<TR><TD COLSPAN=\"4\"><BR></TD></TR>";
			
			echo"<div id=\"employees3\" NAME=\"employees4\">";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strname."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"63\"></div></dd></TD></TR>";
			//echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strlink."&nbsp;</TD><TD><dd><div id=\"adjuntos3\"><INPUT TYPE=\"text\" NAME=\"enlace\" SIZE=\"63\"></div></dd></TD></TR>";
				echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strlang."&nbsp;&nbsp;&nbsp;</TD>";
				//Count the languages available in the dictionary 
				$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
				$query = genetic_count_lang($genetic->id);
				$resultlang = mysql_query($query,$link);
		
				$numlang = mysql_affected_rows($link);
				
				echo "<TD><SELECT NAME=\"language\">";
				echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
				while($langrow = mysql_fetch_array($resultlang)){
			
				//Search which languages the dictionary contains
			
					$idlang = $langrow['genetic_lang_id'];
					$query2 =genetic_search_lang_name($idlang);
					$result2 = mysql_query($query2,$link);
					$n2 = mysql_num_rows($result2);
					$row2 = mysql_fetch_array($result2);
					$namelang=$row2['language'];	
					
					echo "<OPTION VALUE=\"".$namelang."\">".$str = get_string($namelang, "genetic");
				
				
				}
				echo "</SELECT></TD></TR>";
			
			
			//echo "<TD align=\"left\"><dt><a href=\"#\" onClick=\"addCampo()\">+ sinonimo</a></dt></TD>";
			   
			echo"</div>";
			
			//$array=synonyms;
			//$tmp = serialize($array); 
			//$tmp = urlencode($tmp); 
			//FIN
			
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
		print_heading(get_string('editcr', 'genetic'), 'center',2);

		// Get the card type fields from the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		$query = genetic_choose_cr($idcr);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['name'];
		
		// Close the db    
		mysql_close($link);
				
		// Form to edit a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editcrform\" METHOD=\"post\" ACTION=\"editcr.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idcr\" VALUE=\"".$idcr."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$name."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewcr.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Delete
	else if ($action == "delete") {
	
		// Print Title
		print_heading(get_string('deletecr', 'genetic'), 'center',2);
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		// Check if the card type (ty) is being used in any genetic card.
		$query = genetic_use_cr($idcr);
		$result = mysql_query($query, $link);
		$n = mysql_num_rows($result);
		if($n != 0) {
			$redirectmsg = get_string("deletecrused", "genetic");
			redirect($url="viewcr.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}
		
		else {
		// Get the related terms from the database
		
		$query = genetic_choose_cr($idcr);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$idcr=$row['id'];
		$name = $row['name'];
		// Close the db    
		mysql_close($link);
		
	
		
		// Form to delete a related term
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deletecrform\" METHOD=\"post\" ACTION=\"editcr.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idcr\" VALUE=\"".$idcr."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deletecrsure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewcr.php?id=$id'\"/>";
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