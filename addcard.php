<?php  // $Id: addcard.php, v2.0 2012/06/21 10:15:00 Ana Mar�a Lozano de la Fuente Exp $
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

	// File for adding a genetic card

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	$confirm = optional_param('confirm', 0, PARAM_INT);
	$bes = optional_param('be', 0, PARAM_INT);
	$ty = optional_param('ty', 0, PARAM_INT);
	//$domsubdom = optional_param('domsubdom', 0, PARAM_TEXT);
	$domsubdom = optional_param('domsubdom', 0, PARAM_INT);
	//$aux = explode("-", $domsubdom);
	$authors = optional_param('author', 0, PARAM_INT);
	$datecreated = optional_param('datecreated', 0, PARAM_INT);
	$imagen = optional_param('imagen', 0, PARAM_INT);
		
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

    
    // Connect to the database
    $link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
        
    // parameter depending on the language
    
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
	    $context[$idlanguage] = optional_param('context'.$idlanguage, null, PARAM_TEXT);
	    $expression[$idlanguage] = optional_param('expression'.$idlanguage, null, PARAM_TEXT);
	    //$rv = optional_param('rv', 'null', PARAM_TEXT);
	    $notes[$idlanguage] = optional_param('notes'.$idlanguage, null, PARAM_TEXT);
	    $sourceterm[$idlanguage] = optional_param('sourceterm'.$idlanguage, null, PARAM_TEXT);
	    $sourcedefinition[$idlanguage] = optional_param('sourcedefinition'.$idlanguage, null, PARAM_TEXT);
	    $sourcecontext[$idlanguage] = optional_param('sourcecontext'.$idlanguage, null, PARAM_TEXT);
	    $sourceexpression[$idlanguage] = optional_param('sourceexpression'.$idlanguage, null, PARAM_TEXT);
	    $sourcenotes[$idlanguage] = optional_param('sourcenotes'.$idlanguage, null, PARAM_TEXT);
	    $synonyms[$idlanguage] = optional_param('synonyms'.$idlanguage, 0, PARAM_INT);
	    $video[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
	   // $relatedterms[$idlanguage] = optional_param('relatedterms'.$idlanguage, 0, PARAM_INT);
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
    
        

    //----a�adido---lenguage 1    //EVP ESTO NO ESTOY SEGURA DE QUE SE USE NI CUANDO SE ENVIA COMPROBAR
    //$pieimagen = optional_param('pieimagen', 'null', PARAM_TEXT);
    //$pievideo = optional_param('pievideo', 'null', PARAM_TEXT);
    //$srcimage = optional_param('srcimage', 'null', PARAM_TEXT);
    //$srcvideo = optional_param('srcvideo', 'null', PARAM_TEXT);
    //$acronyms = optional_param('acronyms', 'null', PARAM_TEXT);
    //$abreviaturas=optional_param('abreviaturas', 'null', PARAM_TEXT);
    $symbols = optional_param('symbols', 'null', PARAM_TEXT);
    $enlacesnuevos = optional_param('enlacesnuevos', 'null', PARAM_TEXT);
    
    
   // $rem_type2 = optional_param('rem_type2', 'null', PARAM_TEXT);
   // $remission2 = optional_param('remission2', 'null', PARAM_TEXT);
    
    
    
    $strviewfull=get_string("viewfullcard", "genetic");
    
    
	// Check if current user is logged in
    require_login($course->id);
	
	// Log table
    add_to_log($course->id, "genetic", "add card", "addcard.php?id=$cm->id", "$genetic->id");
    
    
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

	
	
	$narrayh = 4;		
	$array_header = array("$bes[0]", "$ty", "$domsubdom[0]", "$authors[0]");
	
	// Header comprobar si hay algun campo vacio en la cabecera
	$empty = genetic_field_not_zero($array_header, $narrayh);
		//show which field is null
		//$emptyh=genetic_field_zero_data ($array_header, $narrah);
	
	
	if (($empty == 1)) {
		print_box_start($classes='generalbox boxaligncenter boxwidthwide');
		$msg = get_string("emptyfieldheader", "genetic");
		echo $msg;
		print_box_end($return=false);
		echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
	}
	else {
			//Count the languages of the dictionary
			
			//$query = genetic_count_lang($genetic->id);
			//$resultlang = mysql_query($query,$link);
			$query=genetic_id_lang($genetic->id);
			$resultlang = mysql_query($query,$link);
			$numlang = mysql_affected_rows($link);
			
			$ncompulsoryitems = 4;  //number of compulsory fields for each term
			$empty2=0;
			$allfieldsempty=0;
			
			while($langrow=mysql_fetch_array($resultlang)){
				
				
			
			// Check if there is any obligatory field empty
				$idlanguage=$langrow['genetic_lang_id'];
				
				//for($u=0;$u<$numlang;$u++){
						
						// Language 
						$empty[$idlanguage] = count_genetic_field_null($term[$idlanguage] , $definition[$idlanguage], $gramcat[$idlanguage], $context[$idlanguage]);
						//$empty3[$u] = genetic_field_not_null2($array_card[$u], $narrayc);
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
			$msg = get_string("notermsadded", "genetic");
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
			
				//comprobar si el termino ya existe en  
					
				//if($confirm!=0){
						$resultlang = mysql_query($query,$link);
						while($langrow=mysql_fetch_array($resultlang)){
							//for($i=0;$i<$numlang;$i++){
								$idlanguage=$langrow['genetic_lang_id'];
								$query2 =genetic_search_lang_name($idlanguage);
								$result2 = mysql_query($query2,$link);
								$row2 = mysql_fetch_array($result2);
								$namelang=$row2['language'];
								
								if($term[$idlanguage]!=''){
									//echo"termino dist de cero".$term[$i]."".$isolang[$i];
								//$query2= genetic_term_exists($term[$idlanguage],$genetic->id);
								$query2=genetic_term_exists_inlang($term[$idlanguage],$genetic->id,$namelang);
								$result2= mysql_query($query2,$link);
								$n2= mysql_num_rows($result2);
						
								$row = mysql_fetch_array($result2);
								$headerrowni = $row['idheader'];
								
								}
							}
				
					//Term in any language already exists
				
					//if(($n2!=0)&&($confirm!=1)){
			
						
				
						if(($n2!=0)&&($confirm!=1))
						{	
							$msg2 = get_string("term_already_exists", "genetic");
							print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
							echo "<TABLE ALIGN=\"center\">";
							echo "<FORM NAME=\"addcard\" METHOD=\"post\" ACTION=\"addcard.php?id={$cm->id}&confirm=1\" ENCTYPE=\"multipart/form-data\">";
							echo "<TR><TD ALIGN=\"right\"><font color=\"red\"><B>".$msg2."</font></TD>";
							echo "<INPUT TYPE=\"hidden\" NAME=\"confirm\" VALUE=\"1\">";
							
							//Send again the parameters received
							for($j=0;$j<count($bes);$j++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"be[ ]\" VALUE=\"".$bes[$j]."\">";
								
							}
							
							echo "<INPUT TYPE=\"hidden\" NAME=\"ty\" VALUE=\"".$ty."\">";
							
							for($k=0;$k<count($domsubdom);$k++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"domsubdom[ ]\" VALUE=\"".$domsubdom[$k]."\">";
							}
							for($l=0;$l<count($authors);$l++){

								echo "<INPUT TYPE=\"hidden\" NAME=\"author[ ]\" VALUE=\"".$authors[$l]."\">";
							}
							
							echo "<INPUT TYPE=\"hidden\" NAME=\"datecreated\" VALUE=\"".$datecreated."\">";
							
							for($e=0;$e<count($imagen);$e++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"imagen[]\" VALUE=\"".$imagen[$e]."\">";
								
							}
							
						
							
							$resultlang = mysql_query($query,$link);
							while($langrow=mysql_fetch_array($resultlang)){
								$idlanguage=$langrow['genetic_lang_id'];
												
								echo "<INPUT TYPE=\"hidden\" NAME=\"term$idlanguage\" VALUE=\"".$term[$idlanguage]."\">";
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
								$j=1;
								for($z=0;$z<$long;$z++){
									echo "<INPUT TYPE=\"hidden\" NAME=\"remission_".$idlanguage."_$j\" VALUE=\"".$remission[$idlanguage][$z]."\">";
									echo "<INPUT TYPE=\"hidden\" NAME=\"remtype_".$idlanguage."_$j\" VALUE=\"".$rem_type[$idlanguage][$z]."\">";
									$j++;
								}
								echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission_".$idlanguage."\" VALUE=\"".$long."\">";
									
																
								for($r=0;$r<count($audio[$idlanguage]);$r++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"audio$idlanguage\" VALUE=\"".$audio[$idlanguage][$r]."\">";
								}
								for($e=0;$e<count($video[$idlanguage]);$e++){
									echo "<INPUT TYPE=\"hidden\" NAME=\"video$idlanguage\" VALUE=\"".$video[$idlanguage][$e]."\">";
								}
								
							}
							
							
							echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
							echo "<input type=\"submit\" value=\"".$str = get_string("accept", "genetic")."\" name=\"buttondelete\" />";
							echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"history.back()\"/>";
							echo "<TD></TD><TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></a></TD></TR>";
							echo "</TD></TR>";
							echo "</FORM></TABLE>";
							print_box_end($return=false);
							
						
						
						}
					
		//			} //FIN DEL IF SI EXISTE EN ALGUN IDIOMA
			
				//}//fin del confirm
				
				// Insert new card
				else {
					
					
					// Header ----modificar la funcion insert header con lo de los sub/dominios 
					$query = genetic_insert_header2($genetic->id, $ty, $datecreated);
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
					}else {
					// Idheader for cards
					$query = genetic_show_lastheader();
					$result = mysql_query($query,$link);
					$row = mysql_fetch_array($result);
					$ni = $row['id'];
				
					//Make relation header-author and header-be and subdomain
					for ($i=0; $i<count($bes); $i++) {
					$query = genetic_insert_rel_be($ni, $bes[$i]);
					$result = mysql_query($query, $link);
					$nok = mysql_affected_rows($link);
					
					}
					for ($i=0; $i<count($authors); $i++) {
					$query = genetic_insert_rel_author($ni, $authors[$i]);
					$result = mysql_query($query, $link);
					
					}
					
					for ($i=0; $i<count($domsubdom); $i++) {
					$query = genetic_insert_rel_subdomain($ni, $domsubdom[$i]);
					$result = mysql_query($query, $link);
					
					}
															
					for ($i=0; $i <count($imagen); $i++){
																
					$query = genetic_insert_has_image($ni, $imagen[$i]);		
					$result = mysql_query($query,$link);
					}									
					
					
						//Language 1
					$query=genetic_id_lang($genetic->id);
					$resultlang = mysql_query($query);
					
					while($langrow=mysql_fetch_array($resultlang)){
					
						$idlanguage=$langrow['genetic_lang_id'];
						
					//for ($i=0; $i<count($term); $i++){ 
						
							if($term[$idlanguage]!=""){	
						
								$query = genetic_insert_card($genetic->id, $ni, $isolang[$idlanguage], $term[$idlanguage], $gramcat[$idlanguage], $definition[$idlanguage], $context[$idlanguage], $expression[$idlanguage], $notes[$idlanguage],$weight_type[$idlanguage]);		
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
								else {
									
									 
									
									// Idcard for sources
									$query = genetic_show_lastcard();
									$result = mysql_query($query,$link);
									$row = mysql_fetch_array($result);
									$cardid = $row['id'];
									
										
									
										
										// Sources language 1
										$query = genetic_insert_source($cardid, $sourceterm[$idlanguage], $sourcedefinition[$idlanguage], $sourcecontext[$idlanguage], $sourceexpression[$idlanguage], $sourcenotes[$idlanguage]);		
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
											
										//REMISIONES	
											//echo "datos:".$remission."".$rem_type."".$;
										$long=count($remission[$idlanguage]);
										for ($z=0;$z<$long;$z++){
											$query = genetic_insert_remission($cardid,$remission[$idlanguage][$z],$rem_type[$idlanguage][$z]);
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
										
																		
									
										}//end else nok
											
									
										
										for ($l=0; $l<count($audio[$idlanguage]); $l++){
																										
																// insertar remissionid y synonymid delos sinonimos escogidos 
																$query = genetic_insert_has_audio($cardid, $audio[$idlanguage][$l]);		
																$result = mysql_query($query,$link);
																$nok = mysql_affected_rows($link);	
																//echo "lang:".$isolang[$i]."AUDIO:".$audio[$i][$l]."coord:".$i."".$l;
																//echo " VALOR DE NOK CROSSRELATED ES " .$nok;
																// Update ok or not?
																if($nok == 0) {
																	$redirectmsg = get_string("insertnok", "genetic");
																	redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
																	// Close the db    
																	mysql_close($link);
																	// Finish the page
																	print_footer($course);
																}
																
																
															
											}	//end for audio	
									
									
								//videos
								
										for ($k = 0; $k < count($video[$idlanguage]); $k++){ 
											//if($video[$idlanguage][$e]!=0) {  //the value 0 is for default, when no video is selected
													$query = genetic_insert_has_video($cardid, $video[$idlanguage][$k]);		
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
												//	}
											}
																
										} //end for video
					
								
							
								} //endif-else term
						
			
					}//nuevo del for

						
	
					} //	FIN DEL ELSE DE QUE SI SE HA METIDO LA CABECERA DE LA FICHA

					$redirectmsg = get_string("insertok", "genetic");
					redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);			
					// Close the db    
					mysql_close($link);
			
			
			} //FIN DEL ELSE SI NO EXISTE EN ESE IDIOMA
			
			
			
		} //FIN DEL ELSE SI NO HAY CAMPOS VACIOS EN LA FICHA
		
	}//FIN DEL ELSE SI NO HAY CAMPOS VACIOS EN LA CABECERA
	
	// Finish the page
	include('banner_foot.html');
	print_footer($course);	

?>
