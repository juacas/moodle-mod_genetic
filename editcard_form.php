<script type="text/javascript">
var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui se hace lamagia... jejeje, esta funcion crea dinamicamente los nuevos campos 
addCampo = function (indice) {
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
   nCampo.name = 'remission3[]';
//Establecemos el tipo de campo
   nCampo.type = 'text';
 //NUEVOOOOOOOOOOOOOOOOOO
	ele = document.createElement('select');
	ele.name = 'rem_type3[]'; 
	
   b = document.createElement('option');
   c = document.createElement('option');
   d = document.createElement('option');
   e = document.createElement('option');
   f = document.createElement('option');
   g = document.createElement('option');
   h = document.createElement('option');
   i = document.createElement('option');
   j = document.createElement('option');
   k = document.createElement('option');
   l = document.createElement('option');
   m = document.createElement('option');
   n = document.createElement('option');
   o = document.createElement('option');
   p = document.createElement('option');
   q = document.createElement('option');
   
    b.value="";
    c.value="sin";
	d.value="fv";
	e.value="acr";
    f.value="abr";
	g.value="abrform";
	h.value="sci_na";
    i.value="sim";
	j.value="diat_var";
	k.value="diaf_var";
    l.value="hiper";
	m.value="hipo";
	n.value="cohipo";
    o.value="anton";
	p.value="reject_form";
	q.value="obs";
	
	
	
	
	 b.innerHTML ="Sin definir";
	ele.appendChild(b);
	 c.innerHTML ="Sinonimo";
	ele.appendChild(c);
	 d.innerHTML ="Variante formal";
	ele.appendChild(d);
	
	 e.innerHTML ="Acronimo";
	ele.appendChild(e);
	 f.innerHTML ="Abreviatura";
	ele.appendChild(f);
	 g.innerHTML ="Forma abreviada";
	ele.appendChild(g);
	 h.innerHTML ="Nombre cientifico";
	ele.appendChild(h);
	 i.innerHTML ="Simbolo";
	ele.appendChild(i);
	 j.innerHTML ="Variante diatopica";
	ele.appendChild(j);
	 k.innerHTML ="Variante diafasica";
	ele.appendChild(k);
	 l.innerHTML ="hiperonimo";
	ele.appendChild(l);
	 m.innerHTML ="Hiponimo";
	ele.appendChild(m);
	 n.innerHTML ="Cohiponimo";
	ele.appendChild(n);
	 o.innerHTML ="Antonimo";
	ele.appendChild(o);
	 p.innerHTML ="Forma rechazable";
	ele.appendChild(p);
	q.innerHTML ="Termino obsoleto";
	ele.appendChild(q);
	
	
	
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
//y adicionar la div que hemos creado, la cual contiene el campo  con su link de eliminación:
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
<?php  // $Id: editcard_form.php, v20 2012/06/15 09:00:00 Ana María Lozano de la Fuente Exp $
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

	// File with form for editing a genetic card

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
    require_once("lib.php");
	require_once("selectsubdomains.php");
	
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
	$strrv = get_string("rv", "genetic");
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
	// Connect to the database
	$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
	
	//Count the languages of the dictionary
	
		$query = genetic_count_lang($genetic->id);
		$resultlang = mysql_query($query,$link);
		
		$numlang = mysql_affected_rows($link);
	

	echo "<TABLE WIDTH=\"100%\">";
	echo "<FORM NAME=\"editcardform\" METHOD=\"post\" ACTION=\"editcard.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("commonheaderdata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		
			// BE - department
			echo "<TR><TD ALIGN=\"right\"><B>".$strbe."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE NAME=\"be[]\">";			
			$query = genetic_show_be();
			$result = mysql_query($query,$link);
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				$queryaux = genetic_show_rel_be($headerni);
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
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editbe_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add department\"/></A></TD></TR>";
		
			// TY - card type
			echo "<TR><TD ALIGN=\"right\"><B>".$strty."</B>&nbsp;*</TD>";
			echo "<TD><SELECT NAME=\"ty\">";			
			$query = genetic_choose_ty($headerty);
			$result = mysql_query($query,$link);
			$row = mysql_fetch_array($result);
			$namety = $row['name'];			
				echo "<OPTION VALUE=\"".$headerty."\">".$namety;
				echo "<OPTION VALUE=\"0\">";
				echo "<OPTION VALUE=\"0\">".$str = get_string("nodefined", "genetic");				
				$query = genetic_show_ty();
				$result = mysql_query($query,$link);
				$n = mysql_num_rows($result);
				for ($i=0; $i<$n; $i++) {
					$row = mysql_fetch_array($result);
					$idty = $row['id'];
					$namety = $row['name'];
					echo "<OPTION VALUE=\"".$idty."\">".$namety;
				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editty_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add card type\"/></A></TD></TR>";

			// Id number (hidden)
			echo "<INPUT TYPE=\"hidden\" NAME=\"ni\" VALUE=\"".$headerni."\"></TD></TR>";
			
			// Subdomain
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strsubdom."</B>&nbsp;*</TD>";
			
			

			
			echo "<TD>";
			
			genetic_select_subdomains5($nivel=0,$headerni);
			echo"</TD>";
			echo "<TD>&nbsp;&nbsp;<A href=\"editdom_form.php?id=$id&cat=subdomain\"><IMG SRC=\"images/Add.gif\" ALT=\"add subdomain\"/></A></TD></TR>";	
			// Author
			echo "<TR><TD ALIGN=\"right\"><B>".$strauthor."</B>&nbsp;*</TD>";
			echo "<TD><SELECT MULTIPLE NAME=\"author[]\">";			
			$query = genetic_show_authors();
			$result = mysql_query($query,$link);
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
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
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editauthor_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add author\"/></A></TD></TR>";
				  // Date created
			$datecreated = 0 + time();
			echo "<TR><TD><INPUT TYPE=\"hidden\" NAME=\"datecreated\" VALUE=\"".$datecreated."\"></TD></TR>";
			
		echo "</TABLE>";
		print_box_end($return=false);	
///START IMAGES

		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
	
		echo "<TABLE ALIGN=\"center\">";
		
		echo "<TR><TD ALIGN=\"right\"><B>".$strimagenes."</B>&nbsp;</TD>";
			
		
			echo "<TD><SELECT MULTIPLE NAME=\"img[]\">";			
			$query = genetic_show_im();
			$result = mysql_query($query,$link);
			$nimages = mysql_num_rows($result);
			
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				
				$queryaux = genetic_show_images($headerni);
				$resultaux = mysql_query($queryaux,$link);
			
				while ($rowaux = mysql_fetch_array($resultaux)) {
					if ($rowaux['id'] == $row['id']) {
					
						if($rowaux['titleimage_de']!='')
						{
						echo "<OPTION SELECTED VALUE=\"".$rowaux['id']."\">".$rowaux['titleimage_de'];
						}
						else{
						echo "<OPTION SELECTED VALUE=\"".$rowaux['id']."\">".$rowaux['fileimage'];
						}
						$flagprint = 1;
					}
				}
				if ($flagprint !=1) {
					echo "<OPTION VALUE=\"".$row['id']."\">".$row['titleimage_de'];
				}
			}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editim_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add images\"/></A></TD>";


	echo "</TABLE>";		
		print_box_end($return=false);


//fin imagenes
		echo "<BR /></TD></TR>";

		echo "<TR><TD ALIGN=\"center\"><BR />".$str = get_string("languagecarddata", "genetic")."</TD></TR>";
		
		echo "<TR><TD>";
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		
		
		
		
		
		//Repite the card the number of languages of the dictionary
		
			
			
			// Select the cards for this header
			$queryc = genetic_show_cards($headerni);
			$resultc = mysql_query($queryc,$link);
			
			
			
			
			//LOOP FOR THE CARDS
			for($z=0;$z<$numlang;$z++){
				$cardrow = mysql_fetch_array($resultc);  
				
				//number of languages filled in the card
				$ncards = mysql_num_rows($resultc);
			
				echo "<INPUT TYPE=\"hidden\" NAME=\"ncards\" VALUE=\"".$ncards."\">";
				
				//Search which languages contains the dictionary
				$langrow = mysql_fetch_array($resultlang);
				$idlang = $langrow['genetic_lang_id'];
				
				$query2 =genetic_search_lang_name($idlang);
				$result2 = mysql_query($query2,$link);
				$n2 = mysql_num_rows($result2);
				$row2 = mysql_fetch_array($result2);
				//Name of the languages
				$namelang=$row2['language'];
				
			
				// Language 1
			
				
				// Remove '\' and save result
				$cardrowid = stripslashes($cardrow['id']);
				$cardrowisolang = stripslashes($cardrow['isolang']);
				$cardrowterm = stripslashes($cardrow['term']);
				$cardrowgramcat = stripslashes($cardrow['gramcat']);
				$cardrowdefinition = stripslashes($cardrow['definition']);
				$cardrowcontext = stripslashes($cardrow['context']);
				$cardrowexpression = stripslashes($cardrow['expression']);
				$cardrownotes = stripslashes($cardrow['notes']);
				$cardrowweight=stripslashes($cardrow['weighting_mark']);
				
		
			// Term (VE)
			echo "<TR><TD ROWSPAN=\"13\" VALIGN=\"top\"><INPUT TYPE=\"hidden\" NAME=\"isolang[]\" VALUE=\"".$namelang."\">";
			//echo "<IMG SRC=\"images/".$cardrowisolang.".png\">";
			echo "<INPUT TYPE=\"hidden\" NAME=\"cardid[]\" VALUE=\"".$cardrowid."\"></TD>";
			echo "<TD ALIGN=\"right\"><IMG SRC=\"images/".$namelang.".png\">&nbsp;&nbsp;&nbsp;<B>".$strterm."</B>&nbsp;*</TD>"; 
			echo "<TD COLSPAN=\"2\"><INPUT TYPE=\"text\" NAME=\"termino[]\" SIZE=\"50\" VALUE=\"".$cardrowterm."\"></TD></TR>";
			
		
			// Gramatic category (gramcat)
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strgramcat."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"gramcat[]\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$gramcat = genetic_array_gramcat();
				for ($i=0; $i<count($gramcat); $i++) {
					if ($gramcat[$i] == $cardrowgramcat) {
						echo "<OPTION SELECTED VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
					}
					else {
						echo "<OPTION VALUE=\"".$gramcat[$i]."\">".$gramcat[$i];
					}
				}
			echo "</SELECT></TD></TR>";	
			
			// Definition (DF)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strdefinition."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"definition[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowdefinition."</TEXTAREA></TD></TR>";
			
			// Context (CT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strcontext."</B>&nbsp;*</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"context[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowcontext."</TEXTAREA></TD></TR>";
			
			// Expression (PH)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strexpression."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"expression[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrowexpression."</TEXTAREA></TD></TR>";
			
			
			
			// Notes (NT)
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><B>".$strnotes."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><TEXTAREA NAME=\"notes[]\" ROWS=\"2\" COLS=\"70\" WRAP=\"soft\">".$cardrownotes."</TEXTAREA></TD></TR>";
			
			// weighting mark
			
			echo "<TR><TD ALIGN=\"right\"><B>".$strwm."</B>&nbsp;</TD>";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"weight_type[]\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$weighting_mark = genetic_array_weighting_mark();
				for ($i=0; $i<count($weighting_mark); $i++) {
					if ($weighting_mark[$i] == $cardrowweight) {
						echo "<OPTION SELECTED VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
					}
					else {
						echo "<OPTION VALUE=\"".$weighting_mark[$i]."\">".get_string($weighting_mark[$i],"genetic");
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
				$sourcerowrv = stripslashes($sourcerow['srcrv']);
				$sourcerownotes = stripslashes($sourcerow['srcnotes']);
			}
			else {
				$sourcerowterm = ''; $sourcerowdefinition = ''; $sourcerowcontext = ''; $sourcerowexpression = ''; $sourcerowrv = ''; $sourcerownotes = '';
			}
			
			// Sources Language 1
			echo "<TR><TD ROWSPAN=\"6\" VALIGN=\"top\" ALIGN=\"right\"><B>".$strsources."</B>&nbsp;</TD>";
			echo "<TD>".$strterm."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourceterm[]\" SIZE=\"63\" VALUE=\"".$sourcerowterm."\"></TD></TR>";
			echo "<TR><TD>".$strdefinition."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourcedefinition[]\" SIZE=\"63\" VALUE=\"".$sourcerowdefinition."\"></TD></TR>";

			echo "<TR><TD>".$strcontext."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourcecontext[]\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strexpression."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourceexpression[]\" SIZE=\"63\"></TD></TR>";

			echo "<TR><TD>".$strrv."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourcerv[]\" SIZE=\"63\"></TD></TR>";
			
			echo "<TR><TD>".$strnotes."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"sourcenotes[]\" SIZE=\"63\" VALUE=\"".$sourcerownotes."\"></TD></TR>";
			
			// Referrals (RV)
			$queryrem = genetic_show_remissions($cardrowid);
			$results = mysql_query($queryrem, $link);
			$nrem= mysql_num_rows($results);
			
			echo "<INPUT TYPE=\"hidden\" NAME=\"nrem\" VALUE=\"".$nrem."\">";
			
			echo "".$nrem;
		
			if($nrem!=0){
			
				while($remrow = mysql_fetch_array($results)){
					echo "<TR><TD></TD><TD ALIGN=\"right\"><NOBR><B>".$strrv."</B></NOBR>&nbsp;</TD>";
			
					// Remove '\' from the entries and allow them in variables
					$cardrowremty = stripslashes($remrow['rem_type']);
					$cardrowrem = stripslashes($remrow['remission']);
						
					
					
					echo "<TD COLSPAN=\"2\"><SELECT NAME=\"rem_type[]\">";
					echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
					$type_rem = genetic_array_type_rem();
					for ($i=0; $i<count($type_rem); $i++) {
						if ($type_rem[$i] == $cardrowremty) {
						echo "<OPTION SELECTED VALUE=\"".$type_rem[$i]."\">".get_string($type_rem[$i],"genetic");
						}
						else {
						echo "<OPTION VALUE=\"".$type_rem[$i]."\">".get_string($type_rem[$i],"genetic");
						}
					}
		
				echo "</SELECT><INPUT TYPE=\"text\" NAME=\"remission[]\" SIZE=\"40\" VALUE=\"".$cardrowrem."\"></TD></TR>";	
				}
			}
			
			
			//New referrals to add
			echo "<TR><TD></TD><TD ALIGN=\"right\"><NOBR><B>".$strrv."</B></NOBR>&nbsp;</TD>";
				echo "<TD><div align=\"center\" id=\"adjuntos2\">";
			echo "<TD COLSPAN=\"2\"><SELECT NAME=\"rem_type2[]\" id= \"selector\">";
				echo "<OPTION VALUE=\"\">".$str = get_string("nodefined", "genetic");
				$type_rem = genetic_array_type_rem();
				for ($k=0; $k<count($type_rem); $k++) {
					echo "<OPTION VALUE=\"".$type_rem[$k]."\">".$str = get_string($type_rem[$k], "genetic");
				}
				
			echo "</SELECT>";
			//echo "</div>";
			//echo "<div align=\"center\" id=\"adjuntos\" >";
			echo"<INPUT TYPE=\"text\" NAME=\"remission2[]\" SIZE=\"40\"><a href=\"#?id=$id&numrem=$z\" onClick=\"addCampo()\"><IMG SRC=\"images/Add.gif\" ALT=\"add remission\"/></a></TD></TR>";	
			
			echo "numrem vale :".$numrem."";
			echo "</div>";
			if($z==$numrem){
			echo "<TR><TD></TD><TD></TD><TD ALIGN=\"right\"><div id=\"adjuntos\" name=\"adjuntos[]\"></TD></TR>";
			}
			echo "</div>";
			
			
				  // Añadir los archivos de audio 
			
			echo "<TD ALIGN=\"right\"><B>".$straudio."</B>&nbsp;</TD>";
			
			echo "<TD><SELECT MULTIPLE NAME=\"audio[][]\" >";
				$query = genetic_show_audio_files($namelang);
				$result = mysql_query($query,$link);
				while ($row = mysql_fetch_array($result)) {
				
				$flagprint = 0;
				$queryaux = genetic_show_audio($cardrowid);
				$resultaux = mysql_query($queryaux,$link);
				while ($rowaux = mysql_fetch_array($resultaux)) {
					if ($rowaux['genetic_audio_id'] == $row['id']) {
						echo "<OPTION SELECTED VALUE=\"".$rowaux['genetic_audio_id']."\">".$row['fileaudio'];
						$flagprint = 1;
					}
				}
				if ($flagprint !=1) {
					echo "<OPTION VALUE=\"".$row['id']."\">".$row['fileaudio'];
				}

				}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editau_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add audio file\"/></A></TD></TR>";
				  
						//Terminos de relacion cruzada

				/*
				echo "<TD ALIGN=\"right\"><B>".$strcrossrelatedterms."</B>&nbsp;</TD>";
			
		
			echo "<TD><SELECT MULTIPLE NAME=\"crossrel[][]\">";			
			$query = genetic_show_crossrelated($cardrowisolang);
			$result = mysql_query($query,$link);
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				$queryaux = genetic_show_crossrelations($cardrowidremissions,$cardrowid);
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
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editcr_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add crossrelated term\"/></A></TD></TR>";
				  
			  
				*/  
				  	
			
				  	 //Videos

				
				echo "<TD ALIGN=\"right\"><B>".$strvideos."</B>&nbsp;</TD>";
			
		
			echo "<TD><SELECT MULTIPLE NAME=\"video[][]\">";			
			$query = genetic_show_vi();
			$result = mysql_query($query,$link);
			
			
			while ($row = mysql_fetch_array($result)) {
				$flagprint = 0;
				$queryaux = genetic_show_videos($cardrowid);
				$resultaux = mysql_query($queryaux,$link);
			
				while ($rowaux = mysql_fetch_array($resultaux)) {
					if ($rowaux['id'] == $row['id']) {
					
						if($rowaux['titlevideo_de']!='')
						{
						echo "<OPTION SELECTED VALUE=\"".$rowaux['id']."\">".$rowaux['titlevideo_de'];
						}
						else{
						echo "<OPTION SELECTED VALUE=\"".$rowaux['id']."\">".$rowaux['filevideo'];
						}
						$flagprint = 1;
					}
				}
				if ($flagprint !=1) {
					echo "<OPTION VALUE=\"".$row['id']."\">".$row['titlevideo_de'];
				}
			}
			echo "</SELECT>
				  &nbsp;&nbsp;<A href=\"editvi_form.php?id=$id\"><IMG SRC=\"images/Add.gif\" ALT=\"add videos\"/></A></TD></TR>";
				  
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

	echo "</FORM></TABLE>";	
	
	// Close the db    
	mysql_close($link);
	
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);	

?>