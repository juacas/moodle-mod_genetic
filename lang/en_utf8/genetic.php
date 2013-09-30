
<?php  // $Id: genetic.php,v 1.0 2012/11/13 18:11:00 Ana María Lozano de la Fuente Exp $
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

//header('Content-Type: text/html; charset=iso-8859-1');
//---añadido---
$string['abreviaturas'] = 'abbreviations :';
$string['accept'] = 'Accept';
$string['action'] = 'Action';
//---añadido---
$string['acronyms'] = 'Acronyms :';
$string['advaudio'] = 'The audio filename must follow this pattern: file_name.extension';
$string['addaudio'] = 'Add audio';
$string['addauthor'] = 'Add new author';
$string['addbe'] = 'Add new institution';
$string['addcard'] = 'Add card';
$string['addcardf'] = 'Add new terminological card';
$string['adddom'] = 'Add new domain';
//---añadido---
$string['addim'] = 'Add new image';
$string['addlang'] = 'Add new language';
$string['addvi'] = 'Add new video';
$string['addau'] = 'Add new audio';
$string['addrt'] = 'Add new related term ';
$string['addcr'] = 'Add new crossrelated term ';
$string['addsubdom'] = 'Add new subdomain';
$string['addsynonym'] = 'Add new synonym';
$string['addty'] = 'Add new proyect';
$string['admin'] = 'Administrator';
$string['alphaorder'] = 'Alphabetical order :';

$string['ar'] = 'árabic';
$string['asc'] = 'Date ASC';
$string['author'] = 'Author/s';
$string['audio'] = 'Audio';
$string['audio_video'] = 'Audio language of the video';
$string['be'] = 'Institution/s';
$string['belongto'] = 'Belongs to';
$string['buttonaddau'] = 'Add author';
$string['buttonaddaudio'] = 'Add audio';
$string['buttonaddbe'] = 'Add institution';
$string['buttonadddom'] = 'Add domain';
$string['buttonaddim'] = 'Add image';
$string['buttonaddrt'] = 'Add related term';
$string['buttonaddcr'] = 'Add cross related term';
$string['buttonaddlang'] = 'Add language';
$string['buttonaddty'] = 'Add proyect';
$string['buttonaddsubdom'] = 'Add subdomain';
$string['buttonaddsyn'] = 'Add synonym';
$string['buttonaddvi'] = 'Add video';
$string['buttongeneralsearch'] = 'General search';
$string['cancel'] = 'Cancel';
$string['cards'] = 'Cards';
$string['category'] = 'Category';
$string['chooselang'] = 'choose language:';
$string['commonheaderdata'] = 'Data common to the languages of the terminological tab';
$string['context'] = 'Context';
$string['continue'] = 'Continue';
$string['criteria'] = 'Criteria';
//---añadido---
$string['crossrelatedterms'] = 'Crossrelated terms';
$string['crosstermsentence'] = 'This term also appears in the next entries';
$string['datecreated'] = 'Creation / modification date';
$string['indexuse'] = ' Use this index to sort the cards according to date of creation/update or alphabetically choosing the language:';
$string['datemodified'] = 'Date of update';
$string['date'] = 'Date :';
//---añadido---
$string['de'] = 'German :';
$string['definition'] = 'Definition';
$string['delete'] = 'Delete';
$string['deleteau'] = 'Delete Audio';
$string['deleteausure'] = ' Are you sure to delete the audio?';
$string['deleteauused'] = 'Author cannot be deleted. Entry is being used by a terminological card.';
$string['deleteauthor'] = 'Delete author';
$string['deleteauthorused'] = 'The author cannot be deleted because it is being used in the dictionary';
$string['deleteaunok'] = 'Error failure when trying to delete an author';
$string['deleteauok'] = 'Author successfully delete ';
$string['deleteauthorsure'] = 'Are you sure to delete the author?';
$string['deletebe'] = 'Delete institution';
$string['deletebeused'] = 'Institution can not be deleted. Entry is being used by a terminological card.';
$string['deletebenok'] = 'Error failure when trying to delete an institution';
$string['deletebeok'] = 'Institution successfully deleted ';
$string['deletebesure'] = ' Are you sure to delete the institution?';
$string['deleteremission'] = 'Delete referral';    
$string['deletesynsure'] = ' Are you sure to delete the synonym?';
$string['deletecard'] = 'Delete terminological card';
$string['deletecardsure'] = ' Are you sure to delete the terminological card ?';
$string['deletedomused'] = 'Domain can not be deleted. Entry is being used by a terminological card.';
$string['deletedom'] = 'Delete domain';
$string['deletedomparent'] = 'Subdomain can not be deleted; contains child subdomains';

