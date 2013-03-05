<?php  // $Id: editcard.php, v1.0 2012/06/06 10:45:00 Ana mar�a Lozano de la Fuente Exp $
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

	// File for editing a genetic card

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
    $confirm = optional_param('confirm', 0, PARAM_INT);
    
	//get the course and dictionary information
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
    
	// Get the form variables
	$ncards= optional_param('ncards', 0, PARAM_INT);  
	$bes = optional_param('be', 0, PARAM_INT);
	$ty = optional_param('ty', 0, PARAM_INT);
	$ni = optional_param('ni', 0, PARAM_INT);
	$domsubdom = optional_param('domsubdom', 0, PARAM_INT);
	$authors = optional_param('author', 0, PARAM_INT);
	$imagen = optional_param('imagen', 0, PARAM_INT);
	
	//$datecreated = time();
	$datecreated = optional_param('datecreated', 0, PARAM_INT);
	$array_header = array("$bes[0]", "$ty", "$domsubdom[0]", "$authors[0]");
	$narrayh = 4;
	
	// Connect to the database
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	// parameters depending on the language
	
	//take the ids of the languages of the dictionary
	$query=genetic_id_lang($genetic->id);
	$resultlang = mysql_query($query,$link);
	while($langrow=mysql_fetch_array($resultlang)){
		$idlanguage=$langrow['genetic_lang_id'];
		// Arrays with data for each language of the dictionary, some may be empty if user does not introduce information for a language
		$isolang[$idlanguage] = optional_param('isolang'.$idlanguage, '', PARAM_TEXT);
		$cardid[$idlanguage] = optional_param('cardid'.$idlanguage, 0, PARAM_INT);
		$term[$idlanguage] = optional_param('termino'.$idlanguage, '', PARAM_TEXT);
		$gramcat[$idlanguage] = optional_param('gramcat'.$idlanguage, null, PARAM_TEXT);
		$weight_type[$idlanguage] = optional_param('weight_type'.$idlanguage, null, PARAM_TEXT);
		$definition[$idlanguage] = optional_param('definition'.$idlanguage, '', PARAM_TEXT);
		$context[$idlanguage] = optional_param('context'.$idlanguage, null, PARAM_TEXT);
		$expression[$idlanguage] = optional_param('expression'.$idlanguage, '', PARAM_TEXT);
		$notes[$idlanguage] = optional_param('notes'.$idlanguage, '', PARAM_TEXT);
		$sourceterm[$idlanguage] = optional_param('sourceterm'.$idlanguage, '', PARAM_TEXT);
		$sourcedefinition[$idlanguage] = optional_param('sourcedefinition'.$idlanguage, '', PARAM_TEXT);
		$sourcecontext[$idlanguage] = optional_param('sourcecontext'.$idlanguage, null, PARAM_TEXT);
		$sourceexpression[$idlanguage] = optional_param('sourceexpression'.$idlanguage, '', PARAM_TEXT);
		$sourcenotes[$idlanguage] = optional_param('sourcenotes'.$idlanguage, '', PARAM_TEXT);
		
		$videos[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
		
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
    add_to_log($course->id, "genetic", "edit card", "editcard.php?id={$cm->id}", "$genetic->id");
    
    //Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");

	
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


	// Print the tabs
	$SESSION->genetic->current_tab = 'cards';
	include('tabs.php');

	
	// Check if there is any obligatory field empty  
	//  in the Header
	$empty = genetic_field_not_zero($array_header, $narrayh);
	if (($empty == 1) ) {
		print_box_start($classes='generalbox boxaligncenter boxwidthwide');
		$msg = get_string("emptyfieldheader", "genetic");
		echo $msg;
		print_box_end($return=false);
		echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
	
	}else {
		// check data for each languages 
			$query=genetic_id_lang($genetic->id);
			$resultlang = mysql_query($query,$link);
			$numlang = mysql_affected_rows($link);
			
			$ncompulsoryitems = 4;  //number of compulsory fields for each term
			$empty2=0;
			$allfieldsempty=0;
			
			while($langrow=mysql_fetch_array($resultlang)){
							
				// Check if there is any obligatory field empty
				$idlanguage=$langrow['genetic_lang_id'];
				// Language 
				$empty[$idlanguage] = count_genetic_field_null($term[$idlanguage] , $definition[$idlanguage], $gramcat[$idlanguage], $context[$idlanguage]);
				if($empty[$idlanguage]==$ncompulsoryitems)  //all fields are empty
						{
						$allfieldsempty++;
						}else{
						if($empty[$idlanguage]>0) $empty2++; //not all compulsory fields filled in for that language	
						}
						
				}
			
		//checks if no terms have been added in any language
			if($allfieldsempty==$numlang){
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("notermsed", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
			}else if (($empty2)>0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("emptyfieldlanguage", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
			}else {	
				$n2=0;
				$resultlang = mysql_query($query,$link);
				while($langrow=mysql_fetch_array($resultlang)){
					$idlanguage=$langrow['genetic_lang_id'];
					$query2 =genetic_search_lang_name($idlanguage);
					$result2 = mysql_query($query2,$link);
					$row2 = mysql_fetch_array($result2);
					$namelang=$row2['language'];
							//EVP NO COMPARAR CON LA MISMA FICHA	
					if($term[$idlanguage]!=''){
						$query2=genetic_term_exists_inlang2($term[$idlanguage],$genetic->id,$namelang,$ni);
						$result2= mysql_query($query2,$link);
						$n2= mysql_num_rows($result2);
						$row = mysql_fetch_array($result2);
						$headerrowni = $row['idheader'];
					}
				}
			}
	}
	if($n2!=0&&($confirm!=1))
	{
		$msg2 = get_string("term_already_exists", "genetic");
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"card\" METHOD=\"post\" ACTION=\"editcard.php?id={$cm->id}&confirm=1\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"right\"><font color=\"red\"><B>".$msg2."</font></TD>";
							echo "<INPUT TYPE=\"hidden\" NAME=\"confirm\" VALUE=\"1\">";
				
										//Send again the parameters received
										for($j=0;$j<count($bes);$j++){
										echo "<INPUT TYPE=\"hidden\" NAME=\"be[]\" VALUE=\"".$bes[$j]."\">";
	
										}
											
										echo "<INPUT TYPE=\"hidden\" NAME=\"ty\" VALUE=\"".$ty."\">";
				
										for($k=0;$k<count($domsubdom);$k++){
										echo "<INPUT TYPE=\"hidden\" NAME=\"domsubdom[]\" VALUE=\"".$domsubdom[$k]."\">";
										}
												for($l=0;$l<count($authors);$l++){
	
												echo "<INPUT TYPE=\"hidden\" NAME=\"author[]\" VALUE=\"".$authors[$l]."\">";
												}
													
												echo "<INPUT TYPE=\"hidden\" NAME=\"datecreated\" VALUE=\"".$datecreated."\">";
													
												for($e=0;$e<count($imagen);$e++){
													echo "<INPUT TYPE=\"hidden\" NAME=\"imagen[]\" VALUE=\"".$imagen[$e]."\">";
	
												}
													
	
													
												$resultlang = mysql_query($query,$link);
												while($langrow=mysql_fetch_array($resultlang)){
												$idlanguage=$langrow['genetic_lang_id'];
	
												echo "<INPUT TYPE=\"hidden\" NAME=\"termino$idlanguage\" VALUE=\"".$term[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"isolang$idlanguage\" VALUE=\"".$isolang[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"definition$idlanguage\" VALUE=\"".$definition[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"gramcat$idlanguage\" VALUE=\"".$gramcat[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"weight_type$idlanguage\" VALUE=\"".$weight_type[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"rem_type$idlanguage\" VALUE=\"".$rem_type[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"context$idlanguage\" VALUE=\"".$context[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"expression$idlanguage\" VALUE=\"".$expression[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"notes$idlanguage\" VALUE=\"".$notes[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"sourceterm$idlanguage\" VALUE=\"".$sourceterm[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"sourcedefinition$idlanguage\" VALUE=\"".$sourcedefinition[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"sourcecontext$idlanguage\" VALUE=\"".$sourcecontext[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"sourceexpression$idlanguage\" VALUE=\"".$sourceexpression[$idlanguage]."\">";
												echo "<INPUT TYPE=\"hidden\" NAME=\"sourcenotes$idlanguage\" VALUE=\"".$sourcenotes[$idlanguage]."\">";
	
												$long=count($remission[$idlanguage]);
												for($z=0;$z<$long;$z++){
														echo "<INPUT TYPE=\"hidden\" NAME=\"remission_".$idlanguage."_$z\" VALUE=\"".$remission[$idlanguage][$z]."\">";
														echo "<INPUT TYPE=\"hidden\" NAME=\"remtype_".$idlanguage."_$z\" VALUE=\"".$rem_type[$idlanguage][$z]."\">";
																echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission_".$idlanguage."\" VALUE=\"".$long."\">";
												}
	
											//		for($z=0;$z<count($synonyms);$z++){
								//echo "<INPUT TYPE=\"hidden\" NAME=\"synonyms[][]\" VALUE=\"".$synonyms[$idlanguage][$z]."\">";
									//			}
													for($r=0;$r<count($audio[$idlanguage]);$r++){
													echo "<INPUT TYPE=\"hidden\" NAME=\"audio".$idlanguage."[]\" VALUE=\"".$audio[$idlanguage][$r]."\">";
														}
													for($e=0;$e<count($video);$e++){
													echo "<INPUT TYPE=\"hidden\" NAME=\"video$idlanguage\" VALUE=\"".$video[$idlanguage][$e]."\">";
												}
								//for($u=0;$u<count($relatedterms);$u++){
									//				echo "<INPUT TYPE=\"hidden\" NAME=\"relatedterms[][]\" VALUE=\"".$relatedterms[$idlanguage][$u]."\">";
										//		}
												//evp esto lo comento porque creo que no se usa
												//for($l=0;$l<count($crossrelatedterms);$l++){
												//echo "<INPUT TYPE=\"hidden\" NAME=\"crossrelatedterms[][]\" VALUE=\"".$crossrelatedterms[$idlanguage][$l]."\">";
												//}
	
												//echo "<INPUT TYPE=\"hidden\" NAME=\"pieimagen[]\" VALUE=\"".$pieimagen[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"pievideo[]\" VALUE=\"".$pievideo[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"srcimage[]\" VALUE=\"".$srcimage[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"srcvideo[]\" VALUE=\"".$srcvideo[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"acronyms[]\" VALUE=\"".$acronyms[$idlanguage]."\">";
												//echo "<INPUT TYPE=\"hidden\" NAME=\"abreviaturas[]\" VALUE=\"".$abreviaturas[$idlanguage]."\">";
	
							}
				
							$strviewfull=get_string("viewfullcard", "genetic");
							
														echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
							echo "<input type=\"submit\" value=\"".$str = get_string("accept", "genetic")."\" name=\"buttondelete\" />";
							echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"history.back()\"/>";
								echo "<TD></TD><TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></a></TD></TR>";
												echo "</TD></TR>";
												echo "</FORM></TABLE>";
												print_box_end($return=false);
													
	
	
	}
		

		// Insert or update  card
			else {
				
		
		
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			// Insert a new card
			
			
			// Header
			$query = genetic_update_header($genetic->id, $ni, $ty, $datecreated);
			$result = mysql_query($query,$link);
			$nok = mysql_affected_rows($link);
				
			// Relation header-author and header-be
			// Delete
			$query = genetic_delete_rel_headerbe($ni);
			$result = mysql_query($query,$link);
			$nok2 = mysql_affected_rows($link);
			
			$query = genetic_delete_rel_headerauthor($ni);
			$result = mysql_query($query,$link);
			$nok3 = mysql_affected_rows($link);
			
			$query = genetic_delete_rel_subdomain($ni);
			$result = mysql_query($query,$link);
			$nok3 = mysql_affected_rows($link);
			
			// Then create
			for ($i=0; $i<count($bes); $i++) {
				$query = genetic_insert_rel_be($ni, $bes[$i]);
				$result = mysql_query($query, $link);
			}
			for ($i=0; $i<count($authors); $i++) {
				
				$query = genetic_insert_rel_author($ni, $authors[$i]);
				$result = mysql_query($query, $link);
			}
			for ($i=0; $i<count($domsubdom); $i++) {
				
				$query = genetic_insert_rel_subdomain($ni, $domsubdom[$i]);
				$result = mysql_query($query, $link);
			}
			
			//imagenes 
			
				$query = genetic_delete_image($ni);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
				
				
				for ($i=0; $i<count($imagen); $i++) {
					$query = genetic_insert_has_image($ni,$imagen[$i]);
					$result = mysql_query($query, $link);
				}
				
			//update data for each language 	(and add data in case no card exists)

				$query=genetic_id_lang($genetic->id); //languages of the dictionary
				$resultlang = mysql_query($query);
					
				while($langrow=mysql_fetch_array($resultlang)){
						
					$idlanguage=$langrow['genetic_lang_id'];
					$query=genetic_get_isolang($idlanguage);
					$result=mysql_query($query,$link);
					$rowlanguage=mysql_fetch_array($result);
					$langname=$rowlanguage['language'];
					
					//check if card of that language exits for that header
					$query= genetic_show_cards2($ni,$langname);
					$result= mysql_query($query,$link);
					$card_exists = mysql_affected_rows($link); // $card_exits=0 if no card exists or 1 if card exists
					
				// Card 
				
				if($term[$idlanguage]!="")
				{
				
				if($card_exists){
				$query = genetic_update_card($cardid[$idlanguage], $term[$idlanguage], $gramcat[$idlanguage], $definition[$idlanguage], $context[$idlanguage], $expression[$idlanguage], $notes[$idlanguage],$weight_type[$idlanguage]);		
				}else{
				$query = genetic_insert_card($genetic->id, $ni, $langname, $term[$idlanguage], $gramcat[$idlanguage], $definition[$idlanguage], $context[$idlanguage], $expression[$idlanguage], $notes[$idlanguage],$weight_type[$idlanguage]);
				}
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
				// Sources 
				if($card_exists){
				$query = genetic_update_source($cardid[$idlanguage], $sourceterm[$idlanguage], $sourcedefinition[$idlanguage], $sourcecontext[$idlanguage], $sourceexpression[$idlanguage],  $sourcenotes[$idlanguage]);				
				}else{
					$query = genetic_show_lastcard();
					$result = mysql_query($query,$link);
					$row = mysql_fetch_array($result);
					$newcardid = $row['id'];
					$query = genetic_insert_source($newcardid, $sourceterm[$idlanguage], $sourcedefinition[$idlanguage], $sourcecontext[$idlanguage], $sourceexpression[$idlanguage],  $sourcenotes[$idlanguage]);		
				}
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
				//remissions
				
				$query = genetic_delete_remissions($cardid[$idlanguage]);
				$result = mysql_query($query,$link);
				
				if($card_exists){
					$idcard=$cardid[$idlanguage];
				}else{
					$idcard=$newcardid;
				}
				
				if($numfieldsremission[$idlanguage]>0){
					$long=count($remission[$idlanguage]);
					for ($z=0;$z<$long;$z++){
					$query = genetic_insert_remission($idcard,$remission[$idlanguage][$z],$rem_type[$idlanguage][$z]);
					$result = mysql_query($query,$link);
					$nok = mysql_affected_rows($link);
					// Update ok or not?
					if($nok == 0) {
						$redirectmsg = get_string("insertnok", "genetic");
						redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
						// Close the db
						mysql_close($link);
						// Finish the page
						print_footer($course);
						}
					}
				}
				//Audio 
				
				if($card_exists){
				$query = genetic_delete_audio($cardid[$idlanguage]);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
				}
					
				for ($k=0; $k<count($audio[$idlanguage]); $k++) {
				
					$query = genetic_insert_has_audio($idcard,$audio[$idlanguage][$k]);
					$result = mysql_query($query, $link);
				}
				
					//videos  
			if($card_exists){
					$query = genetic_delete_video($cardid[$idlanguage]);
					$result = mysql_query($query,$link);
					$nok3 = mysql_affected_rows($link);
			}
			
				for ($k=0; $k<count($videos); $k++) {
				
					$query = genetic_insert_has_video($idcard,$videos[$idlanguage][$k]);
					$result = mysql_query($query, $link);
				}
			
				}//fin del if term
			} //end of while 
				
			//insert new data

			$redirectmsg = get_string("updateok", "genetic");
			redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
			
			// Close the db    
			mysql_close($link);
		}
					
	
	// Finish the page
	include('banner_foot.html');
	print_footer($course);	

?>
