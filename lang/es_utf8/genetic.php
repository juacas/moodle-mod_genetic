<?php  // $Id: genetic.php,v 1.0 2012/06/11 18:11:00 Ana Mar�a Lozano de la Fuente Exp $
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

//header('Content-Type: text/html; charset=iso-8859-1');
//---a�adido---
$string['abreviaturas'] = 'Abreviaturas :';
$string['accept'] = 'Aceptar';
$string['action'] = 'Acción';
//---a�adido---
$string['acronyms'] = 'Acrónimos :';
$string['advaudio'] = 'El nombre del archivo de audio ha de seguir el siguiente patrón: nombre_término.extensión';
$string['addaudio'] = 'Añadir audio';
$string['addauthor'] = 'Añadir nuevo autor/a';
$string['addbe'] = 'Añadir nueva institución';
$string['addcard'] = 'Añadir ficha';
$string['addcardf'] = 'Añadir nueva ficha terminológica';
$string['adddom'] = 'Añadir nuevo dominio';
//---a�adido---
$string['addim'] = 'Añadir nueva imagen';
$string['addlang'] = 'Añadir nuevo idioma';
$string['addau'] = 'Añadir nuevo audio';
$string['addvi'] = 'Añadir nuevo vídeo';
$string['addrt'] = 'Añadir nuevo término relacionado';
$string['addcr'] = 'Añadir nuevo término relacion cruzada';
$string['addsubdom'] = 'Añadir nuevo subdominio';
$string['addsynonym'] = 'Añadir nuevo sinónimo';
$string['addty'] = 'Añadir nuevo proyecto';
$string['admin'] = 'Administrador';
$string['alphaorder'] = 'Por orden alfabético :';

$string['ar'] = 'árabe';
$string['asc'] = 'Fecha ASC';
$string['author'] = 'Autor/es';
$string['audio'] = 'Audio';
$string['audio_video'] = 'Idioma audio vídeo';
$string['be'] = 'Institución/es';
$string['belongto'] = 'Pertenece a';
$string['buttonaddau'] = 'Añadir autor/a';
$string['buttonaddaudio'] = 'Añadir audio';
$string['buttonaddbe'] = 'Añadir institución';
$string['buttonadddom'] = 'Añadir dominio';
//a�adido
$string['buttonaddim'] = 'Añadir imágen';
$string['buttonaddrt'] = 'Añadir término relacionado';
$string['buttonaddcr'] = 'Añadir término relación cruzada';
$string['buttonaddlang'] = 'Añadir idioma';
$string['buttonaddty'] = 'Añadir proyecto';
$string['buttonaddsubdom'] = 'Añadir subdominio';
$string['buttonaddsyn'] = 'Añadir sinónimo';
$string['buttonaddvi'] = 'Añadir vídeo';
$string['buttongeneralsearch'] = 'Búsqueda general';
$string['cancel'] = 'Cancelar';
$string['cards'] = 'Fichas';
$string['category'] = 'Categoría';
$string['chooselang'] = 'Elija idioma:';
$string['commonheaderdata'] = 'Datos comunes a los idiomas de la ficha terminológica';
$string['context'] = 'Contexto';
$string['criteria'] = 'Criterio de búsqueda';
//---a�adido---
$string['crossrelatedterms'] = 'Términos cruzados';
$string['datecreated'] = 'Fecha de creación / modificación';
$string['indexuse'] = 'Use este índice para ordenar las fichas según la fecha de creación / modificación o alfabeticamente escogiendo el idioma:';
$string['datemodified'] = 'Fecha de modificación';
$string['date'] = 'Fecha :';
//---a�adido---
$string['de'] = 'Alemán ';
$string['definition'] = 'Definición';
$string['delete'] = 'Borrar';
$string['deleteausure'] = ' Está seguro de borrar el audio ?';
$string['deleteauused'] = 'No se puede borrar el autor. La entrada está siendo usada por una ficha terminológica.';
$string['deleteauthor'] = 'Borrar autor/a';
$string['deleteaunok'] = 'Error al borrar autor/a';
$string['deleteauok'] = 'Autor/a borrado correctamente';
$string['deleteauthorsure'] = ' Está seguro de borrar el/la autor/a ?';
$string['deletebe'] = 'Borrar institución';
$string['deletebeused'] = 'No se puede borrar la institución. La entrada está siendo usada por una ficha terminológica.';
$string['deletebenok'] = 'Error al borrar la institución';
$string['deletebeok'] = 'Institución borrada correctamente';
$string['deletebesure'] = ' Está seguro de borrar la institución ?';
$string['deletesynsure'] = ' Está seguro de borrar el sinónimo ?';
$string['deletecard'] = 'Borrar ficha terminológica';
$string['deletecardsure'] = ' Está seguro de borrar la ficha terminológica ?';
$string['deletedomused'] = 'No se puede borrar el subdominio. La entrada está siendo usada por una ficha terminológica.';
$string['deletedom'] = 'Borrar dominio';
$string['deletedomparent'] = 'No se puede borrar subdominio; contiene a otros';
//---a�adido---
$string['deleteim'] = 'Borrar imagen';
$string['deletevi'] = 'Borrar vídeo';
$string['deleteimnok'] = 'Error al borrar la imagen';
$string['deleteaunok'] = 'Error al borrar el audio';
$string['deleteimok'] = 'Imagen borrada correctamente';
$string['deletelangok'] = 'Idioma borrado correctamente';
$string['deletelangnok'] = 'Error al borrar el idioma';
$string['deleteauok'] = 'Audio borrado correctamente';
$string['deletevinok'] = 'Error al borrar el vídeo';
$string['deleteviok'] = 'Vídeo borrado correctamente';
$string['deleteauused'] = 'No se puede borrar el audio. La entrada está siendo usada por una ficha terminológica.';
$string['deleteimused'] = 'No se puede borrar la imagen. La entrada está siendo usada por una ficha terminológica.';
$string['deletelangused'] = 'No se puede borrar el idioma. El idioma está siendo usada por una ficha terminológica.';
$string['deleteviused'] = 'No se puede borrar el vídeo. La entrada está siendo usada por una ficha terminológica.';
$string['deletedomsdnok'] = 'Error al borrar subdominio';
$string['deletedomsdok'] = 'Subdominio borrado correctamente';
$string['deletedomsdsure'] = ' Está seguro de borrar el subdominio ?';

