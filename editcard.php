<?php  // $Id: editcard.php, v1.0 2012/06/06 10:45:00 Ana maría Lozano de la Fuente Exp $
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

	// File for editing a genetic card

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	
	// Get the form variables
	$ncards= optional_param('ncards', 0, PARAM_INT);
	$bes = optional_param('be', 0, PARAM_INT);
	$ty = optional_param('ty', 0, PARAM_INT);
	$ni = optional_param('ni', 0, PARAM_INT);
	$domsubdom = optional_param('domsubdom', 0, PARAM_INT);
	$authors = optional_param('author', 0, PARAM_INT);
	//$datecreated = time();
	$datecreated = optional_param('datecreated', 0, PARAM_INT);
	$array_header = array("$bes[0]", "$ty", "$domsubdom[0]", "$authors[0]");
	$narrayh = 4;
	// Language 1
	$isolang = optional_param('isolang', '', PARAM_TEXT);
	$cardid = optional_param('cardid', 0, PARAM_INT);
	$term = optional_param('termino', '', PARAM_TEXT);
	$gramcat = optional_param('gramcat', 'null', PARAM_TEXT);
	$weight_type = optional_param('weight_type', 'null', PARAM_TEXT);
	$definition = optional_param('definition', '', PARAM_TEXT);
	$context = optional_param('context', 'null', PARAM_TEXT);
	$expression = optional_param('expression', '', PARAM_TEXT);
	$rv = optional_param('rv', 'null', PARAM_TEXT);
	$notes = optional_param('notes', '', PARAM_TEXT);
	$sourceterm = optional_param('sourceterm', '', PARAM_TEXT);
	$sourcedefinition = optional_param('sourcedefinition', '', PARAM_TEXT);
	$sourcecontext = optional_param('sourcecontext', 'null', PARAM_TEXT);
	$sourceexpression = optional_param('sourceexpression', '', PARAM_TEXT);
	$sourcerv = optional_param('sourcerv', 'null', PARAM_TEXT);
	$sourcenotes = optional_param('sourcenotes', '', PARAM_TEXT);
	$array_card1 = array("$term", "$definition", "$gramcat", "$context");
	$narrayc = 4;
	$synonyms = optional_param('syn', 0, PARAM_INT);
	$cardrowidremissions = optional_param('cardrowidremissions', 0, PARAM_INT);
	$relatedterms = optional_param('rel', 0, PARAM_INT);
	$crossrelatedterms = optional_param('crossrel', 0, PARAM_INT);
	$images = optional_param('img', 0, PARAM_INT);
	$videos = optional_param('video', 0, PARAM_INT);
	$audio = optional_param('audio', 0, PARAM_INT);
	$acr = optional_param('acr', '', PARAM_TEXT);
	$abr = optional_param('abr', '', PARAM_TEXT);	
	$remission = optional_param('remission', '', PARAM_TEXT);
	$rem_type = optional_param('rem_type', '', PARAM_TEXT);
	$adjuntos= optional_param('adjuntos', 'null', PARAM_TEXT);
	$enlacesnuevos = optional_param('enlacesnuevos', 'null', PARAM_TEXT);
	$rem_type2 = optional_param('rem_type2', 'null', PARAM_TEXT);
	$remission2 = optional_param('remission2', 'null', PARAM_TEXT);
	$rem_type3 = optional_param('rem_type3', 'null', PARAM_TEXT);
	$remission3 = optional_param('remission3', 'null', PARAM_TEXT);
	$nrem = optional_param('nrem', 0, PARAM_INT);

	
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
	
	// Header
	$empty = genetic_field_not_zero($array_header, $narrayh);
	//$emptysel = genetic_field_not_selected ($dom);
	//$emptysel2 = genetic_field_not_selected ($domsubdom);	
	if (($empty == 1) ) {
		print_box_start($classes='generalbox boxaligncenter boxwidthwide');
		$msg = get_string("emptyfieldheader", "genetic");
		echo $msg;
		print_box_end($return=false);
		echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
	}
	else {
		// Language 1
		$empty = genetic_field_not_null($array_card1, $narrayc);
		
		
		
		
		if (($empty == 1)) {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfieldlanguage", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
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
			
			//imagenes  Language 1
			
				$query = genetic_delete_image($ni);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
				
				
				for ($i=0; $i<count($images); $i++) {
					$query = genetic_insert_has_image($ni,$images[$i]);
					$result = mysql_query($query, $link);
				}
				
			//update data 	
			for ($i=0; $i<count($ncards); $i++){
			
				// Card Language 1
				
				$query = genetic_update_card($cardid[$i], $term[$i], $gramcat[$i], $definition[$i], $context[$i], $expression[$i], $notes[$i],$weight_type[$i]);		
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
			

				// Sources Language 1
				$query = genetic_update_source($cardid[$i], $sourceterm[$i], $sourcedefinition[$i], $sourcecontext[$i], $sourceexpression[$i], $sourcerv[$i], $sourcenotes[$i]);				
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
				//remissions
				
				$query = genetic_delete_remissions($cardid[$i]);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
				
				//echo"cuantosss::".$nok3;
				$dy=$nok3;
				for($t=0;$t<$dy;$t++){
				
				if(($remission[$t]!="")&&($rem_type[$t]!="")){
				//echo "datos:".$remission[$t]."".$rem_type[$t]."";
				$query = genetic_insert_remission($cardid[$i],$remission[$t],$rem_type[$t]);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
				}
				}	

				//REMISION extra
										
											//echo "datos:".$remission2[$r]."".$rem_type2[$r]."";
										if(($remission2[$i]!="")&&($rem_type2[$i]!="")){
											//echo"remision2::".$remission2[$r];						
										$query = genetic_insert_remission($cardid[$i],$remission2[$i],$rem_type2[$i]);		
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
											
										
								
									
								
									//REMISIONES dinamicas
									
									for($r=0;$r<count($remission3);$r++){
										
										//echo "datos:".$remission3[$r]."::::".$rem_type3[$r]."";	
										if(($remission3[$r]!="")||($rem_type3[$r]!="")){
																	
										$query = genetic_insert_remission($cardid[$i],$remission3[$r],$rem_type3[$r]);		
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
			
			
				
				//Audio Language 1
			
				$query = genetic_delete_audio($cardid[$i]);
				$result = mysql_query($query,$link);
				$nok3 = mysql_affected_rows($link);
			
			
				for ($k=0; $k<count($audio); $k++) {
				
					$query = genetic_insert_has_audio($cardid[$i],$audio[$i][$k]);
					$result = mysql_query($query, $link);
				}
				
				
			
					//videos  Language 1
			
					$query = genetic_delete_video($cardid[$i]);
					$result = mysql_query($query,$link);
					$nok3 = mysql_affected_rows($link);
			
			
				for ($k=0; $k<count($videos); $k++) {
				
					$query = genetic_insert_has_video($cardid[$i],$videos[$i][$k]);
					$result = mysql_query($query, $link);
				}
			}//fin del for nuevo
			
			//insert new data
			
			for($j=$ncards; $j<count($term); $j++){
			
			
			$narrayc = 4;
			$array_card[$j] = array("$term[$j] ", "$definition[$j]", "$gramcat[$j]", "$context[$j]");
			// Language 1
			$empty[$j] = genetic_field_not_null($array_card[$j], $narrayc);
			
			
			if($empty[$j]!=1){
			
			$query = genetic_insert_card($genetic->id, $ni, $isolang[$j], $term[$j], $gramcat[$j], $definition[$j], $context[$j], $expression[$j], $notes[$j],$weight_type[$j]);		
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
										$query = genetic_insert_source($cardid, $sourceterm[$j], $sourcedefinition[$j], $sourcecontext[$j], $sourceexpression[$j], $sourcerv[$j], $sourcenotes[$j]);		
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
										if(($remission[$j]!="")||($rem_type[$j]!="")){	
										$query = genetic_insert_remission($cardid,$remission[$j],$rem_type[$j]);		
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
											
											//REMISIONES 
										for($r=0;$r<count($adjuntos);$r++){
											echo "datos2:".$remission2[$r]."".$rem_type2[$r]."";
										if(($remission2[$r]!="")||($rem_type2[$r]!="")){
																	
										$query = genetic_insert_remission($cardid,$remission2[$r],$rem_type2[$r]);		
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
											//REMISIONES dinamicas
											
										for($r=0;$r<count($enlacesnuevos);$r++){
											echo "datos3:".$remission3[$r]."".$rem_type3[$r]."";
										if(($remission3[$r]!="")||($rem_type3[$r]!="")){
																	
										$query = genetic_insert_remission($cardid,$remission3[$r],$rem_type3[$r]);		
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
									
										//añadir los sinonimos a la tabla genetic_synonyms_has_genetic_remission (solo a esta tabla porque estos sinonimos ya estan guardados)
										//(en la tabla de sinonimos, solo los asociamos a una remision determinada)
										
											//obtener la cantidad de elementos que tiene el array sinonimos
									
											//recorremos el array entero tot=numero de sinonimos para ese termino en ese idioma	
											
									//---añadido--- terminos audio
										for ($l=0; $l<count($audio[$j]); $l++){
											
															
																// insertar remissionid y synonymid delos sinonimos escogidos 
																$query = genetic_insert_has_audio($cardid, $audio[$j][$l]);		
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
																
																
															
											}		
									
									
								//---añadido--- guardar los video/s
								
								
															//echo "numero de videos".count($video[$i]);
															for ($k = 0; $k < count($video[$j]); $k++){
																// insertar cardid e idimage
																//echo "valor de cardid: " .$cardid;
																//echo "valor de id video: " .$video[$k];
																$query = genetic_insert_has_video($cardid, $video[$j][$k]);		
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
			
			
			
			
			
			
			
			
			
			
			
			
			}//end if empty
			
			}//end for insert new data
			$redirectmsg = get_string("updateok", "genetic");
			redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
			
			// Close the db    
			mysql_close($link);
		}
	}
	
	// Finish the page
	include('banner_foot.html');
	print_footer($course);	

?>
