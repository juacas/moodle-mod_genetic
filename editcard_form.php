<?php  // $Id: editcard_form.php, v20 2012/06/15 09:00:00 Ana Mar�a Lozano de la Fuente Exp $
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

	// File with form for editing a genetic card

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
    require_once("lib.php");
	require_once("selectsubdomains.php");
?>
<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

<?php 
		//To get the strings for the options of the select generated in JS function addCampo
		$opts=array();
		$opts["nodefined"] = get_string("nodefined", "genetic");
		$type_rem = genetic_array_type_rem();
		for ($k=0; $k<count($type_rem); $k++) {
				$opts[$type_rem[$k]]=get_string($type_rem[$k], "genetic");
			}
		$type_rem_nodefine[0] = "";
		$type_rem = array_merge($type_rem_nodefine,$type_rem);
		echo "var optsNames='".join(',',$opts)."';";
		echo "var optsValues='".join(',',$type_rem)."';";
		echo "var strDeleteRem='".get_string('deleteremission','genetic')."';"
?>
		
		// JS function that dinamically create fields to input remissions in the form 
		// idlang is the id of the language and optionsremtype is a string containing the values of the options of the element select separated with commas


addCampo = function (idlang) {

	        numero=++document.getElementById('numfieldsremission'+idlang).value;
			
			nDiv = document.getElementById('remissions'+idlang); 

			nCampo = document.createElement('input');
		    nCampo.name = 'remission_'+idlang+"_"+numero;
		    nCampo.id = 'remission_'+idlang+"_"+numero;
		    nCampo.type = 'text';
			nCampo.size=40;
		 
			ele = document.createElement('select');
			ele.name = 'remtype_'+idlang+"_"+numero; 
			ele.id = 'remtype_'+idlang+"_"+numero;
			
			var option_values=optsValues.split(",");
			var option_names=optsNames.split(",");
			var lenght_options=option_values.length;
			var option= new Array(lenght_options);

			for(i=0;i<lenght_options;i++)
			{
				option[i]=document.createElement('option');
				option[i].value=option_values[i];
				option[i].innerHTML=option_names[i];
				ele.appendChild(option[i]);
			}

			br = document.createElement('br');								
			br.id = 'br_'+idlang+"_"+numero;
			nDiv.appendChild(br);
			
			
			nDiv.appendChild(ele); 

			nDiv.appendChild(nCampo);

			//Add eliminate button
			a=document.createElement('a');
			a.setAttribute("onclick","javascript:deleteRemission("+idlang+","+numero+");");
			a.id='a_'+idlang+"_"+numero;
			img=document.createElement('img');
			img.src="images/delete.svg";
			img.alt=strDeleteRem;
			img.id='deleteimage'+idlang+"_"+numero;
			a.appendChild(img);
			nDiv.appendChild(a);
			
			//document.getElementById('numfieldsremission'+idlang).value++;
}


deleteRemission = function(idlang,idelement){
			nDiv = document.getElementById('remissions'+idlang); 
			remission = document.getElementById('remission_'+idlang+"_"+idelement);
			remissiontype = document.getElementById('remtype_'+idlang+"_"+idelement);
			a = document.getElementById('a_'+idlang+"_"+idelement);
			br =  document.getElementById('br_'+idlang+"_"+idelement);
			nDiv.removeChild(remission);
			nDiv.removeChild(remissiontype);
			nDiv.removeChild(a);
			nDiv.removeChild(br);
}
		


		
//con esta funci�n eliminamos el campo cuyo link de eliminaci�n sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);

   
 }
//con esta funci�n recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) {
   return evt.srcElement ?  evt.srcElement : evt.target;
}

 