$string['deletenok'] = 'Error al borrar la ficha terminológica';
$string['deletelangsure'] = ' Está seguro de borrar el idioma ?';
$string['deleteok'] = 'Ficha terminológica borrada correctamente';
$string['deletert']='Borrar término relacionado';
$string['deletecr']='Borrar término relación cruzada';
$string['deletertnok'] = 'Error al borrar término relacionado';
$string['deletertok'] = 'Término relacionado borrado correctamente';
$string['deletecrok'] = 'Término relación cruzada borrado correctamente';
$string['deletertsure'] = ' Está seguro de borrar el término relacionado ?';
$string['deletecrsure'] = ' Está seguro de borrar el término relación cruzada ?';
$string['deletertused'] = 'Borrar término relacionado';
$string['deletecrused'] = 'Borrar término relacion cruzada';
$string['deletesubdom'] = 'Borrar subdominio';
$string['deletesubdomused'] = 'No se puede borrar el subdominio. La entrada está siendo usada por una ficha terminológica.';
$string['deletesynonym']='Borrar sinónimo';
$string['deletety'] = 'Borrar proyecto';
$string['deletetyused'] = 'No se puede borrar el proyecto. La entrada está siendo usada por una ficha terminológica.';
$string['deletesynused'] = 'No se puede borrar el sinónimo. La entrada está siendo usada por una ficha terminológica.';
$string['deletesynnok'] = 'Error al borrar sinónimo';
$string['deletesynok'] = 'Sinónimo borrado correctamente';
$string['deletetynok'] = 'Error al borrar proyecto';
$string['deletecrnok'] = 'Error al borrar término cruzado';
$string['deletetyok'] = 'Proyecto borrado correctamente';
$string['deletetysure'] = ' Está seguro de borrar el proyecto ?';
$string['deleteimsure'] = ' Está seguro de borrar la imagen ?';
$string['deletevisure'] = ' Está seguro de borrar el vídeo ?';
$string['desc'] = 'Fecha DESC';
$string['description'] = 'Descripción';
$string['detail'] = 'Ver detalles';
$string['dom'] = 'Dominio';
$string['subdomview'] = 'Vista jerarquizada de los subdominios:';
$string['edit'] = 'Editar';
$string['editau'] = 'Editar audio';
$string['editauthor'] = 'Editar autor/a';
$string['editbe'] = 'Editar institución';
$string['editcard'] = 'Editar ficha terminológica';
$string['editdom'] = 'Editar dominio';
//---a�adido---

