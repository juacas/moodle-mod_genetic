<?php require_once("../../lib/fpdf/fpdf.php");
include("../../config.php");
require_once("db_functions.php");
require_once("lib.php");
require_once("selectsubdomainspdf.php");
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



// Get the form variables
$id = optional_param('id',0,PARAM_INT);
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
    add_to_log($course->id, "genetic", "search cards", "search.php?id=$cm->id", "$genetic->id");  
	
//	Get the necessary strings
	$strbe = utf8_decode(get_string("be", "genetic"));
	$strty = utf8_decode(get_string("ty", "genetic"));
	$strni = utf8_decode(get_string("ni", "genetic"));
	$strdom = get_string("dom", "genetic");
	$strsubdom = get_string("subdom", "genetic");
	$strauthor = get_string("author", "genetic");
	$strdate = utf8_decode(get_string("datecreated", "genetic"));
	$strterm = utf8_decode(get_string("term", "genetic"));
	$strnummatch = utf8_decode(get_string("nummatch", "genetic"));
	$strresultsearch = utf8_decode(get_string("resultsearch", "genetic"));
	$strfoot = utf8_decode(get_string("footsentencees", "genetic"));
	$strcriteria=utf8_decode(get_string("criteria", "genetic"));
	$strterm=utf8_decode(get_string("term", "genetic"));
	$strdate=utf8_decode(get_string("date", "genetic"));
	$strsearchword=utf8_decode(get_string("searchword", "genetic"));	
	$strterm = utf8_decode(get_string("term", "genetic"));
	$strgramcat = utf8_decode(get_string("gramcat", "genetic"));
	$strdefinition = utf8_decode(get_string("definition", "genetic"));
	$strcontext = utf8_decode(get_string("context", "genetic"));
	$strexpression = utf8_decode(get_string("expression", "genetic"));
	$strrv = utf8_decode(get_string("rv", "genetic"));
	$strnotes = utf8_decode(get_string("notes", "genetic"));
	$strsources = utf8_decode(get_string("sources", "genetic"));
	$strnosources = utf8_decode(get_string("nosources", "genetic"));
