<?php  // $Id: view.php,v 1.0 2012/06/27 17:20:00 Ana Mar�a Lozano Exp $ 
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

/**
 * This page prints a particular instance of genetic module
 **/

	// Attached files
    require_once("../../config.php");
    require_once("db/access.php");
    require_once("lib.php");
	require_once("db_functions.php");
	require_once("selectsubdomains.php");

	// Necessary parameters
    $id = optional_param('id', 0, PARAM_INT); // Course Module ID, or
    $t  = optional_param('t', 0, PARAM_INT);  // genetic ID
	
	// Param to order all cards by date
	$order = optional_param('order', '', PARAM_TEXT); // Date order
	$language= optional_param('language', '', PARAM_TEXT);
	
	
	

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

    } else if ($t) {
        if (! $genetic = get_record("genetic", "id", $t)) {
            error("Course module is incorrect");
        }
        if (! $course = get_record("course", "id", $genetic->course)) {
            error("Could not determine wich course this belong to");
        }
        if (! $cm = get_coursemodule_from_instance("genetic", $genetic->id, $course->id)) {
            error("Could not determine wich course module this belong to");
        }
		
		$id = $cm->id;
    } else {
		error("Must specify genetic ID or course module ID");
	}

	// Check if current user is logged in
    require_login($course->id);

	// Log table
    add_to_log($course->id, "genetic", "view all genetic cards", "view.php?id=$cm->id", "$genetic->id");
	
	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	// Check if the user has permission in this activity
	if (! has_capability('mod/genetic:view', $context)) {
		error('Sin permisos');
	}
	
	else {	
	
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	$strsearch = get_string("buttongeneralsearch", "genetic");
	$strdateexplain = get_string("indexuse", "genetic");	
	$striconedit = get_string("edit", "genetic");
	$stricondelete = get_string("delete", "genetic");	
	$strnodefined = get_string("nodefined", "genetic");
	$stralphaorder = get_string("alphaorder", "genetic");
	
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
	// a�adido:
	$strlang = get_string("lang", "genetic");
	$strimagenes=get_string("imagenes", "genetic");
	//$strdatemod=get_string("datemodified", "genetic");
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
	$strasc = get_string("asc", "genetic");
	$strdesc =get_string("desc", "genetic");
	$strviewfull=get_string("viewfullcard", "genetic");
	$strnolang  = get_string("nolang", "genetic");
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

	
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	//$link = PConnect($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname); // don't work

	
		// Print the title of the module project
		print_heading($genetic->name, 'center', 1);

		// Description box
		if ($genetic->description != '') {
			print_box(format_text($genetic->description, FORMAT_MOODLE), 'generalbox', 'description');
		}

// Print the main part of the page
				
		// GENERAL SEARCH BOX
		//Check if there is any card or it is empty
		$querycards = genetic_show_headers($genetic->id);
        $resultcards = mysql_query($querycards,$link);
		$nhcards = mysql_num_rows($resultcards);

		// Print searchbox if there are cards
		if ($nhcards != 0) {
			echo "<form method=\"post\" action=\"search.php?id=$id\">";
			echo "<table class=\"boxaligncenter\" width=\"70%\" border=\"0\">";
			echo "<tr><td align=\"center\" class=\"geneticsearchbox\"><IMG SRC=\"images/Search.gif\">&nbsp;&nbsp;";
			echo "<input type=\"submit\" value=".$strsearch." name=\"buttongeneralsearch\" />";
			echo "<input type=\"text\" name=\"generalkey\" size=\"20\" value=\"\" alt=\"".$strsearch."\" />";
			echo "<input type=\"hidden\" name=\"search\" value=\"general\" />";
			echo "</td></tr></table>";
			echo "</form>";
			echo "<br />";
		}


		// Print the tabs
		$SESSION->genetic->current_tab = 'cards';
		include('tabs.php');

		

		// NAVIGATION BAR
		// Print the date navigation bar   ---a�adido el orden alfabetico----
		
        echo "<div class=\"dateexplain\">";
        echo "$strdateexplain";
		echo "</div>";
	    //echo "<br />";
		echo "<TABLE WIDTH=\"20%\" ALIGN=\"center\" BORDER=\"0\"><TR><TD ALIGN=\"center\">
			  <TD>&nbsp;&nbsp;<a href=\"view.php?id=$id&order=ASC\"><NOBR>".$strasc."</NOBR></a></TD><TD>&nbsp;/</TD>
			  <TD>&nbsp;&nbsp;<a href=\"view.php?id=$id&order=DESC\"><NOBR>".$strdesc."</NOBR></a></TD><TD>&nbsp;/</TD>&nbsp;&nbsp;";
		
		
		echo"<FORM NAME=\"form2\" METHOD=\"post\" ACTION=\"view.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TD>&nbsp;&nbsp;<font color=\"blue\"><NOBR>".$stralphaorder."</NOBR></font></TD>&nbsp;&nbsp;&nbsp;&nbsp;";
		
			//Number of languages available to add
			$isolang = genetic_array_isolang();
			$numlang=count ($isolang);
			$s=0;
			
			for($i=0;$i<$numlang;$i++){

					//search id language
					$query = genetic_search_lang($isolang[$i]);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					$row = mysql_fetch_array($result);
					$idlang = $row['id'];

					//check if the language is already in the dictionary
					$query = genetic_exist_lang_dic($idlang,$genetic->id);
					$result = mysql_query($query,$link);
					$n = mysql_num_rows($result);
					if($n!=0){
					echo "<p><TD>&nbsp;&nbsp;<a href=\"view.php?id=$id&order=ALPHABETIC&language=".$isolang[$i]."\" target='_self'><img src=\"images/".$isolang[$i].".png\"'></a></TD>&nbsp;&nbsp;</p>";	
					$s=1;
					}
					
			}			
			
			if($s==0){
					echo "<BR>";
					echo "<TR><p><TD ALIGN=\"center\">&nbsp;&nbsp;<IMG SRC=\"images/Info.gif\"> ".$strnolang."</TD></p></TR>";
					}
		
			
		echo" </TR></TABLE>";
		
		
		
		if($order=='ALPHABETIC')
		{
		$query = genetic_show_headers_order2($genetic->id,$language);
		$resultorder = mysql_query($query,$link);
		$nokk = mysql_affected_rows($link);
		}
		if($order=='DESC')
		{
		$query = genetic_show_headers_order($genetic->id,$order);
					$resultorder = mysql_query($query,$link);
		}
		if($order=='ASC')
		{
			$query = genetic_show_headers_order($genetic->id,$order);
					$resultorder = mysql_query($query,$link);
		}
		echo "<BR>";
		/*echo "<BR>";
		echo "<BR>";*/
		// Printing the card entries
		// If there are no cards
		if ($nhcards == 0) {
			print_box('<div style="text-align:center">' . get_string("noentries","genetic") . '</div>',"center","95%");
		}
		else if(($order=='ALPHABETIC') &&($nokk==0))
		{
			print_box('<div style="text-align:center">' . get_string("noentriesterm","genetic") . '</div>',"center","95%");
		}
		//If there are cards
		else {	
			  
			
			// Print genetic cards  
			for ($j=0; $j<$nhcards; $j++) {
			

				//Order ASC en fecha de creacion
				if($order == 'ASC') {
					$headerrow = mysql_fetch_array($resultorder);	
				}
				
				// Order DESC en fecha de creacion
				else if ($order == 'DESC') {	
					$headerrow = mysql_fetch_array($resultorder);	
				}
				// Order ALPHABETIC  ----a�adido---
				else if ($order == 'ALPHABETIC') {
					$headerrow = mysql_fetch_array($resultorder);	
				}
				// No order
				else {
					$headerrow = mysql_fetch_array($resultcards);
				}

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
				
				$query = genetic_show_rel_author($headerrowni);
				$result = mysql_query($query, $link);
				
				$row = mysql_fetch_array($result);
				$headerauthor1 = stripslashes($row['name']);
				$headerauthor2 = stripslashes($row['surname']);
				$headerauthor = $headerauthor1." ".$headerauthor2;
				while ($row = mysql_fetch_array($result)) {
					
					$headerauthor1 = stripslashes($row['name']);
					$headerauthor2 = stripslashes($row['surname']);
					$headerauthor3 = $headerauthor1." ".$headerauthor2;
					$headerauthor = $headerauthor.", ".$headerauthor3;
				}
				
				
				//NEW CODE ONLY SHOW THE TERMS:
				
				
				// Get the cards in 3 languages si order es ASC o DESC y en s�lo 1 si order es ALPHABETIC
				if(($order=='ASC')||($order=='DESC'))
				{
				$query = genetic_show_cards($headerrowni);
				$resultc = mysql_query($query, $link);
				$ncards = mysql_num_rows($resultc);
				}
				else if($order=='ALPHABETIC')
				{
					
					$query = genetic_show_cards2($headerrowni,$language);
					$resultc = mysql_query($query, $link);
					$ncards = mysql_num_rows($resultc);	
					
				}
				else{
				$query = genetic_show_cards($headerrowni);
				$resultc = mysql_query($query, $link);
				$ncards = mysql_num_rows($resultc);
				}
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
					$cardrowtermid = stripslashes($cardrow['id']);
				
						if ($cardrowterm != '') {
								echo "<TD ROWSPAN=\"13\" VALIGN=\"top\" WIDTH=\"5%\"><IMG SRC=\"images/".$cardrowisolang.".png\">
									<B>".$strterm.":&nbsp;&nbsp;</B><a href=\"search.php?id=$id&idterm=$cardrowtermid&search=term_by_link\"><p style='margin-top:0;margin-bottom:0;'>".$cardrowterm."</a>&nbsp;&nbsp;<a href=\"http://eurogene.open.ac.uk/search03/$cardrowterm\" target=\"blank\"><img src=\"images/eurogene.jpg\"  width=\"40\" height=\"30\"></a></p></TD>";
									
									
				
						}
				
				}
				echo "</TABLE><HR />";
				
				
				//FIN CODIGO NUEVO
				
				
				
				// Print header
				echo "<BR /><BR />";
				//print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
				echo "<TABLE ALIGN=\"center\" width='80%'>";				
				// Department - BE
				echo "<TR ><TD width='35%'><B>".$strbe."</B>&nbsp;&nbsp;</TD><TD>".$headerbe."</TD></TR>";
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
						
						
						echo"<NOBR>".$subdomparent. " <A HREF=\"http://eurogene.open.ac.uk/theme/$headerrowsubdom2\" target=\"blank\" ><FONT COLOR=\"#238E23\">".$headerrowsubdom."</FONT></A></NOBR><BR>";
					
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
			
			
			
			
		} //fin del else de que si q hay cards


	// Close the database
    mysql_close($link);
	
	
	}  // Close caps ELSE 
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);
	
?>

