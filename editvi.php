<?php  // $Id: editty.php,v 1.0 2012/06/14 10:45:00 Ana Mar�a Lozano de la Fuente Exp $
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
	
	// Param to know what doing with card types 
	$action = optional_param('action','',PARAM_ALPHA);
	
	// Get the form variables	
	$idvi = optional_param('idvi', 0, PARAM_INT);
	$name = optional_param('name', '', PARAM_TEXT);
	$name2 = optional_param('name2', '', PARAM_TEXT);
	$name_de = optional_param('name_de', '', PARAM_TEXT);
	$name_fr = optional_param('name_fr', '', PARAM_TEXT);
	$name_en = optional_param('name_en', '', PARAM_TEXT);
	$name3 = optional_param('name3', '', PARAM_TEXT);
	$video = optional_param('video', '', PARAM_TEXT);
	$pievideo = optional_param('pievideo', '', PARAM_TEXT);
	$pievideo_de = optional_param('pievideo_de', '', PARAM_TEXT);
	$pievideo_en = optional_param('pievideo_en', '', PARAM_TEXT);
	$pievideo_fr = optional_param('pievideo_fr', '', PARAM_TEXT);
	$srcvideo = optional_param('srcvideo', '', PARAM_TEXT);
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
    
    	$numfieldsremission[$idlanguage] = optional_param('numfieldsremission'.$idlanguage,0,PARAM_INT);
    	$j=0;
    	for($i=1;$i<=$numfieldsremission[$idlanguage];$i++){
    		if(optional_param('remission_'.$idlanguage.'_'.$i)!=null){
    			$remission[$idlanguage][$j]=optional_param('remission_'.$idlanguage.'_'.$i);
    			$rem_type[$idlanguage][$j]=optional_param('remtype_'.$idlanguage.'_'.$i);
    			$j++;
    		}
    		 
    	}
    
    
    	$prevvideo[$idlanguage] = optional_param('video'.$idlanguage, 0, PARAM_INT);
    	$audio[$idlanguage] = optional_param('audio'.$idlanguage, null, PARAM_INT);
    }
    // end of the hidden parameters
    
	// Check if current user is logged in
    require_login($course->id);

	// Log table
    add_to_log($course->id, "genetic", "edit videos", "editvi.php?id=$cm->id&idvi=$idvi&action=$action", "$genetic->id");
    
    
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
	$SESSION->genetic->current_tab = 'showvi';
	include('tabs.php');

	
	// Print the main part of the page    
	
	// Delete
	if ($action == "delete") {
		
		//echo $rutaDestino;
		$query = genetic_video_used($idvi);
		$result =mysql_query($query, $link);
		$nok = mysql_num_rows ($link);
		if($nok>0){
			$redirectmsg = "El vídeo no se puede eliminar porque está siendo utilizado en el diccionario.";
			redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
			// Close the db
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}else{		
		
			
			$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
			$dir=$rutaEnServidor.'/video';
			$rutaDestino=$dir.'/'.$name;
			unlink($rutaDestino);

			$query = genetic_delete_vi($idvi);
			$result = mysql_query($query,$link);
			$nok = mysql_affected_rows($link);
				
			// Delete ok or not?
			if($nok == -1) {
				$redirectmsg = get_string("deletevinok", "genetic");
				redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);			
				// Close the db    
				mysql_close($link);
				
			}
			$redirectmsg = get_string("deleteviok", "genetic")."<BR />";
			redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
			// Close the db    
			mysql_close($link);
		}
	}
	
		
	
	// Add or Edit
	else {		
		
		// Check if there is any obligatory field empty   
		if ($lang=="none")  {
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			echo_hidden_form($cm->id, $genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
				
		}
	
		else {
		
			// Add
			if ($action == "") {
			
				//---a�adido--- guardar video/s
				
					
										//Definir si el array fue definido y no es NULL	
										if (isset($_FILES["video"])) {
											//obtener la cantidad de elementos que tiene el array
											
													
												//Comprobar si se subio el archivo o es nulo
												if(is_uploaded_file($_FILES["video"]["tmp_name"])){
												
													//obtenemos la propiedad de cada imagen
													$nombrevideo = $_FILES['video']['name']; 
													$tipo_video = $_FILES['video']['type']; 
													$tamano_archivo = $_FILES['video']['size']; 
													$rutaTemporal=$_FILES['video']['tmp_name'];
													//$rutaEnServidor='C:\wamp\www\moodle\files';
													$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
													
													//check if course folder exists
													if(!file_exists($rutaEnServidor)){
														umask(0000);
														mkdir($rutaEnServidor,$CFG->directorypermissions);
													}
														
													//-------------------------------------------
														//check if video folder exist
											
														$dir=$rutaEnServidor.'/video';
														if (file_exists($dir)) {
															//echo "El directorio existe";
														} else {
															//echo "El directorio no existe";
															mkdir($dir,$CFG->directorypermissions);
														}
														
													
														$nocontinue=0;
													
													//comprobar que ese archivo no existe ya en la BD
														$query = genetic_search_vi($nombrevideo);
														$result = mysql_query($query,$link);
														$nok2 = mysql_affected_rows($link);
														if($nok2!=0){
														
														
															$query =genetic_show_lastvideo(); 
															$result = mysql_query($query,$link);
															$nok2 = mysql_affected_rows($link);
															$row = mysql_fetch_array($result);
															$idvideo = $row['id'];
															$format = substr( $nombrevideo, -4, 4 );
															$nombrevideo=$idvideo."".$format;
															
															echo get_string("insertvinok", "genetic");
															echo ": ";
															echo get_string("errnamevideoexists","genetic");
																													
															echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
																
															// Close the db
															mysql_close($link);
															$nocontinue=1;
															
															//echo"".$nombrevideo;
													
															//$redirectmsg = get_string("insertviexist", "genetic");
															//redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
															// Close the db    
															//mysql_close($link);
															// Finish the page
															//print_footer($course);
														
												
													}
													if($nocontinue==0){
													$rutaDestino=$dir.'/'.$nombrevideo;
									
														//compruebo si las caracter�sticas del archivo son las que deseo 
															if (!((strpos($tipo_video, "wav") || strpos($tipo_video, "avi")|| strpos($tipo_video, "wmv")|| strpos($tipo_video, "mp4"))&& ($tamano_archivo < 100000000) )) {
																echo  get_string('errorvideoextension','genetic');
																	echo get_string("insertvinok", "genetic");
																	echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
																	// Close the db    
																	mysql_close($link);
																	
													
															}else{ 
																	if (move_uploaded_file($_FILES['video']['tmp_name'], $rutaDestino)){
																		echo "El archivo ha sido cargado correctamente."; 
															
																	//insertar la imagen en la BBDD ---->la buena seria la de la linea comentada de abajo pero da error xq n las tablas no hay type_image
																	if($pievideo==""){$pievideo= get_string("nodescrlang","genetic");}
																	if($pievideo_en==""){$pievideo_en= get_string("nodescrlang","genetic");}
																	if($pievideo_fr==""){$piev_fr= get_string("nodescrlang","genetic");}
																	if($srcvideo==""){$srcvideo= get_string("nosrcvideo","genetic");}
																	if($pievideo_de==""){$pievideo_de= get_string("nodescrlang","genetic");}
															
																	$query = genetic_insert_vi($pievideo,$pievideo_de,$pievideo_en,$pievideo_fr,$nombrevideo ,$srcvideo, $lang);
																	$result = mysql_query($query,$link);
																	$nok = mysql_affected_rows($link);
																	//echo"valor de insertado es:".$nok;
																	// Insert ok or not?
																	if($nok == 0) {
																	echo get_string("insertvinok", "genetic");
																	echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
			
																	//Close the db    
																	mysql_close($link);
																	
																	}
															
																	echo get_string("insertviok", "genetic");
																	echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
																	// Close the db    
																	mysql_close($link);
																
															}
															else{ 
																echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
																echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
																// Close the db
																mysql_close($link);
																
															} 
												
														} //cierre del else si cumple las especificaciones dadas
													}//cierre del if no continue
													
											
												}  //cierre del if uploaded
												else{
													echo "NO SE SUBIO EL VIDEO";
													echo_hidden_form($cm->id,$genetic->id,$idheader,$bes,$authors,$ty,$domsubdom,$imagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$prevvideo,$originpage);
													// Close the db
													mysql_close($link);
													
												}
											}
										
				
			}
			
			// Edit
			else if ($action == "edit") {
			
			$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
			$dir=$rutaEnServidor.'/video';
			$archivoAnterior=$dir.'/'.$prename;
			$archivoPosterior=$dir.'/'.$name;
			
			if(file_exists($archivoPosterior)){
				echo "No se puede modificar el nombre del fichero del vídeo porque ya existe un fichero con ese nombre.";
				$redirectmsg = get_string("updateimnok", "genetic");
				redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
			
			}else{
				$query = genetic_search_vi($name);
				$result = mysql_query($query,$link);
				$nok2 = mysql_affected_rows($link);
				if($nok2!=0){
					echo "No se puede modificar el nombre del fichero del vídeo porque ya existe un fichero con ese nombre.";
					$redirectmsg = get_string("updateimnok", "genetic");
					redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
					
				}else{
			//echo $archivoAnterior;
			//echo $archivoPosterior;
				rename($archivoAnterior,$archivoPosterior);
						
				$query = genetic_update_vi($idvi, $name,$name2,$name_de,$name_fr,$name_en,$name3, $lang);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);

				// Update ok or not?
				if($nok == 0) {
					$redirectmsg = get_string("updatevinok", "genetic");
					redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);					
					// Close the db    
					mysql_close($link);
					// Finish the page
					print_footer($course);
				}
				$redirectmsg = get_string("updateviok", "genetic");
				redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
			}
			}
				// Close the db 
				mysql_close($link);
			}
		} 
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