$string['editim'] = 'Editar imágen';
$string['editsyn'] = 'Editar sinónimo';
$string['editvi'] = 'Editar vídeo';
$string['editrt'] = 'Editar término relacionado';
$string['editcr'] = 'Editar término relacion cruzada';
$string['editsubdom'] = 'Editar subdominio';
$string['editty'] = 'Editar proyecto';
$string['emptyfield'] = 'Campo obligatorio vacío. Compruebe los datos anteriores';
$string['emptyfieldterm'] = 'Campo vacío. Escriba el término sobre el que desea buscar.';
$string['emptyfieldauthor'] = 'Campo vacío. Escriba el autor sobre el que desea buscar.';
$string['emptyfielddom'] = 'Campo vacío. Seleccione el dominio sobre el que desea buscar.';
$string['emptyfieldgramcat'] = 'Campo vacío. Debe seleccionar una categoría gramatical.';
$string['emptyfieldheader'] = 'Campo obligatorio de cabecera no seleccionado. Revise los datos comunes a las fichas terminológicas.';
$string['emptyfieldisolang'] = 'Campo vacío. Seleccione el idioma sobre el que desea buscar.';
$string['emptyfieldlanguage'] = 'Campo obligatorio de idioma vacío. Revise los datos refrentes a los términos.';
$string['emptysearchtype'] = 'Debe seleccionar un criterio de búsqueda y rellenarlo';
//---a�adido---
$string['en'] = 'Inglés ';
$string['errordb'] = 'Se ha producido un error al seleccionar la base de datos correspondiente a la actividad. Vuelva a intentarlo.';
$string['es'] = 'Castellano ';
$string['expression'] = 'Fraseología';
$string['footsentencees'] = 'Con la colaboración de la Consejería de Educación de la Junta de Castilla y León.';
$string['fr'] = 'Francés ';
$string['genetic'] = 'Genetic';
$string['gramcat'] = 'Categoría gramatical';
$string['guest'] = 'Invitado';
$string['imagenes'] = 'Imágenes :';
$string['insertaunok'] = 'Error al insertar autor/a';
$string['insertaudiook'] = 'Audio insertado correctamente';
$string['insertaudionok'] = 'Error al insertar el audio';
$string['insertauok'] = 'Autor/a insertado correctamente';
$string['insertbenok'] = 'Error al insertar institución';
$string['insertbeok'] = 'Institución insertada correctamente';
$string['insertdomsdnok'] = 'Error al insertar subdominio';
$string['insertdomsdok'] = 'Subdominio insertado correctamente';
$string['insertlangok'] = 'Idioma insertado correctamente';
$string['insertdomsexist'] = 'Error de insercion. El subdominio ya existe';
$string['insertauexist'] = 'Error de insercion. El nombre del archivo del audio ya existe';
$string['insertimexist'] = 'Error de insercion. El nombre del archivo de la imagen ya existe';
$string['insertviexist'] = 'Error de insercion. El nombre del archivo de la vídeo ya existe';
$string['insertimnok'] = 'Error al insertar la imagen';
$string['insertimok'] = 'Imagen insertada correctamente';
$string['insertvinok'] = 'Error al insertar el vídeo';
$string['insertviok'] = ' Vídeo insertado correctamente';
$string['insertnok'] = 'Error al insertar ficha terminológica';
$string['insertok'] = 'Ficha terminológica insertada correctamente';
$string['insertrtnok'] = 'Error al insertar el término relacionado';
$string['insertrtused'] = 'El término relacionado en ese idioma ya existe en el diccionario';
$string['insertcrnok'] = 'Error al insertar el término relación cruzada';
$string['insertcrused'] = 'El término de relación cruzada en ese idioma ya existe en el diccionario';
$string['insertrtok'] = 'Término relacionado insertado correctamente';
$string['insertcrok'] = 'Término relación cruzada insertado correctamente';
$string['insertsynok'] = 'Sinónimo insertado correctamente';
$string['insertsynnok'] = 'Sinónimo insertado correctamente';
$string['insertsynused'] = 'El sinónimo en ese idioma ya existe en el diccionario';
$string['inserttynok'] = 'Error al insertar el proyecto';
$string['inserttyok'] = 'proyecto insertado correctamente';
$string['labelspecial'] = 'Muestra las fichas cuyo término no comienza por una letra';
//---a�adido---
$string['lang'] = 'Idioma';
$string['langdicexist'] = ' ya existe en el diccionario';
$string['languagecarddata'] = 'Datos particulares de cada idioma de la ficha terminológica';
$string['link'] = 'Enlace';
$string['linksubd'] = 'Pulsar sobre cada subdominio para acceder al topic browser de Eurogene.';
$string['maximumchars'] = 'N�mero máximo de caracteres';
$string['modau'] = 'Modificar audio';
$string['modimagen'] = 'Modificar imagen';
$string['name'] = 'Nombre';
$string['newsearch'] = 'Nueva búsqueda';
$string['ni'] = 'Número identificación';
$string['nodefined'] = 'Sin definir';
$string['nodescrlang'] = 'No hay decripción';
$string['noentries'] = 'No se han encontrado fichas terminológicas';
$string['noentriesterm'] = 'No se ha introducido términos en este idioma';
$string['noexistauthor'] = 'El autor buscado no aparece en la base de datos.';
$string['noinsertlangdic'] = 'Idioma no insertado en el diccionario.';
$string['nolang'] = 'No hay idiomas incluidos en el diccionario.';
$string['noresultauthor'] = 'No se han encontrado autor(es) que coincidan';
$string['noresultdom'] = 'No se han encontrado fichas terminológicas en el dominio seleccionado.';
$string['noresultgeneral'] = 'No se ha encontrado ninguna coincidencia en las fichas terminológicas.';
$string['noresultgramcat'] = 'No se han encontrado fichas terminológicas en categoría gramatical seleccionada.';
$string['noresultisolang'] = 'No se han encontrado fichas terminológicas en el idioma seleccionado.';
$string['noresultterm'] = 'No se han encontrado término(s) que coincidan';
$string['nosources'] = 'No se han encontrado fuentes para el término';
$string['nosrcimage'] = 'No se han encontrado fuentes para la imagen';
$string['nosrcvideo'] = 'No Sources were  found for this video';
$string['notes'] = 'Notas';
$string['nummatch'] = 'Número de coincidencias';
//----a�adido---
$string['pieimagen'] = 'Descripción de la imagen (es)';
$string['pieimagen_fr'] = 'Descripción de la imagen (fr)';
$string['pieimagen_en'] = 'Descripción de la imagen (en)';
$string['pieimagen_de'] = 'Descripción de la imagen (de)';
$string['pievideo'] = 'Descripción del vídeo (es)';
$string['pievideo_fr'] = 'Descripción del vídeo (fr)';
$string['pievideo_en'] = 'Descripción del vídeo (en)';
$string['pievideo_de'] = 'Descripción del vídeo (de)';
$string['reference'] = 'Remisiones';
//---a�adido---
$string['relatedterms'] = 'Términos relacionados';
$string['reliabilitycode'] = 'Código de fiabilidad';
$string['requiredfields'] = '(*) Campos obligatorios. No es necesario rellenar todos los idiomas';
$string['resultsearch'] = 'Resultado de la búsqueda';
$string['rv'] = 'Remisiones';
$string['save'] = 'Guardar';
$string['search'] = 'Buscar';
$string['searchauthor'] = 'Buscar por autor';
$string['searchcard'] = 'Buscar ficha terminológica';
$string['searchcards'] = 'Buscar fichas';
$string['searchdom'] = 'Buscar por subdominio';
$string['searchlanguage'] = 'Buscar por idioma';
$string['searchproyect'] = 'Buscar por proyecto';
$string['searchterm'] = 'Buscar por término';
$string['searchtopdf'] = 'Resultado de la búsqueda en PDF';
$string['searchword'] = 'Palabra/s introducida';
$string['seealso'] = 'Ver tambien:';
//--a�adido--
$string['selimagen'] = 'Añadir imagen';
$string['selvideo'] = 'Añadir vídeo';
$string['seltypesearch'] = 'Seleccione el criterio de búsqueda y escriba/elija la casilla correspondiente';
$string['setlang'] = 'Ajustes de idioma';
$string['showauthors'] = 'Gestionar autores';
$string['showbe'] = 'Ver instituciones';
$string['showcards'] = 'Ver fichas';
$string['showcr'] = 'Ver referencias cruzadas';
$string['showlang'] = 'Gestionar idiomas';
$string['showsubdom'] = 'Ver dominios';
$string['showsubdoms'] = 'Gestionar subdominios';
$string['showrt'] = 'Ver términos relacionados';
$string['showty'] = 'Ver proyectos';
$string['showsyn'] = 'Ver sinónimos';
//---a�adido---
$string['showim'] = 'Ver imágenes';
$string['showvi'] = 'Ver vídeos';
$string['showau'] = 'Audio';
$string['siglas'] = 'Siglas';
$string['sources'] = 'Fuentes';
//---a�adido---
$string['src'] = 'Fuente:';
$string['src_image'] = 'Fuentes de la imagen';
//---a�adido---
$string['src_video'] = 'Fuentes del vídeo';
$string['student'] = 'Alumno';
$string['subdom'] = 'Subdominios';
$string['subdomain'] = 'Subdominio';
$string['surname'] = 'Apellidos';
//---a�adido---
$string['synonym'] = 'Sinonimos :';
$string['synonymm'] = 'Sinónimo';