$string['deleteim'] = 'Delete image';
$string['deletevi'] = 'Delete video';
$string['deleteimnok'] = 'Error failure when trying to delete the image';
$string['deleteaunok'] = 'Error failure when trying to delete the audio';
$string['deleteimok'] = 'Image successfully deleted ';
$string['deletelangok'] = 'Language successfully deleted';
$string['deletelangnok'] = 'Error failure when trying to delete the language';
$string['deleteaudiook'] = 'Audio successfully deleted';
$string['deletevinok'] = 'Error failure when trying to delete the video';
$string['deleteviok'] = 'Video successfully deleted ';
$string['deleteauused'] = 'Audio can not be deleted. Entry is being used by a terminological card.';
$string['deleteimused'] = 'Image can not be deleted. Entry is being used by a terminological card.';
$string['deletelangused'] = 'Language can not be deleted. Entry is being used by a terminological card.';
$string['deleteviused'] = 'Video can not be deleted. Entry is being used by a terminological card.';
$string['deletedomsdnok'] = 'Error failure when trying to delete the subdomain';
$string['deletedomsdok'] = 'Subdomain successfully deleted ';
$string['deletedomsdsure'] = ' Are you sure to delete the subdomain ?';

$string['deletenok'] = 'Error failure when trying to delete the terminological card';
$string['deletelangsure'] = ' Are you sure to delete the language ?';
$string['deleteok'] = 'Terminological card successfully deleted ';
$string['deletert']='Delete related term';
$string['deletecr']='Delete crossrelated term';
$string['deletertnok'] = 'Error failure when trying to delete the related term';
$string['deletertok'] = 'Related term successfully deleted ';
$string['deletecrok'] = 'Crossrelated term successfully deleted ';
$string['deletertsure'] = ' Are you sure to delete the related term ?';
$string['deletecrsure'] = ' Are you sure to delete the crossrelated term ?';
$string['deletertused'] = 'Delete related term ';
$string['deletecrused'] = 'Delete crossrelated term';
$string['deletesubdom'] = 'Delete subdomain';
$string['deletesubdomused'] = 'Subdomain can not be deleted. Entry is being used by a terminological card.';
$string['deletesynonym']='Delete synonym';
$string['deletety'] = 'Delete proyect';
$string['deletetyused'] = 'Proyect can not be deleted. Entry is being used by a terminological card.';
$string['deletesynused'] = 'Synonym can not be deleted. Entry is being used by a terminological card.';
$string['deletesynnok'] = 'Error failure when trying to delete the synonym';
$string['deletesynok'] = 'Synonym successfully deleted ';
$string['deletetynok'] = 'Error failure when trying to delete the proyect';
$string['deletecrnok'] = 'Error failure when trying to delete the crossrelated term';
$string['deletetyok'] = 'Proyect successfully deleted ';
$string['deletetysure'] = ' Are you sure to delete proyect?';
$string['deleteimsure'] = ' Are you sure to delete the image ?';
$string['deletevisure'] = ' Are you sure to delete the video ?';
$string['desc'] = 'Date DESC';
$string['description'] = 'Description';
$string['detail'] = 'Show details';
$string['dom'] = 'Domain';
$string['subdomview'] = 'Hierarchical view of the subdomains:';
$string['edit'] = 'Edit';
$string['editau'] = 'Edit audio';
$string['editauthor'] = 'Edit author';
$string['editbe'] = 'Edit institution';
$string['editcard'] = 'Edit terminological card';
$string['editdom'] = 'Edit domain';


