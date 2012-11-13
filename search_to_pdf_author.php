<?php require_once("fpdf/fpdf.php");
include("../../config.php");
require_once("db_functions.php");
require_once("lib.php");
require_once("selectsubdomainspdf.php");
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


// Get the form variables
$id = optional_param('id',0,PARAM_INT);
$author = optional_param('author', '', PARAM_TEXT);

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
	$strbe = get_string("be", "genetic");
	$strty = get_string("ty", "genetic");
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
			
			//Conect to de DB	
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			$queryauthor = genetic_exist_author($author);
			$resultauthor = mysql_query($queryauthor,$link);
			$nauthor = mysql_num_rows($resultauthor);
			
			for ($w=0; $w<$nauthor; $w++) {
				
					$row = mysql_fetch_array($resultauthor);
					$auid = $row['id'];
					
					
					// Search relation author-header
					$query = genetic_search_author($auid);					
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					
					//Search the headercards
						for ($j=0; $j<$n; $j++) {
						
							$row = mysql_fetch_array($result);
							$headerrowni = $row['idheadercard'];
							$s = mysql_num_rows($result);
							// Make the card search
							$queryh = genetic_choose_header($headerrowni);					
							$resulth = mysql_query($queryh,$link);
							
							}
					
			
			}
			
			
			//importar la clase // crea un nuevo pdf
			$pdf=new FPDF(); 

			 
			
			//define el tipo, estilo y tamaño de fuente / letra a utilizar
			$pdf->SetFont('Arial','B',12); 
			
			
			//number of pages i need to show the search
			$numpag=($s/4);
			
			//Abro el numero de paginas que necesito
			for($z=0;$z<$numpag;$z++){
				
				
				// agrega una página al pdf
				$pdf->AddPage();
				///------------------
				//HEAD DOCUMENT
				$pdf->Header();
			
				// Logo
				$pdf->Image('images2/eurogene.jpg',10,8,33);
				// Arial bold 15
				$pdf->SetFont('Arial','B',15);
				// Movernos a la derecha
				$pdf->Cell(80);
				// Título
				$pdf->Cell(30,10,$genetic->name,0,0,'C');
				// Salto de línea
				$pdf->Ln(20);
			
				//END HEAD DOCUMENT
				///----------------------
				//BODY OF THE DOCUMENT, BEGIN OF THE LOOP OF THE CONTENT
			
			
			
				//check if it is the first page:
				if($z==0){
					$pdf->Cell(40,10,$strresultsearch);
					$pdf->Ln();			
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(5,5,$strcriteria.': ');
					$pdf->Cell(35);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(5,5,$strauthor);
					$pdf->Ln();
					$pdf->Cell(5,5,$strnummatch.': ');
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(35);
					$pdf->Cell(5,5,$s);
					//$pdf->Ln();
					$pdf->Cell(20);
					$pdf->SetFont('Arial','B',8);
					$pdf->Cell(5,5,$strdate);
					$pdf->Cell(20);
					$pdf->SetFont('Arial','',8);
					$pdf->Cell(5,5,date('d/m/Y'),0,1,'L');
				}
					if($z!=0){$pdf->Ln(5);}
			
				//if there are matches:
				if($s!=0){
					
					//Load the Header
						for ($t=0; $t<$nauthor; $t++){ 
						
							$queryauthor = genetic_exist_author($author);
							$resultauthor = mysql_query($queryauthor,$link);
				
							$row = mysql_fetch_array($resultauthor);
								$auid = $row['id'];
							
					
							// Search relation author-header
							$query = genetic_search_author($auid);					
							$result = mysql_query($query,$link);
							$n = mysql_num_rows($result);
					
							//Search the headercards
						for ($e=0; $e<$s; $e++){ 
							
							
						
							$row = mysql_fetch_array($result);
							$headerrowni = $row['idheadercard'];
							
							// Make the card search
							$queryh = genetic_choose_header($headerrowni);
							$resulth = mysql_query($queryh,$link);
							
							
							//Print  4 Cards in each paper
				
							for($i=0; $i<4; $i++){
			
								
								//Load the Header
						
					
						
								// Get the header
											
								$headerrow = mysql_fetch_array($resulth);
								$headerrowni = stripslashes($headerrow['id']);
											
								// Remove '\' from the entries and allow them in variables
								$headerrowni = stripslashes($headerrow['id']);
								$headerrowty = stripslashes($headerrow['ty']);
						
								$headerrowsubdom = stripslashes($headerrow['subdom']);
								$headerrowdate = date("F Y", $headerrow['datecreated']);
					
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
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
							
									$pdf->Ln();
									$pdf->Ln();
				
									if ($cardrowterm != '') {
									
										
										
										$pdf->SetFont('Arial','B',8);
										
										//depends the language
										$pdf->Image('images2\\'.$cardrowisolang.'.jpg',10+50*$k,60+2*$y,5,5);
										
										$pdf->Cell(8+50*$k);
										$pdf->SetFont('Arial','B',8);
										
										$pdf->Cell(5,5,$strterm.': ');
										$pdf->SetFont('Arial','',8);
										$pdf->Cell(12);
										$pdf->Cell(5,5,utf8_decode($cardrowterm));
										
										//$pdf->Ln();
										$pdf->Cell(90);
									}
									
						}
					//End of the terms in the diferent languages
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
								$pdf->Cell(5,5,$strdate.':');
								$pdf->SetFont('Arial','',8);
								$pdf->Cell(35);
								$pdf->Cell(5,5,utf8_decode($headerrowdate));
								
								
								
								
						}//END OF "IF HEADER EXISTS	

								
			
					}//End on every header match
				//los dos fines del for nautir:
					}
						
					}
				}//End of if there are matches 
			
			//END OF THE LOOP OF THE PAGE CONTENT
			//END OF THE BODY DOCUMENT
			
			///----------------------------
			
			//FOOT DOCUMENT
			
				
				//FOOT DOCUMENT
				$pdf->Footer();
				//$pdf->SetY(-10);
				// Logo
				$pdf->Image('images2/itnt.jpg',30,265,33);
				// Arial bold 15
				$pdf->SetFont('Arial','I',8);
				$pdf->Ln(16);
				// Movernos a la derecha
				$pdf->Cell(60);
				// Título
				$pdf->Cell(5,5,$strfoot,0,0);
				// Salto de línea
				//$pdf->SetY(265);
				$pdf->Ln(5);
				$pdf->Cell(0,5,'Page '.$pdf->PageNo().'/'.ceil($numpag),0,0,'C');
				
			}
			//END FOOT DOCUMENT
			
			
			
			// Salto de línea
			$pdf->Ln(20);
			
		

$pdf->Output(); 
// genera el pdf?>