//---a�adido---
$string['symbols'] = 'Simbolos';
$string['teacher'] = 'Profesor';
$string['term'] = 'Término';
$string['termnoexists'] = 'El término no existe en el diccionario';
$string['termnoexistslang'] = 'El término en ese idioma no esta disponible en el diccionario';
//--a�adido---
$string['term_already_exists'] = 'El término ya existe.  Confirma que desea introducir otra vez el término?';
//--a�adido---
$string['title_video'] = 'Título del vídeo';

$string['ty'] = 'Proyecto';
$string['updateaudionok'] = 'Error al actualizar audio';
$string['updateaudiook'] = 'Audio actualizado correctamente';
$string['updateaunok'] = 'Error al actualizar autor';
$string['updateauok'] = 'Autor actualizado correctamente';
$string['updatebenok'] = 'Error al actualizar institución';
$string['updatebeok'] = 'Institución actualizada correctamente';
$string['updatesynnok'] = 'Error al actualizar sinónimo';
$string['updatesynok'] = 'Sinónimo actualizado correctamente';
$string['updatedomsdnok'] = 'Error al actualizar subdominio';
$string['updatedomsdok'] = 'Subdominio actualizado correctamente';
$string['updateimok'] = 'Imagen actualizada correctamente';
$string['updateimnok'] = 'Error al actualizar la imagen';
$string['updateviok'] = 'Vídeo actualizada correctamente';
$string['updatevinok'] = 'Error al actualizar el vídeo';
$string['updatenok'] = 'Error al actualizar la ficha terminológica';