$string['editim'] = 'Edit image';
$string['editsyn'] = 'Edit synonym';
$string['editvi'] = 'Edit video';
$string['editrt'] = 'Edit related term';
$string['editcr'] = 'Edit cross related term';
$string['editsubdom'] = 'Edit subdomain';
$string['editty'] = 'Edit proyect';
$string['emptyfield'] = 'Required field empty. Check previous data';
$string['emptyfieldterm'] = ' Field empty. Enter the term you want to search.';
$string['emptyfieldauthor'] = ' Field empty. Enter the author you want to search.';
$string['emptyfielddom'] = ' Field empty. Enter the domain you want to search.';
$string['emptyfieldgramcat'] = ' Field empty. Select a gramatical category.';
$string['emptyfieldheader'] = 'Required field empty not selected. Review data common  to the languages of the terminological tab';
$string['emptyfieldisolang'] = ' Field empty. Select the language of the search';
$string['emptyfieldlanguage'] = 'Required language field empty. Review data common  to the term.';
$string['emptysearchtype'] = 'You must select a criteria search and fill';

$string['en'] = 'English :';
$string['errordb'] = 'Error failure when trying to select tha databases of the activity. Try again.';
$string['errorvideoextension'] = "Incorrect file type or size. <br><br><table><tr><td><li>Files .wav o .avi o .wmv are allowed<br><li>100 MB max file sizes are allowed.</td></tr></table>";
$string['es'] = 'Spanish :';
$string['expression'] = 'expression';
$string['errextensionimage']="The extension or the size of the file is not correct. <br><br><table><tr><td><li>Extensions allowed: .gif o .jpg<br><li>The maximum allowed size is 100 MB.</td></tr></table>";
$string['errnameimageexists'] = 'The name of the file exists.<br><br><table><tr><td><li>It is not allowed to upload two files with the same name in the same course.</td></tr></table>';
$string['errnamevideoexists'] = 'The name of the file exists.<br><br><table><tr><td><li>It is not allowed to upload two files with the same name in the same course.</td></tr></table>';
$string['fileuploadcorrect']='The file has been uploaded correctly.';
$string['footsentences'] = 'With the collaboration of the Ministry of Education of the Junta de Castilla y León';
$string['fr'] = 'French :';
$string['genetic'] = 'Genetic';
$string['gramcat'] = 'Gramatical category';
$string['guest'] = 'Guest';
$string['imagenes'] = 'Images :';
$string['insertaunok'] = 'Error failure when trying to insert the author';
$string['insertauok'] = 'Author successfully inserted ';
$string['insertaudiook'] = 'Audio successfully inserted';
$string['insertaudionok'] = 'Error failure when trying to insert the audio';
$string['insertbenok'] = 'Error failure when trying to insert the institution';
$string['insertbeok'] = 'Institution successfully inserted ';
$string['insertdomsdnok'] = 'Error failure when trying to insert the subdomain';
$string['insertdomsdok'] = 'Subdomain successfully inserted ';
$string['insertlangok'] = 'Language successfully inserted ';
$string['insertdomsexist'] = 'Error insertion. Subdomain already exists';
$string['insertauexist'] = 'Error insertion. Filename of the audio already exists';
$string['insertimexist'] = 'Error insertion. Filename of the image already exists';
$string['insertviexist'] = 'Error insertion. Filename of the video already exists';
$string['insertimnok'] = 'Error failure when trying to insert the image';
$string['insertimok'] = ' Image successfully inserted ';
$string['insertvinok'] = 'Error failure when trying to insert the video';
$string['insertviok'] = ' Video successfully inserted ';
$string['insertnok'] = ' Error failure when trying to insert the terminological card';
$string['insertok'] = ' Terminological card successfull inserted y';
$string['insertrtnok'] = 'Error failure when trying to insert the related term';
$string['insertcrnok'] = 'Error failure when trying to insert the crossrelated term';
$string['insertcrused'] = 'Error failure. Crossrelated term already exists in this language';
$string['insertrtok'] = 'Related term successfully inserted ';
$string['insertrtused'] = 'Error failure. Related term already exists in this language';
$string['insertcrok'] = 'Crossrelated term successfully inserted ';
$string['insertsynok'] = 'Synonym successfully inserted';
$string['insertsynnok'] = 'Error failure when trying to insert the synonym';
$string['insertsynused'] = 'Error failure. Synonym already exists in this language';
$string['inserttynok'] = ' Error failure when trying to insert the proyect';
$string['inserttyok'] = 'Proyect successfully inserted';
$string['labelspecial'] = 'Shows the card whose term do not begin with a letter';
//---añadido---
$string['lang'] = 'Language';
$string['langdicexist'] = 'already exists in the diccionary';
$string['languagecarddata'] = 'Particulars of each language of a terminological card';
$string['link'] = 'Link';
$string['linksubd'] = 'Click on each subdomain to link the topic browser of Eurogene.';
$string['maximumchars'] = 'Maximum number of characters';
$string['modau'] = 'Modify audio';
$string['modimagen'] = 'Modify image';
$string['name'] = 'Name';
$string['nameexists'] = 'The name already exists';
$string['newsearch'] = 'New search';
$string['ni'] = 'Identification number';
$string['noaudiofound'] = 'No audio files were found for this language';
$string['nodefined'] = 'No defined';
$string['nodescrlang'] = 'No description available';
$string['noentries'] = 'No terminological cards were found';
$string['noentriesterm'] = 'No terms available in this language';
$string['noexistauthor'] = 'The author were not found in the databases';
$string['noinsertlangdic'] = 'Language not inserted in the dictionary.';
$string['nolang'] = 'No languages incluided in the dictionary.';
$string['noresultauthor'] = 'No matches for this author';
$string['noresultdom'] = 'Terminological cards were not found in the selected domain.';
$string['noresultgeneral'] = 'No matches were found for the terminological cards.';
$string['noresultgramcat'] = 'Terminological cards were not found in the selected gramatical category .';
$string['noresultisolang'] = 'Terminological cards were not found in the selected language.';
$string['noresultterm'] = 'No matches for this term';
$string['nosources'] = 'No Sources were found for this term';
$string['nosrcimage'] = 'No Sources were found for this image';
$string['nosrcvideo'] = 'No Sources were found for this video';
$string['notermsadded'] = 'No terms have been added in any language';
$string['notes'] = 'Notes';
$string['nummatch'] = 'Number of matches';
//----añadido---
$string['pieimagen'] = 'Image description';
$string['pieimagen_fr'] = 'Image description(fr)';
$string['pieimagen_en'] = 'Image description(en)';
$string['pieimagen_de'] = 'Image description(de)';
$string['pievideo'] = 'Video description';
$string['pievideo_fr'] = 'Video description(fr)';
$string['pievideo_en'] = 'Video description(en)';
$string['pievideo_de'] = 'Video description(de)';
$string['reference'] = 'Remissions';
//---añadido---
$string['relatedterms'] = 'Related terms';
$string['reliabilitycode'] = 'Reliability code';
$string['requiredfields'] = '(*) Required fields. Not necessary fill all the languages terms';
$string['resultsearch'] = 'Search result';
$string['rv'] = 'Remissions';
$string['save'] = 'Save';
$string['search'] = 'Search';
$string['searchauthor'] = 'Author search';
$string['searchcard'] = 'Search terminological card';
$string['searchcards'] = 'Search cards';
$string['searchdom'] = 'Subdomain search';
$string['searchlanguage'] = 'Language search';
$string['searchproyect'] = 'Proyect search';
$string['searchterm'] = 'Term search';
$string['searchtopdf'] = 'PDF result search';
$string['searchword'] = 'Entered word/s';
$string['seealso'] = 'See also:';
//--a�adido--
$string['selimagen'] = 'Add image';
$string['selvideo'] = 'Add video';
$string['seltypesearch'] = 'Select the criteria search and fill in the box';
$string['setlang'] = 'Languages settings';
$string['showauthors'] = 'Manage authors';
$string['showaudio'] = 'Manage audios';
$string['showbe'] = 'Show institutions';
$string['showcards'] = 'Show cards';
$string['showcr'] = 'Show crossrelated terms';
$string['showimagen'] = 'Manage images';
$string['showlang'] = 'Manage languages';
$string['showsubdom'] = 'Show domains';
$string['showsubdoms'] = 'Manage subdomains';
$string['showrt'] = 'Show related terms';
$string['showty'] = 'Show proyects';
$string['showsyn'] = 'Show synonyms';
$string['showvideo'] = 'Manage videos';

