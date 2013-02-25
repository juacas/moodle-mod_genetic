<?php  // $Id: addcard_form.php, v2.0 2012/06/21 09:35:00 Ana Mar�a Lozano de la fuente Exp $
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

	
	// File with form for adding a genetic card

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
    require_once("lib.php");
	 require_once("selectsubdomains.php");
	 
?>


<script type="text/javascript">

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
echo "var optsValues='".join(',',$type_rem)."';"
?>

// JS function that dinamically create fields to input remissions in the form 
// idlang is the id of the language and optionsremtype is a string containing the values of the options of the element select separated with commas


addCampo = function (idlang) {

	var numero=++document.getElementById('numfieldsremission'+idlang).value;

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


	//document.addcardform.appendChild(nDiv);

	//Add eliminate button
	a=document.createElement('a');
	a.setAttribute("onclick","javascript:deleteRemission("+idlang+","+numero+");");
	a.id='a_'+idlang+"_"+numero;
	img=document.createElement('img');
	img.src="images/delete.svg";
	img.alt="Delete remission";
	img.id='deleteimage'+idlang+"_"+numero;
	a.appendChild(img);
	nDiv.appendChild(a);
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

/*sethiddenfields = function() {
	//var a=document.getElementById("datecreated").value;
	a = document.forms['addcardform'].elements["datecreated"].value;    
	alert(a);
    document.forms['selectimage'].elements["myauthor"].value = a;
}*/
 

</script>

<?php 

	// Parameters
    $id = optional_param('id',0,PARAM_INT); //id of the course-module  
    $t = optional_param('t',0,PARAM_INT);   // id del instance genetic
	$idbe2 = optional_param('idbe',0,PARAM_INT);
	$z= optional_param('z',0,PARAM_INT);
	 
	
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
    add_to_log($course->id, "genetic", "add card", "addcard_form.php?id=$cm->id", "$genetic->id");
	
	// Get the context of the module instance
	$context = get_context_instance(CONTEXT_MODULE, $cm->id);
	
	// Check if the user has permission in this activity
	if (! has_capability('mod/genetic:manageentries', $context)) {
		error('Sin permisos');
	}

	else {
	
	
	//Get the strings wich are necessaries
	$strnolang  = get_string("nolang", "genetic");
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
	$strrv = get_string("rv", "genetic");
	$strnotes = get_string("notes", "genetic");
	$strsources = get_string("sources", "genetic");
	//---a�adido---
	$strimagenes=get_string("imagenes", "genetic");
	$strvideos=get_string("videos", "genetic");
	$strimage = get_string("selimagen", "genetic");
	//$strpieimagen = get_string("pieimagen", "genetic"); 
	$strvideo = get_string("selvideo", "genetic");
	//$strpievideo = get_string("pievideo", "genetic");
	//$strsrcimage = get_string("src_image", "genetic");
	//$strsrcvideo = get_string("src_video", "genetic");
	//$stracronyms = get_string("acronyms", "genetic");
	//$strabreviaturas = get_string("abreviaturas", "genetic");
	$strsymbols = get_string("symbols", "genetic");
	$strsynonyms = get_string("synonym", "genetic");
	$strrelatedterms = get_string("relatedterms", "genetic");
	$strcrossrelatedterms = get_string("crossrelatedterms", "genetic");
	$straudio = get_string("audio", "genetic");
	$strwm= get_string("wm", "genetic");
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
	print_heading(get_string('addcardf', 'genetic'), 'center',2);
	// Print the main part of the page
	
    // Form to add a genetic card	
	// Connect to the database
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	//Count the languages of the dictionary
	
		$query = genetic_count_lang($genetic->id);
		$resultlang = mysql_query($query,$link);
		$numlang = mysql_affected_rows($link);
		
	//No languages-->they must be included
	
	if($numlang==0){
	echo "<TABLE WIDTH=\"100%\">";
	echo "<TR><TD ALIGN=\"center\">&nbsp;<IMG SRC=\"images/Info.gif\"> ".$strnolang."</TD></TR>";
	echo "</TABLE>";
	
	// Check if the user has permission in this activity to add new languages
		if (has_capability('mod/genetic:manageentries', $context)) {
			// Form to add a Card type
			echo "<TABLE WIDTH=\"100%\">";
			echo "<FORM NAME=\"addlangform\" METHOD=\"post\" ACTION=\"editlang_form.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
			echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
			echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("buttonaddlang", "genetic")."\" NAME=\"buttonadd\" />&nbsp;&nbsp;";
			echo "</TD></TR>";
			echo "</FORM></TABLE>";
		}
	
	}	
	
	//if there are languages, print the cards
	
	
	else{
		
		//Take the parameters than come from other forms (editim_form,etc.) as previously they were enterered by the user
		$prevbes= optional_param('be', null, PARAM_INT);
		$prevauthors= optional_param('author', null, PARAM_INT);
		$prevdomsubdom = optional_param('domsubdom', null, PARAM_INT);
		$ty = optional_param('ty', 0, PARAM_INT);
		$previmagen = optional_param('prevformimagen', null, PARAM_INT);
				
	print_container(get_string("requiredfields", "genetic"), $clearfix=false, $classes='generalbox boxaligncenter boxwidthwide', '', $return=false);	
	
	//Print the heacer to add the card 
	echo "<FORM  NAME=\"addcardform\" METHOD=\"post\" ACTION=\"\" ENCTYPE=\"multipart/form-data\">";
	echo "<TABLE WIDTH=\"100%\">";
	//echo "<FORM  NAME=\"addcardform\" METHOD=\"post\" ACTION=\"addcard.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
	echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("commonheaderdata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		
		echo "<TABLE ALIGN=\"center\">";
		
			// BE - Department
			echo "<TR><TD ALIGN=\"right\" WIDTH=\"20%\"><B>".$strbe."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE id=\"be\" NAME=\"be[]\" onchange=\"document.getElementById('idbe').value = this.value;\">";
				$query = genetic_show_be();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {					
					$idbe = $row['id'];
					$namebe = $row['name'];
					$isselected = 0;
					for($i=0;$i<count($prevbes);$i++){
						if($idbe==$prevbes[$i])$isselected=1;
					}
					if($isselected==1){
						echo "<OPTION VALUE=\"".$idbe."\" selected>".$namebe."</OPTION>";
					}else{		
						echo "<OPTION VALUE=\"".$idbe."\">".$namebe."</OPTION>";
					}
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editbe_form.php?id=$id&idbe=document.getElementById('divfech').innerHTML\"><IMG SRC=\"images/Add.gif\" ALT=\"add department\"/></A></TD></TR>";
				  
			echo"<div id=\"divfech\"></div>";	 
			//echo"<div id=\"un_div\"><input type=\"hidden\" id=\"i\" value=\"4\" /></div>";
			

			
			// TY - Type of card
			echo "<TR><TD ALIGN=\"right\"><B>".$strty."</B>&nbsp;*</TD>";
			echo "<TD><SELECT NAME=\"ty\">";
				echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");				
				$query = genetic_show_ty();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {
					$idty = $row['id'];
					$namety = $row['name'];
					if($idty==$ty){
						echo "<OPTION VALUE=\"".$idty."\" selected>".$namety;}
					else{
						echo "<OPTION VALUE=\"".$idty."\">".$namety;
					}
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editty_form.php?id=$id\" ><IMG SRC=\"images/Add.gif\" ALT=\"add card type\"/></A></TD></TR>";
			
			//  Subdomain
			echo "<TR><TD ALIGN=\"right\"><B>".$strsubdom."</B>&nbsp;*</TD>";
			//echo "<TABLE align=\"center\">";
			echo "<TD>";
			genetic_select_subdomains3($nivel=0,$prevdomsubdom);
			echo"</TD>";
			echo "<TD>&nbsp;&nbsp;<A href=\"editdom_form.php?id=$id&cat=subdomain\"><IMG SRC=\"images/Add.gif\" ALT=\"add subdomain\"/></A></TD></TR>";
			//echo"</TABLE>";
			
			
			// Author
			echo "<TR><TD ALIGN=\"right\"><B>".$strauthor."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE NAME=\"author[]\">";
				$query = genetic_show_authors();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {
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
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editauthor_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add author\"/></A></TD></TR>";
				  
			// Date created
			$datecreated = 0 + time();
			echo "<TR><TD><INPUT TYPE=\"hidden\" NAME=\"datecreated\" VALUE=\"".$datecreated."\"></TD></TR>";
			

		echo "</TABLE>";		
		print_box_end($return=false);

//------------------------------
print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
	
		echo "<TABLE ALIGN=\"center\">";

//----a�adido---subir las imagenes
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strimagenes."</B>&nbsp;</TD>";
			//echo "<TR><TD COLSPAN=\"4\"><BR></TD></TR>";
			
			
			
			echo "<TD><SELECT MULTIPLE NAME=\"imagen[]\" >";
				$query = genetic_show_im();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {					
					$idimg = $row['id'];
					$nameimg = $row['fileimage'];
					$titleimg= $row['titleimage_de']; //evp s�lo alem�n??
					//$srcimg= $row['srcimage']; 
					$isselected=0;
					for($i=0;$i<count($previmagen);$i++){
						if($idimg==$previmagen[$i])$isselected=1;
					}
					if($isselected==1){
						echo "<OPTION VALUE=\"".$idimg."\" selected>".$nameimg."</OPTION>";
					}else{
						echo "<OPTION VALUE=\"".$idimg."\">".$nameimg."</OPTION>";
					}
				}
		echo "</SELECT>";
		echo "		  &nbsp;&nbsp;";
		echo"<input type=\"image\" src=\"images/Add.gif\" ALT=\"add image\" name=\"addimagen\" value=\"A�adir imagen\" onclick=\"this.form.action='editim_form.php?id=$id';this.form.submit();\"\>";
		echo "</TD>";
	//	<A href=\"editim_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add image\"/></A>
		
			echo "</TABLE>";		
	

		print_box_end($return=false);

//-------------------------		
		echo "<BR /></TD></TR>";

		echo "<TR><TD ALIGN=\"center\">";
		echo "<BR />".$str = get_string("languagecarddata", "genetic");
		echo "</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		
		//Print the body of the card 
		
		
		
		echo "<TABLE ALIGN=\"center\">";
		
		
		

		//Repite the card the number of languages of the dictionary
		$j=-1;
		while($langrow = mysql_fetch_array($resultlang)){
			$j++;
			
			//Search which languages contains the dictionary
			
			$idlang = $langrow['genetic_lang_id'];
			$query2 =genetic_search_lang_name($idlang);
			$result2 = mysql_query($query2,$link);
			$n2 = mysql_num_rows($result2);
			$row2 = mysql_fetch_array($result2);
			$namelang=$row2['language'];	
			
			//Take the parameters than come from other forms depending on the language(editim_form,etc.) as previously they were enterered by the user
			$term = optional_param('term'.$idlang, null, PARAM_TEXT);
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
			$prevsourcerv = optional_param('sourcerv'.$idlang, null, PARAM_TEXT);
			$prevsourcenotes = optional_param('sourcenotes'.$idlang, null, PARAM_TEXT);
			$prevrem_type = optional_param('rem_type'.$idlang, null, PARAM_TEXT);
			
			$prevnumfieldsremission[$idlang] = optional_param('numfieldsremission'.$idlang,0,PARAM_INT);
			$z=0;
    		for($i=1;$i<=$prevnumfieldsremission[$idlang];$i++){
    			if(optional_param('remission_'.$idlang.'_'.$i)!=null){
    				$prevremission[$idlang][$z]=optional_param('remission_'.$idlang.'_'.$i);
    				$prevrem_type[$idlang][$z]=optional_param('remtype_'.$idlang.'_'.$i);
    				$z++;
    			}
    		
    	}
			 
			
			
			$prevremission = optional_param('remission'.$idlang, null, PARAM_TEXT);
			
			
			$prevaudio = optional_param('audio'.$idlang, null, PARAM_INT);
			$prevvideo = optional_param('video'.$idlang, null, PARAM_INT);
				
		
		
					// Language 1
		
			// Term (VE)
			echo "<TR><TD ROWSPAN=\"13\" VALIGN=\"top\"><INPUT TYPE=\"hidden\" NAME=\"isolang$idlang\" VALUE=\"".$namelang."\"></TD>";
			echo "<TD ALIGN=\"right\"><IMG SRC=\"images/".$namelang.".png\">&nbsp;".$namelang."&nbsp;";
			echo "<B>".$strterm."</B>&nbsp;*</TD>";
			//evp a lo mejor conviene hacer una comprobaci�n if $term!=null
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"term$idlang\" value=\"".$term."\" SIZE=\"50\"></TD></TR>";
			
			// Gramatic category
			echo "<TR><TD ALIGN=\"right\"><B>".$strgramcat."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"gramcat$idlang\">";
			echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
			$gramcat = genetic_array_gramcat($namelang);
				for ($i=0; $i<count($gramcat); $i++) {
					if($gramcat[$i]==$prevgramcat){
						echo "<OPTION VALUE=\"".$gramcat[$i]."\" selected>".$gramcat[$i];}
					else{
						echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
					}
				}
			echo "</SELECT></TD></TR>";			
			
			// Definition (DF)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strdefinition."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"TEXTAREA\" NAME=\"definition$idlang\" value=\"".$prevdefinition."\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
						
			// Context (CT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strcontext."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"TEXTAREA\" NAME=\"context$idlang\" value=\"".$prevcontext."\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";

			// Expression (PH)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strexpression."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"TEXTAREA\" NAME=\"expression$idlang\" value=\"".$prevexpression."\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
			
			
			// Notes (NT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strnotes."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"TEXTAREA\" NAME=\"notes$idlang\" value=\"".$prevnotes."\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
			
			
			//weighting mark
			echo "<TR><TD ALIGN=\"right\"><B>".$strwm."</B></NOBR>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"weight_type$idlang\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$weighting_mark = genetic_array_weighting_mark();
				for ($i=0; $i<count($weighting_mark); $i++) {
					if($weighting_mark[$i]==$prevweight_type){
						echo "<OPTION VALUE=\"".$weighting_mark[$i]."\" selected>".$str = get_string($weighting_mark[$i], "genetic");
					}
					else{
						echo "<OPTION VALUE=\"".$weighting_mark[$i]."\">".$str = get_string($weighting_mark[$i], "genetic");}
				}
			echo "</SELECT></TR>";
			
			
			// Sources language 
			echo "<TR><TD ROWSPAN=\"6\" VALIGN=\"top\" ALIGN=\"right\"><B>".$strsources."</B>&nbsp;</TD>";
			echo "<TD>".$strterm."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourceterm$idlang\" value=\"".$prevsourceterm."\" SIZE=\"63\"></TD></TR>";
			echo "<TR><TD>".$strdefinition."&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcedefinition$idlang\" value=\"".$prevsourcedefinition."\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strcontext."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcecontext$idlang\" value=\"".$prevsourcecontext."\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strexpression."&nbsp;<INPUT TYPE=\"text\" NAME=\"sourceexpression$idlang\" value=\"".$prevsourceexpression."\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strrv."&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcerv$idlang\" value=\"".$prevsourcerv."\" SIZE=\"63\"></TD></TR>";
			
			echo "<TR><TD>".$strnotes."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcenotes$idlang\" value=\"".$prevsourcenotes."\" SIZE=\"63\"></TD></TR>";
			
			echo "<TR><TD COLSPAN=\"4\"><BR /></TD></TR>";
			
			// Referrals (RV)
			echo "<TR><TD></TD><TD ALIGN=\"right\"><NOBR><B>".$strrv."</B></NOBR>&nbsp;</TD>";
			
			//echo "<TR><TD></TD><TD VALIGN=\"top\" ALIGN=\"right\">".$strabreviaturas."&nbsp;</TD><TD  COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"abreviaturas[]\" SIZE=\"50\"></TD></TR>";
			//echo "<TD></TD><TD VALIGN=\"top\" ALIGN=\"right\">".$stracronyms."&nbsp;</TD>&nbsp;<TD  COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"acronyms[]\" SIZE=\"50\"></TD></TR>";
			echo "<TD COLSPAN=\"2\">";
			
			
			
			
			echo "<fieldset><legend>$strrv</legend>";
			echo "<div id=\"remissions$idlang\">";
			echo "<SELECT ID=\"remtype_".$idlang."_1\" NAME=\"remtype_".$idlang."_1\" id=\"selector\">";

			echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$type_rem = genetic_array_type_rem();
				for ($k=0; $k<count($type_rem); $k++) {
					if($type_rem[$k]==$prevrem_type[$idlang]){
						echo "<OPTION VALUE=\"".$type_rem[$k]."\" selected>".$str = get_string($type_rem[$k], "genetic");}
					else{
						echo "<OPTION VALUE=\"".$type_rem[$k]."\">".$str = get_string($type_rem[$k], "genetic");
					}
				}
				
			echo "</SELECT>";

			//$strtyperem=implode(',',$type_rem);
			echo"<INPUT TYPE=\"text\" NAME=\"remission_".$idlang."_1\" ID=\"remission_".$idlang."_1\" value=\"".$prevremission[$idlang]."\" SIZE=\"40\">";
			echo"<a id=\"a_".$idlang."_1\" onClick=\"deleteRemission($idlang,1);\"><IMG SRC=\"images/delete.svg\" ALT=\"Delete remission\"/></a>";
			echo "</div>";
			echo "</fieldset>";
			echo "<a onClick=\"addCampo($idlang);\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";
			//echo "<a  onClick=\"addCampo($idlang,'$strtyperem');\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";
				
	//		echo"<INPUT TYPE=\"text\" NAME=\"remission$idlang\" value=\"".$prevremission."\" SIZE=\"40\"> <a href=\"#\" onClick=\"addCampo($idlang)\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></div></TD></TR>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission$idlang\" ID=\"numfieldsremission$idlang\" VALUE=\"1\">";
			
			
			
			echo "<TR><TD COLSPAN=\"20\"><BR /></TD></TR>";
			
			
		
			// A�adir los archivos de audio 
			
			echo "<TD ALIGN=\"right\"><B>".$straudio."</B>&nbsp;</TD>";
			
			echo "<TD><SELECT MULTIPLE NAME=\"audio".$idlang."[]\" >";
				$query = genetic_show_audio_files($namelang);
				$result = mysql_query($query,$link);
				$nonselected=1;
				while ($row = mysql_fetch_array($result)) {					
					$idaudio = $row['id'];
					$nameaudio = $row['fileaudio'];
					$isselected = 0;
					for($k=0;$k<count($prevaudio);$k++){
						if($idaudio==$prevaudio[$k])$isselected=1;
					}
					if($isselected==1){
						echo "<OPTION VALUE=\"".$idaudio."\" selected>".$nameaudio."</OPTION>";
						$nonselected=0;
					}else{
						echo "<OPTION VALUE=\"".$idaudio."\">".$nameaudio."</OPTION>";
					}
				}
				if($nonselected==0){
					echo "<OPTION VALUE=\"default\">".$str = get_string("nodefined", "genetic");
				}else{
					echo "<OPTION SELECTED VALUE=\"default\">".$str = get_string("nodefined", "genetic");
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editau_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add audio file\"/></A></TD></TR>";
		
		
			//----a�adido---subir los videos en el lenguaje 1
			
			echo "<TD ALIGN=\"right\"><B>".$strvideos."</B>&nbsp;</TD>";
			
			
			echo "<TD><SELECT MULTIPLE NAME=\"video".$idlang."[]\" >";
				$query = genetic_show_vi();
				$result = mysql_query($query,$link);
				$nonselected=1;
				while ($row = mysql_fetch_array($result)) {					
					$idvid = $row['id'];
					$namevid = $row['filevideo'];
					$isselected=0;
					for($k=0;$k<count($prevvideo);$k++){
						if($idvid==$prevvideo[$k])$isselected=1;
					}
					if($isselected==1){
						echo "<OPTION selected VALUE=\"".$idvid."\">".$namevid."</OPTION>";
						$nonselected=0;
					}else{
						echo "<OPTION VALUE=\"".$idvid."\">".$namevid."</OPTION>";
					} 
				}
				if($nonselected==0){
					echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");
				}else{
					echo "<OPTION SELECTED VALUE=\"0\">".$str = get_string("nodefined", "genetic");
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editvi_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add video\"/></A></TD></TR>";
			
			echo "<TR><TD COLSPAN=\"4\"><BR /></TD></TR>";
			
			//echo "<TR><TD COLSPAN=\"20\"><BR /></TD></TR>";
			
		}//otro nuevo	while
			
		echo "</TABLE>";
		print_box_end($return=false);
		echo "</TD></TR>";
		
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		//echo "<INPUT NAME= \"send\" id=\"send\" TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT NAME= \"buttonsave\" id=\"send\" TYPE=\"button\" VALUE=\"".$str = get_string("save", "genetic")."\"  onclick=\"this.form.action='addcard.php?id=$id';this.form.submit()\";	>&nbsp;&nbsp;";
		

		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";

		echo "</TABLE></FORM>";	
	
	
	// Close the db    
	mysql_close($link);
	
	}//fin del else de que s� hay idiomas
	
	
	
	} // Close caps ELSE
	
	// Finish the page
//	include('banner_foot.html');   //  evp estoy hay que incluirlo, ya veresmo como
    print_footer($course);	
		
	
?>

			