$string['updateok'] = 'Ficha terminológica actualizada correctamente';
$string['updatertnok'] = 'Error al actualizar término relacionado';
$string['updatecrnok'] = 'Error al actualizar término relación cruzada';
$string['updatertok'] = 'Término relacionado actualizado correctamente';
$string['updatecrok'] = 'Término relación cruzada actualizado correctamente';
$string['updatetynok'] = 'Error al actualizar proyecto';
$string['updatetyok'] = 'Proyecto actualizado correctamente';
$string['usernotable'] = 'Error, usted no puede acceder a la actividad.';
$string['f'] = 'Femenino';
$string['m'] = 'Masculino';
$string['adj'] = 'Adjetivo';
$string['adv'] = 'Adverbio';
$string['vtr'] = 'Verbo transitivo';
$string['vintr'] = 'Verbo intransitivo';
$string['videos'] = 'Vídeos:';
$string['viewfullcard'] = 'Ver ficha completa';
$string['viewlang'] = 'Ver idiomas';

//Remisiones
$string['rem'] = 'Remisiones';
$string['sin'] = 'Sinónimo';
$string['fv'] = 'Variante formal';
$string['acr'] = 'Acrónimo';
$string['abr'] = 'Abreviatura';
$string['abrform'] = 'Forma abreviada';
$string['sci_na'] = 'Nombre científico';
$string['sim'] = 'símbolo';
$string['diat_var'] = 'Variante diatópica';
$string['diaf_var'] = 'Variante diafásica';
$string['hiper'] = 'Hiperónimo';
$string['hipo'] = 'Hipónimo';
$string['cohipo'] = 'Cohipónimo';
$string['anton'] = 'Antónimo';
$string['reject_form'] = 'Forma rechazable';
$string['obs'] = 'Termino obsoleto';
//marca de ponderacion
$string['wm'] = 'Marca de ponderación';
$string['nor'] = 'Término normativo o normalizado ';
$string['neo'] = 'Neologismo pendiente de aprobación';
$string['pen'] = 'Término pendiente de estudio';
$string['reject'] = 'Término rechazable';


//$string['terminology'] = 'Terminology';
$string['modulename'] = 'Diccionario Eurogene';
$string['modulenameplural'] = 'Diccionarios Eurogene';

$string['newmodulefieldset'] = 'Custom example fieldset';
$string['newmoduleintro'] = 'newmodule Intro';
$string['newmodulename'] = 'newmodule Name';

?>
