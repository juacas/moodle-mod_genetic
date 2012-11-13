<?php  // $Id: editsynonym_form.php,v 1.0 2012/06/13 21:40:00 Ana María Lozano de la Fuente Exp $

	// File with a form for add or edit synonyms.

	// Attached files
    require_once("../../config.php");
	require_once("db_functions.php");
	require_once("lib.php");
	// Necessary parameters
	
    $id = optional_param('id',0,PARAM_INT);
    $t = optional_param('t',0,PARAM_INT);
	
	// Parameters to manage a synonym
	$idsyn = optional_param('idsyn',0,PARAM_INT);
	$action = optional_param('action','',PARAM_ALPHA);
	$origen = optional_param('origen','',PARAM_TEXT);

	
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
    add_to_log($course->id, "genetic", "edit synonyms", "editsynonym_form.php?id=$cm->id&idsyn=$idsyn&action=$action", "$genetic->id");
	
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
    //$strname  = get_string("name", "genetic");
	$strsynonymm = get_string("synonymm", "genetic");
	$strlink = get_string("link", "genetic");
	$strlang = get_string("lang", "genetic");
	
	//Get a short version for the name of the genetic module
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
	
	
	// Check the URL parameter (action: add, edit or delete)
	?>
</script>

<script type="text/javascript">

var numero = 0; //Esta es una variable de control para mantener nombres
            //diferentes de cada campo creado dinamicamente.
evento = function (evt) { //esta funcion nos devuelve el tipo de evento disparado
   return (!evt) ? event : evt;
}

