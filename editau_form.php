<?php  // $Id: editau_form.php,v 1.0 2010/01/12 16:40:00 Irene Fern�ndez Ram�rez Exp $
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
	$strname = get_string("name","genetic");
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
		echo "<FORM NAME=\"addauform\" METHOD=\"post\" ACTION=\"\" ENCTYPE=\"multipart/form-data\">";
			
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
			
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" onClick=\"this.form.action='editau.php?id=$id';this.form.submit();\"/>&nbsp;&nbsp;";
		
		if($originpage=='edit'){
				echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"this.form.action='editcard_form.php?id=$id&idheader=$idheader';this.form.submit();\"/>";
			}else{
				echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"this.form.action='addcard_form.php?id=$id';this.form.submit();\"/>";
			}
		
		
		
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Edit
	else if ($action == "edit") {	
		// Print Title
		print_heading(get_string('editau', 'genetic'), 'center',2);

		// Get the card type fields from the database
		$query = genetic_choose_au($idau);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$prename = $row['fileaudio'];
		$name3 = $row ['srcaudio'];
		$language = $row ['lang'];
				
		// Form to edit a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editauform\" METHOD=\"post\" ACTION=\"editau.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idau\" VALUE=\"".$idau."\">";
		//echo "<INPUT TYPE=\"hidden\" NAME=\"idcard\" VALUE=\"".$idcard."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"prename\" VALUE=\"".$prename."\">";
		echo "<TR><TD>".$strmodau."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$prename."\"></TD></TR>";
		//modificar audio
		
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"center\">".$strlang."&nbsp;</TD><TD><SELECT NAME=\"lang\" ALIGN=\"right\">";
			
			//echo "<OPTION VALUE=\"".$language."\">".$language;
			echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			
			$query=genetic_id_lang($genetic->id);
			$result=mysql_query($query,$link);
			while($row=mysql_fetch_array($result))
			{
				$querylang=genetic_get_isolang($row['genetic_lang_id']);
				$resultlang=mysql_query($querylang,$link);
				$rowlang=mysql_fetch_array($resultlang);
				if($rowlang['language']==$language){
					echo "<OPTION selected VALUE=\"".$rowlang['language']."\">".$str = get_string($rowlang['language'], "genetic");
				}else{
					echo "<OPTION VALUE=\"".$rowlang['language']."\">".$str = get_string($rowlang['language'], "genetic");
				} 
			}
			echo "</SELECT></TD></TR>";
		
		echo "<TR><TD>".$strsrc."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name3\" SIZE=\"80\" VALUE=\"".$name3."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewau.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
		// Close the db
		mysql_close($link);
	}
	
	// Delete
	else if ($action == "delete") {
	
		// Print Title
		print_heading(get_string('deleteau', 'genetic'), 'center',2);
		
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
		// Close the db    
		mysql_close($link);
		
		// Form to delete a card type
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deleteauform\" METHOD=\"post\" ACTION=\"editau.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idau\" VALUE=\"".$idau."\">";
		//echo "<INPUT TYPE=\"hidden\" NAME=\"idcard\" VALUE=\"".$idcard."\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"name\" VALUE=\"".$name."\">";
		echo "<TR><TD>".$strname.": &nbsp;&nbsp;</TD><TD>".$name."</TD></TR>";
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