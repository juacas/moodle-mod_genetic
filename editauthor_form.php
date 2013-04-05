<?php  // $Id: editauthors_form.php,v 1.0 2012/06/13 21:40:00 Ana Mar�a Lozano de la Fuente Exp $
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

	// File with a form for add, edit or delete Authors.
	
	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Necessary parameters to add/edit/delete author
	$idauthor = optional_param('idauthor',0,PARAM_INT);
	$action = optional_param('action','',PARAM_ALPHA);
	$origen = optional_param('origen','',PARAM_TEXT);
	
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
	

    // parameters (hidden) used to fill in the addcard/editcard form with the data the user entered previously
    $bes = optional_param('be', 0, PARAM_INT);
    $ty = optional_param('ty', 0, PARAM_INT);
    $originpage= optional_param('originpage',null,PARAM_TEXT);
    $idheader= optional_param('idheader', null, PARAM_INT);
    $domsubdom = optional_param('domsubdom', 0, PARAM_INT);
    $authors = optional_param('author', 0, PARAM_INT);
    $datecreated = optional_param('datecreated', 0, PARAM_INT);
    $imagen = optional_param('imagen', 0, PARAM_INT);
    
    // Connect to the database
    $link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
    
    // parameters depending on the language
    
    //take the ids of the languages of the dictionary
    $query=genetic_id_lang($genetic->id);
    $resultlang = mysql_query($query,$link);
    while($langrow=mysql_fetch_array($resultlang)){
    
    	$idlanguage=$langrow['genetic_lang_id'];
    	$isolang[$idlanguage] = optional_param('isolang'.$idlanguage, null, PARAM_TEXT);
    	$term[$idlanguage] = optional_param('term'.$idlanguage, null, PARAM_TEXT);
    	$gramcat[$idlanguage] = optional_param('gramcat'.$idlanguage, null, PARAM_TEXT);
    	$weight_type[$idlanguage] = optional_param('weight_type'.$idlanguage, null, PARAM_TEXT);
    	$definition[$idlanguage] = optional_param('definition'.$idlanguage, null, PARAM_TEXT);
    	$formcontext[$idlanguage] = optional_param('context'.$idlanguage, null, PARAM_TEXT);
    	$expression[$idlanguage] = optional_param('expression'.$idlanguage, null, PARAM_TEXT);
    	$notes[$idlanguage] = optional_param('notes'.$idlanguage, null, PARAM_TEXT);
    	$sourceterm[$idlanguage] = optional_param('sourceterm'.$idlanguage, null, PARAM_TEXT);
    	$sourcedefinition[$idlanguage] = optional_param('sourcedefinition'.$idlanguage, null, PARAM_TEXT);
    	$sourcecontext[$idlanguage] = optional_param('sourcecontext'.$idlanguage, null, PARAM_TEXT);
    	$sourceexpression[$idlanguage] = optional_param('sourceexpression'.$idlanguage, null, PARAM_TEXT);
    	$sourcerv[$idlanguage] = optional_param('sourcerv'.$idlanguage, null, PARAM_TEXT);
    	$sourcenotes[$idlanguage] = optional_param('sourcenotes'.$idlanguage, null, PARAM_TEXT);
    	$synonyms[$idlanguage] = optional_param('synonyms'.$idlanguage, 0, PARAM_INT);
    	$video[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
    	$relatedterms[$idlanguage] = optional_param('relatedterms'.$idlanguage, 0, PARAM_INT);
    	$audio[$idlanguage] = optional_param('audio'.$idlanguage, 0, PARAM_INT);
    	$numfieldsremission[$idlanguage] = optional_param('numfieldsremission'.$idlanguage,0,PARAM_INT);
    	$j=0;
    	for($i=1;$i<=$numfieldsremission[$idlanguage];$i++){
    		if(optional_param('remission_'.$idlanguage.'_'.$i)!=null){
    			$remission[$idlanguage][$j]=optional_param('remission_'.$idlanguage.'_'.$i);
    			$rem_type[$idlanguage][$j]=optional_param('remtype_'.$idlanguage.'_'.$i);
    			$j++;
    		}
    
    	}
    
    }
    
	// Check if current user is logged in
    require_login($course->id);

	// Log table
    add_to_log($course->id, "genetic", "edit authors", "editauthor_form.php?id=$cm->id&idauthor=$idauthor&action=$action", "$genetic->id");
	
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
	$strsurname = get_string("surname", "genetic");

	
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
	
	
	// Check the URL parameters (add, edit, delete)
	// Add
	if ($action == "") {
	
		// Print Title
		print_heading(get_string('addauthor', 'genetic'), 'center',2);
		
		// Form to add an author
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"addauthorform\" METHOD=\"post\" ACTION=\"editauthor.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD>".$strcat."&nbsp;</TD><TD><SELECT NAME=\"type\">";
			echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
			echo "<OPTION VALUE=\"admin\">".$str = get_string("admin", "genetic");
			echo "<OPTION VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
			echo "<OPTION VALUE=\"student\">".$str = get_string("student", "genetic");
			echo "<OPTION VALUE=\"guest\">".$str = get_string("guest", "genetic");
			
		echo "</SELECT></TD></TR>";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\"></TD></TR>";
		echo "<TR><TD>".$strsurname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"surname\" SIZE=\"80\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		
		//hidden fields for the addcard form to be filled with the data the user previously entered
		for($i=0;$i<count($bes);$i++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"be[]\" VALUE=\"".$bes[$i]."\"\>";
		}
		for($i=0;$i<count($authors);$i++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"author[]\" VALUE=\"".$authors[$i]."\"\>";
		}
			
		echo "<INPUT TYPE=\"hidden\" NAME=\"ty\" VALUE=\"".$ty."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"originpage\" VALUE=\"".$originpage."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idheader\" VALUE=\"".$idheader."\"\>";
		for($i=0;$i<count($domsubdom);$i++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"domsubdom[]\" VALUE=\"".$domsubdom[$i]."\"\>";
		}
		
		for($i=0;$i<count($imagen);$i++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"prevformimagen[]\" VALUE=\"".$imagen[$i]."\"\>";
		}
		
		$resultlang = mysql_query($query,$link);
		while($langrow=mysql_fetch_array($resultlang)){
			$idlanguage=$langrow['genetic_lang_id'];
			echo "<INPUT TYPE=\"hidden\" NAME=\"isolang$idlanguage\" VALUE=\"".$isolang[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"term$idlanguage\" value=\"".$term[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"gramcat$idlanguage\" value=\"".$gramcat[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"definition$idlanguage\" value=\"".$definition[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"context$idlanguage\" value=\"".$formcontext[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"expression$idlanguage\" value=\"".$expression[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"notes$idlanguage\" value=\"".$notes[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"weight_type$idlanguage\" value=\"".$weight_type[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourceterm$idlanguage\" value=\"".$sourceterm[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourcedefinition$idlanguage\" value=\"".$sourcedefinition[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourcecontext$idlanguage\" value=\"".$sourcecontext[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourceexpression$idlanguage\" value=\"".$sourceexpression[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourcerv$idlanguage\" value=\"".$sourcerv[$idlanguage]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"sourcenotes$idlanguage\" value=\"".$sourcenotes[$idlanguage]."\"\>";
		
			$long=count($remission[$idlanguage]);
			$j=1;
			for($z=0;$z<$long;$z++){
				echo "<INPUT TYPE=\"hidden\" NAME=\"remission_".$idlanguage."_$j\" VALUE=\"".$remission[$idlanguage][$z]."\">";
				echo "<INPUT TYPE=\"hidden\" NAME=\"remtype_".$idlanguage."_$j\" VALUE=\"".$rem_type[$idlanguage][$z]."\">";
				$j++;
			}
			echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission".$idlanguage."\" VALUE=\"".$long."\">";
			for($r=0;$r<count($audio[$idlanguage]);$r++){
				echo "<INPUT TYPE=\"hidden\" NAME=\"audio".$idlanguage."[]\" VALUE=\"".$audio[$idlanguage][$r]."\">";
			}
			for($e=0;$e<count($video[$idlanguage]);$e++){
				echo "<INPUT TYPE=\"hidden\" NAME=\"video".$idlanguage."[]\" VALUE=\"".$video[$idlanguage][$e]."\">";
			}
		}
		
		echo "<INPUT TYPE=\"hidden\" NAME=\"origen\" VALUE=\"".$origen."\">";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" onClick=\"this.form.action='editauthor.php?id=$id';this.form.submit();\"/>&nbsp;&nbsp;";
		
		if($origen=="add_author"){
			$newurl='viewauthor.php';
			echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='".$newurl."?id=$id'\"/>";
		}else if($origen==""){
			if($originpage=='edit'){
				echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"this.form.action='editcard_form.php?id=$id&idheader=$idheader';this.form.submit();\"/>";
			}else{
				echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"this.form.action='addcard_form.php?id=$id';this.form.submit();\"/>";
			}
		}	
			
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		
		print_box_end($return=false);
	}
	
	// Edit
	else if ($action == "edit") {	
		// Print Title
		print_heading(get_string('editauthor', 'genetic'), 'center',2);
		
		// Get the author fields from the database
		
		$query = genetic_choose_author($idauthor);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$type = $row['type'];
		$pre_name = $row['name'];
		$pre_surname=$row['surname'];
		// Close the db    
		mysql_close($link);
				
		// Form to edit an author
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editauthorform\" METHOD=\"post\" ACTION=\"editauthor.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idauthor\" VALUE=\"".$idauthor."\">";
		echo "<TR><TD>".$strcat."&nbsp;</TD><TD><SELECT NAME=\"type\">";
			if ($type == 'admin') {
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				echo "<OPTION SELECTED VALUE=\"admin\">".$str = get_string("admin", "genetic");
				echo "<OPTION VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
				echo "<OPTION VALUE=\"student\">".$str = get_string("student", "genetic");
				echo "<OPTION VALUE=\"guest\">".$str = get_string("guest", "genetic");
			}else if ($type == 'teacher') {
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				echo "<OPTION VALUE=\"admin\">".$str = get_string("admin", "genetic");
				echo "<OPTION SELECTED VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
				echo "<OPTION VALUE=\"student\">".$str = get_string("student", "genetic");
				echo "<OPTION VALUE=\"guest\">".$str = get_string("guest", "genetic");
			}else if ($type == 'student') {
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				echo "<OPTION VALUE=\"admin\">".$str = get_string("admin", "genetic");
				echo "<OPTION VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
				echo "<OPTION SELECTED VALUE=\"student\">".$str = get_string("student", "genetic");
				echo "<OPTION VALUE=\"guest\">".$str = get_string("guest", "genetic");
			}else if ($type == 'guest') {
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				echo "<OPTION VALUE=\"admin\">".$str = get_string("admin", "genetic");
				echo "<OPTION VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
				echo "<OPTION VALUE=\"student\">".$str = get_string("student", "genetic");
				echo "<OPTION SELECTED VALUE=\"guest\">".$str = get_string("guest", "genetic");
			}else{
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				echo "<OPTION VALUE=\"admin\">".$str = get_string("admin", "genetic");
				echo "<OPTION VALUE=\"teacher\">".$str = get_string("teacher", "genetic");
				echo "<OPTION VALUE=\"student\">".$str = get_string("student", "genetic");
				echo "<OPTION VALUE=\"guest\">".$str = get_string("guest", "genetic");
			}
		echo "</SELECT></TD></TR>";
		//$namesurname = explode(" ", $name);
		//echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$namesurname[0]."\"></TD></TR>";
		//echo "<TR><TD>".$strsurname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"surname\" SIZE=\"80\" VALUE=\"".$namesurname[1]."\"></TD></TR>";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$pre_name."\"></TD></TR>";
		echo "<TR><TD>".$strsurname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"surname\" SIZE=\"80\" VALUE=\"".$pre_surname."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewauthor.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Delete
	else if ($action == "delete") {	
		// Print Title
		print_heading(get_string('deleteauthor', 'genetic'), 'center',2);
		
	
		
		// Check if the author is being used in any genetic card.
		$query = genetic_use_author($idauthor);
		$result = mysql_query($query, $link);
		$n = mysql_num_rows($result);
		if($n != 0) {
			$redirectmsg = get_string("deleteauused", "genetic");
			redirect($url="viewauthor.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}
		
		else {
		// Get the author fields from the database
		$query = genetic_choose_author($idauthor);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$type = $row['type'];
		$name = $row['name'];
		// Close the db    
		mysql_close($link);
		
		// Form to delete an author
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deleteauthorform\" METHOD=\"post\" ACTION=\"editauthor.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idauthor\" VALUE=\"".$idauthor."\">";
		echo "<TR><TD>".$strcat."&nbsp;</TD><TD>".$type."</TD></TR>";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deleteauthorsure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewauthor.php?id=$id'\"/>";
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