//Aqui esta funcion crea dinamicamente los nuevos campos file
addCampo = function () {

	txt5=document.createElement('br');
	txt6=document.createElement('br');
	
//Creamos un nuevo div para que contenga el nuevo campo
   nDiv = document.createElement('div');
  
//con esto se establece la clase de la div
   nDiv.className = 'archivo';
//este es el id de la div, aqui la utilidad de la variable numero
//nos permite darle un id unico
   nDiv.id = 'employees4' + (++numero);
   
//creamos el input para el formulario:
   //nCampo = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   //nCampo.name = 'imagen[]';
//Establecemos el tipo de campo
   //nCampo.type = 'file';
   //nCampo.size = '63';

   
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   //nDiv.appendChild(nCampo);


//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos3');
  
	container.appendChild(txt5);
	
    container.appendChild(txt6);

    container.appendChild(nDiv);
	
  
//creamos el input para el formulario:
   nCampo2 = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo2.name = 'synonyms[]';
   
//Establecemos el tipo de campo
   nCampo2.type = 'text';
   nCampo2.size='63';

//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo
   nDiv.appendChild(nCampo2);
   
//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:
   container = document.getElementById('adjuntos3');
 
   container.appendChild(nDiv);
  
   nCamp = document.createElement('br');
   nDiv.appendChild(nCamp);
   container = document.getElementById('adjuntos2');
   container.appendChild(nDiv);
 
//creamos el input para el formulario:
   nCampo3 = document.createElement('input');
//le damos un nombre, es importante que lo nombren como vector, pues todos los campos
//compartiran el nombre en un arreglo, asi es mas facil procesar posteriormente con php
   nCampo3.name = 'link[]';
//Establecemos el tipo de campo
   nCampo3.type = 'text';
   nCampo3.size='63';

    
//Bien es el momento de integrar lo que hemos creado al documento,
//primero usamos la función appendChild para adicionar el campo file nuevo

   nDiv.appendChild(nCampo3);

//Ahora si recuerdan, en el html hay una div cuyo id es 'adjuntos', bien
//con esta función obtenemos una referencia a ella para usar de nuevo appendChild
//y adicionar la div que hemos creado, la cual contiene el campo file con su link de eliminación:

   container= document.getElementById('adjuntos3');
   container.appendChild(nDiv);
   
   //Ahora creamos un link para poder eliminar un campo que ya no deseemos
   a = document.createElement('a');
   //El link debe tener el mismo nombre de la div padre, para efectos de localizarla y eliminarla
   a.name = nDiv.id;
   //Este link no debe ir a ningun lado
   a.href = '#';
   //Establecemos que dispare esta funcion en click
   a.onclick = elimCamp;
   //Con esto ponemos el texto del link
   
   a.innerHTML = 'Eliminar_sinonimo';
   //Adicionamos el Link
   nDiv.appendChild(a);

}
//con esta función eliminamos el campo cuyo link de eliminación sea presionado
elimCamp = function (evt){
   evt = evento(evt);
   nuevoCampoo = rObj(evt);
   div = document.getElementById(nuevoCampoo.name);
   //div2 = document.getElementById(nCampo2.name);
   //div3 = document.getElementById(nCampo3.name);
   div.parentNode.removeChild(div);
   //div2.parentNode.removeChild(div2);
   //div3.parentNode.removeChild(div3);
}
//con esta función recuperamos una instancia del objeto que disparo el evento
rObj = function (evt) {
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>
<?php	

	// Add
	if ($action == "") {	
		// Print Title
		print_heading(get_string('addsynonym', 'genetic'), 'center',2);
							
		// Form to add a synonym
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"addsynonymform\" METHOD=\"post\" ACTION=\"editsynonym.php?id=$id\" ENCTYPE=\"multipart/form-data\">";
		
			
			//SINONIMOS
			
			
			echo "<TR><TD COLSPAN=\"4\"><BR></TD></TR>";
			
			echo"<div id=\"employees3\" NAME=\"employees4\">";
			echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\"><NOBR>".$strsynonymm."&nbsp;</NOBR></TD><TD><dd><div id=\"adjuntos2\"><INPUT TYPE=\"text\" NAME=\"synonyms\" SIZE=\"63\"></div></dd></TD></TR>";
			//echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strlink."&nbsp;</TD><TD><dd><div id=\"adjuntos3\"><INPUT TYPE=\"text\" NAME=\"enlace\" SIZE=\"63\"></div></dd></TD></TR>";
				echo "<TR><TD VALIGN=\"top\" ALIGN=\"right\">".$strlang."&nbsp;&nbsp;&nbsp;</TD>";
				
				//Count the languages available in the dictionary 
				$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
				$query = genetic_count_lang($genetic->id);
				$resultlang = mysql_query($query,$link);
		
				$numlang = mysql_affected_rows($link);
				
				echo "<TD><SELECT NAME=\"language\">";
				echo "<OPTION VALUE=\"none\">".$str = get_string("nodefined", "genetic");
				while($langrow = mysql_fetch_array($resultlang)){
			
				//Search which languages the dictionary contains
			
					$idlang = $langrow['genetic_lang_id'];
					$query2 =genetic_search_lang_name($idlang);
					$result2 = mysql_query($query2,$link);
					$n2 = mysql_num_rows($result2);
					$row2 = mysql_fetch_array($result2);
					$namelang=$row2['language'];	
					
					echo "<OPTION VALUE=\"".$namelang."\">".$str = get_string($namelang, "genetic");
				
				
				}
				echo "</SELECT></TD></TR>";
			//echo "<TD align=\"left\"><dt><a href=\"#\" onClick=\"addCampo()\">+ sinonimo</a></dt></TD>";
			   
			echo"</div>";
			
			//$array=synonyms;
			//$tmp = serialize($array); 
			//$tmp = urlencode($tmp); 
			//FIN
			
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"hidden\" NAME=\"origen\" VALUE=\"".$origen."\">";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='addcard_form.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
		
	}
	//pegado
		// Edit
	else if ($action == "edit") {
		// Print Title
		print_heading(get_string('editsyn', 'genetic'), 'center',2);
		
		// Get the synonyms fields from the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		$query = genetic_choose_syn($idsyn);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['name'];
		// Close the db    
		mysql_close($link);
				
		// Form to edit a synonym
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"editsynform\" METHOD=\"post\" ACTION=\"editsynonym.php?id=$id&action=edit\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idsyn\" VALUE=\"".$idsyn."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD><INPUT TYPE=\"text\" NAME=\"synonyms\" SIZE=\"80\" VALUE=\"".$name."\"></TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("save", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewsyn.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
	}
	
	// Delete
	else if ($action == "delete") {
		// Print Title
		print_heading(get_string('deletesynonym', 'genetic'), 'center',2);
		
		// Connect to the database
		$link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
		
		// Check if the synonym is being used in any genetic card.
		$query = genetic_use_syn($idsyn);
		$result = mysql_query($query, $link);
		$n = mysql_num_rows($result);
		if($n != 0) {
			$redirectmsg = get_string("deletesynused", "genetic");
			redirect($url="viewsyn.php?id={$cm->id}", $redirectmsg, $delay=-1);				
			// Close the db    
			mysql_close($link);
			// Finish the page
			print_footer($course);				
		}

		else {
		// Get the synonym fields from the database
		$query = genetic_choose_syn($idsyn);
		$result = mysql_query($query,$link);
		$row = mysql_fetch_array($result);
		$name = $row['name'];
		// Close the db    
		mysql_close($link);
		
		// Form to delete a synonym
		print_box_start($classes='generalbox boxaligncenter boxwidthwide', '', $return=false);
		echo "<TABLE ALIGN=\"center\">";
		echo "<FORM NAME=\"deletesynform\" METHOD=\"post\" ACTION=\"editsynonym.php?id=$id&action=delete\" ENCTYPE=\"multipart/form-data\">";
		echo "<INPUT TYPE=\"hidden\" NAME=\"idsyn\" VALUE=\"".$idsyn."\">";
		echo "<TR><TD>".$strname."&nbsp;</TD><TD>".$name."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />".$str = get_string("deletesynsure", "genetic")."</TD></TR>";
		echo "<TR><TD COLSPAN=\"2\" ALIGN=\"center\"><BR /><BR />";
		echo "<INPUT TYPE=\"submit\" VALUE=\"".$str = get_string("delete", "genetic")."\" NAME=\"buttonsave\" />&nbsp;&nbsp;";
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("cancel", "genetic")."\" NAME=\"buttoncancel\" onClick=\"location.href='viewsyn.php?id=$id'\"/>";
		echo "</TD></TR>";
		echo "</FORM></TABLE>";
		print_box_end($return=false);
		}
	}
	//fin pegado
	} // Close caps ELSE
	
	// Finish the page
	include('banner_foot.html');
    print_footer($course);

?>