//NUEVAS CADENAS
	$strlang = utf8_decode(get_string("lang", "genetic"));
	$strimagenes=utf8_decode(get_string("imagenes", "genetic"));
	$straudio=utf8_decode(get_string("audio", "genetic"));
	$strvideos=utf8_decode(get_string("videos", "genetic"));
	$strrem=utf8_decode(get_string("rem", "genetic"));
	$strcross=utf8_decode(get_string("crossrelatedterms", "genetic"));
	

	
	$strwm=utf8_decode(get_string("wm", "genetic"));	
			//Conect to de DB	
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			
			// Make the card search
			$query = genetic_search_lang_c($genetic->id, $lang);
			$result = mysql_query($query,$link);
			
			//NUMBER OF MATCHES==number of pages I need
			$n = mysql_num_rows($result);
			
			//importar la clase // crea un nuevo pdf
			$pdf=new FPDF(); 

			 
			
			//define el tipo, estilo y tama�o de fuente / letra a utilizar
			$pdf->SetFont('Arial','B',12); 
			
			
			
			
			//Abro el numero de paginas que necesito
			for($z=0;$z<$n;$z++){
				
				
				// agrega una p�gina al pdf
				$pdf->AddPage();
				
				///------------------
				//HEAD DOCUMENT
				///-------------------
				$pdf->Header();
			
				// Logo
				$pdf->Image('images2/eurogene.jpg',10,8,33);
				// Arial bold 15
				$pdf->SetFont('Arial','B',15);
				// Movernos a la derecha
				$pdf->Cell(80);
				// T�tulo
				$pdf->Cell(30,10,utf8_decode($genetic->name),0,0,'C');
				// Salto de l�nea
				$pdf->Ln(20);
			
				//END HEAD DOCUMENT
				
				
				///---------------------------------------------------
				//BODY OF THE DOCUMENT, 
				///---------------------------------------------------
			
			
				//check if it is the first page:
				if($z==0){
					$pdf->Cell(80,10,$strresultsearch);
					$pdf->Ln();			
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(40,5,$strcriteria.': ');
					//$pdf->Cell(35);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(40,5,$strlang);
					
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(40,5,$strlang.': ');
					//$pdf->Cell(35);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(40,5,utf8_decode(get_string($lang, "genetic")));
					
					
					$pdf->Ln();
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(40,5,$strnummatch.': ');
					$pdf->SetFont('Arial','',8);
					//$pdf->Cell(35);
					$pdf->Cell(40,5,$n);
					//$pdf->Ln();
					//$pdf->Cell(20);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(20,5,$strdate);
					//$pdf->Cell(20);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(20,5,date('d/m/Y'),0,1,'L');
				}
				if($z!=0){$pdf->Ln();$pdf->Ln();}
			
				//if there are matches:
				if($n!=0){
		
					//Print  1 Card in each paper
	
						
						//Load the Header
					
						$cardrow = mysql_fetch_array($result);
						// Remove '\' from the entries and allow them in variables
						$cardrowisolang = stripslashes($cardrow['isolang']);
						$cardrowterm = stripslashes($cardrow['term']);
						$cardrowidheader = stripslashes($cardrow['idheader']);
					
						// Get the header
						$queryh = genetic_choose_header($cardrowidheader);
						$resulth = mysql_query($queryh,$link);					
						$headerrow = mysql_fetch_array($resulth);					
						// Remove '\' from the entries and allow them in variables
						$headerrowni = stripslashes($headerrow['id']);
						$headerrowty = stripslashes($headerrow['ty']);
					
						//$headerrowsubdom = stripslashes($headerrow['subdom']);
						$headerrowdate = date("j F Y", $headerrow['datecreated']);
					
						// Make queries for numerical fields				
						// BE - Deparment
						$queryaux = genetic_show_rel_be($headerrowni);
						$resultaux = mysql_query($queryaux, $link);
						$rowaux = mysql_fetch_array($resultaux);
						$headerbe = stripslashes($rowaux['name']);
						
						while ($rowaux = mysql_fetch_array($resultaux)) {
						
							$aux = stripslashes($rowaux['name']);
							$headerbe = $headerbe.", ".$aux;
						}
					
						// TY - Card type
						
						if($headerrowty == 0) {
							$headerrowty = $strnodefined;
						}
						
						else {
							$queryaux = genetic_choose_ty($headerrowty);
							$rowaux = mysql_fetch_array(mysql_query($queryaux, $link));
							$headerrowty = stripslashes($rowaux['name']);
						}
					
					
						// Author
						$queryauthor = genetic_show_rel_author($headerrowni);
						$resultauthor = mysql_query($queryauthor, $link);
				
						$rowauthor = mysql_fetch_array($resultauthor);
						$headerauthor1 = stripslashes($rowauthor['name']);
						$headerauthor2 = stripslashes($rowauthor['surname']);
						$headerauthor = $headerauthor1." ".$headerauthor2;
						while ($rowauthor = mysql_fetch_array($resultauthor )) {
					
							$headerauthor1 = stripslashes($rowauthor['name']);
							$headerauthor2 = stripslashes($rowauthor['surname']);
							$headerauthor3 = $headerauthor1." ".$headerauthor2;
							$headerauthor = $headerauthor.", ".$headerauthor3;
						}
					
						
						//Load the cards
						$query = genetic_show_cards($headerrowni);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
					
						//SEARCH DOCUMENT For each language term 
					
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
							
							$cardrowgramcat = stripslashes($cardrow['gramcat']);
							$cardrowdefinition = stripslashes($cardrow['definition']);
							$cardrowcontext = stripslashes($cardrow['context']);
							$cardrowexpression = stripslashes($cardrow['expression']);
							$cardrowweight = stripslashes($cardrow['weighting_mark']);
							$cardrownotes = stripslashes($cardrow['notes']);
							$cardrowid = stripslashes($cardrow['id']);
						
									
									///HEAD CARD----------------------------------
									
									
										//Print the header of the card if exist
								if($headerrowni!=0){
								$pdf->Cell(0,10);
								$pdf->Ln();
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(5,5,$strbe.': ');
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerbe));
								$pdf->Ln();
								
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(5,5,$strty.': ');
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerrowty));
								$pdf->Ln();
								
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(5,5,$strni.': ');
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerrowni));
								$pdf->Ln();
								
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(5,5,$strsubdom.': ');
								//$pdf->Ln();
								$pdf->Cell(20);								
								// Subdomain
						
									$query = genetic_show_rel_subdomain($headerrowni);
									$resultdom = mysql_query($query, $link);
									
									while ($row = mysql_fetch_array($resultdom)) {
										$headerrowsubdomiddom = stripslashes($row['iddom']);
										$headerrowsubdom = stripslashes($row['name']);
						
										//---------------------search tree subdomain
											//$cadena="";
										//$subdomparent=calcular_ruta_subdominiospdf($headerrowsubdomiddom,$cadena);
							
										//--------------------end of the search tree subdomain
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(15);
										$pdf->Cell(5,5,utf8_decode($headerrowsubdom));
										
										
									}
									
								//$pdf->Cell(15);
								$pdf->Ln();
								$pdf->SetFont('Arial','B',8);								
								$pdf->Cell(5,5,$strauthor.':');
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerauthor));
								$pdf->Ln();
								
								$pdf->SetFont('Arial','B',8);
								$pdf->Cell(5,5,$strdate);
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerrowdate));
								
								
								
						}//END OF "IF HEADER EXISTS	
									
									///END OF HEAD CARD--------------------------------
									if ($cardrowterm != '') {
									
										
									
										$pdf->SetFont('Arial','B',8);
										//$pdf->Ln();
										
										///$route= "images2\".$cardrowisolang.".jpg";
										//depends the language
										
										//$pdf->Image('images2\\'.$cardrowisolang.'.jpg',10,95,5,5);
										//$pdf->Image($CFG->dirroot.'\mod\genetic\images2\\'.$cardrowisolang.'.jpg',10,95,5,5);
										//$pdf->Cell(8+50*$k);
										$ruta=$CFG->dirroot.'/mod/genetic/images2'; 
										$pdf->Image($ruta.'/'.$cardrowisolang.'.jpg',10,95,5,5);
										$pdf->Ln();
										$pdf->Ln();
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(5,5,$strterm.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(5,5,utf8_decode($cardrowterm));
										
										$pdf->Ln(5);
									
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strgramcat.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(8,5,utf8_decode($cardrowgramcat));
										
										$pdf->Ln(5);
										
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strdefinition.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(120,5,utf8_decode($cardrowdefinition));
										
										$pdf->Ln();
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strcontext.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(120,5,utf8_decode($cardrowcontext));
									
										if($cardrowexpression!=""){	
										$pdf->Ln();
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strexpression.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(120,5,utf8_decode($cardrowexpression));
										}
										if($cardrowweight!=""){
										$pdf->Ln();
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strwm.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(120,5,utf8_decode(get_string($cardrowweight,"genetic")));
										}
										if($cardrownotes!=""){
										$pdf->Ln();
										
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strnotes.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(120,5,utf8_decode($cardrownotes));
										}
										///IMAGENES
										
											// ---a�adido---GET THE IMAGES  
						
											
																  
						
										$query2 = genetic_show_images($headerrowni);
										$resultc2 = mysql_query($query2, $link);
										$ncards2 = mysql_num_rows($resultc2);
						
						
										//ncard2 seria el numero de imagenes de cada termino
							  
										if($ncards2!=0){

										$pdf->Ln();
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strimagenes);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(12);
										$pdf->Cell(30,5,$strsources.':');
										
										//echo"<TR><TD><IMG SRC=\"images/Picture.gif\"><B>".$strimagenes."</B></TD><TD></TD><TD><B>".$strsrc."</TD></TR>";
											while($cardrow3 = mysql_fetch_array($resultc2))
											{
											//---a�adido---mostrar imagenes
						
						
												if($cardrowisolang=='es')
												{						
												$cardrowtitle_image = stripslashes($cardrow3['titleimage_es']);
												}
												if($cardrowisolang=='de')
												{
												$cardrowtitle_image = stripslashes($cardrow3['titleimage_de']);
												}
												if($cardrowisolang=='en')
												{
												$cardrowtitle_image = stripslashes($cardrow3['titleimage_en']);
												}
												if($cardrowisolang=='fr')
												{
												$cardrowtitle_image = stripslashes($cardrow3['titleimage_fr']);
												}
						
						
						
												$cardrowfile_image = stripslashes($cardrow3['fileimage']);
												$cardrowsrc_image = stripslashes($cardrow3['srcimage']);
						
						
												//$rutaDestino='../../../../moodledata/'.$COURSE->id.'/imagen/'.$cardrowfile_image;
												$rutaDestino=$CFG->dataroot.'/'.$COURSE->id.'/imagen/'.$cardrowfile_image;
					
												if($cardrowtitle_image!=''){
							
												$pdf->Ln();
												$pdf->Ln();
												$pdf->Cell(12);
												$pdf->Image($rutaDestino,25,140,5,5);
												//echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"50\" height=\"50\" ></TD><TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowtitle_image."</TD>";		
												$pdf->SetFont('Arial','',8);
												$pdf->Cell(12);
												$pdf->Cell(18,5,utf8_decode($cardrowtitle_image));
												//echo"<BR>";
												}
												else{
												//echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"50\" height=\"50\" ></TD><TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowfile_image."</TD>";
												$pdf->Ln();
												$pdf->Ln();
												$pdf->Cell(12);
												$pdf->Image($rutaDestino,25,140,10,10);
												$pdf->SetFont('Arial','',8);
												$pdf->Cell(12);
												$pdf->Cell(18,5,utf8_decode($cardrowfile_image));
												}
							
												
												$pdf->Cell(12);
												$pdf->Cell(30,5,utf8_decode($cardrowsrc_image));
						
											}
					
						
										}
						
										// ---a�adido---GET THE VIDEOS  
										$query4 = genetic_show_videos($cardrowid);
										$resultc4 = mysql_query($query4, $link);
										$ncards4 = mysql_num_rows($resultc4);
										
						
										if($ncards4!=0){
										$pdf->Ln();
										$pdf->Ln();
										$pdf->Cell(12);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(30,5,$strvideos);
										$pdf->SetFont('Arial','B',8);
										$pdf->Cell(12);
										$pdf->Cell(30,5,$straudio.':');
										$pdf->SetFont('Arial','B',8);
										//$pdf->Cell(12);
										$pdf->Cell(30,5,$strsources.':');
						
										//ncard3 seria el numero de videos de cada termino
										//echo"<TR><TD><B>".$strvideos."</B></TD><TD></TD><TD><B>".$straudio.":</TD><TD><B>".$strsrc."</TD></TR>";
											while($cardrow4 = mysql_fetch_array($resultc4))
											{
												//---a�adido---mostrar videos
							
												$cardrowfile_video = stripslashes($cardrow4['filevideo']);
												if($cardrowisolang=='es')
												{
												$cardrowtitle_video = stripslashes($cardrow4['titlevideo_es']);
												}
												if($cardrowisolang=='de')
												{
												$cardrowtitle_video = stripslashes($cardrow4['titlevideo_de']);
												}
												if($cardrowisolang=='en')
												{
												$cardrowtitle_video = stripslashes($cardrow4['titlevideo_en']);
												}
												if($cardrowisolang=='fr')
												{
												$cardrowtitle_video = stripslashes($cardrow4['titlevideo_fr']);
												}
						
												$cardrowsrc_video = stripslashes($cardrow4['srcvideo']);
												$cardrowlang_video = stripslashes($cardrow4['audiolang']);
						
												$rutaEnServidor='../../files';
												$rutaDestino=$rutaEnServidor.'/'.$cardrow4['filevideo'];
						
												if($cardrowtitle_video!=''){
													//echo "<TR><NOBR><TD><IMG SRC=\"images/Movie.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowtitle_video."</A></NOBR></TD>";		
													//$pdf->Ln();
													$pdf->Ln();
													$pdf->Cell(12);
													//$pdf->Image($rutaDestino,25,140,5,5);
							
													$pdf->SetFont('Arial','',8);
													//$pdf->Cell(10);
													$pdf->Cell(30,5,utf8_decode($cardrowtitle_video));
					
												}
												else{
													//echo "<TR><TD><IMG SRC=\"images/Movie.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowfile_video."</A></TD>";	
													//$pdf->Ln();
													$pdf->Ln();
													$pdf->Cell(12);
													//$pdf->Image($rutaDestino,25,140,5,5);
													$pdf->SetFont('Arial','',8);
													$pdf->Cell(10);
													$pdf->Cell(25,5,utf8_decode($cardrowfile_video));
							
													}
													//echo"<TD></TD><TD>&nbsp;".$cardrowlang_video."</TD>";	
													///echo"<TD>&nbsp;".$cardrowsrc_video."</TD></TR>";
													$pdf->SetFont('Arial','',8);
													$pdf->Cell(12);
													$pdf->Cell(30,5,utf8_decode($cardrowlang_video));
						
													//$pdf->Cell(12);
													$pdf->Cell(30,5,utf8_decode($cardrowsrc_video));
											}
										}//fin de videos
										
						
										//AUDIO FILES
						
										$query4 = genetic_show_audio($cardrowid);
										$resultc4 = mysql_query($query4, $link);
										$ncards4 = mysql_num_rows($resultc4);
										$cardrow4 = mysql_fetch_array($resultc4);
						
										if($ncards4!=0){
										//ncard4 seria el numero de archivos de audio de cada termino
							
										//---a�adido---mostrar archivo audio
							
											$cardrowidaudio = stripslashes($cardrow4['genetic_audio_id']);
											if($cardrowidaudio!=0){
											//echo"<TR><TD><B>".$straudio.":</B></TD></TR>";
								
											$pdf->Ln();
											$pdf->Cell(12);
											$pdf->SetFont('Arial','B',8);
											$pdf->Cell(30,5,$straudio.':');
											$pdf->SetFont('Arial','B',8);
											$pdf->Cell(12);
											$pdf->Cell(30,5,$strsources.':');
											}
							
											$query4 = genetic_show_audio_id($cardrowidaudio);
											$resultc4 = mysql_query($query4, $link);
											while($cardrow4 = mysql_fetch_array($resultc4))
											{
											$cardrowsrcaudio = stripslashes($cardrow4['srcaudio']);
											$cardrowaudioname = stripslashes($cardrow4['fileaudio']);
					
											$rutaEnServidor='../../files';
											$rutaDestino=$rutaEnServidor.'/'.$cardrow4['fileaudio'];
											//$pdf->Ln();
											$pdf->Ln();
											$pdf->Cell(12);
						
							
											$pdf->SetFont('Arial','',8);
											//$pdf->Cell(10);
											$pdf->Cell(30,5,utf8_decode($cardrowaudioname));
											$pdf->Cell(12);
											$pdf->Cell(30,5,utf8_decode($cardrowsrcaudio));

							
							
											}
						
						
										}
									
										//REMISIONES
						
										$query4 = genetic_search_remissions($cardrowid);
										$resultc4 = mysql_query($query4, $link);
										$ncards4 = mysql_num_rows($resultc4);
					
										//si hay remisiones:
										if($ncards4 !=0){
						
							
									//echo"<TR><TD><B>".$strrem."</B>&nbsp;&nbsp;</TD></TR>";
									
											$pdf->Ln();
											$pdf->Cell(12);
											$pdf->SetFont('Arial','B',8);
											$pdf->Cell(30,5,$strrem.':');
											$pdf->Ln();
								
									//para cada tipo:
											while( $cardrow6=mysql_fetch_array($resultc4)){
							
												$remissionstype = stripslashes($cardrow6['rem_type']);
												$query5 = genetic_search_remissions_rem($remissionstype);
												$resultc5 = mysql_query($query5, $link);
								
												$ncards5 = mysql_num_rows($resultc5);
												//si hay remisiones de un tipo:
												if($ncards5!=0){
								
												
													$pdf->Cell(15);
													$pdf->SetFont('Arial','B',8);
													$pdf->Cell(27,5,$str2=utf8_decode($str = get_string($remissionstype, "genetic")).':');
													while($cardrow5 = mysql_fetch_array($resultc5)){
														$remissions = stripslashes($cardrow5['remission']);

														$pdf->Cell(12);
														$pdf->SetFont('Arial','',8);
														$pdf->Cell(30,5,utf8_decode($remissions));
													}
								
												}
							
						
							
							
											}
							
										}					
									
									
						
						
									//-----------------Nueva consulta
						  
									$consulta = genetic_show_crossrelations2($cardrowterm);
									$resultado = mysql_query($consulta, $link);
									$numero = mysql_num_rows($resultado);
						  
						
									if($numero!=0){
									
											$pdf->Ln();
											$pdf->Cell(12);
											$pdf->SetFont('Arial','B',8);
											$pdf->Cell(30,5,$strcross.':');
										
										while($cardrow6 = mysql_fetch_array($resultado)){
									//---a�adido---mostrar crossrelations
						
											$cardrowcross = stripslashes($cardrow6['term']);
											$cardrowcross_link = stripslashes($cardrow6['isolang']);
										
											$pdf->Cell(12);
											$pdf->SetFont('Arial','',8);
											$pdf->Cell(30,5,utf8_decode($cardrowcross));
									
						
										}
								
									}	
						
									// Get SOURCES of each term
									$query = genetic_show_sources($cardrowid);
									$results = mysql_query($query, $link);
									// Get the source fields
									$sourcerow = mysql_fetch_array($results);			
									// Remove '\' from the entries and allow them in variables
									$sourcerowterm = stripslashes($sourcerow['srcterm']);
									$sourcerowdefinition = stripslashes($sourcerow['srcdefinition']);
									$sourcerowcontext = stripslashes($sourcerow['srccontext']);
									$sourcerowexpression = stripslashes($sourcerow['srcexpression']);
									
									$sourcerownotes = stripslashes($sourcerow['srcnotes']);
									// Empty fields?
									if (($sourcerowterm != '') || ($sourcerowdefinition != '') || ($sourcerowcontext != '') || ($sourcerowexpression != '') ||  ($sourcerownotes != '')) {
								// Print the entries of the sources
							
							
									//Fuentes:	
									$pdf->Ln();
									$pdf->Cell(12);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(30,5,$strsources);
							
									//srcdef
									$pdf->Ln();
									$pdf->Cell(15);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(27,5,$strdefinition);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,utf8_decode($sourcerowdefinition));
							
							
									//srccontext
									$pdf->Ln();
									$pdf->Cell(15);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(27,5,$strcontext);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,utf8_decode($sourcerowcontext));
						
						
									//srcexpr
									$pdf->Ln();
									$pdf->Cell(15);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(27,5,$strexpression);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,utf8_decode($sourcerowexpression));
							
									//srcrv
									$pdf->Ln();
									$pdf->Cell(15);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(27,5,$strrv);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,utf8_decode($sourcerowrv));
							
									//srcrv
									$pdf->Ln();
									$pdf->Cell(15);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(27,5,$strnotes);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,utf8_decode($sourcerownotes));
						
						
									}
									else {
							
						
									//srcrv
									$pdf->Ln();
									$pdf->Cell(12);
									$pdf->SetFont('Arial','B',8);
									$pdf->Cell(30,5,$strsources);
									$pdf->SetFont('Arial','',8);
									$pdf->Cell(12);
									$pdf->Cell(120,5,$strnosources);
									}

			
									
								}//fin de que existe un termino no nulo
									
						
						}//End of if there are matches 
			
			//---------------------------
			//END OF THE BODY DOCUMENT
			///----------------------------
			
			
			///------------------
			//FOOT DOCUMENT
			///--------------------
				
				//FOOT DOCUMENT
				$pdf->Footer();
				//$pdf->SetY(-10);
				// Logo
				$pdf->Image('images2/itnt.jpg',30,265,33);
				// Arial bold 15
				$pdf->SetY(250);
				$pdf->SetFont('Arial','I',8);
				$pdf->Ln(16);
				// Movernos a la derecha
				$pdf->Cell(60);
				// T�tulo
				$pdf->Cell(5,5,$strfoot,0,0);
				// Salto de l�nea
				//$pdf->SetY(265);
				$pdf->Ln(5);
				$pdf->Cell(0,5,'Page '.$pdf->PageNo().'/'.ceil($n),0,0,'C');
				
			}
			
			///-----------------------
			//END FOOT DOCUMENT
			///----------------------------
			
			
			// Salto de l�nea
			$pdf->Ln(20);
			
		

$pdf->Output(); 
// genera el pdf?>

