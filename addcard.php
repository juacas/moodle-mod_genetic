<?php  // $Id: addcard.php, v2.0 2012/06/21 10:15:00 Ana María Lozano de la Fuente Exp $
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

	// File for adding a genetic card

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	$confirm = optional_param('confirm', 0, PARAM_INT);
	// Get the form variables	
	$confirm = optional_param('confirm',0,PARAM_INT);
	$bes = optional_param('be', 0, PARAM_INT);
	$ty = optional_param('ty', 0, PARAM_INT);
	//$domsubdom = optional_param('domsubdom', 0, PARAM_TEXT);
	$domsubdom = optional_param('domsubdom', 0, PARAM_INT);
	$aux = explode("-", $domsubdom);
	$authors = optional_param('author', 0, PARAM_INT);
	$datecreated = optional_param('datecreated', 0, PARAM_INT);
	// Language 1
	$isolang = optional_param('isolang', 'null', PARAM_TEXT);
	$term = optional_param('term', 'null', PARAM_TEXT);
	$gramcat = optional_param('gramcat', 'null', PARAM_TEXT);
	
	$weight_type = optional_param('weight_type', 'null', PARAM_TEXT);
	$rem_type = optional_param('rem_type', 'null', PARAM_TEXT);
	$remission = optional_param('remission', 'null', PARAM_TEXT);
	
	$definition = optional_param('definition', 'null', PARAM_TEXT);
	$context = optional_param('context', 'null', PARAM_TEXT);
	$expression = optional_param('expression', 'null', PARAM_TEXT);
	//$rv = optional_param('rv', 'null', PARAM_TEXT);
	$notes = optional_param('notes', 'null', PARAM_TEXT);
	$sourceterm = optional_param('sourceterm', 'null', PARAM_TEXT);
	$sourcedefinition = optional_param('sourcedefinition', 'null', PARAM_TEXT);
	$sourcecontext = optional_param('sourcecontext', 'null', PARAM_TEXT);
	$sourceexpression = optional_param('sourceexpression', 'null', PARAM_TEXT);
	$sourcerv = optional_param('sourcerv', 'null', PARAM_TEXT);
	$sourcenotes = optional_param('sourcenotes', 'null', PARAM_TEXT);
	$synonyms = optional_param('synonyms', 0, PARAM_INT);
	$imagen = optional_param('imagen', 0, PARAM_INT);
	$video = optional_param('video', 0, PARAM_INT);
	$relatedterms = optional_param('relatedterms', 0, PARAM_INT);
	$audio = optional_param('audio', 0, PARAM_INT);
	//----añadido---lenguage 1
	$pieimagen = optional_param('pieimagen', 'null', PARAM_TEXT);
	$pievideo = optional_param('pievideo', 'null', PARAM_TEXT);
	$srcimage = optional_param('srcimage', 'null', PARAM_TEXT);
	$srcvideo = optional_param('srcvideo', 'null', PARAM_TEXT);
	$acronyms = optional_param('acronyms', 'null', PARAM_TEXT);
	$abreviaturas=optional_param('abreviaturas', 'null', PARAM_TEXT);
	$symbols = optional_param('symbols', 'null', PARAM_TEXT);
	$enlacesnuevos = optional_param('enlacesnuevos', 'null', PARAM_TEXT);
	$rem_type2 = optional_param('rem_type2', 'null', PARAM_TEXT);
	$remission2 = optional_param('remission2', 'null', PARAM_TEXT);
	$strviewfull=get_string("viewfullcard", "genetic");
	
	
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

	
	// Connect to the database
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
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
			
			$query = genetic_count_lang($genetic->id);
			$resultlang = mysql_query($query,$link);
			$numlang = mysql_affected_rows($link);
			
			// Check if there is any obligatory field empty
	
				$narrayc = 4;
				$empty2=0;
				
				for($u=0;$u<$numlang;$u++){
	
						$array_card[$u] = array("$term[$u] ", "$definition[$u]", "$gramcat[$u]", "$context[$u]");
	
						// Language 1
						$empty[$u] = genetic_field_not_null($array_card[$u], $narrayc);
						//$empty3[$u] = genetic_field_not_null2($array_card[$u], $narrayc);
						if($empty[$u]==1){
								$empty2++;
								//$z[$u]=genetic_field_which_null($array_card[$u], $narrayc);
								
					
						}
				
				}
			
		
		//Comprobar si hay algun campo vacio en la ficha en cualquier idioma
		if (($empty2==$numlang) ) {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfieldlanguage", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
		else {	
			
			
			
				
					//comprobar si el termino ya existe en  
					
				//if($confirm!=0){
				
							for($i=0;$i<$numlang;$i++){
							
								if($term[$i]!=''){
									//echo"termino dist de cero".$term[$i]."".$isolang[$i];
								$query2= genetic_term_exists($term[$i],$genetic->id);
								$result2= mysql_query($query2,$link);
								$n2= mysql_num_rows($result2);
						
								$row = mysql_fetch_array($result2);
								$headerrowni = $row['idheader'];
								
								}
							}
				
					//Term in any language already exists
				
					if(($n2!=0)&&($confirm!=1)){
				
						$msg2 = get_string("term_already_exists", "genetic");
				
						if($n2!=0)
						{	
						
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
							$contador=count($imagen);
							for($e=0;$e<count($imagen);$e++){
							
								
								echo "<INPUT TYPE=\"hidden\" NAME=\"imagen[ ]\" VALUE=\"".$imagen[$e]."\">";
								
							
							}
							
							for($i=0;$i<count($numlang)+1;$i++){
							
							
								echo "<INPUT TYPE=\"hidden\" NAME=\"term[]\" VALUE=\"".$term[$i]."\">";
								
								echo "<INPUT TYPE=\"hidden\" NAME=\"isolang[]\" VALUE=\"".$isolang[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"definition[]\" VALUE=\"".$definition[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"gramcat[]\" VALUE=\"".$gramcat[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"weight_type[]\" VALUE=\"".$weight_type[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"rem_type[]\" VALUE=\"".$rem_type[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"remission[]\" VALUE=\"".$remission[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"context[]\" VALUE=\"".$context[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"expression[]\" VALUE=\"".$expression[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"notes[]\" VALUE=\"".$notes[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourceterm[]\" VALUE=\"".$sourceterm[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourcedefinition[]\" VALUE=\"".$sourcedefinition[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourcecontext[]\" VALUE=\"".$sourceconyexy[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourceexpression[]\" VALUE=\"".$sourceexpression[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourcerv[]\" VALUE=\"".$sourcerv[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"sourcenotes[]\" VALUE=\"".$sourcenotes[$i]."\">";
								
								for($z=0;$z<count($synonyms);$z++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"synonyms[][]\" VALUE=\"".$synonyms[$i][$z]."\">";
								}
								for($e=0;$e<count($video);$e++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"video[][]\" VALUE=\"".$video[$i][$e]."\">";
								}
								for($r=0;$r<count($audio);$r++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"audio[][]\" VALUE=\"".$audio[$i][$r]."\">";
								}
								for($u=0;$u<count($relatedterms);$u++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"relatedterms[][]\" VALUE=\"".$relatedterms[$i][$u]."\">";
								}
								for($l=0;$l<count($crossrelatedterms);$l++){
								echo "<INPUT TYPE=\"hidden\" NAME=\"crossrelatedterms[][]\" VALUE=\"".$crossrelatedterms[$i][$l]."\">";
								}
								echo "<INPUT TYPE=\"hidden\" NAME=\"pieimagen[]\" VALUE=\"".$pieimagen[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"pievideo[]\" VALUE=\"".$pievideo[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"srcimage[]\" VALUE=\"".$srcimage[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"srcvideo[]\" VALUE=\"".$srcvideo[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"acronyms[]\" VALUE=\"".$acronyms[$i]."\">";
								echo "<INPUT TYPE=\"hidden\" NAME=\"abreviaturas[]\" VALUE=\"".$abreviaturas[$i]."\">";
	
							}
							
							
							echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
							echo "<input type=\"submit\" value=\"".$str = get_string("accept", "genetic")."\" name=\"buttondelete\" />";
							echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"history.back()\"/>";
							echo "<TD></TD><TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></a></TD></TR>";
							echo "</TD></TR>";
							echo "</FORM></TABLE>";
							print_box_end($return=false);
							
						
						
						}
					
					} //FIN DEL IF SI EXISTE EN ALGUN IDIOMA
			
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
					}
			
					else {
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
						
						
					for ($i=0; $i<count($term); $i++){ 
						
							if($term[$i]!=""){	
						
								$query = genetic_insert_card($genetic->id, $ni, $isolang[$i], $term[$i], $gramcat[$i], $definition[$i], $context[$i], $expression[$i], $notes[$i],$weight_type[$i]);		
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
										$query = genetic_insert_source($cardid, $sourceterm[$i], $sourcedefinition[$i], $sourcecontext[$i], $sourceexpression[$i], $sourcerv[$i], $sourcenotes[$i]);		
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
										if(($remission[$i]!="")||($rem_type[$i]!="")){
																	
										$query = genetic_insert_remission($cardid,$remission[$i],$rem_type[$i]);		
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
										for($r=0;$r<count($enlacesnuevos);$r++){
											//echo "datos:".$remission."".$rem_type."".$;
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
										//añadir los sinonimos a la tabla genetic_synonyms_has_genetic_remission (solo a esta tabla porque estos sinonimos ya estan guardados)
										//(en la tabla de sinonimos, solo los asociamos a una remision determinada)
										
											//obtener la cantidad de elementos que tiene el array sinonimos
									
											//recorremos el array entero tot=numero de sinonimos para ese termino en ese idioma	
											
									//---añadido--- terminos audio
										for ($l=0; $l<count($audio[$i]); $l++){
											
															
																// insertar remissionid y synonymid delos sinonimos escogidos 
																$query = genetic_insert_has_audio($cardid, $audio[$i][$l]);		
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
															for ($k = 0; $k < count($video[$i]); $k++){
																// insertar cardid e idimage
																//echo "valor de cardid: " .$cardid;
																//echo "valor de id video: " .$video[$k];
																$query = genetic_insert_has_video($cardid, $video[$i][$k]);		
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
						
							}//fin de que existe termino !=0
						
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
