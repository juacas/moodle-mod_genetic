<?php
    //include("../../config.php");
    //require_once("db_functions.php");
    //require_once("lib.php");
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

	
require_once("selectsubdomains.php");
	
		
function genetic_subdomains2($idgenetic,$id,$dom)
		{
		
		// Necessary parameters
   
    
	
	//Get the strings wich are necessaries
    $strterminologies = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	
	$striconedit = get_string("edit", "genetic");
	$stricondelete = get_string("delete", "genetic");
	$strnodefined = get_string("nodefined", "genetic");
	
	$strbe = get_string("be", "genetic");
	$strty = get_string("ty", "genetic");
	$strni = get_string("ni", "genetic");
	$strdom = get_string("dom", "genetic");
	$strsubdom = get_string("subdom", "genetic");
	$strauthor = get_string("author", "genetic");
	$strdate = get_string("datecreated", "genetic");

	$strterm = get_string("term", "genetic");
	$strgramcat = get_string("gramcat", "genetic");
	$strdefinition = get_string("definition", "genetic");
	$strcontext = get_string("context", "genetic");
	$strexpression = get_string("expression", "genetic");
	$strrv = get_string("rv", "genetic");
	$strnotes = get_string("notes", "genetic");
	$strsources = get_string("sources", "genetic");
	$strnosources = get_string("nosources", "genetic");		

	//NUEVAS CADENAS
	$strlang = get_string("lang", "genetic");
	$strimagenes=get_string("imagenes", "genetic");
	$strtitle_image=get_string("title_image", "genetic");
	$strsrc=get_string("src", "genetic");
	$strsrc_image=get_string("src_image", "genetic");
	$strtitle_video=get_string("title_video", "genetic");
	$strsrc_video=get_string("src_video", "genetic");
	$strvideos=get_string("videos", "genetic");
	$strsiglas=get_string("siglas", "genetic");
	$strabreviaturas=get_string("abreviaturas", "genetic");
	$stracronyms=get_string("acronyms", "genetic");
	$strnomsynonym=get_string("synonym", "genetic");
	$strcross=get_string("crossrelatedterms", "genetic");
	$strseealso=get_string("seealso", "genetic");
	$strrelatedterms=get_string("relatedterms", "genetic");
	$straudio=get_string("audio", "genetic");
	$strviewfull=get_string("viewfullcard", "genetic");	
		
		//$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);			
					//echo "<BR>id dominio: ".$dom;
					
					//Look for the sons::
					$query_rsRegistro = genetic_arbol2($dom);
					$rsRegistro = mysql_query($query_rsRegistro);
					
					$row_rsRegistro = mysql_fetch_array($rsRegistro);
					
					$totalRows_rsRegistro = mysql_num_rows($rsRegistro);
					
				
							

							// Ejecutamos la funcion dentro de si misma (busqueda de fichas con subdominios internos)
						
							$query = genetic_search_domain_h($idgenetic, $dom);
			
							$result = mysql_query($query);
							//number of cards with this subdomain
							$n = mysql_num_rows($result);
							
									
					
									if ($n>0) {
									
											
						
											//Search the headercards //print the cards
											for ($j=0; $j<$n; $j++) {
						
											
							
											// Get the header cards fields
											while ($headerrow = mysql_fetch_array($result)) {
											
											
											
											
											// Remove '\' from the entries and allow them in variables
												$headerrowidgenetic = stripslashes($headerrow['id_genetic']);
								
												
													$headerrowni = stripslashes($headerrow['id']);
													$headerrowty = stripslashes($headerrow['ty']);
													$headerrowdate = date("F Y", $headerrow['datecreated']);	
									
														// Make queries for numerical fields
								
													// BE - Department
													$queryaux = genetic_show_rel_be($headerrowni);
													$resultaux = mysql_query($queryaux);
													$rowaux = mysql_fetch_array($resultaux);
													$headerbe = stripslashes($rowaux['name']);
													while ($rowaux = mysql_fetch_array($resultaux)) {
													$aux = stripslashes($rowaux['name']);
													$headerbe = $headerbe.", ".$aux;
													}
									
												
													
														//Author
													
													$queryauthor = genetic_show_rel_author($headerrowni);
													$resultauthor = mysql_query($queryauthor);
				
													$rowauthor = mysql_fetch_array($resultauthor);
													$headerauthor1 = stripslashes($rowauthor['name']);
													$headerauthor2 = stripslashes($rowauthor['surname']);
													$headerauthor = $headerauthor1." ".$headerauthor2;
													while ($rowauthor = mysql_fetch_array($resultauthor)) {
					
														$headerauthor1 = stripslashes($rowauthor['name']);
														$headerauthor2 = stripslashes($rowauthor['surname']);
														$headerauthor3 = $headerauthor1." ".$headerauthor2;
														$headerauthor = $headerauthor.", ".$headerauthor3;
													}
													
				
													// TY - Card type
													if($headerrowty == 0) {
													$headerrowty = $strnodefined;
													}
													else {
														$queryaux = genetic_choose_ty($headerrowty);
														$rowaux = mysql_fetch_array(mysql_query($queryaux));
														$headerrowty = stripslashes($rowaux['name']);
													}
						
												/*
													//Button for new searches
													echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
													echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
													echo "</FORM>";
													echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_subdom2.php?id=$id&dom=$dom\" ENCTYPE=\"multipart/form-data\">";	
													echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
													echo "</FORM></TABLE>";
												*/	
													// Get the fields and print the resulting cards
									
													$query = genetic_show_cards($headerrowni);
													$resultc = mysql_query($query);
													$ncards = mysql_num_rows($resultc);
								
														// Print the header of the cards
													echo "<BR /><BR />";
													print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
													echo "<TABLE ALIGN=\"center\">";
					
				
													echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
													for ($k=0; $k<$ncards; $k++) {
				
				
														// Get the cards fields
														$cardrow = mysql_fetch_array($resultc);				
														// Remove '\' from the entries and allow them in variables
														$cardrowisolang = stripslashes($cardrow['isolang']);
														$cardrowterm = stripslashes($cardrow['term']);
				
														if ($cardrowterm != '') {
															echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
															<B>".$strterm.":</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a><a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
														}
				
													}
														echo "</TABLE><HR />";
				
				
													// Print header
													echo "<BR /><BR />";
													//print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
													echo "<TABLE ALIGN=\"center\">";				
													// Department - BE
													echo "<TR><TD><B>".$strbe."</B>&nbsp;&nbsp;</TD><TD>".$headerbe."</TD></TR>";
													// Card type - TY
													echo "<TR><TD><B>".$strty."</B>&nbsp;&nbsp;</TD><TD>".$headerrowty."</TD></TR>";				
													// Id number - NI
													echo "<TR><TD><B>".$strni."</B>&nbsp;&nbsp;</TD><TD>".$headerrowni."</TD></TR>";
								
														// Subdomain
													echo "<TR><TD><B>".$strsubdom."</B>&nbsp;&nbsp;</TD>";
				
				
														$query = genetic_show_rel_subdomain($headerrowni);
														$resultdom = mysql_query($query);
													echo "<TD>";
													while ($row = mysql_fetch_array($resultdom)) {
															$headerrowsubdomiddom = stripslashes($row['iddom']);
															$headerrowsubdom = stripslashes($row['name']);
															$headerrowsubdom2=str_replace(" ","-",$headerrowsubdom);
						
															//---------------------search tree subdomain
						
							
							
								
																$cadena="";
																$subdomparent=calcular_ruta_subdominios($headerrowsubdomiddom,$cadena);
							
								
						
																//--------------------end of the search tree subdomain
						
						
														echo"".$subdomparent. " <A HREF=\"http://eurogene.open.ac.uk/theme/$headerrowsubdom2\" target=\"blank\" ><FONT COLOR=\"#238E23\">".$headerrowsubdom."</FONT></A><BR>";
					
													}
					
													echo "</TD>";				
													// Author
													echo "<TR><TD><B>".$strauthor."</B>&nbsp;&nbsp;</TD><TD>".$headerauthor."</TD></TR>";
													// Creation/ Modified date
													echo "<TR><TD><B>".$strdate."</B>&nbsp;&nbsp;</TD><TD>".$headerrowdate."</TD></TR>";
				
													// Edit/Delete tools
													echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id=$id&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
													<A HREF=\"deletecard.php?id=$id&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
													echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
													echo "</TABLE>";
													// Finish the card
													print_box_end($return=false);
												
											}
										}
						
									}
									
									
					//echo "<BR>TOTAL  hijos: ".$totalRows_rsRegistro;
					
					
					//if($totalRows_rsRegistro > 0)
					
					//{
								
								$query_rsRegistro = genetic_arbol2($dom);
								$rsRegistro = mysql_query($query_rsRegistro);
					
								
								//id son subdomain
								$son=$row_rsRegistro['id'];
								//echo "id de los hijos: ".$son;
							
								//echo "cambio el id y ahora es el del hijo".$son;
								// Y le pasamos el id del registro actual
								while($row_rsRegistro = mysql_fetch_array($rsRegistro)){
								genetic_subdomains2($idgenetic,$id,$row_rsRegistro['id']);
								
								}

								
						

						
					//}
					
				
					
		} //end of the recursive function
?>