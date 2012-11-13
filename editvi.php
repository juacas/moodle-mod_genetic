<?php  // $Id: editty.php,v 1.0 2012/06/14 10:45:00 Ana María Lozano de la Fuente Exp $
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

	// File for managing the card types (add new ones, edit or delete them).

	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");
	
	


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
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		// Select the card type (id)
		$query = genetic_delete_vi($idvi);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);
		
		$rutaEnServidor='C:\wamp\www\moodle\mod\genetic\video';
		$rutaDestino=$rutaEnServidor.'/'.$name;
		//echo $rutaDestino;
		unlink($rutaDestino);
		
		
		
		// Delete ok or not?
		if($nok == 0) {
			$redirectmsg = get_string("deletevinok", "genetic");
			redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);			
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}
		$redirectmsg = get_string("deleteviok", "genetic")."<BR />";
		redirect($url="viewvi.php?id={$cm->id}", $redirectmsg, $delay=-1);
		// Close the db    
		mysql_close($link);
		// Finish the page
		print_footer($course);
	}
	
		
	
	// Add or Edit
	else {		
		
		// Check if there is any obligatory field empty   
		if ($lang=="none")  {
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
			
				//---añadido--- guardar video/s
				
					
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
													//check if the directory vidoe exist if not create one
													
													//-------------------------------------------
														//check if video folder exist
											
														$dir=$rutaEnServidor.'/video';
														if (file_exists($directorio)) {
															//echo "El directorio existe";
														} else {
															//echo "El directorio no existe";
															mkdir($dir,$CFG->directorypermissions);
														}
														
													
													
													
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
															//echo"".$nombrevideo;
													
															//$redirectmsg = get_string("insertviexist", "genetic");
															//redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
															// Close the db    
															//mysql_close($link);
															// Finish the page
															//print_footer($course);
														
												
													}
													
													$rutaDestino=$dir.'/'.$nombrevideo;
									
														//compruebo si las características del archivo son las que deseo 
															if (!((strpos($tipo_video, "wav") || strpos($tipo_video, "avi")|| strpos($tipo_video, "wmv")|| strpos($tipo_video, "mp4"))&& ($tamano_archivo < 100000000) )) {
																echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .wav o .avi o .wmv<br><li>se permiten archivos de 100 MB máximo.</td></tr></table>";
																	$redirectmsg = get_string("insertvinok", "genetic");
																	redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
																	// Close the db    
																	mysql_close($link);
																	// Finish the page
																	print_footer($course);
													
															}
															else{ 
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
																	$redirectmsg = get_string("insertvinok", "genetic");
																	redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);					
																	//Close the db    
																	mysql_close($link);
																	// Finish the page
																	print_footer($course);
																	}
															
																	$redirectmsg = get_string("insertviok", "genetic");
																	redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
																	// Close the db    
																	mysql_close($link);
																	// Finish the page
																	print_footer($course);
															
															}
															else{ 
																echo "Ocurrió algún error al subir el fichero. No pudo guardarse."; 
															} 
												
														} //cierre del else si cumple las especificaciones dadas
													
													
											
												}  //cierre del if uploaded
												else{
												echo "NO SE SUBIO EL VIDEO";
												}
											}
										
				
			}
			
			// Edit
			else if ($action == "edit") {
			
			$rutaEnServidor='C:\wamp\www\moodle\mod\genetic\video';
			
			$archivoAnterior=$rutaEnServidor.'/'.$prename;
			$archivoPosterior=$rutaEnServidor.'/'.$name;
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
				// Close the db 
				mysql_close($link);
			}
		} 
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