//---a�adido---
$string['showim'] = 'Show images';
$string['showvi'] = 'Show videos';
$string['showau'] = 'Audio';
$string['siglas'] = 'Acronyms';
$string['sources'] = 'Sources';

$string['src'] = 'Source:';
$string['src_image'] = 'Image sources';

$string['src_video'] = 'Video sources';
$string['student'] = 'Student';
$string['subdom'] = 'Subdomains';
$string['subdomain'] = 'Subdomain';
$string['surname'] = 'Last names';

$string['synonym'] = 'Synonyms :';
$string['synonymm'] = 'Synonym';



$string['symbols'] = 'Simbols';
$string['teacher'] = 'Teacher';
$string['term'] = 'Term';
$string['termnoexists'] = 'No term exists with this name';
$string['termnoexistslang'] = 'No term in this language available in the diccionary';

$string['term_already_exists'] = 'Term already exists. Are you sure to add a new one?';

$string['title_image'] = 'Image title';
$string['title_video'] = 'Video title';

$string['ty'] = 'Project';
$string['updateaudionok'] = 'Error failure when trying to update the audio';
$string['updateaudiook'] = 'Audio succesfully updated';
$string['updateaunok'] = 'Error failure when trying to update the author';
$string['updateauok'] = 'Author succesfully updated ';
$string['updatebenok'] = 'Error failure when trying to update the institution';
$string['updatebeok'] = 'Institution succesfully updated ';
$string['updatesynnok'] = 'Error failure when trying to update the synonym';
$string['updatesynok'] = 'Synonym succesfully updated ';
$string['updatedomsdnok'] = 'Error failure when trying to update the subdomain';
$string['updatedomsdok'] = 'Subdomain succesfully updated ';
$string['updateimok'] = 'Image succesfully updated ';
$string['updateimnok'] = 'Error failure when trying to update the image';
$string['updateviok'] = 'Video succesfully updated';
$string['updatevinok'] = 'Error failure when trying to update the video';
$string['updatenok'] = 'Error failure when trying to update the terminological card';

