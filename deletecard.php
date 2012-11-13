<?php  // $Id: delete.php,v 2.0 2012/06/04 17:05:00 Ana María Lozano de la Fuente Exp $
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

	// File that deletes a genetic card
	
	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	require_once("selectsubdomains.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
    // Necessary URL parameters to delete a card
	$headerni = optional_param('idheader',0,PARAM_INT);
	$confirm = optional_param('confirm',0,PARAM_INT);
	$newcardid = optional_param('newcardid',0,PARAM_INT);
	
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
    add_to_log($course->id, "genetic", "delete card", "deletecard.php?id={$cm->id}&idheader=$headerni", "$genetic->id");
	
	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	// Check if the user has permission in this activity
	if (! has_capability('mod/genetic:manageentries', $context)) {
		error('Sin permisos');
	}

	else {
	// Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	
	$strnodefined = get_string("nodefined", "genetic");
	
	$strbe = get_string("be", "genetic");
	$strty = get_string("ty", "genetic");
	$strni = get_string("ni", "genetic");
	$strdom = get_string("dom", "genetic");
	$strsubdom = get_string("subdom", "genetic");
	$strauthor = get_string("author", "genetic");
	$strdate = get_string("datecreated", "genetic");

	
	// Get a short version for the name of the genetic
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

				  
    // Print Title
	print_heading(get_string('deletecard', 'genetic'), 'center',2);

	
	// Print the main part of the page

	// Get card information from the database
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$query = genetic_choose_header($headerni);
    $result = mysql_query($query,$link);
	
	// Header information
	$headerrow = mysql_fetch_array($result);	
	// Remove '\' and save the result
	$headerty = stripslashes($headerrow['ty']);
	$headerdom = stripslashes($headerrow['dom']);
	$headersubdom = stripslashes($headerrow['subdom']);
	$headerdate = date("F Y", $headerrow['datecreated']);
	
	// Make queries for numerical fields				
	// BE - Deparment
	$query = genetic_show_rel_be($headerni);
	$result = mysql_query($query, $link);
	$row = mysql_fetch_array($result);
	$headerbe = stripslashes($row['name']);
	while ($row = mysql_fetch_array($result)) {
		$aux = stripslashes($row['name']);
		$headerbe = $headerbe.", ".$aux;
	}
	
	// TY - Card type
	if($headerty == 0) {
		$headerty = $strnodefined;
	}
	else {
		$query = genetic_choose_ty($headerty);
		$row = mysql_fetch_array(mysql_query($query, $link));
		$headerty = stripslashes($row['name']);
	}
	
		// Subdomain
	$query = genetic_show_rel_subdomain($headerni);
	$result = mysql_query($query, $link);
	$row = mysql_fetch_array($result);
	$headersubdom = stripslashes($row['name']);
	while ($row = mysql_fetch_array($result)) {
		$aux = stripslashes($row['name']);
		$headersubdom = $headersubdom.", ".$aux;
	}
	
	// Author
				
				$query = genetic_show_rel_author($headerni);
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
				

	//Count the languages available in the dictionary
	
	
	
	// Select the cards for this header
	$query = genetic_show_cards($headerni);
	$resultcards = mysql_query($query,$link);
	//number of card with this header
	$numlang = mysql_affected_rows($link);
	
	// Delete "cards"
	
	
	
	

	// Print genetic card fields to delete it
	if ($confirm != 1) {	
		// Print headercard information
		print_box_start($classes='generalbox boxaligncenter boxwidthwide');
		echo "<TABLE ALIGN=\"center\">";
		echo "<TR><TD><B>".$strbe."</B>&nbsp;&nbsp;</TD><TD>".$headerbe."</TD></TR>";
		echo "<TR><TD><B>".$strty."</B>&nbsp;&nbsp;</TD><TD>".$headerty."</TD></TR>";
		echo "<TR><TD><B>".$strni."</B>&nbsp;&nbsp;</TD><TD>".$headerni."</TD></TR>";
		// Subdomain
				echo "<TR><TD><B>".$strsubdom."</B>&nbsp;&nbsp;</TD>";
				
				
					$query = genetic_show_rel_subdomain($headerni);
					$resultdom = mysql_query($query, $link);
					echo "<TD>";
					while ($row = mysql_fetch_array($resultdom)) {
						$headerrowsubdomiddom = stripslashes($row['iddom']);
						$headerrowsubdom = stripslashes($row['name']);
						
						//---------------------search tree subdomain
						
							
							
								
								$subdomparent=calcular_ruta_subdominios($headerrowsubdomiddom);
							
								
						
						//--------------------end of the search tree subdomain
						
						
						echo"".$subdomparent. " /<A HREF=\"http://eurogene.open.ac.uk/theme/$headerrowsubdom\" target=\"blank\" ><FONT COLOR=\"#238E23\">".$headerrowsubdom."</FONT></A><BR>";
					
					}
					
					echo "</TD>";
		//fin subdomain			
		
		
		echo "<TR><TD><B>".$strauthor."</B>&nbsp;&nbsp;</TD><TD>".$headerauthor."</TD></TR>";
		echo "<TR><TD><B>".$strdate."</B>&nbsp;&nbsp;</TD><TD>".$headerdate."</TD>";
		echo "<TR><TD COLSPAN=\"2\"><BR />";
		
		// Print card language information
		echo "<TABLE ALIGN=\"center\"><TR>";
		
			while($cardrow = mysql_fetch_array($resultcards)){
	
				// Remove '\' and save result
				$cardid = stripslashes($cardrow['id']);
				$cardisolang = stripslashes($cardrow['isolang']);
				$cardterm = stripslashes($cardrow['term']);
	
	
	
				//select the id-remissions of every language
	
				$query2 = genetic_show_remissions($cardid);
				$resultrem = mysql_query($query2,$link);
				
				if ($cardterm != '') {
					echo "<TD>&nbsp;&nbsp;<IMG SRC=\"images/".$cardisolang.".png\">&nbsp;&nbsp;".$cardterm."&nbsp;&nbsp;</TD>";
				}
			
				
				
				//echo "</TD></TR><TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str."<BR /><BR /></TD></TR>";
				echo "</TABLE>";	
			

					// Delete card
						
						echo "<form method=\"post\" action=\"deletecard.php?id={$cm->id}&idheader=$headerni&confirm=1\">";
						echo "<table class=\"boxaligncenter\">";
		
						for($i=0;$i<count($cardid);$i++){
				
								echo "<INPUT TYPE=\"hidden\" NAME=\"newcardid[ ]\" VALUE=\"".$cardid."\">";
						}
						
			}
			
		//Confirm to delete the card	
			$str = get_string("deletecardsure", "genetic");
			echo"<TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str."<BR /><BR /></TD>";	
		
						
		echo "<tr><td align=\"center\"><input type=\"submit\" value=\"".$str = get_string("delete", "genetic")."\" name=\"buttondelete\" /></TD>";
		echo "<td align=\"center\"><input type=\"button\" value=\"".$str = get_string("cancel", "genetic")."\" name=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/></TD></TR>";
		echo "</table>";
		echo "</form>";
		echo "</TABLE>";
	    print_box_end($return=false);
	}
	
	// Delete the genetic card from the database
	else {
		// Delete header
		$query = genetic_delete_header($headerni);
		$result = mysql_query($query,$link);
		$nok = mysql_affected_rows($link);
		
		// Delete relation header-be and header-author
		$query = genetic_delete_rel_headerbe($headerni);
		$result = mysql_query($query,$link);
		$nok2 = mysql_affected_rows($link);
		
		$query = genetic_delete_rel_headerauthor($headerni);
		$result = mysql_query($query,$link);
		$nok3 = mysql_affected_rows($link);
		
		$query = genetic_delete_rel_subdomain($headerni);
		$result = mysql_query($query,$link);
		$nok4 = mysql_affected_rows($link);
		
		
		
		// Delete ok or not?
		if(($nok == 0) || ($nok2 == 0) || ($nok3 == 0) || ($nok4 == 0)) {
			$redirectmsg = get_string("deletenok", "genetic");
			redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
		}		
		else {
						
				
				
				// Delete 3 languages
				$query = genetic_delete_card($headerni);
				$result = mysql_query($query,$link);
				$nok = mysql_affected_rows($link);
				
				
				//Delete images
		
				$query = genetic_delete_image($headerni);
				$result = mysql_query($query,$link);
				$nok4 = mysql_affected_rows($link);
				
					// Delete ok or not?
					if($nok == 0) {
						$redirectmsg = get_string("deletenok", "genetic");
						redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);
						
					}
			
					else {
				
						
						
						// Delete Sources
						
						for($i=0;$i<count($newcardid);$i++){
						
						
						$query = genetic_delete_source($newcardid[$i]);
						$result = mysql_query($query,$link);
						$nok = mysql_affected_rows($link);
						
						
						// Delete videos 
									
						$query = genetic_delete_video($newcardid[$i]);
						$result = mysql_query($query,$link);
						$nok4 = mysql_affected_rows($link);	
						
						//search remid
						
							$queryrem=genetic_show_remissions($newcardid[$i]);
							$resultrem = mysql_query($queryrem,$link);
							
							while($cardrowrem = mysql_fetch_array($resultrem)){
							
								$remid= stripslashes($cardrowrem['id']);
							
								
								// Delete syn
								$query = genetic_delete_has_synonym($remid);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);
								
								// Delete relterm 
								$query = genetic_delete_has_related($remid);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);
								
								// Delete crossrelterm 
								$query = genetic_delete_has_crossrelated($remid);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);
								
								
								
							}
							
								// Delete remisions 
									$query = genetic_delete_remissions($newcardid[$i]);
									$result = mysql_query($query,$link);
									$nok = mysql_affected_rows($link);
						
						
						
								$query = genetic_delete_audio($newcardid[$i]);
								$result = mysql_query($query,$link);
								$nok = mysql_affected_rows($link);
						
						
						}//new for
						
						
					
						
						
						
						
						//Borrar los archivos de Audio de las tablas
				
						// Audio Language 1
				
						/*$query = genetic_search_audio($newcardid[$i]);
						$result = mysql_query($query,$link);
						$nok = mysql_affected_rows($link);
	
						$cardrow = mysql_fetch_array($result);
						$name = stripslashes($cardrow['fileaudio']);
						//Borrar los archivos de audio de la carpeta
				
						$rutaEnServidor='C:\wamp\www\moodle\mod\genetic\audio';
						$rutaDestino=$rutaEnServidor.'/'.$name;
						//echo $rutaDestino;
						unlink($rutaDestino);
					*/
						
				
									
					
			}
			
			
		}
		$redirectmsg = get_string("deleteok", "genetic");
		redirect($url="view.php?id={$cm->id}", $redirectmsg, $delay=-1);		
		
		// Close the database link
		mysql_close($link);
	}
	
	} // Close caps ELSE
		
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>