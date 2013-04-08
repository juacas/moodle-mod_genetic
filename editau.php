<?php  // $Id: editau.php,v 1.0 2009/12/14 10:45:00 Irene Fern�ndez Ram�rez Exp $
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

	// File for managing the card types (add new ones, edit or delete them).

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");
    require_once('echo_hidden_form.php');

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	$idcard = optional_param('idcard',0,PARAM_INT);
	
	// Param to know what doing with card types 
	$action = optional_param('action','',PARAM_ALPHA);
	
	// Get the form variables	
	$idau = optional_param('idau', 0, PARAM_INT);
	$name = optional_param('name', '', PARAM_TEXT);
	//$idcard = optional_param('idcard', '', PARAM_TEXT);
	$name3 = optional_param('name3', '', PARAM_TEXT);
	$audio = optional_param('audio', '', PARAM_TEXT);
	$srcaudio = optional_param('srcau', '', PARAM_TEXT);
	$term = optional_param('term', '', PARAM_TEXT);
	$prename = optional_param('prename', '', PARAM_TEXT);
	$lang = optional_param('lang', '', PARAM_TEXT);
    
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
	
    // parameters (hidden) used to fill in the add_card form with the data the user entered previously
    $originpage = optional_param('originpage',null, PARAM_TEXT);
    $idheader = optional_param('idheader',0,PARAM_INT);
    $bes = optional_param('be', 0, PARAM_INT);
    $ty = optional_param('ty', 0, PARAM_INT);
    $domsubdom = optional_param('domsubdom', 0, PARAM_INT);
    $authors = optional_param('author', 0, PARAM_INT);
    $imagen = optional_param('prevformimagen', 0, PARAM_INT);
    //	$isolang = optional_param('isolang', null, PARAM_TEXT);
    
    
    // parameter depending on the language
    
    //take the ids of the languages of the dictionary
    $query=genetic_id_lang($genetic->id);
    // Connect to the database
    $link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
    $resultlang = mysql_query($query,$link);
    while($langrow=mysql_fetch_array($resultlang))
    {
    	$idlanguage=$langrow['genetic_lang_id'];
    	$isolang[$idlanguage] = optional_param('isolang'.$idlanguage, null, PARAM_TEXT);
    	$prevterm[$idlanguage] = optional_param('term'.$idlanguage, null, PARAM_TEXT);
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
    
    	$numfieldsremission[$idlanguage] = optional_param('numfieldsremission'.$idlanguage,0,PARAM_INT);
    	$j=0;
    	for($i=1;$i<=$numfieldsremission[$idlanguage];$i++){
    		if(optional_param('remission_'.$idlanguage.'_'.$i)!=null){
    			$remission[$idlanguage][$j]=optional_param('remission_'.$idlanguage.'_'.$i);
    			$rem_type[$idlanguage][$j]=optional_param('remtype_'.$idlanguage.'_'.$i);
    			$j++;
    		}
    		 
    	}
    
    
    	$video[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
    	$prevaudio[$idlanguage] = optional_param('audio'.$idlanguage, null, PARAM_INT);
    }
    // end of the hidden parameters
    
	// Check if current user is logged in
    require_login($course->id);

	// Log table
    add_to_log($course->id, "genetic", "edit audio", "editau.php?id=$cm->id&idau=$idau&action=$action", "$genetic->id");
    
    
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");

	
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

	// Print the tabs
	$SESSION->genetic->current_tab = 'showau';
	include('tabs.php');

	
	// Print the main part of the page    
	
	// Delete
	if ($action == "delete") {
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		$query = genetic_audio_used($idau);
		$result =mysql_query($query, $link);
		$nok = mysql_num_rows ($link);
		if($nok>0){
			$redirectmsg = "El audio no se puede eliminar porque está siendo utilizado en el diccionario.";
			redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);
			// Close the db
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}else{
		
			$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
			$dir=$rutaEnServidor.'/audio';
			$rutaDestino=$dir.'/'.$name;
			
			if(!unlink($rutaDestino))
			{
				$redirectmsg = get_string("deleteaunok", "genetic");
				redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);
			}else{
			
				// Remove the audio from database 
				//$query = genetic_remove_audiocards($idau);   //this sentences eliminate the link between audio and card
				//$result = mysql_query($query,$link);
				//$nok = mysql_affected_rows($link);
				
				$query2 = genetic_remove_audio($idau);
				$result2 = mysql_query($query2,$link);
				$nok2 = mysql_affected_rows($link);
				
				// Delete ok or not?
				if($nok == 0) {
						$redirectmsg = get_string("deleteaunok", "genetic");
						redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);			
						// Close the db    
						mysql_close($link);
						// Finish the page
						print_footer($course);
					}
					$redirectmsg = get_string("deleteauok", "genetic")."<BR />";
					redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);
				}
			}
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
	}
	
	// Add or Edit
	else {		
		// Check if there is any obligatory field empty   
		if (($srcaudio == "")&&($action==""))  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
	
		else {
			
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			// Add
			if ($action == "") {
			
				//---a�adido--- guardar el audio
					
										//Definir si el array fue definido y no es NULL	
										if (isset($_FILES["audio"])) {
											//obtener la cantidad de elementos que tiene el array
											
												
												//Comprobar si se subio el archivo o es nulo
												if(is_uploaded_file($_FILES["audio"]["tmp_name"])){
												
													//obtenemos la propiedad de cada audio
														$nombreAudio = $_FILES['audio']['name']; 
														$tipo_audio = $_FILES['audio']['type']; 
														$tamano_archivo = $_FILES['audio']['size']; 
														$rutaTemporal=$_FILES['audio']['tmp_name'];
														//$rutaEnServidor='C:\wamp\www\moodle\files';
														$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
														//-------------------------------------------
														
														// create the folder of the course if it does not exist
														if(!file_exists($rutaEnServidor)){
															umask(0000);
															mkdir($rutaEnServidor,$CFG->directorypermissions);
														}
														
														//check if audio folder exist
											
														$dir=$rutaEnServidor.'/audio';
														if (file_exists($dir)) {
															//echo "El directorio existe";
														} else {
															//echo "El directorio no existe";
															mkdir($dir,$CFG->directorypermissions);
														}
														
														$rutaDestino=$dir.'/'.$nombreAudio;
														if(file_exists($rutaDestino)){
															echo "No se ha podido crear el fichero de audio porque existe un fichero con el mismo nombre<br /><br />";
															echo get_string("insertaudionok", "genetic");
															echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$prevterm,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$prevaudio,$video,$originpage);
															// Close the db
															mysql_close($link);
															// Finish the page
															print_footer($course);
															
														}else{
													
													
														
															//comprobar que ese archivo no existe ya en la BD 
															$query = genetic_search_au($nombreAudio);
															$result = mysql_query($query,$link);
															$nok2 = mysql_affected_rows($link);
														
																		if($nok2!=0){
																		
																			echo "No se ha podido crear el fichero de audio porque existe un fichero con el mismo nombre<br /><br />";
																			echo get_string("insertaudionok", "genetic");
																			echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$prevterm,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$prevaudio,$video,$originpage);
																			// Close the db
																			mysql_close($link);
																			// Finish the page
																			print_footer($course);
																		//$query =genetic_show_lastaudio(); 
																		//$result = mysql_query($query,$link);
																		//$nok2 = mysql_affected_rows($link);
																		//$row = mysql_fetch_array($result);
																		//$idaudio = $row['id'];
																		//$format = substr( $nombreAudio, -4, 4 );
																		//$nombreAudio=$idaudio."".$format;
																		//echo"".$nombreAudio;
													
																			//$redirectmsg = get_string("insertauexist", "genetic");
																			//redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
																			// Close the db    
																			//mysql_close($link);
																			// Finish the page
																			//print_footer($course);
														
												
																		}else{
																		
													
																		
													
													
																			//compruebo si las caracter�sticas del archivo son las que deseo 
																				if (!(( strpos($tipo_audio, "wav") || strpos($tipo_audio, "mp3") || strpos($tipo_audio, "mpeg")) && ($tamano_archivo < 10000000))) {
																					echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .wav o .mp3<br><li>se permiten archivos de 100 MB máximo.</td></tr></table>";
																					echo get_string("insertaudionok", "genetic");
																					echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$prevterm,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$prevaudio,$video,$originpage);
																					// Close the db    
																					mysql_close($link);
																					// Finish the page
																					print_footer($course);
												
													
																				}
																				else{ 
																					
																					if (move_uploaded_file($_FILES['audio']['tmp_name'], $rutaDestino)){
																					echo "El archivo ha sido cargado correctamente."; 
															
																					//insertar el audio en la BBDD 
															
																					$query = genetic_insert_au($nombreAudio ,$srcaudio,$lang);
																					$result = mysql_query($query,$link);
																					$nok = mysql_affected_rows($link);
																	
															
																					// Insert ok or not?
																					if($nok == 0) {
																					echo get_string("insertaudionok", "genetic");
																					echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$prevterm,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$prevaudio,$video,$originpage);
						
																					// Close the db    
																					mysql_close($link);
																					// Finish the page
																					print_footer($course);
																					}else{
																					//echo $nok;
																					echo get_string("insertaudiook", "genetic");
																					echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$prevterm,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$prevaudio,$video,$originpage);
																					// Close the db    
																					mysql_close($link);
																					// Finish the page
																					print_footer($course);
																					}
																					}
																					else{ 
																						echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
																						echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
																						
																					} 
												
																				} //cierre del else si cumple las especificaciones dadas
													
																		
														
														} //close the if nok
														}
											}
					}					
				
			}
			
			// Edit
			else if ($action == "edit") {
			
			$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
			//-------------------------------------------
			//check if audio folder exist
				
			$dir=$rutaEnServidor.'/audio';
			
			
			if (file_exists($dir)) {
				//echo "El directorio existe";
			} else {
				//echo "El directorio no existe";
				mkdir($dir,$CFG->directorypermissions);
			}
			
			//$rutaDestino=$dir.'/'.$nombreAudio;
			
			$archivoAnterior=$dir.'/'.$prename;
			$archivoPosterior=$dir.'/'.$name;
			
			if(file_exists($archivoPosterior)){
				echo "No se ha podido modificar el nombre del fichero de audio porque existe un fichero con el mismo nombre<br /><br />";
				echo get_string("insertaudionok", "genetic");
				redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);			
				// Close the db
				mysql_close($link);
				// Finish the page
				print_footer($course);
					
			}else{
				
				$query = genetic_search_au($name);
				$result = mysql_query($query,$link);
				$nok2 = mysql_affected_rows($link);
				if($nok2!=0){
					echo "No se ha podido modificar el nombre del fichero de audio porque existe un fichero con el mismo nombre<br /><br />";
					echo get_string("insertaudionok", "genetic");
					redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);			
					// Close the db
					mysql_close($link);
					// Finish the page
					print_footer($course);
				}else{
					rename($archivoAnterior,$archivoPosterior);
				
								$query = genetic_update_au($idau,$name,$name3,$lang);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);
							//	$row = mysql_fetch_array($result);
				
									// Update ok or not?
									if($nok == 0) {
									$redirectmsg = get_string("updateaudionok", "genetic");
									redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);					
									// Close the db    
									mysql_close($link);
									// Finish the page
									print_footer($course);
									}
									
						$redirectmsg = get_string("updateaudiook", "genetic");
						redirect($url="viewau.php?id={$cm->id}", $redirectmsg, $delay=-1);
						// Close the db 
						mysql_close($link);
				}		
			}
			}
		
		}//finish del add or edit
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