$string['updateok'] = 'Terminological card succesfully updated';
$string['updatertnok'] = 'Error failure when trying to update the related term';
$string['updatecrnok'] = 'Error failure when trying to update the crossrelated term';
$string['updatertok'] = 'Related term succesfully updated';
$string['updatecrok'] = 'Crossrelated term succesfully updated';
$string['updatetynok'] = 'Error failure when trying to update the proyect';
$string['updatetyok'] = 'Prooyect succesfully updated';
$string['usernotable'] = 'Error, You do not have access to the activity.';
$string['f'] = 'Female';
$string['m'] = 'Male';
$string['adj'] = 'Adjective';
$string['adv'] = 'Adverb';
$string['vtr'] = ' Transitive verb';
$string['vintr'] = ' Intransitive verb';
$string['videos'] = 'Videos:';
$string['viewfullcard'] = 'View full card';
$string['viewlang'] = 'See languages';

//Remisiones
$string['rem'] = 'Referrals';
$string['sin'] = 'Synonym';
$string['fv'] = 'Formal variant';
$string['acr'] = 'Acronym';
$string['abr'] = 'Abbreviation';
$string['abrform'] = 'Abbreviation form';
$string['sci_na'] = 'Scientific name';
$string['sim'] = 'Symbol';
$string['diat_var'] = 'Variant diatopical';
$string['diaf_var'] = 'Variant diaphasic';
$string['hiper'] = 'Hypernym';
$string['hipo'] = 'Hyponym';
$string['cohipo'] = 'Cohyponymo';
$string['anton'] = 'Antonym';
$string['reject_form'] = 'Rejectable form';
$string['obs'] = 'Obsolete term';
//marca de ponderacion
$string['wm'] = 'Weighting mark';
$string['nor'] = 'Normative term';
$string['neo'] = 'Neologism pending approval';
$string['pen'] = 'Term pending further research';
$string['reject'] = 'Unacceptable term';



$string['modulename'] = 'Eurogen dictionary';
$string['modulenameplural'] = 'Eurogen dictionaries';

//$string['newmodulefieldset'] = 'Custom example fieldset';
//$string['newmoduleintro'] = 'newmodule Intro';
//$string['newmodulename'] = 'newmodule Name';

?>