</script>
<?php 
	
	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	$numrem =optional_param('numrem',0,PARAM_INT);
	
    // Necessary parameters to edit a card
	$headerni = optional_param('idheader',0,PARAM_INT);

	
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
    add_to_log($course->id, "genetic", "edit card", "editcard_form.php?id={$cm->id}&idheader=$headerni", "$genetic->id");
	
	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	// Check if the user has permission in this activity
	if (! has_capability('mod/genetic:manageentries', $context)) {
		error('Sin permisos');
	}

	else {
	//Get the strings wich are necessaries
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");
	$strbe = get_string("be", "genetic");
	$strty = get_string("ty", "genetic");
	$strni = get_string("ni", "genetic");
	$strdom = get_string("dom", "genetic");
	$strsubdom = get_string("subdom", "genetic");
	$strauthor = get_string("author", "genetic");
	$strterm = get_string("term", "genetic");
	$strgramcat = get_string("gramcat", "genetic");
	$strdefinition = get_string("definition", "genetic");
	$strcontext = get_string("context", "genetic");
	$strexpression = get_string("expression", "genetic");
	$strnotes = get_string("notes", "genetic");
	$strsources = get_string("sources", "genetic");
	$stracronims= get_string("acronyms", "genetic");
	$strabreviaturas= get_string("abreviaturas", "genetic");
	$strsyn= get_string("synonym", "genetic");
	$strrelatedterms= get_string("relatedterms", "genetic");
	$strcrossrelatedterms= get_string("crossrelatedterms", "genetic");
	$strimagenes=get_string("imagenes", "genetic");
	$strvideos=get_string("videos", "genetic");
	$straudio=get_string("audio", "genetic");
	$strwm=get_string("wm", "genetic");
	$strrv = get_string("rv", "genetic");
	
	// Get card information
	// Connect to the db
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	$query = genetic_choose_header($headerni);
    $result = mysql_query($query,$link);
	
	// Header
	$headerrow = mysql_fetch_array($result);	
	// Remove '\' and save the result
	$headerty = stripslashes($headerrow['ty']);
	//$headerdom = stripslashes($headerrow['dom']);
	//$headersubdom = stripslashes($headerrow['subdom']);
	
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


    // Print Title
	print_heading(get_string('editcard', 'genetic'), 'center',2);	

	
	// Print the main part of the page
	
    // Form to edit a genetic card	
	
	//Select the languages of the dictionary
	
		$query = genetic_count_lang($genetic->id);
		$resultlang = mysql_query($query,$link);   //$resultlang contains the rows returned by the query, each one for each language in the dictionary (id, genetic_lang_id, genetic_id)
		
		$numlang = mysql_affected_rows($link);  //$numlang contains the number of languages in the dictionary
	
	//Take the parameters than come from other forms (editim_form,etc.) as previously they were enterered by the user
	$prevbes= optional_param('be', null, PARAM_INT);
	$prevauthors= optional_param('author', null, PARAM_INT);
	$prevdomsubdom = optional_param('domsubdom', null, PARAM_INT);
	$ty = optional_param('ty', 0, PARAM_INT);
	$previmagen = optional_param('prevformimagen', null, PARAM_INT);
		

	
	echo "<FORM NAME=\"editcardform\" METHOD=\"post\" ACTION=\"editcard.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
	echo "<TABLE WIDTH=\"100%\">";
	echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("commonheaderdata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
			
			// to distinguis the origin page in add imagen forms, etc.
			echo "<INPUT TYPE=\"hidden\" NAME=\"originpage\" VALUE=\"edit\"></TD></TR>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"idheader\" VALUE=\"$headerni\"></TD></TR>";
				
			// BE - department
			echo "<TR><TD ALIGN=\"right\"><B>".$strbe."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE NAME=\"be[]\">";			
			$query = genetic_show_be();
			$result = mysql_query($query,$link);
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				$idbe=$row['id'];
				$name=$row['name'];
				$queryaux = genetic_header_has_be($headerni,$idbe);
				$resultaux = mysql_query($queryaux,$link);
				$isselected = 0;
				for($i=0;$i<count($prevbes);$i++){
					if($idbe==$prevbes[$i])$isselected=1;
				}
				if($isselected==1){
					echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['name'];
				}else{
					if((mysql_fetch_array($resultaux))&&($prevbes==null)){ //prevbes is null if the page is not called from editim,etc (forms of plus buttons).
						echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['name'];
					}else{
						echo "<OPTION VALUE=\"".$row['id']."\">".$row['name'];
					}
				}			
			}
			echo "</SELECT>&nbsp;&nbsp;";
			//<A href=\"editbe_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add department\"/></A></TD></TR>";
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add department\" name=\"adddepartament\" value=\"Add Department\" onclick=\"this.form.action='editbe_form.php?id=$id';this.form.submit();\"></TD></TR>";
				
			// TY - card type
			echo "<TR><TD ALIGN=\"right\"><B>".$strty."</B>&nbsp;*</TD>";
			echo "<TD><SELECT NAME=\"ty\">";			
			$query = genetic_show_ty();
			$result = mysql_query($query,$link);
			while($row = mysql_fetch_array($result)){
				$namety = $row['name'];
				$idty= $row['id'];

				$queryaux=get_ty_headercard($headerni,$idty);
				$resultaux=mysql_query($queryaux,$link);
				if($idty==$ty){
					echo "<OPTION selected VALUE=\"".$idty."\">".$namety;
				}
				else{
						if(mysql_fetch_array($resultaux)&&($ty==0)) {
			 				echo "<OPTION selected VALUE=\"".$idty."\">".$namety;
						}else{
							echo "<OPTION VALUE=\"".$idty."\">".$namety;
						}
					}
				}
			echo "</SELECT>&nbsp;&nbsp;";
			//<A href=\"editty_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add card type\"/></A></TD></TR>";
			
			
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add project\" name=\"addproject\" value=\"Add Project\" onclick=\"this.form.action='editty_form.php?id=$id';this.form.submit();\"></TD></TR>";
			
			// Id number (hidden)
			echo "<INPUT TYPE=\"hidden\" NAME=\"ni\" VALUE=\"".$headerni."\"></TD></TR>";
			
			// Subdomain
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strsubdom."</B>&nbsp;*</TD>";
			
			

			
			echo "<TD>";
			
			genetic_select_subdomains5($nivel=0,$headerni,$prevdomsubdom);
			echo"</TD>";
			echo "<TD>&nbsp;&nbsp;";
			//<A href=\"editdom_form.php?id=$id&cat=subdomain\"><IMG SRC=\"images/Add.gif\" ALT=\"add subdomain\"/></A></TD></TR>";	
			
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add domain\" name=\"adddomain\" value=\"Add Domain\" onclick=\"this.form.action='editdom_form.php?id=$id&cat=subdomain';this.form.submit();\"></TD></TR>";
				
			
			// Author
			echo "<TR><TD ALIGN=\"right\"><B>".$strauthor."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE NAME=\"author[]\">";			
			$query = genetic_show_authors();
			$result = mysql_query($query,$link);
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				if($prevauthors!=null){
					$idauthor = $row['id'];
					$nameauthor = $row['name'];
					$surnameauthor =$row ['surname'];
					$isselected=0;
					for($i=0;$i<count($prevauthors);$i++){
						if($idauthor==$prevauthors[$i])$isselected=1;
					}
					if($isselected==1){
						echo "<OPTION VALUE=\"".$idauthor."\" selected>".$nameauthor."  ".$surnameauthor."</OPTION>";
					}else{
						echo "<OPTION VALUE=\"".$idauthor."\">".$nameauthor."  ".$surnameauthor."</OPTION>";
						}
					}
				else{
					$queryaux = genetic_show_rel_author($headerni);
					$resultaux = mysql_query($queryaux,$link);
					while ($rowaux = mysql_fetch_array($resultaux)) {
					if ($rowaux['id'] == $row['id']) {
						echo "<OPTION SELECTED VALUE=\"".$rowaux['id']."\">".$rowaux['name'];
						$flagprint = 1;
						}
					}
					if ($flagprint !=1) {
						echo "<OPTION VALUE=\"".$row['id']."\">".$row['name'];
					}
				}	
			}
			echo "</SELECT>&nbsp;&nbsp;";
			//<A href=\"editauthor_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add author\"/></A></TD></TR>";
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add author\" name=\"addauthor\" value=\"Add Author\" onclick=\"this.form.action='editauthor_form.php?id=$id';this.form.submit();\"></TD></TR>";
			
			// Date created
			$datecreated = 0 + time();
			echo "<TR><TD><INPUT TYPE=\"hidden\" NAME=\"datecreated\" VALUE=\"".$datecreated."\"></TD></TR>";
			
		echo "</TABLE>";
		print_box_end($return=false);	

		///START IMAGES

		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
	
		echo "<TABLE ALIGN=\"center\">";
		
		echo "<TR><TD ALIGN=\"right\"><B>".$strimagenes."</B>&nbsp;</TD>";
			
		
		echo "<TD><SELECT MULTIPLE NAME=\"imagen[]\">";			
			$query = genetic_show_im();
			$result = mysql_query($query,$link);
						
			$noimagen=1;
			while ($row = mysql_fetch_array($result)) {
				$idimg = $row['id'];
				$nameimg = $row['fileimage'];
				if($previmagen!=null){
					$isselected=0;
					for($i=0;$i<count($previmagen);$i++){
						if($idimg==$previmagen[$i])
							{$isselected=1;
							$noimagen=0;
							}
					}
					if($isselected==1){
						echo "<OPTION VALUE=\"".$idimg."\" selected>".$nameimg."</OPTION>";
					}else{
						echo "<OPTION VALUE=\"".$idimg."\">".$nameimg."</OPTION>";
					}	
				}else{
				$queryaux = genetic_get_images_header($headerni,$idimg);
				$resultaux = mysql_query($queryaux,$link);
			    if(mysql_fetch_array($resultaux)) {
						echo "<OPTION SELECTED VALUE=\"".$idimg."\">".$nameimg;
						$noimagen=0;
						}else{
						echo "<OPTION VALUE=\"".$idimg."\">".$nameimg;
						}
					}
			}
			if($noimagen){
				echo "<OPTION SELECTED VALUE=\"0\">".$str = get_string("nodefined", "genetic");
			}else{
				echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
			}
			
			echo "</SELECT>";
				  echo"    &nbsp;&nbsp;";
    			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add image\" name=\"addimagen\" value=\"A�adir imagen\" onclick=\"this.form.action='editim_form.php?id=$id';this.form.submit();\"\>";
			
				//  <A href=\"editim_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add images\"/></A></TD>";


	    echo "</TABLE>";		
		print_box_end($return=false);


        //fin imagenes
		
		echo "<BR /></TD></TR>";

		echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("languagecarddata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		
		
		
		
		
		//Repite the card the number of languages of the dictionary
		
			
			
			// Select the cards for this header, one card for each language
			
		$queryc = genetic_show_cards($headerni);
		$resultc = mysql_query($queryc,$link);   
			//esto estaba en el bucle pero no hace falta
		//$cardrow = mysql_fetch_array($resultc);
		//number of languages filled in the card
		$ncards = mysql_num_rows($resultc);
			
			
			//LOOP FOR THE CARDS     $numlang= number of languages of the dictionary
			
		//Repite the card the number of languages of the dictionary
		$j=-1;
		while($langrow = mysql_fetch_array($resultlang)){
			$j++;
				
			//for($z=0;$z<$numlang;$z++){
		
				echo "<INPUT TYPE=\"hidden\" NAME=\"ncards\" VALUE=\"".$ncards."\">"; //evp number of current cards for that term
				
				//Search which languages contains the dictionary  $lagrow contains an array with the rows of the DB for each language existing 
				//$langrow = mysql_fetch_array($resultlang); //evp vamos recorriendo los lenguajes
				$idlang = $langrow['genetic_lang_id']; //id of language
				$query2 =genetic_search_lang_name($idlang);
				$result2 = mysql_query($query2,$link); //a select regturnign id and name of the languge
				$row2 = mysql_fetch_array($result2);
				$namelang=$row2['language'];   //$namelang: the name of the language (de,es..)...
							
				// Language 1
			
			// Remove '\' and save result
			
				//Take the parameters than come from other forms depending on the language(editim_form,etc.) as previously they were enterered by the user
				$prevterm = optional_param('term'.$idlang, null, PARAM_TEXT);
				$prevgramcat = optional_param('gramcat'.$idlang, null, PARAM_TEXT);
				$prevdefinition = optional_param('definition'.$idlang, null, PARAM_TEXT);
				$prevcontext = optional_param('context'.$idlang, null, PARAM_TEXT);
				$prevexpression = optional_param('expression'.$idlang, null, PARAM_TEXT);
				$prevnotes = optional_param('notes'.$idlang, null, PARAM_TEXT);
				$prevweight_type = optional_param('weight_type'.$idlang, null, PARAM_TEXT);
				$prevsourceterm = optional_param('sourceterm'.$idlang, null, PARAM_TEXT);
				$prevsourcedefinition = optional_param('sourcedefinition'.$idlang, null, PARAM_TEXT);
				$prevsourcecontext = optional_param('sourcecontext'.$idlang, null, PARAM_TEXT);
				$prevsourceexpression = optional_param('sourceexpression'.$idlang, null, PARAM_TEXT);
				$prevsourcenotes = optional_param('sourcenotes'.$idlang, null, PARAM_TEXT);
									
				$prevnumfieldsremission[$idlang] = optional_param('numfieldsremission'.$idlang,-1,PARAM_INT);
				$z=0;
				for($i=1;$i<=$prevnumfieldsremission[$idlang];$i++){
					if(optional_param('remission_'.$idlang.'_'.$i)!=null){
						$prevremission[$idlang][$z]=optional_param('remission_'.$idlang.'_'.$i);
						$prevrem_type[$idlang][$z]=optional_param('remtype_'.$idlang.'_'.$i);
						$z++;
					}
				
				}
				
				$prevaudio[$idlang] = optional_param('audio'.$idlang, null, PARAM_INT);
				$prevvideo[$idlang] = optional_param('video'.$idlang, null, PARAM_INT);
				
				
				$queryc = genetic_show_cards2($headerni,$namelang); //take the card corresponding to the language
				$resultc = mysql_query($queryc,$link);
				$cardrow = mysql_fetch_array($resultc); //evp only one result as there is one card per language
				
					$cardrowid = stripslashes($cardrow['id']);
					$cardrowisolang = stripslashes($cardrow['isolang']); //name of the language for this card
					$cardrowterm = stripslashes($cardrow['term']);
					$cardrowgramcat = stripslashes($cardrow['gramcat']);
					$cardrowdefinition = stripslashes($cardrow['definition']);
					$cardrowcontext = stripslashes($cardrow['context']);
					$cardrowexpression = stripslashes($cardrow['expression']);
					$cardrownotes = stripslashes($cardrow['notes']);
					$cardrowweight=stripslashes($cardrow['weighting_mark']);
								
		
			// Term (VE)
			echo "<TR><INPUT TYPE=\"hidden\" NAME=\"isolang$idlang\" VALUE=\"".$namelang."\">";
			//echo "<IMG SRC=\"images/".$cardrowisolang.".png\">";
			echo "<INPUT TYPE=\"hidden\" NAME=\"cardid$idlang\" VALUE=\"".$cardrowid."\">";
			echo "<TD ALIGN=\"right\"><IMG SRC=\"images/".$namelang.".png\">&nbsp;&nbsp;&nbsp;<B>".$strterm."</B>&nbsp;*</TD>"; 
			if($prevterm!=null){
				echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"term$idlang\" SIZE=\"50\" VALUE=\"".$prevterm."\"></TD></TR>";
			}else{
				echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"term$idlang\" SIZE=\"50\" VALUE=\"".$cardrowterm."\"></TD></TR>";
			}
		
			// Gramatic category (gramcat)
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strgramcat."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"gramcat$idlang\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$gramcat = genetic_array_gramcat($namelang);
				if($prevgramcat!=null) {
					for ($i=0; $i<count($gramcat); $i++) {
						if($gramcat[$i]==$prevgramcat){
							echo "<OPTION VALUE=\"".$gramcat[$i]."\" selected>".$gramcat[$i];}
							else{
								echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
							}
						}
				}else{
					for ($i=0; $i<count($gramcat); $i++) {
						if ($gramcat[$i] == $cardrowgramcat) {
							echo "<OPTION SELECTED VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
						}
						else {
							echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
						}
					}
				}
			echo "</SELECT></TD></TR>";	
			
			// Definition (DF)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strdefinition."</B>&nbsp;*</TD>";
			if($prevdefinition!=null){
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"definition$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$prevdefinition."</TEXTAREA></TD></TR>";
			}else{
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"definition$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowdefinition."</TEXTAREA></TD></TR>";
			}
			
			// Context (CT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strcontext."</B>&nbsp;*</TD>";
			if($prevcontext!=null){
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"context$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$prevcontext."</TEXTAREA></TD></TR>";
			}else{
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"context$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowcontext."</TEXTAREA></TD></TR>";
			}
			
			// Expression (PH)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strexpression."</B>&nbsp;</TD>";
			if($prevexpression!=null){
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"expression$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$prevexpression."</TEXTAREA></TD></TR>";
			}else{
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"expression$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowexpression."</TEXTAREA></TD></TR>";
			}
			
			
			// Notes (NT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strnotes."</B>&nbsp;</TD>";
			if($prevnotes!=null){
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"notes$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$prevnotes."</TEXTAREA></TD></TR>";
			}else{
				echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"notes$idlang\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrownotes."</TEXTAREA></TD></TR>";
			}
			// weighting mark
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strwm."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"weight_type$idlang\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$weighting_mark = genetic_array_weighting_mark();
				if($prevweight_type!=null){
					for ($i=0; $i<count($weighting_mark); $i++) {
						if ($weighting_mark[$i] == $prevweight_type) {
							echo "<OPTION SELECTED VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
						}
						else {
							echo "<OPTION VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
						}
					}
				}else{
					for ($i=0; $i<count($weighting_mark); $i++) {
						if ($weighting_mark[$i] == $cardrowweight) {
							echo "<OPTION SELECTED VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
						}
						else {
							echo "<OPTION VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
						}
					}
				}
			echo "</SELECT></TD></TR>";	
			
			
			
			// Get the sources from language 1
			$querys = genetic_show_sources($cardrowid);
			$results = mysql_query($querys, $link);
			$nsources = mysql_num_rows($results);
			if($nsources != 0) {
				// Get the source fields
				$sourcerow = mysql_fetch_array($results);
				// Remove '\' from the entries and allow them in variables
				$sourcerowterm = stripslashes($sourcerow['srcterm']);
				$sourcerowdefinition = stripslashes($sourcerow['srcdefinition']);
				$sourcerowcontext = stripslashes($sourcerow['srccontext']);
				$sourcerowexpression = stripslashes($sourcerow['srcexpression']);
				$sourcerownotes = stripslashes($sourcerow['srcnotes']);
			}
			else {
				$sourcerowterm = ''; $sourcerowdefinition = ''; $sourcerowcontext = ''; $sourcerowexpression = ''; $sourcerownotes = '';
			}
			
			// Sources Language 1
			echo "<TR><TD ROWSPAN=\"6\" VALIGN=\"top\" ALIGN=\"right\"><B>".$strsources."</B>&nbsp;</TD>";
			echo "<TD>".$strterm."&nbsp;</TD><TD>";
			if($prevsourceterm!=null){
				echo"<INPUT TYPE=\"text\" NAME=\"sourceterm$idlang\" SIZE=\"63\" VALUE=\"".$prevsourceterm."\"></TD></TR>";
			}else{
				echo"<INPUT TYPE=\"text\" NAME=\"sourceterm$idlang\" SIZE=\"63\" VALUE=\"".$sourcerowterm."\"></TD></TR>";
			}
			echo "<TR><TD>".$strdefinition."&nbsp;</TD><TD>";
			if($prevsourcedefinition!=null){
				echo"<INPUT TYPE=\"text\" NAME=\"sourcedefinition$idlang\" SIZE=\"63\" VALUE=\"".$prevsourcedefinition."\"></TD></TR>";
			}else{
				echo"<INPUT TYPE=\"text\" NAME=\"sourcedefinition$idlang\" SIZE=\"63\" VALUE=\"".$sourcerowdefinition."\"></TD></TR>";
			}
			echo "<TR><TD>".$strcontext."&nbsp;</TD><TD>";
			if($prevsourcecontext!=null){
				echo"<INPUT TYPE=\"text\" NAME=\"sourcecontext$idlang\"  SIZE=\"63\" VALUE=\"".$prevsourcecontext."\"></TD></TR>";
			}else{
				echo"<INPUT TYPE=\"text\" NAME=\"sourcecontext$idlang\"  SIZE=\"63\" VALUE=\"".$sourcerowcontext."\"></TD></TR>";
			}
			echo "<TR><TD>".$strexpression."&nbsp;</TD><TD>";
			if($prevsourceexpression!=null){
				echo"<INPUT TYPE=\"text\" NAME=\"sourceexpression$idlang\" SIZE=\"63\" VALUE=\"".$prevsourceexpression."\"></TD></TR>";
			}else{
				echo"<INPUT TYPE=\"text\" NAME=\"sourceexpression$idlang\" SIZE=\"63\" VALUE=\"".$sourcerowexpression."\"></TD></TR>";
			}
			echo "<TR><TD>".$strnotes."&nbsp;</TD><TD>";
			if($prevsourcenotes!=null){
				echo"<INPUT TYPE=\"text\" NAME=\"sourcenotes$idlang\" SIZE=\"63\" VALUE=\"".$prevsourcenotes."\"></TD></TR>";
			}else{
				echo"<INPUT TYPE=\"text\" NAME=\"sourcenotes$idlang\" SIZE=\"63\" VALUE=\"".$sourcerownotes."\"></TD></TR>";
			}	
			//Referrals (RV)
			echo "<TR><TD ALIGN=\"right\"><NOBR><B>".$strrv."</B></NOBR>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\">";
			
			if($prevnumfieldsremission[$idlang]!=-1){
					echo "<fieldset><legend>$strrv</legend>";
					echo "<div id=\"remissions$idlang\">";
					$z=1;
					for($i=0;$i<$prevnumfieldsremission[$idlang];$i++){
						echo "<SELECT ID=\"remtype_".$idlang."_".$z."\" NAME=\"remtype_".$idlang."_$z\" id=\"selector\">";
						$type_rem = genetic_array_type_rem();
						for ($k=0; $k<count($type_rem); $k++) {
							if($type_rem[$k]==$prevrem_type[$idlang][$i]){
								echo "<OPTION VALUE=\"".$type_rem[$k]."\" selected>".$str = get_string($type_rem[$k], "genetic");}
							else{
								echo "<OPTION VALUE=\"".$type_rem[$k]."\">".$str = get_string($type_rem[$k], "genetic");
							}
						}
						echo "</SELECT>";
						echo"<INPUT TYPE=\"text\" NAME=\"remission_".$idlang."_".$z."\" ID=\"remission_".$idlang."_$z\" value=\"".$prevremission[$idlang][$i]."\" SIZE=\"40\">";
						echo"<a id=\"a_".$idlang."_$z\" onClick=\"deleteRemission($idlang,$z);\"><IMG SRC=\"images/delete.svg\" ALT=\"".get_string('deleteremission','genetic')."\"/></a>";
						echo"<br id=\"br_".$idlang."_$z\">";
						$z++;
					} // end while
				echo "</div>";
				echo "</fieldset>";
				echo "<a onClick=\"addCampo($idlang);\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";
				echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission$idlang\" ID=\"numfieldsremission$idlang\" VALUE=\"$prevnumfieldsremission[$idlang]\">";
			
			}else{
				// if there are no remissions that come from a previous form, take the data from the database
				$queryrem = genetic_show_remissions($cardrowid); //select the remissions for a card
				$results = mysql_query($queryrem, $link);
				$nrem= mysql_num_rows($results);
							
				echo "<fieldset><legend>$strrv</legend>";
				echo "<div id=\"remissions$idlang\">";
				$z=1;
				while($remrow = mysql_fetch_array($results)){
					$cardrowremty = stripslashes($remrow['rem_type']);
					$cardrowrem = stripslashes($remrow['remission']);
					echo "<SELECT ID=\"remtype_".$idlang."_".$z."\" NAME=\"remtype_".$idlang."_$z\" id=\"selector\">";
					$type_rem = genetic_array_type_rem();
						for ($k=0; $k<count($type_rem); $k++) {
							if($type_rem[$k]==$cardrowremty){
								echo "<OPTION VALUE=\"".$type_rem[$k]."\" selected>".$str = get_string($type_rem[$k], "genetic");}
							else{
								echo "<OPTION VALUE=\"".$type_rem[$k]."\">".$str = get_string($type_rem[$k], "genetic");
							}
						}
					
					echo "</SELECT>";
	
					echo"<INPUT TYPE=\"text\" NAME=\"remission_".$idlang."_".$z."\" ID=\"remission_".$idlang."_$z\" value=\"".$cardrowrem."\" SIZE=\"40\">";
					echo"<a id=\"a_".$idlang."_$z\" onClick=\"deleteRemission($idlang,$z);\"><IMG SRC=\"images/delete.svg\" ALT=\"".get_string('deleteremission','genetic')."\"/></a>";
					echo"<br id=\"br_".$idlang."_$z\">";
					$z++;
				} // end while
				echo "</div>";
				echo "</fieldset>";
				echo "<a onClick=\"addCampo($idlang);\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";
				echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission$idlang\" ID=\"numfieldsremission$idlang\" VALUE=\"$nrem\">";
			}
			
			
			echo "<TR><TD COLSPAN=\"20\"><BR /></TD></TR>";
			
			
				  // A�adir los archivos de audio 
			
			echo "<TD ALIGN=\"right\"><B>".$straudio."</B>&nbsp;</TD>";
			
			echo "<TD><SELECT MULTIPLE NAME=\"audio".$idlang."[]\" >";
				$query = genetic_show_audio_files($namelang);
				$result = mysql_query($query,$link);
				$noaudio= true;
				if($prevaudio[$idlang]!=null){
					while ($row = mysql_fetch_array($result)) {  //row for all audios of the language
						$selected=false;
						for($i=0;$i<count($prevaudio[$idlang]);$i++){
							if($row['id']==$prevaudio[$idlang][$i]){
								$selected=true;
								$noaudio=false;
							} 
						}
						if($selected){echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['fileaudio'];
						}else{	echo "<OPTION  VALUE=\"".$row['id']."\">".$row['fileaudio'];}
					}
					//evp if no file of audio is found, leave the values empty
				}else{
					while ($row = mysql_fetch_array($result)) {  //row for all audios of the language
					$queryaux = genetic_is_audio_incard($cardrowid,$row['id']);
					$resultaux = mysql_query($queryaux,$link);
		
					if($rowaux = mysql_fetch_array($resultaux)) { //rowaux for the audios of that card
						echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['fileaudio'];
						$noaudio=false;
					}else{
						echo "<OPTION  VALUE=\"".$row['id']."\">".$row['fileaudio'];
						}
					}
				}
				//evp if no file of audio is found, leave the values empty
				if($noaudio){
					echo "<OPTION selected VALUE=\"0\">".$str = get_string("nodefined", "genetic");
				}else{
					echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
				}
			echo "</SELECT>&nbsp;&nbsp;";
			//<A href=\"editau_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add audio file\"/></A></TD></TR>";
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add audio\" name=\"addaudio\" value=\"Add Audio\" onclick=\"this.form.action='editau_form.php?id=$id';this.form.submit();\"\></TD></TR>";
			
								
				  	 //Videos

				
				echo "<TD ALIGN=\"right\"><B>".$strvideos."</B>&nbsp;</TD>";
			
		
			echo "<TD><SELECT MULTIPLE NAME=\"video".$idlang."[]\">";			
			$query = genetic_show_vi();
			$result = mysql_query($query,$link);
			$novideo = true;
			if($prevvideo[$idlang]!=null){
				while ($row = mysql_fetch_array($result)) {
					$selected=false;
					for($i=0;$i<count($prevvideo[$idlang]);$i++)
					{	
						if($row['id']==$prevvideo[$idlang][$i]){
						$selected=true;
						$novideo=false;
						}
					}	
					if($selected==true){
						echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['filevideo'];
					}else{
						echo "<OPTION  VALUE=\"".$row['id']."\">".$row['filevideo'];
					}
				}	
 			}else{
				while ($row = mysql_fetch_array($result)) {
					$queryaux = genetic_is_video_incard($cardrowid,$row['id']);
					$resultaux = mysql_query($queryaux,$link);
					if($rowaux = mysql_fetch_array($resultaux)) { //rowaux for the audios of that card
						echo "<OPTION SELECTED VALUE=\"".$row['id']."\">".$row['filevideo'];
						$novideo=false;
					}else{
						echo "<OPTION  VALUE=\"".$row['id']."\">".$row['filevideo'];
					}
				}
				//evp if no file of video is found, leave the values empty
			}
			
			if($novideo){
				echo "<OPTION selected VALUE=\"0\">".$str = get_string("nodefined", "genetic");
			}else{
				echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
			}
				
				
			echo "</SELECT>&nbsp;&nbsp;";
			echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add video\" name=\"addvideo\" value=\"Add Video\" onclick=\"this.form.action='editvi_form.php?id=$id';this.form.submit();\"\>";
			
			//<A href=\"editvi_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add videos\"/></A></TD></TR>";
				  
			echo "<TR><TD COLSPAN=\"4\"><BR /></TD></TR>";
			
			
	
	}//fin del for 
	
				//Edit Images common to the cards
			
				
			
				
		
		echo "</TABLE>";
		print_box_end($return=false);
		echo "</TD></TR>";
		
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";

	echo "</TABLE></FORM>";	
	
	// Close the db    
	mysql_close($link);
	
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);	

?>