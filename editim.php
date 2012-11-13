<?php  // $Id: editty.php,v 1.0 2009/12/14 10:45:00 Irene Fernández Ramírez Exp $
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
	$idim = optional_param('idim', 0, PARAM_INT);
	$name = optional_param('name', '', PARAM_TEXT);
	$name_es = optional_param('name_es', '', PARAM_TEXT);
	$name_fr = optional_param('name_fr', '', PARAM_TEXT);
	$name_de = optional_param('name_de', '', PARAM_TEXT);
	$name_en = optional_param('name_en', '', PARAM_TEXT);
	$name3 = optional_param('name3', '', PARAM_TEXT);
	$image = optional_param('imagen', '', PARAM_TEXT);
	$pieimagen = optional_param('pieimagen', '', PARAM_TEXT);
	$pieimagen_de = optional_param('pieimagen_de', '', PARAM_TEXT);
	$pieimagen_en = optional_param('pieimagen_en', '', PARAM_TEXT);
	$pieimagen_fr = optional_param('pieimagen_fr', '', PARAM_TEXT);
	$srcimage = optional_param('srcimage', '', PARAM_TEXT);
	$prename = optional_param('prename', '', PARAM_TEXT);
	
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
    add_to_log($course->id, "genetic", "edit images", "editim.php?id=$cm->id&idim=$idim&action=$action", "$genetic->id");
    
    
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
	$SESSION->genetic->current_tab = 'showim';
	include('tabs.php');

	
	// Print the main part of the page    
	
	// Delete
	if ($action == "delete") {
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		// Select the card type (id)
		$query = genetic_delete_im($idim);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);
		
		$rutaEnServidor='C:\wamp\www\moodle\mod\genetic\imagen';
		$rutaDestino=$rutaEnServidor.'/'.$name;
		//echo $rutaDestino;
		unlink($rutaDestino);
		
		
		
		// Delete ok or not?
		if($nok == 0) {
			$redirectmsg = get_string("deleteimnok", "genetic");
			redirect($url="viewim.php?id={$cm->id}", $redirectmsg, $delay=-1);			
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);
		}
		$redirectmsg = get_string("deleteimok", "genetic")."<BR />";
		redirect($url="viewim.php?id={$cm->id}", $redirectmsg, $delay=-1);
		// Close the db    
		mysql_close($link);
		// Finish the page
		print_footer($course);
	}
	
	// Add or Edit
	else {

		
		
		// Check if there is any obligatory field empty 
/*		
		if ($image=="")  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
*/	
		//else {
			
			// Connect to the database
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			// Add
			if ($action == "") {
			
				//---añadido--- guardar la imagen/es
				
				
					
										//Definir si el array fue definido y no es NULL	
										if (isset($_FILES["imagen"])) {
											
														
												
												//Comprobar si se subio el archivo o es nulo
												if(is_uploaded_file($_FILES["imagen"]["tmp_name"])){
												
													//obtenemos la propiedad de cada imagen
														$nombreImagen = $_FILES['imagen']['name']; 
														$tipo_imagen = $_FILES['imagen']['type']; 
														$tamano_archivo = $_FILES['imagen']['size']; 
														$rutaTemporal=$_FILES['imagen']['tmp_name'];
														//$rutaEnServidor='../../files';
														$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
														
														//-------------------------------------------
														//check if imagen folder exist
											
														$dir=$rutaEnServidor.'/imagen';
														if (file_exists($directorio)) {
															//echo "El directorio existe";
														} else {
															//echo "El directorio no existe";
															umask(0000);

															mkdir($dir,$CFG->directorypermissions);
															
														}
														
														$rutaDestino=$dir.'/'.$nombreImagen;
														//echo"".$rutaDestino;
														
													//comprobar que ese archivo no existe ya en la BD
														$query = genetic_search_im($nombreImagen);
														$result = mysql_query($query,$link);
														$nok2 = mysql_affected_rows($link);
													if($nok2!=0){
													
															// ----añadido----Show the id of the last image
															$query =genetic_show_lastimage(); 
															$result = mysql_query($query,$link);
															$nok2 = mysql_affected_rows($link);
															$row = mysql_fetch_array($result);
															$idimage = $row['id'];
															$format = substr( $nombreImagen, -4, 4 );
															$nombreImagen=$idimage."".$format;
															
														
												
													}
												$rutaDestino=$dir.'/'.$nombreImagen;
												
												
												//compruebo si las características del archivo son las que deseo 
														if (!((strpos($tipo_imagen, "gif") || strpos($tipo_imagen, "jpg")|| strpos($tipo_imagen, "jpeg")) && ($tamano_archivo < 100000000))) {
															echo "La extensión o el tamaño de los archivos no es correcta. <br><br><table><tr><td><li>Se permiten archivos .gif o .jpg<br><li>se permiten archivos de 100 MB máximo.</td></tr></table>";
															$redirectmsg = get_string("insertimnok", "genetic");
															redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);
															// Close the db    
															mysql_close($link);
															// Finish the page
															print_footer($course);
												
													
														}
													else{ 
															
														
															
															if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)){
															
																	echo "El archivo ha sido cargado correctamente."; 
															
																//insertar la imagen en la BBDD ---->la buena seria la de la linea comentada de abajo pero da error xq n las tablas no hay type_image
															
																	if($pieimagen==""){$pieimagen= get_string("nodescrlang","genetic");}
																	if($pieimagen_en==""){$pieimagen_en= get_string("nodescrlang","genetic");}
																	if($pieimagen_fr==""){$pieimagen_fr= get_string("nodescrlang","genetic");}
																	if($srcimage==""){$srcimage= get_string("nosrcimage","genetic");}
																	if($pieimagen_de==""){$pieimagen_de= get_string("nodescrlang","genetic");}
																	$query = genetic_insert_im($pieimagen,$pieimagen_de,$pieimagen_en,$pieimagen_fr,$nombreImagen ,$srcimage);
																	$result = mysql_query($query,$link);
																	$nok = mysql_affected_rows($link);
																	
																	
															
																// Insert ok or not?
																if($nok == 0) {
																	$redirectmsg = get_string("insertimnok", "genetic");
																	redirect($url="addcard_form.php?id={$cm->id}", $redirectmsg, $delay=-1);					
																	// Close the db    
																	mysql_close($link);
																	// Finish the page
																	print_footer($course);
																}
																//echo $nok;
																	$redirectmsg = get_string("insertimok", "genetic");
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
										
											}
										
				
			}
			
			// Edit
			else if ($action == "edit") {
			
			$rutaEnServidor='C:\wamp\www\moodle\mod\genetic\imagen';
			
			$archivoAnterior=$rutaEnServidor.'/'.$prename;
			$archivoPosterior=$rutaEnServidor.'/'.$name;
			//echo $archivoAnterior;
			//echo $archivoPosterior;
			rename($archivoAnterior,$archivoPosterior);
			
				$query = genetic_update_im($idim, $name,$name_es,$name_de,$name_fr,$name_en,$name3);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);

				// Update ok or not?
				if($nok == 0) {
					$redirectmsg = get_string("updateimnok", "genetic");
					redirect($url="viewim.php?id={$cm->id}", $redirectmsg, $delay=-1);					
					// Close the db    
					mysql_close($link);
					// Finish the page
					print_footer($course);
				}
				$redirectmsg = get_string("updateimok", "genetic");
				redirect($url="viewim.php?id={$cm->id}", $redirectmsg, $delay=-1);
				// Close the db 
				mysql_close($link);
			}
		//}ELSE QUE ACABO DE QUITAR
		
		// Finish the page
		include('banner_foot.html');
		print_footer($course);
	}	

?>
