<?php  // $Id: editdom_form.php,v 1.0 2012/06/05 19:40:00 Ana Mar�a Lozano de la Fuente Exp $
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

	// File with a form for add, edit or delete domains/subdomains
	
	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	require_once("selectsubdomains.php");
	
	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Necessary parameters to add/edit/delete domains/subdomains
	$iddom = optional_param('iddom',0,PARAM_INT);
	$action = optional_param('action','',PARAM_ALPHA);
	$cat = optional_param('cat','',PARAM_TEXT);
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
    add_to_log($course->id, "genetic", "edit domains", "editdom_form.php?id=$cm->id&iddom=$iddom&action=$action", "$genetic->id");
	
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
	$strbelongto = get_string("belongto", "genetic");

	
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
	
		
		// Subdomain 
		if ($cat == "subdomain") {
			// Print Title
			print_heading(get_string('addsubdom', 'genetic'), 'center',2);
			
			// Form to add a subdomain
			print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
			echo "<TABLE ALIGN=\"center\">";
			echo "<FORM NAME=\"addsubdomform\" METHOD=\"post\" ACTION=\"\" ENCTYPE=\"multipart/form-data\">";
			echo "<TR><TD>".$strcat."&nbsp;</TD><TD>".$cat."</TD></TR>";
			echo "<TR><TD>".$strbelongto."&nbsp;</TD>";
			//echo"<TD><SELECT NAME=\"belongto\" STYLE=\"width: 200px\" >";
			// Connect to the db
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);	
			//Get domains from the database
			//echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</OPTION>";
			/*
			$query = genetic_show_subdomains();
			$result = mysql_query($query,$link);
			
			while ($domrow = mysql_fetch_array($result)) {
			
				$iddom = $domrow['id'];
				$namedom = $domrow['name'];
				echo "<OPTION VALUE=\"".$iddom."\">".$namedom."</OPTION>";
				
			}
			
			*/
			echo "<TABLE align=\"center\">";
			genetic_select_subdomains($nivel=0);
			echo"</TABLE>";
			echo "</SELECT></TD></TR>";
				
			echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\"></TD></TR>";
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
			
			// Close the db    
			mysql_close($link);
			
			echo "<INPUT TYPE=\"hidden\" NAME=\"origen\" VALUE=\"".$origen."\">";
			
			echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" onClick=\"this.form.action='editdom.php?id=$id&cat=subdomain';this.form.submit();\"/>&nbsp;&nbsp;";
			
			if($origen=="add_dom"){
				$newurl='viewdom.php';
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
	}
	
	// Edit
	else if ($action == "edit") {
	
		
		// Subdomain
		if ($cat == "subdomain") {
			// Print Title
			print_heading(get_string('editsubdom', 'genetic'), 'center',2);
			// Get subdom fields
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			$query = genetic_choose_subdomain($iddom);
			$result = mysql_query($query,$link);
			$domrow = mysql_fetch_array($result);
			$belongto = $domrow['iddom'];
			$subdomname = $domrow['name'];
			// Close the db    
			mysql_close($link);
					
			// Form to edit a subdomain
			print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
			echo "<TABLE ALIGN=\"center\">";
			echo "<FORM NAME=\"editsubdomform\" METHOD=\"post\" ACTION=\"editdom.php?id=$id&action=edit&cat=subdomain\" ENCTYPE=\"multipart/form-data\">";
			echo "<INPUT TYPE=\"hidden\" NAME=\"iddom\" VALUE=\"".$iddom."\">";
			echo "<TR><TD>".$strcat."&nbsp;</TD><TD>".$cat."</TD></TR>";
			echo "<TR><TD>".$strbelongto."&nbsp;</TD>";
			//echo"<TD><SELECT NAME=\"belongto\">";
			// Connect to the db
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);	
			
			
			echo "<TABLE align=\"center\">";
			genetic_select_subdomains2($nivel=0,$belongto);
			echo"</TABLE>";
			
			// Close the db    
			mysql_close($link);
			echo "</SELECT></TD></TR>";			
			echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"name\" SIZE=\"80\" VALUE=\"".$subdomname."\"></TD></TR>";
			echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
			echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
			echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewdom.php?id=$id'\"/>";
			echo "</TD></TR>";
			echo "</FORM></TABLE>";
			print_box_end($return=false);
		}
	}
	
	// Delete
	else if ($action == "delete") {
		
		
		// Subdomain
		if ($cat == "subdomain") {		
			// Print Title
			print_heading(get_string('deletesubdom', 'genetic'), 'center',2);
			
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			// Check if the subdomain is being used in any genetic card.
			$query = genetic_use_subdom($iddom);
			$resultprev = mysql_query($query, $link);
			$result = mysql_num_rows ($link);
			if($result==0)
			{
			
				//comprobar que en ese subdominio no hay dentro otros subdominios
				$queryexist = genetic_search_subdomain($iddom);
				$result = mysql_query($queryexist,$link);
				$nok = mysql_affected_rows($link);
			
			
				if($nok!=0){
							$redirectmsg = get_string("deletedomparent", "genetic");
							redirect($url="viewdom.php?id={$cm->id}", $redirectmsg, $delay=-1);				
							// Close the db    
							mysql_close($link);
							// Finish the page
							print_footer($course);
					}
			
			// Get subdom fields
			
			$query = genetic_choose_subdomain($iddom);
			$result = mysql_query($query,$link);
			$domrow = mysql_fetch_array($result);
			$belongto = $domrow['iddom'];
			$name = $domrow['name'];
			
			// Form to delete a subdomain
			print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
			echo "<TABLE ALIGN=\"center\">";
			echo "<FORM NAME=\"deletesubdomform\" METHOD=\"post\" ACTION=\"editdom.php?id=$id&action=delete&cat=subdomain\" ENCTYPE=\"multipart/form-data\">";
			echo "<INPUT TYPE=\"hidden\" NAME=\"iddom\" VALUE=\"".$iddom."\">";
			echo "<TR><TD>".$strcat."&nbsp;</TD><TD>".$cat."</TD></TR>";
			echo "<TR><TD>".$strbelongto."&nbsp;</TD>";
			//$query = genetic_choose_domain($belongto);
			$query = genetic_choose_subdomain($belongto);
			$result = mysql_query($query,$link);
			$domrow = mysql_fetch_array($result);
			echo "<TD>".$domrow['name']."</TD></TR>";
			// Close the db    
			mysql_close($link);
			echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
			echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deletedomsdsure", "genetic")."</TD></TR>";
			echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
			echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
			echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewdom.php?id=$id'\"/>";
			echo "</TD></TR>";
			echo "</FORM></TABLE>";
			print_box_end($return=false);
			}else{
					$redirectmsg = get_string("deletesubdomused", "genetic");
					redirect($url="viewdom.php?id={$cm->id}", $redirectmsg, $delay=-1);
					// Close the db
					mysql_close($link);
					// Finish the page
					print_footer($course);
			}
				
		}
	}
	
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>