<?php  // $Id: search.php,v 2.0 2012/06/25 10:45:00 Ana Mar�a Lozano de la Fuente Exp $
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

	// File for searching genetic cards by a determined key
	
	// Attached files
    include("../../config.php");
    require_once("db_functions.php");
    require_once("lib.php");
	require_once("search_subdomain_function.php");
	require_once("selectsubdomains.php");
	//--------------------------
		require_once("../../lib/fpdf/fpdf.php");
		
	//----------------------------
	
	
	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Get the form variables	
	$way = optional_param('way', '', PARAM_TEXT);
	$exact = optional_param('exact', '', PARAM_TEXT);
	$searchtype = optional_param('search', '', PARAM_TEXT);
	$term = optional_param('term', '', PARAM_TEXT);
	$idterm = optional_param('idterm', '', PARAM_INT);
	$idheader= optional_param('idheader', '', PARAM_TEXT);
	$author = optional_param('author', '', PARAM_TEXT);
	$dom = optional_param('belongto',0,PARAM_INT);
	$idty = optional_param('proyect',0,PARAM_INT);
	$lang = optional_param('lang', '', PARAM_TEXT);
	$gramcat = optional_param('gramcat', '', PARAM_TEXT);
	$generalkey = optional_param('generalkey', '', PARAM_TEXT);	
	$order = optional_param('order', '', PARAM_TEXT);
	
	
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
	$strrem=get_string("rem", "genetic");
	$strwm=get_string("wm", "genetic");
	//Get a short version for the name of the genetic
	$geneticname = format_string($genetic->name);
	$namelenght = strlen($geneticname);
	if ($namelenght > 40) {
		$geneticname = substr($geneticname, 0, 40)."...";
	}

	$strgenetics = get_string("modulenameplural", "genetic");
    $navlinks = array();
    $navlinks[] = array('name' => $strgenetics, 'link' => "index.php?id=$course->id", 'type' => 'activity');
    $navlinks[] = array('name' => format_string($genetic->name), 'link' => '', 'type' => 'activityinstance');
    $navigation = build_navigation($navlinks);

	
	//Print the page header
    print_header_simple(format_string($genetic->name), "", $navigation, "", "", true,
                  update_module_button($cm->id, $course->id, $strgenetic), navmenu($course, $cm));

				  
	// Print Tabs
	$SESSION->genetic->current_tab = 'searchcard';
	include('tabs.php');    
	
	// Print the main part of the page

	
	// Check the search type
	
	/*************
	  Term search
	 *************/
	 
	if ($searchtype == "term") {
		
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($term);
		if ($empty == 1)  {
			
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
		else {
			
			
			// Make the card search
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			$query = genetic_search_headerbyterm($genetic->id, $term);
			
			
			$result = mysql_query($query,$link);
			$n = mysql_num_rows($result);
			
			// There are results?
			if($n == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noresultterm", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db
				mysql_close($link);
				
			}
			else {
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD>";
				echo "</FORM>";
				echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf2.php?id=$id&term=$term\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				echo "</FORM></TABLE >";
				//button to PDF search
				
				//echo "<TABLE ALIGN=\"center\"><FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf.php?id=$id&term=$term\" ENCTYPE=\"multipart/form-data\">";	
				//echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				//echo "</FORM></TABLE >";
				
				// Get the fields and print the resulting cards
				for ($i=0; $i<$n; $i++) {
					
					// Get the cards fields
					$cardrow = mysql_fetch_array($result);
					// Remove '\' from the entries and allow them in variables
					//$cardrowisolang = stripslashes($cardrow['isolang']);
					//$cardrowterm = stripslashes($cardrow['term']);
					
					//$cardrowgramcat = stripslashes($cardrow['gramcat']);
					//$cardrowdefinition = stripslashes($cardrow['definition']);
					//$cardrowcontext = stripslashes($cardrow['context']);
					//$cardrowexpression = stripslashes($cardrow['expression']);
					//$cardrownotes = stripslashes($cardrow['notes']);
					//$cardrowid = stripslashes($cardrow['id']);
					$headerrowni = stripslashes($cardrow['id']);
					
					// Get the header
					$queryh = genetic_choose_header($headerrowni);
					$resulth = mysql_query($queryh,$link);					
					$headerrow = mysql_fetch_array($resulth);					
					// Remove '\' from the entries and allow them in variables
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
					
					
					
					$query = genetic_show_cards($headerrowni);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
						
						
						// Print box for the terms
						echo "<BR /><BR />";
						print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
						echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
							$cardrowid = $cardrow['id'];
								if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&idterm=$cardrowid&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\" ></a></NOBR></TD>";
									
									
				
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
						$resultdom = mysql_query($query, $link);
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
					// Finish the card
					print_box_end($return=false);
				}
				// Close the db    
				mysql_close($link);
			}	

			
				
		}
		
		
	}
	/*************
	  proyect search
	 *************/
	 
	else if ($searchtype == "proyects") {
		
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($idty);
		if ($empty == 1)  {
			
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
		else {
			
			
			// Make the card search
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			
			$query = genetic_search_header($genetic->id, $idty);
			
			
			$resulth = mysql_query($query,$link);
			
			$n = mysql_num_rows($resulth);
			
			
			// There are results?
			if($n == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noresultterm", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db
				mysql_close($link);
				
			}
			else {
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD>";
				echo "</FORM>";
				echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_proy.php?id=$id&proyect=$idty\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				echo "</FORM></TABLE >";
				//button to PDF search
				
				//echo "<TABLE ALIGN=\"center\"><FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf.php?id=$id&term=$term\" ENCTYPE=\"multipart/form-data\">";	
				//echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				//echo "</FORM></TABLE >";
				
				// Get the fields and print the resulting header
				for ($i=0; $i<$n; $i++) {
					
					// Get the cards fields
					$headerrow = mysql_fetch_array($resulth);
										
					// Remove '\' from the entries and allow them in variables
					$headerrowni = stripslashes($headerrow['id']);
					$headerrowty = stripslashes($headerrow['ty']);
					
					//$headerrowsubdom = stripslashes($headerrow['subdom']);
					$headerrowdate = date("j F Y", $headerrow['datecreated']);
					
					$resultc=genetic_search_proyect($idgenetic, $headerrowni);
					$cardrow = mysql_fetch_array($resultc);
					// Remove '\' from the entries and allow them in variables
					$cardrowisolang = stripslashes($cardrow['isolang']);
					$cardrowterm = stripslashes($cardrow['term']);
					
					$cardrowgramcat = stripslashes($cardrow['gramcat']);
					$cardrowdefinition = stripslashes($cardrow['definition']);
					$cardrowcontext = stripslashes($cardrow['context']);
					$cardrowexpression = stripslashes($cardrow['expression']);
					$cardrownotes = stripslashes($cardrow['notes']);
					$cardrowid = stripslashes($cardrow['id']);
					$cardrowidheader = stripslashes($cardrow['idheader']);
					
					
					
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
					
					
					
					$query = genetic_show_cards($headerrowni);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
						
						
						// Print box for the terms
						echo "<BR /><BR />";
						print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
						echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
				
								if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
									
									
				
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
						$resultdom = mysql_query($query, $link);
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
					// Finish the card
					print_box_end($return=false);
				}
				// Close the db    
				mysql_close($link);
			}	

			
				
		}
		
		
	}


	/***************
	  Author search
	 ***************/

	 
	 else if ($searchtype == "author") {
	 
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($author);
		if ($empty == 1)  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}		
		else {
			
			// Search if any author exists with that name in bbdd
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			$queryauthor = genetic_exist_author($author);
			$resultauthor = mysql_query($queryauthor,$link);
			$nauthor = mysql_num_rows($resultauthor);
			
			
			// There are results?
			if($nauthor == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noexistauthor", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db    
				mysql_close($link);
				// Finish the page
				//print_footer($course);
			}
			else {
				// Search in the genetic cards by author id
				for ($i=0; $i<$nauthor; $i++) {
				
					$row = mysql_fetch_array($resultauthor);
					$auid = $row['id'];
					
					
					
					// Search relation author-header
					$query = genetic_search_author($auid);					
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					
					
					// There are results?
					if($n == 0) {
						print_box_start($classes='generalbox boxaligncenter boxwidthwide');
						$msg = get_string("noresultauthor", "genetic");
						echo $msg;
						print_box_end($return=false);
						echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
						// Close the db    
						mysql_close($link);
						
					}
					
					else {
					
					
					//Button for new searches
									
									echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
									echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
									echo "</FORM>";
									echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_author2.php?id=$id&author=$author\" ENCTYPE=\"multipart/form-data\">";	
									echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
									echo "</FORM></TABLE>";
									
						
						//Search the headercards
						for ($j=0; $j<$n; $j++) {
						
							
							$row = mysql_fetch_array($result);
							$headerrowni = $row['idheadercard'];
							
							$queryh = genetic_choose_header($headerrowni);					
							$resulth = mysql_query($queryh,$link);
							
							// Get the header cards fields
							while ($headerrow = mysql_fetch_array($resulth)) {												
								// Remove '\' from the entries and allow them in variables
								$headerrowidgenetic = stripslashes($headerrow['id_genetic']);
								
								// Show only cards from THIS course
								if ($headerrowidgenetic == $genetic->id) {
									$headerrowty = stripslashes($headerrow['ty']);
									//$headerrowdom = stripslashes($headerrow['dom']);
									//$headerrowsubdom = stripslashes($headerrow['subdom']);
									$headerrowdate = date("j F Y", $headerrow['datecreated']);	
									
									// Make queries for numerical fields
								
									// BE - Department
									$queryaux = genetic_show_rel_be($headerrowni);
									$resultaux = mysql_query($queryaux, $link);
									$rowaux = mysql_fetch_array($resultaux);
									$headerbe = stripslashes($rowaux['name']);
									while ($rowaux = mysql_fetch_array($resultaux)) {
										$aux = stripslashes($rowaux['name']);
										$headerbe = $headerbe.", ".$aux;
									}
									
									
									
									// Show the other Authors of the card 
									$queryauthor = genetic_show_rel_author($headerrowni);
									$resultauthor = mysql_query($queryauthor, $link);
				
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
										$rowaux = mysql_fetch_array(mysql_query($queryaux, $link));
										$headerrowty = stripslashes($rowaux['name']);
									}
									
									//Button for new searches
									/*
									echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
									echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
									echo "</FORM>";
									echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_author2.php?id=$id&author=$author\" ENCTYPE=\"multipart/form-data\">";	
									echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
									echo "</FORM></TABLE>";
									*/
									$query = genetic_show_cards($headerrowni);
									$resultc = mysql_query($query, $link);
									$ncards = mysql_num_rows($resultc);
						
						
									// Print box for the terms
										echo "<BR /><BR />";
										print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
										echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
										for ($k=0; $k<$ncards; $k++) {
				
				
										// Get the cards fields
										$cardrow = mysql_fetch_array($resultc);				
										// Remove '\' from the entries and allow them in variables
										$cardrowisolang = stripslashes($cardrow['isolang']);
										$cardrowterm = stripslashes($cardrow['term']);
				
											if ($cardrowterm != '') {
											echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
											<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
									
									
				
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
						$resultdom = mysql_query($query, $link);
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
									
									
									
									// Finish the card
									print_box_end($return=false);
								}
							}
						}
						// Close the db    
						mysql_close($link);
					}
				}
			}
		}
		
		
	}
	



	/**************
	 SUBDOM SEARCH
	*****************/
	
	 else if ($searchtype == "doms") {	
	 
					$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
					$query = genetic_search_domain_h($genetic->id, $dom);
			
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
			
					
			/*
					// There are results?
					if($n == 0) {
						print_box_start($classes='generalbox boxaligncenter boxwidthwide');
						$msg = get_string("noresultdom", "genetic");
						echo $msg;
						print_box_end($return=false);
						echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
						// Close the db    
						mysql_close($link);
						// Finish the page
						//print_footer($course);
					}
					
					else{
			*/		
					//Button for new searches
					//Button for new searches
													echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
													echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
													echo "</FORM>";
													echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_subdom2.php?id=$id&dom=$dom\" ENCTYPE=\"multipart/form-data\">";	
													echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
													echo "</FORM></TABLE>";
				
					// CALL A RECURSIVE FUNCTION FOR THE MULTIPLE SUBDOMAINS (SONS)
					
						$sql3=genetic_subdomains2($genetic->id,$cm->id,$dom);
					
					//}
					
					
				// Close the db    
						mysql_close($link);
					
	} //End of the search my subdomain
	
	/*****************
	  Language search
	 *****************/
	 
	else if ($searchtype == "langs") {	
		// Check if there is any obligatory field empty
		$empty = 0;
		$empty = genetic_field_not_selected_null($lang);
		if ($empty == 1)  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfieldlanguage", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}		
		else {
			// Make the search
			
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			$query = genetic_search_lang_c($genetic->id, $lang);
			$result = mysql_query($query,$link);
			$n = mysql_num_rows($result);
			
			if($n == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noresultisolang", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db    
				mysql_close($link);
				// Finish the page
				
			}
			else {
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
				echo "</FORM>";
				echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_lang2.php?id=$id&lang=$lang\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				echo "</FORM></TABLE>";

				for ($i=0; $i<$n; $i++) {
					// Get the cards fields
					$cardrow = mysql_fetch_array($result);
					// Remove '\' from the entries and allow them in variables
					$cardrowisolang = stripslashes($cardrow['isolang']);
					$cardrowterm = stripslashes($cardrow['term']);
					$cardrowgramcat = stripslashes($cardrow['gramcat']);
					$cardrowdefinition = stripslashes($cardrow['definition']);
					$cardrowcontext = stripslashes($cardrow['context']);
					$cardrowexpression = stripslashes($cardrow['expression']);
					
					$cardrownotes = stripslashes($cardrow['notes']);
					$cardrowid = stripslashes($cardrow['id']);
					$cardrowidheader = stripslashes($cardrow['idheader']);
					
					if ($cardrowterm != '') {					
						//Get the header
						$queryh = genetic_choose_header($cardrowidheader);
						$resulth = mysql_query($queryh,$link);					
						$headerrow = mysql_fetch_array($resulth);					
						// Remove '\' from the entries and allow them in variables
						$headerrowni = stripslashes($headerrow['id']);
						$headerrowty = stripslashes($headerrow['ty']);
						$headerrowdate = date("j F Y", stripslashes($headerrow['datecreated']));
						
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
	
						$query = genetic_show_cards($headerrowni);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
						
						
						// Print box for the terms
						echo "<BR /><BR />";
						print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
						echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
				
								if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
									
									
				
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
						// Finish the card
						print_box_end($return=false);
					}
				}
			}
			// Close the db    
			mysql_close($link);		
		}
	}	
	
	/****************************
	  Gramatical category search
	 ****************************/
	 
	else if ($searchtype == "gramcats") {	
		// Check if there is any obligatory field empty
		$empty = 0;
		$empty = genetic_field_not_selected_null($gramcat);
		if ($empty == 1)  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfieldgramcat", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}		
		else {
			// Make the search
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			//FALTA HACER UN DISTINCT
			$query = genetic_search_gramcat_c($genetic->id, $gramcat);
			$result = mysql_query($query,$link);
			$n = mysql_num_rows($result);
			
			
			if($n == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noresultgramcat", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db    
				mysql_close($link);
				// Finish the page
				//print_footer($course);
			}
			else {
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
				echo "</FORM>";
				echo "<FORM NAME=\"pdfsearch\" METHOD=\"post\" ACTION=\"search_to_pdf_gramcat.php?id=$id&gramcategory=$gramcat\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("searchtopdf", "genetic")."\" NAME=\"buttonpdfsearch\" /></TD></TR>";
				echo "</FORM></TABLE>";

				for ($i=0; $i<$n; $i++) {
				
					// Get the cards fields
					
					$cardrow = mysql_fetch_array($result);
					// Remove '\' from the entries and allow them in variables
					$cardrowisolang = stripslashes($cardrow['isolang']);
					$cardrowterm = stripslashes($cardrow['term']);
					
					$cardrowid = stripslashes($cardrow['id']);
					$cardrowidheader = stripslashes($cardrow['idheader']);
					
					if ($cardrowterm != '') {					
						//Get the header
						$queryh = genetic_choose_header($cardrowidheader);
						$resulth = mysql_query($queryh,$link);					
						$headerrow = mysql_fetch_array($resulth);					
						// Remove '\' from the entries and allow them in variables
						$headerrowni = stripslashes($headerrow['id']);
						$headerrowty = stripslashes($headerrow['ty']);
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
						
						$query = genetic_show_cards_gram($headerrowni,$gramcat);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
						
						
						// Print box for the terms
						echo "<BR /><BR />";
						print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
						echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
				
								if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
									
									
				
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
				
				
							// Finish the box card
							print_box_end($return=false);
				
				
				
					}
				}
			}
			// Close the db    
			mysql_close($link);		
		}
	}
	/*************
	  Fullcard search by link
	 *************/
	 
	else if ($searchtype == "fullcard_by_link") {
	
	
		
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($idheader);
		
		if ($empty == 1)  {
			
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
		else{
		
		
		// Make the card search
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			//Header terms
			$query5 = genetic_search_header_type($genetic->id,$idheader);
						$resultc5 = mysql_query($query5, $link);
						$ncards5 = mysql_num_rows($resultc5);
						$headerrow = mysql_fetch_array($resultc5);
						// Header fields
				// Remove '\' from the entries and allow them in variables
				$headerrowni = stripslashes($headerrow['id']);
				$headerrowty = stripslashes($headerrow['ty']);
				$headerrowdate = date("j F Y", $headerrow['datecreated']);
				//---A�adido----
				
				
				// Make queries for numerical fields				
				// BE - Deparment
				$query = genetic_show_rel_be($headerrowni);
				$result = mysql_query($query, $link);
				$row = mysql_fetch_array($result);
				$headerbe = stripslashes($row['name']);
				while ($row = mysql_fetch_array($result)) {
					$aux = stripslashes($row['name']);
					$headerbe = $headerbe.", ".$aux;
				}
				
				// TY - Card type
				if($headerrowty == 0) {
					$headerrowty = $strnodefined;
				}
				else {
					$query = genetic_choose_ty($headerrowty);
					$row = mysql_fetch_array(mysql_query($query, $link));
					$headerrowty = stripslashes($row['name']);
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
				
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"view.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("showcards", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
				echo "</FORM></TABLE>";
				
				// Print box for the terms
				echo "<BR /><BR />";
				print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
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
				echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
					  <A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
				//echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
				echo "</TABLE><HR/>";
				
				//card terms
		
			$query = genetic_show_cards($idheader);
			$resultc = mysql_query($query, $link);
			$ncards = mysql_num_rows($resultc);
			
						
						for ($k=0; $k<$ncards; $k++) {
				
				
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
					//YA NO HAY CAMPO REMISIONES
					
					$cardrownotes = stripslashes($cardrow['notes']);
					$cardrowid = stripslashes($cardrow['id']);	
				
				
					// Print languages
					
					if ($cardrowterm != '') {
						echo "<BR /><br/><br/><TABLE  ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">
							
							<Tr><td colSPAN=\"4\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">&nbsp;&nbsp;&nbsp;&nbsp;</TD>
								<tr><TD WIDTH=\"27%\"><B>".$strterm.":</B>&nbsp;&nbsp;</TD>
								<TD>".$cardrowterm."</a><a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></TD></TR>
							<TR><TD><B>".$strgramcat.":</B>&nbsp;&nbsp;</TD><TD>".$cardrowgramcat."</TD></TR>";
							//Definition
							echo"<TR><TD><B>".$strdefinition.":</B>&nbsp;&nbsp;</TD>";
							
						 //-----------------Replace crossrelations in definition-------------------
						  
						  $consulta3 = genetic_show_terms($genetic->id);
						 
						  $resultado3 = mysql_query($consulta3, $link);
						  $numero = mysql_num_rows($resultado3);
							//Take the first match and replace the string 
							
						if($numero!=0){
						
							$cardrow3 = mysql_fetch_array($resultado3); 
							$cardrowcross3 = stripslashes($cardrow3['term']);
							$cross3=$cardrowcross3;  
							$cadena_devuelta3= str_replace($cardrowcross3,"<a href=\"search.php?id=$id&term=$cross3&search=term\"><NOBR>".$cardrowcross3."</NOBR></a>",$cardrowdefinition);
							
							$replace=$cadena_devuelta3;
								while($cardrow33 = mysql_fetch_array($resultado3)){
							
									//Replace crossrelations in definition
						
									$cardrowcross333 = stripslashes($cardrow33['term']);
									$cardrowcrossid = stripslashes($cardrow33['idheader']);
									//take cardrowcross and replace; return the new string
									$replace=str_replace($cardrowcross333,"<a href=\"search.php?id=$id&idheader=$cardrowcrossid&search=fullcard_by_link\"><NOBR>".$cardrowcross333."</NOBR></a>",$replace);
									
								
								}
							
						
						
							
							echo "<TD>" .$replace."</TD>";
						}
						
						
						//--------------------End of replace------------------------------------------------		
							
						else if($numero==0){
						
						
						echo"<TD>".$cardrowdefinition."</TD></TR>";
						}
						
						echo"<TR><TD><B>".$strcontext.":</B>&nbsp;&nbsp;</TD><TD>".$cardrowcontext."</TD></TR>
							<TR><TD><B>".$strexpression.":</B>&nbsp;&nbsp;</TD><TD>".$cardrowexpression."</TD></TR>
							<TR><TD><B>".$strnotes.":</B>&nbsp;&nbsp;</TD><TD>".$cardrownotes."</TD></TR>";
							
							if($cardrowweight!=""){
							echo"<TR><TD><NOBR><B>".$strwm.":</B>&nbsp;&nbsp;</TD><TD>".get_string($cardrowweight,"genetic")."</NOBR></TD></TR>";
							}
							echo "<BR>";
						
						// ---a�adido---GET THE IMAGES  
						
						$query2 = genetic_show_images($headerrowni);
						$resultc2 = mysql_query($query2, $link);
						$ncards2 = mysql_num_rows($resultc2);
						
						
						//ncard2 seria el numero de imagenes de cada termino
							  
						if($ncards2!=0){	
						
						echo"<tr><td colspan='4' height='10'><hr></td></tr><TR><TD colspan='4' ><IMG SRC=\"images/Picture.gif\"><B>".$strimagenes."</B></TD></tr>";
						echo"<TD></TD><TD><b><i>".get_string('title_image','genetic')."</b></i></TD><TD><B><i>$strsrc</i></TD></TR>";
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
						

											
						
						
						
						$rutaEnServidor=$CFG->dataroot . '/'. $COURSE->id;
						$dir=$rutaEnServidor.'/imagen';
						$rutaDestino=$dir.'/'.$cardrowfile_image;
						
						$Servidor=$CFG->wwwroot ;
						$rutaDestino=$Servidor.'/file.php/'.$COURSE->id.'/imagen/'.$cardrowfile_image;
						
							if($cardrowtitle_image!=''){
							echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"100\" height=\"90\" ></TD><TD>".$cardrowtitle_image."</TD>";		
							
							echo"<BR>";
							}
							else{
							echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"50\" height=\"50\" ></TD><TD>".$cardrowfile_image."</TD>";
							
							}
							
						echo"<TD><nobr>".$cardrowsrc_image."</nobr></TD></TR>";
						
						}
					
						
						}
							//echo "<BR>";
							
							
						// ---a�adido---GET THE VIDEOS  
						$ncards4=0;
						$query4 = genetic_show_videos($cardrowid);
						$resultc4 = mysql_query($query4, $link);
						$ncards4 = mysql_num_rows($resultc4);
						echo "<BR>";
						if($ncards4!=0){
						      //ncard3 seria el numero de videos de cada termino
						echo"<tr><td colspan='4' height='10'><hr></td></tr>";
						echo"<TR><TD><B>$strvideos</TD></TR>";
						echo"<TR><TD><B><i> </B></TD><TD><B><i>".$strtitle_video.":</TD><TD><B><i>".$strlang.":</TD><TD><B><i>".$strsrc."</TD></TR>";
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
						
					
						$rutaDestino='http://localhost/moodle/file.php/'.$COURSE->id.'/video/'.$cardrowfile_video;
						
						echo "<TR><TD><IMG SRC=\"images/Movie.gif\"><A HREF=".$rutaDestino." target=\"blank\" >".$cardrowfile_video."</A></TD>";
								
						echo "<td>".$cardrowtitle_video."</A></TD>";		
						
							
						echo"<TD>".$cardrowlang_video."</TD>";	
						echo"<TD>".$cardrowsrc_video."</TD></TR>";
						}
						}
						
						//AUDIO FILES
						$ncardsaudio=0;
						$queryaudio = genetic_show_audio($cardrowid);
						$resultaudio = mysql_query($queryaudio, $link);
						$ncardsaudio = mysql_num_rows($resultaudio);
						//$cardrowaudio = mysql_fetch_array($resultaudio);
						$counteraud=0;
						
						while($cardrow4 = mysql_fetch_array($resultaudio)){
						  
							//---a�adido---mostrar archivo audio
							
							$cardrowidaudio = stripslashes($cardrow4['genetic_audio_id']);
							if(($cardrowidaudio!=0)&&($counteraud==0))
							{
									echo"<tr><td colspan='4' height='10'><hr></td></tr>";
									echo"<TR><TD colspan='4' ><B>".$straudio.":</B></TD></tr>";
									echo"<tr><td></td><TD><B><i>".$strsources.":</i></B> </TD></TR>";
									$counteraud=1;
							}
							
								$queryaudioid = genetic_show_audio_id($cardrowidaudio);
								$resultaudioid = mysql_query($queryaudioid, $link);
								while($cardrow4 = mysql_fetch_array($resultaudioid))
								{
										$cardrowsrcaudio = stripslashes($cardrow4['srcaudio']);
										$cardrowaudioname = stripslashes($cardrow4['fileaudio']);
										$rutaDestino='http://localhost/moodle/file.php/'.$COURSE->id.'/audio/'.$cardrowaudioname;
							
										echo "<TR><TD><IMG SRC=\"images/Sound.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;".$cardrowaudioname."</A></TD><TD>".$cardrowsrcaudio."</TD></TR>";		
							
										}
							}
						
						
						
						
						
						
				
						
			//-----------------Nueva consulta
						  
						  $consulta = genetic_show_crossrelations2($cardrowterm);
						  $resultado = mysql_query($consulta, $link);
						  $numero = mysql_num_rows($resultado);
						  //echo"encontrado vale".$numero;
						  //while($cardrow6 = mysql_fetch_array($resultado)){
							
							//$termino = stripslashes($cardrow6['term']);
							//echo"encontrado ".$termino;
						$r=0;
						if($numero!=0){
									
								while($cardrow6 = mysql_fetch_array($resultado)){
									//---a�adido---mostrar crossrelations
						
									$cardrowcross = stripslashes($cardrow6['term']);
									$cardrowcross_link = stripslashes($cardrow6['isolang']);
									
									if($cardrowterm!=$cardrowcross){
									
									if($r==0){
										echo"<tr><td colspan='4' height='10'><hr></td></tr>";
										echo"<TR><TD><B><NOBR>".$strcross.". </B><i>".get_string('crosstermsentence','genetic').":</i></NOBR></TD></TR>";
										echo"<TR><TD>"; $r=1;}
									
									echo"&nbsp;&nbsp;<a href=\"search.php?id=$id&term=$cardrowcross&search=term&way=exact\"><NOBR>".$cardrowcross."</NOBR>";
									
									}
						
								}
								echo"</TD></TR>";
						}
						//fin------------------------------------------------	
						//Show referrals of each type
						
						
						  $consultaref = genetic_show_remissions_dist($cardrowid);
						  $resultadoref = mysql_query($consultaref, $link);
						  $numeroref = mysql_num_rows($resultadoref);
						  if($numeroref!=0){
								echo"<tr><td colspan='4' height='10'><hr></td></tr><TR>";
						  		echo"<TR><TD colspan='4'><B>".$strrem.":</B></TD></TR>";	
								while($cardrowref = mysql_fetch_array($resultadoref)){
									//---a�adido---mostrar crossrelations
						
									$cardrowref = stripslashes($cardrowref['rem_type']);
									
									echo"<TR><NOBR><TD><B><i>&nbsp;&nbsp;&nbsp;&nbsp;".get_string($cardrowref,"genetic").":</B></i></TD></NOBR>";
									
									$consultaref2 = genetic_show_remissions_name($cardrowref,$cardrowid);
									$resultadoref2 = mysql_query($consultaref2, $link);
									$numeroref2 = mysql_num_rows($resultadoref2);
									
									$counterrem2=0;
									while($cardrowref2 = mysql_fetch_array($resultadoref2)){
									
										$cardrowrem2 = stripslashes($cardrowref2['remission']);
										if($counterrem2==0){
											echo"<TD>".$cardrowrem2."</TD></tr>";
										}else{
											echo"<tr><td>&nbsp;&nbsp;</td><TD>".$cardrowrem2."</TD></tr>";
										}
										$counterrem2++;
										}
										
									
									}
									
									
									}
									
							
						
						//fin------------------------------------------------
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
							echo "<tr><td colspan='4' height='10'><hr></td></tr>";
							echo "<TR><TD colSPAN=\"4\" VALIGN=\"top\"><B>".$strsources.":</B>&nbsp;&nbsp;</td></tr>";
							echo "<tr><TD><b><i>&nbsp;&nbsp;&nbsp;&nbsp;".$strterm.":</b></i></td><td>".$sourcerowterm."</TD></TR>
								<TR><TD><b><i>&nbsp;&nbsp;&nbsp;&nbsp;".$strdefinition.":</b></i></td><td>".$sourcerowdefinition."</TD></NOBR></TR>
								<TR><TD><b><i>&nbsp;&nbsp;&nbsp;&nbsp;".$strcontext.":</b></i></td><td>".$sourcerowcontext."</TD></NOBR></TR>
								<TR><TD><b><i>&nbsp;&nbsp;&nbsp;&nbsp;".$strexpression.":</b></i></td><td>".$sourcerowexpression."</TD></NOBR></TR>
								<TR><TD><b><i>&nbsp;&nbsp;&nbsp;&nbsp;".$strnotes.":</b></i></td><td>".$sourcerownotes."</TD></NOBR></TR>
								</TABLE>";
						}
						else {
							echo "<tr><td colspan='4' height='10'><hr></td></tr>";
							echo "<TR><TD><B>".$strsources."</B></TD><TD><NOBR><i>".$strnosources."</i></NOBR></TD></TR>
								</TABLE>";
						}
					}
					
					
					
				}
				
				// Finish the box card
				print_box_end($return=false);
		
		}
		
	}
		
	/*************
	  Term search by link
	 *************/
	 
	else if ($searchtype == "term_by_link") {
		
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($idterm);
		if ($empty == 1)  {
			
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}
		
		else {
		
			
			// Make the card search
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			//way==exact-->search the "exact term" if the term to search comes from a remission
			
			$query = genetic_search_term_exactly2($genetic->id, $idterm);
			
			$result = mysql_query($query,$link);
			$n = mysql_num_rows($result);
			
				
				// Get the fields and print the resulting cards
				
				
					// Get the cards fields
					$cardrow = mysql_fetch_array($result);
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
					
					// Get the sources
					$querys = genetic_show_sources($cardrowid);
					$results = mysql_query($querys, $link);
					//Get the source fields
					$sourcerow = mysql_fetch_array($results);
					// Remove '\' from the entries and allow them in variables
					$sourcerowterm = stripslashes($sourcerow['srcterm']);
					$sourcerowdefinition = stripslashes($sourcerow['srcdefinition']);
					$sourcerowexpression = stripslashes($sourcerow['srcexpression']);
					$sourcerownotes = stripslashes($sourcerow['srcnotes']);
					
					// Print the result genetic card
					// Header
					echo "<BR /><BR />";
					print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
					echo "<TABLE ALIGN=\"center\" >";					
					
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
					// Creation / Modified date
					echo "<TR><TD><B>".$strdate."</B>&nbsp;&nbsp;</TD><TD>".$headerrowdate."</TD></TR>";
					// Edit/Delete tools
					echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						  <A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD></TR>";
					echo "</TABLE><HR />";
		
					// Card 
					echo "<BR /><TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">
						<TR><TD ROWSPAN=\"13\" VALIGN=\"top\"><IMG SRC=\"images/".$cardrowisolang.".png\">&nbsp;&nbsp;&nbsp;&nbsp;</TD>
							<TD><B>".$strterm."</B>&nbsp;&nbsp;</TD>
							<TD>".$cardrowterm."</a><a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\" ></a></TD></TR>							
						<TR><TD><B>".$strgramcat."</B>&nbsp;&nbsp;</TD><TD>".$cardrowgramcat."</TD></TR>";
						echo "<TR><TD><B>".$strdefinition."</B>&nbsp;&nbsp;</TD>";
						 //-----------------Replace crossrelations in definition-------------------
						  
						  $consulta3 = genetic_show_terms($genetic->id);
						 
						  $resultado3 = mysql_query($consulta3, $link);
						  $numero = mysql_num_rows($resultado3);
							//Take the first match and replace the string 
							
						if($numero!=0){
						
							$cardrow3 = mysql_fetch_array($resultado3); 
							$cardrowcross3 = stripslashes($cardrow3['term']);
							$cross=$cardrowcross3;
							$cadena_devuelta3= str_replace($cardrowcross3,"<a href=\"search.php?id=$id&term=$cross3&search=term\"><NOBR>".$cardrowcross3."</NOBR></a>",$cardrowdefinition);
							
							$replace=$cadena_devuelta3;
								while($cardrow33 = mysql_fetch_array($resultado3)){
							
									//Replace crossrelations in definition
						
									$cardrowcross333 = stripslashes($cardrow33['term']);
									$cardrowcrossid = stripslashes($cardrow33['idheader']);
									//take cardrowcross and replace; return the new string
									$replace=str_replace($cardrowcross333,"<a href=\"search.php?id=$id&idheader=$cardrowcrossid&search=fullcard_by_link\"><NOBR>".$cardrowcross333."</NOBR></a>",$replace);
									
								
								}
							
						
						
							
							echo "<TD>" .$replace."</TD>";
						}
						
						
							
						else if($numero==0){
						echo"<TD>".$cardrowdefinition."</TD></TR>";
						}	
					
					echo"<TR><TD><B>".$strcontext."</B>&nbsp;&nbsp;</TD><TD>".$cardrowcontext."</TD></TR>						
						<TR><TD><B>".$strexpression."</B>&nbsp;&nbsp;</TD><TD>".$cardrowexpression."</TD></TR>												
						<TR><TD><B>".$strnotes."</B>&nbsp;&nbsp;</TD><TD>".$cardrownotes."</TD></TR>";
						if($cardrowweight!=""){
							echo"<TR><TD><NOBR><B>".$strwm.":</B>&nbsp;&nbsp;".get_string($cardrowweight,"genetic")."</NOBR></TD></TR>";
							}
						
						
						// INCLUSION CODIGO POR TERMINO
						
						// ---a�adido---GET THE IMAGES  
						
						$query2 = genetic_show_images($headerrowni);
						$resultc2 = mysql_query($query2, $link);
						$ncards2 = mysql_num_rows($resultc2);
						
						
						//ncard2 seria el numero de imagenes de cada termino
							  
						if($ncards2!=0){	
						echo"<TR><TD><IMG SRC=\"images/Picture.gif\"><B>".$strimagenes."</B></TD><TD></TD><TD><B>".$strsrc."</TD></TR>";
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
						
						
						//$cardrowtitle_image = stripslashes($cardrow3['titleimage_.$isolang']);
						
						$cardrowfile_image = stripslashes($cardrow3['fileimage']);
						$cardrowsrc_image = stripslashes($cardrow3['srcimage']);
						
						//$rutaEnServidor='../../files';
						//$rutaDestino=$rutaEnServidor.'/'.$cardrow3['fileimage'];
						//$rutaDestino='http://localhost/moodle/file.php/'.$COURSE->id.'/imagen/'.$cardrowfile_image;
						$Servidor=$CFG->wwwroot ;
						$rutaDestino=$Servidor.'/file.php/'.$COURSE->id.'/imagen/'.$cardrowfile_image;
					
							if($cardrowtitle_image!=''){
							echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"50\" height=\"50\"  border=\"0\"></TD><TD><NOBR>".$cardrowtitle_image."</NOBR></TD>";		
							}
							else{
							echo "<TR><TD><TR><TD><img src=".$rutaDestino." width=\"50\" height=\"50\"  border=\"0\"></TD><TD>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowfile_image."</TD>";
							}
						echo"<TD><NOBR>&nbsp;".$cardrowsrc_image."</NOBR></TD></TR>";
						
						}
						
						}
							echo "<BR>";
							
							
						// ---a�adido---GET THE VIDEOS  
						$query4 = genetic_show_videos($cardrowid);
						$resultc4 = mysql_query($query4, $link);
						$ncards4 = mysql_num_rows($resultc4);
						if($ncards4!=0){
						      //ncard3 seria el numero de videos de cada termino
						echo"<TR><TD><B>".$strvideos."</B></TD><TD><B>".$straudio."</TD><TD><B>".$strsrc."</TD></TR>";
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
						//$rutaEnServidor='../../files';
						//$rutaDestino=$rutaEnServidor.'/'.$cardrow4['filevideo'];
						$rutaDestino='http://localhost/moodle/file.php/'.$COURSE->id.'/imagen/'.$cardrowfile_video;
						
							if($cardrowtitle_video!=''){
							echo "<TR><TD><IMG SRC=\"images/Movie.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowtitle_video."</A></TD>";		
							}
							else{
							echo "<TR><TD><IMG SRC=\"images/Movie.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowfile_video."</A></TD>";	
							}
							
						echo"<TD>&nbsp;".$cardrowlang_video."</TD>";
						echo"<TD>&nbsp;".$cardrowsrc_video."</TD></TR>";
						}
						}
						
						//AUDIO FILES
						
						$query4 = genetic_show_audio($cardrowid);
						$resultc4 = mysql_query($query4, $link);
						$ncards4 = mysql_num_rows($resultc4);
						$cardrow4 = mysql_fetch_array($resultc4);
						
						if($ncards4!=0){
						
						      //ncard4 seria el numero de archivos de audio de cada termino
							//echo"<TR><TD><B>".$straudio.":</B></TD></TR>";
							//---a�adido---mostrar archivo audio
							
							$cardrowidaudio = stripslashes($cardrow4['genetic_audio_id']);
							if($cardrowidaudio!=0){echo"<TR><TD><B>".$straudio.":</B></TD></TR>";}
							
							$query4 = genetic_show_audio_id($cardrowidaudio);
							$resultc4 = mysql_query($query4, $link);
							while($cardrow4 = mysql_fetch_array($resultc4))
							{
							$cardrowsrcaudio = stripslashes($cardrow4['srcaudio']);
							$cardrowaudioname = stripslashes($cardrow4['fileaudio']);
					
							//$rutaEnServidor='../../files';
							//$rutaDestino=$rutaEnServidor.'/'.$cardrow4['fileaudio'];
							$rutaDestino='http://localhost/moodle/file.php/'.$COURSE->id.'/audio/'.$cardrowaudioname;

							echo "<TR><TD><IMG SRC=\"images/Sound.gif\"><A HREF=".$rutaDestino." target=\"blank\" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$cardrowaudioname."</A></TD><TD><B>".$strsources."</B> : ".$cardrowsrcaudio."</TD>";		
							
							}
						
						
						}
						
					
				
						//-----------------Nueva consulta
						  
						  $consulta = genetic_show_crossrelations2($cardrowterm);
						  $resultado = mysql_query($consulta, $link);
						  $numero = mysql_num_rows($resultado);
						  //echo"encontrado vale".$numero;
						  //while($cardrow6 = mysql_fetch_array($resultado)){
							
							//$termino = stripslashes($cardrow6['term']);
							//echo"encontrado ".$termino;
						$r=0;
						if($numero!=0){
									
								while($cardrow6 = mysql_fetch_array($resultado)){
									//---a�adido---mostrar crossrelations
						
									$cardrowcross = stripslashes($cardrow6['term']);
									$cardrowcross_link = stripslashes($cardrow6['isolang']);
									
									if($cardrowterm!=$cardrowcross){
									
									if($r==0){echo"<TR><TD><B><NOBR>".$strcross."</B> Este termino tambien aparece en las siguientes entradas:</NOBR></TD></TR>";
									echo"<TR><TD>"; $r=1;}
									
									echo"&nbsp;&nbsp;<a href=\"search.php?id=$id&term=$cardrowcross&search=term&way=exact\"><NOBR>".$cardrowcross."</NOBR>";
									
									}
						
								}
								echo"</TD></TR>";
						}
						//fin------------------------------------------------
						
						//Show referrals of each type
						
						
						  $consultaref = genetic_show_remissions_dist($cardrowid);
						  $resultadoref = mysql_query($consultaref, $link);
						  $numeroref = mysql_num_rows($resultadoref);
						  if($numeroref!=0){
								echo"<TR><TD><B>".$strrem.":</B></TD></TR>";	
								while($cardrowref = mysql_fetch_array($resultadoref)){
								
									//---a�adido---mostrar crossrelations
						
									$cardrowref = stripslashes($cardrowref['rem_type']);
									
									echo"<TR><NOBR><TD><B>".get_string($cardrowref,"genetic").":</B></TD></NOBR></TR>";
									
									$consultaref2 = genetic_show_remissions_name($cardrowref,$cardrowid);
									$resultadoref2 = mysql_query($consultaref2, $link);
									$numeroref2 = mysql_num_rows($resultadoref2);
									
									while($cardrowref2 = mysql_fetch_array($resultadoref2)){
									
										$cardrowrem2 = stripslashes($cardrowref2['remission']);
									
										echo"<TR><TD>".$cardrowrem2."</TD></TR>";
									
									
									}
									
									
									}
									
							}
						
						//fin------------------------------------------------
						
						//FIN INCLUSION POR TERMINO
					// Sources
					if(($sourcerowterm != '') || ($sourcerowdefinition != '') || ($sourcerowexpression != '') || ($sourcerownotes != '')) {
						//Print sources
						echo "<TR><TD ROWSPAN=\"6\" VALIGN=\"top\"><B>".$strsources."</B>&nbsp;&nbsp;</TD><TD>".$strterm.":&nbsp;&nbsp;".$sourcerowterm."</TD></TR>
							<TR><TD>".$strdefinition.":&nbsp;&nbsp;".$sourcerowdefinition."</TD></TR>
							<TR><TD>".$strcontext.":&nbsp;&nbsp;".$sourcerowcontext."</TD></TR>
							<TR><TD>".$strexpression.":&nbsp;&nbsp;".$sourcerowexpression."</TD></TR>
							<TR><TD>".$strnotes.":&nbsp;&nbsp;".$sourcerownotes."</TD></TR>
							</TABLE>";
					}
					else {
						echo "<TR><TD><B>".$strsources."</B>&nbsp;&nbsp;</TD><TD>".$strnosources."</TD></TR>
							</TABLE>";
					}
					// Finish the card
					print_box_end($return=false);
				
				// Close the db    
				mysql_close($link);
						
		}
	}

	/****************
	  General search
	 ****************/
	 
	else {	
		// Check if there is any obligatory field empty
		$empty = genetic_field_not_selected_null($generalkey);
		if ($empty == 1)  {
			print_box_start($classes='generalbox boxaligncenter boxwidthwide');
			$msg = get_string("emptyfield", "genetic");
			echo $msg;
			print_box_end($return=false);
			echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";
		}		
		else {
			// Make the search
			
			$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
			$query =genetic_search_headerbyall($genetic->id, $generalkey);
			$result = mysql_query($query,$link);
			$n = mysql_num_rows($result);
			
			// There are results?
			if($n == 0) {
				print_box_start($classes='generalbox boxaligncenter boxwidthwide');
				$msg = get_string("noresultgeneral", "genetic");
				echo $msg;
				print_box_end($return=false);
				echo "<CENTER><A HREF=\"javascript:history.back(1)\">".get_string('back')."</A></CENTER>";				
				// Close the db    
				mysql_close($link);
				// Finish the page
				//print_footer($course);
			}
			else {
			
				//Button for new searches
				echo "<TABLE ALIGN=\"center\"><FORM NAME=\"newsearchform\" METHOD=\"post\" ACTION=\"search_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";	
				echo "<TR><TD><INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("newsearch", "genetic")."\" NAME=\"buttonsearch\" /></TD></TR>";
			
				echo "</FORM></TABLE>";

				for ($i=0; $i<$n; $i++) {
					// Get the cards fields
					$cardrow = mysql_fetch_array($result);
					// Remove '\' from the entries and allow them in variables
					//$cardrowisolang = stripslashes($cardrow['isolang']);
					//$cardrowterm = stripslashes($cardrow['term']);
					//$cardrowgramcat = stripslashes($cardrow['gramcat']);
					//$cardrowdefinition = stripslashes($cardrow['definition']);
					//$cardrowcontext = stripslashes($cardrow['context']);
					//$cardrowexpression = stripslashes($cardrow['expression']);
					//$cardrownotes = stripslashes($cardrow['notes']);
					//$cardrowid = stripslashes($cardrow['id']);
					$headerrowni = stripslashes($cardrow['id']);
					
					
					
					// Get the header
					$queryh = genetic_choose_header($headerrowni);
					$resulth = mysql_query($queryh,$link);					
					$headerrow = mysql_fetch_array($resulth);					
					// Remove '\' from the entries and allow them in variables
					//$headerrowni = stripslashes($headerrow['id']);
					$headerrowty = stripslashes($headerrow['ty']);
					
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
								
						$query = genetic_show_cards($headerrowni);
						$resultc = mysql_query($query, $link);
						$ncards = mysql_num_rows($resultc);
						
						
						// Print box for the terms
						echo "<BR /><BR />";
						print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				
						echo "<TABLE ALIGN=\"center\" STYLE=\"table-layout:fixed\" WIDTH=\"80%\">";
						for ($k=0; $k<$ncards; $k++) {
				
				
							// Get the cards fields
							$cardrow = mysql_fetch_array($resultc);				
							// Remove '\' from the entries and allow them in variables
							$cardrowisolang = stripslashes($cardrow['isolang']);
							$cardrowterm = stripslashes($cardrow['term']);
				
								if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&term=$cardrowterm&search=term_by_link\"><NOBR>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></NOBR></TD>";
									
									
				
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
						echo "<TR><TD COLSPAN=\"2\"ALIGN=\"center\"><A HREF=\"editcard_form.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/edit.gif\" tittle=\"".$striconedit."\" ALT=\"".$striconedit."\"></A>&nbsp;&nbsp;
						<A HREF=\"deletecard.php?id={$cm->id}&idheader=$headerrowni\"><IMG SRC=\"images/delete.gif\" tittle=\"".$stricondelete."\" ALT=\"".$stricondelete."\"></A></TD>";
						echo "<TD><a href=\"search.php?id=$id&idheader=$headerrowni&search=fullcard_by_link\"><NOBR>".$strviewfull."</NOBR></TD></TR>";
						echo "</TABLE>";
					// Finish the card
					print_box_end($return=false);
				}
				// Close the db    
				mysql_close($link);
			}			
		}
	}
	
	
		
	// Finish the page
	include('banner_foot.html');
	print_footer($course);

?>
