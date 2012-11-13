<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos file
addCampo = function () {
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'text' + (++numero);
//creamos el input para el formulario:
   nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo.name = 'remission2[]';
//Establecemos el tipo de campo
   nCampo.type = 'text';
 //NUEVOOOOOOOOOOOOOOOOOO
	ele = document.createElement('select');
	ele.name = 'rem_type2'+numero; 
	
   b = document.createElement('option');
   c = document.createElement('option');
   d = document.createElement('option');
   
    b.value="sin definir";
    c.value="sinonimo";
	d.value="variante formal";
	 b.innerHTML ="sin definir";
	ele.appendChild(b);
	 c.innerHTML ="sinonimo";
	ele.appendChild(c);
	 d.innerHTML ="variante formal";
	ele.appendChild(d);
	
	nDiv.appendChild(ele); 
//Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
//El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
//Este link no debe ir a ningun lado
   a.href = '#';
//Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
//Con esto ponemos el texto del link
   a.innerHTML = 'Eliminar';
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo);
//Adicionamos el Link
   nDiv.appendChild(a);
 
   
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);

   
}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);

   
 }
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) {
   return evt.srcElement ?  evt.srcElement : evt.target;
}

 

</script>

<?php  // $Id: addcard_form.php, v2.0 2012/06/21 09:35:00 Ana María Lozano de la fuente Exp $
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

	
	// File with form for adding a genetic card

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
    require_once("lib.php");
	 require_once("selectsubdomains.php");

	// Necessary parameters
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
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
	//---añadido---
	$strimagenes=get_string("imagenes", "genetic");
	$strvideos=get_string("videos", "genetic");
	$strimage = get_string("selimagen", "genetic");
	$strpieimagen = get_string("pieimagen", "genetic");
	$strvideo = get_string("selvideo", "genetic");
	$strpievideo = get_string("pievideo", "genetic");
	$strsrcimage = get_string("src_image", "genetic");
	$strsrcvideo = get_string("src_video", "genetic");
	$stracronyms = get_string("acronyms", "genetic");
	$strabreviaturas = get_string("abreviaturas", "genetic");
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
	print_container(get_string("requiredfields", "genetic"), $clearfix=false, $classes='generalbox boxaligncenter boxwidthwide', '', $return=false);	
	
	//Print the heacer to add the card 
	
	echo "<TABLE WIDTH=\"100%\">";
	echo "<FORM  NAME=\"addcardform\" METHOD=\"post\" ACTION=\"addcard.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("commonheaderdata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		
		echo "<TABLE ALIGN=\"center\">";
		
			// BE - Department
			echo "<TR><TD ALIGN=\"right\" WIDTH=\"20%\"><B>".$strbe."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE id=\"be\" NAME=\"be[]\" onchange=\"document.getElementById('divfech').innerHTML=this.value;document.getElementById('idbe').value = this.value;\">";
				$query = genetic_show_be();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {					
					$idbe = $row['id'];
					$namebe = $row['name'];
					echo "<OPTION VALUE=\"".$idbe."\">".$namebe."</OPTION>";
					
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editbe_form.php?id=$id&idbe=document.getElementById('divfech').innerHTML\"><IMG SRC=\"images/Add.gif\" ALT=\"add department\"/></A></TD></TR>";
				  
			echo"aqui::<div id=\"divfech\"></div>";	 
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
					echo "<OPTION VALUE=\"".$idty."\">".$namety;
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editty_form.php?id=$id\" ><IMG SRC=\"images/Add.gif\" ALT=\"add card type\"/></A></TD></TR>";
			
			//  Subdomain
			echo "<TR><TD ALIGN=\"right\"><B>".$strsubdom."</B>&nbsp;*</TD>";
			//echo "<TABLE align=\"center\">";
			echo "<TD>";
			genetic_select_subdomains3($nivel=0);
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
					echo "<OPTION VALUE=\"".$idauthor."\">".$nameauthor."  ".$surnameauthor."</OPTION>";
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

//----añadido---subir las imagenes en el lenguaje 1
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strimagenes."</B>&nbsp;</TD>";
			//echo "<TR><TD COLSPAN=\"4\"><BR></TD></TR>";
			
			
			
			echo "<TD><SELECT MULTIPLE NAME=\"imagen[]\" >";
				$query = genetic_show_im();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {					
					$idimg = $row['id'];
					$nameimg = $row['fileimage'];
					$titleimg= $row['titleimage_de'];
					$srcimg= $row['srcimagen'];
					
					echo "<OPTION VALUE=\"".$idimg."\">".$nameimg."</OPTION>";
					
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editim_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add image\"/></A></TD>";
			
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

		while($langrow = mysql_fetch_array($resultlang)){
			
			
			//Search which languages contains the dictionary
			
			$idlang = $langrow['genetic_lang_id'];
			$query2 =genetic_search_lang_name($idlang);
			$result2 = mysql_query($query2,$link);
			$n2 = mysql_num_rows($result2);
			$row2 = mysql_fetch_array($result2);
			
			$namelang=$row2['language'];	
		
		
					// Language 1
		
			// Term (VE)
			echo "<TR><TD ROWSPAN=\"13\" VALIGN=\"top\"><INPUT TYPE=\"hidden\" NAME=\"isolang[]\" VALUE=\"".$namelang."\"></TD>";
			echo "<TD ALIGN=\"right\"><IMG SRC=\"images/".$namelang.".png\">&nbsp;".$namelang."&nbsp;";
			echo "<B>".$strterm."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"term[]\" SIZE=\"50\"></TD></TR>";
			
			// Gramatic category
			echo "<TR><TD ALIGN=\"right\"><B>".$strgramcat."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"gramcat[]\">";
				echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
				$gramcat = genetic_array_gramcat();
				for ($i=0; $i<count($gramcat); $i++) {
					echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
				}
			echo "</SELECT></TD></TR>";			
			
			// Definition (DF)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strdefinition."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"definition[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
			
			// Context (CT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strcontext."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"context[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";

			// Expression (PH)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strexpression."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"expression[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
			
			
			// Notes (NT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strnotes."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"notes[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\"></TEXTAREA></TD></TR>";
			
			
			//weighting mark
			echo "<TR><TD ALIGN=\"right\"><B>".$strwm."</B></NOBR>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"weight_type[]\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$weighting_mark = genetic_array_weighting_mark();
				for ($i=0; $i<count($weighting_mark); $i++) {
					echo "<OPTION VALUE=\"".$weighting_mark[$i]."\">".$str = get_string($weighting_mark[$i], "genetic");
				}
			echo "</SELECT></TR>";
			
			
			// Sources language 1
			echo "<TR><TD ROWSPAN=\"6\" VALIGN=\"top\" ALIGN=\"right\"><B>".$strsources."</B>&nbsp;</TD>";
			echo "<TD>".$strterm."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourceterm[]\" SIZE=\"63\"></TD></TR>";
			echo "<TR><TD>".$strdefinition."&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcedefinition[]\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strcontext."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcecontext[]\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strexpression."&nbsp;<INPUT TYPE=\"text\" NAME=\"sourceexpression[]\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strrv."&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcerv[]\" SIZE=\"63\"></TD></TR>";
			
			echo "<TR><TD>".$strnotes."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE=\"text\" NAME=\"sourcenotes[]\" SIZE=\"63\"></TD></TR>";
			
			echo "<TR><TD COLSPAN=\"4\"><BR /></TD></TR>";
			
			// Referrals (RV)
			echo "<TR><TD></TD><TD ALIGN=\"right\"><NOBR><B>".$strrv."</B></NOBR>&nbsp;</TD>";
			
			//echo "<TR><TD></TD><TD VALIGN=\"top\" ALIGN=\"right\">".$strabreviaturas."&nbsp;</TD><TD  COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"abreviaturas[]\" SIZE=\"50\"></TD></TR>";
			//echo "<TD></TD><TD VALIGN=\"top\" ALIGN=\"right\">".$stracronyms."&nbsp;</TD>&nbsp;<TD  COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"acronyms[]\" SIZE=\"50\"></TD></TR>";
			echo "<div id=\"adjuntos2\">";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"rem_type[]\" id= \"selector\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$type_rem = genetic_array_type_rem();
				for ($k=0; $k<count($type_rem); $k++) {
					echo "<OPTION VALUE=\"".$type_rem[$k]."\">".$str = get_string($type_rem[$k], "genetic");
				}
				
			echo "</SELECT>";
			echo "</div>";
			echo "<div id=\"adjuntos\" >";
			echo"<INPUT TYPE=\"text\" NAME=\"remission[]\" SIZE=\"40\"><a href=\"#\" onClick=\"addCampo()\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";	
			echo "</div>";
			echo "<div id=\"enlacesnuevos\" name=\"enlacesnuevos[]\">";
			echo "</div>";
			
			
			
			echo "<TR><TD COLSPAN=\"20\"><BR /></TD></TR>";
			
			
		
			// Añadir los archivos de audio 
			
			echo "<TD ALIGN=\"right\"><B>".$straudio."</B>&nbsp;</TD>";
			
			echo "<TD><SELECT MULTIPLE NAME=\"audio[][]\" >";
				$query = genetic_show_audio_files($namelang);
				$result = mysql_query($query,$link);
				echo "<OPTION SELECTED VALUE=\"default\">".$str = get_string("nodefined", "genetic");
				while ($row = mysql_fetch_array($result)) {					
					$idaudio = $row['id'];
					$nameaudio = $row['fileaudio'];
					echo "<OPTION VALUE=\"".$idaudio."\">".$nameaudio."</OPTION>";
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editau_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add audio file\"/></A></TD></TR>";
		
		
			//----añadido---subir los videos en el lenguaje 1
			
			echo "<TD ALIGN=\"right\"><B>".$strvideos."</B>&nbsp;</TD>";
			
			
			echo "<TD><SELECT MULTIPLE NAME=\"video[][]\" >";
				$query = genetic_show_vi();
				$result = mysql_query($query,$link);
				echo "<OPTION SELECTED VALUE=\"default\">".$str = get_string("nodefined", "genetic");
				while ($row = mysql_fetch_array($result)) {					
					$idvid = $row['id'];
					$namevid = $row['filevideo'];
					$titlevid= $row['titlevideo_de'];
					$srcvid= $row['srcvideo'];
					
					echo "<OPTION VALUE=\"".$idvid."\">".$namevid."</OPTION>";
					
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editvi_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add video\"/></A></TD></TR>";
			
			echo "<TR><TD COLSPAN=\"4\"><BR /></TD></TR>";
			
			//echo "<TR><TD COLSPAN=\"20\"><BR /></TD></TR>";
			
		}//otro nuevo	while
/*			
		//----añadido---subir las imagenes en el lenguaje 1
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strimagenes."</B>&nbsp;</TD>";
			//echo "<TR><TD COLSPAN=\"4\"><BR></TD></TR>";
			
			
			
			echo "<TD><SELECT MULTIPLE NAME=\"imagen[]\" >";
				$query = genetic_show_im();
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {					
					$idimg = $row['id'];
					$nameimg = $row['fileimage'];
					$titleimg= $row['titleimage_de'];
					$srcimg= $row['srcimagen'];
					if($titleimg!='')
					{
					echo "<OPTION VALUE=\"".$idimg."\">".$titleimg."</OPTION>";
					}
					else{
					echo "<OPTION VALUE=\"".$idimg."\">".$nameimg."</OPTION>";
					}
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editim_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add image\"/></A></TD>";
	*/		
			
			
		echo "</TABLE>";
		print_box_end($return=false);
		echo "</TD></TR>";
		
		echo "<TR><TD ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT NAME= \"send\" id=\"send\" TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='view.php?id=$id'\"/>";
		echo "</TD></TR>";

		echo "</FORM></TABLE>";	
	
	
	// Close the db    
	mysql_close($link);
	
	}//fin del else de que sí hay idiomas
	
	
	
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);	
		
	
?>

			