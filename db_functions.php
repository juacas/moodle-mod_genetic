<?PHP  // $Id: db_functions.php,v 1.0 2012/06/27 17:50:00 Ana Maria Lozano de la Fuente Exp $
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

// Connect to the database
function connect_genetic($host, $user, $pass, $name)
{

	$link=mysql_pconnect($host,$user,$pass);		//Connect to the db server
	if(!$link)
	{
		$errconnect = get_string('errorconnect', 'genetic');
		error("$errconnect"); 
	} 
	
	
	$seldb=mysql_select_db($name);		//Choose the activity db
	if(!$seldb)
	{
		$errdb = get_string('errordb', 'genetic');
		error("$errdb"); 
	}
	
	return $link;
}

/**********
COUNTS
************/

// Count the languages of the dictionary
function genetic_count_lang($geneticid) {
	global $CFG;
	$query = "SELECT * 
	FROM {$CFG->prefix}genetic_lang_has_genetic
	WHERE genetic_id='$geneticid'";
	return $query;
}

// take the id of the languages of the dictionary
function genetic_id_lang($geneticid) {
	global $CFG;
	$query = "SELECT genetic_lang_id
	FROM {$CFG->prefix}genetic_lang_has_genetic
	WHERE genetic_id='$geneticid'";
	return $query;
}
/*********
  QUERIES
 *********/

// Show headercards fields
function genetic_show_headers($geneticid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
 		 WHERE id_genetic = '$geneticid'
		 ORDER BY id ASC";
	return $query;
}

// Show idtypes
function genetic_show_idtypes($geneticid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
 		 WHERE id_genetic = '$geneticid'
		 ORDER BY id ASC";
	return $query;
}
// Show types
function genetic_show_types() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_ty
		 ORDER BY id ASC";
	return $query;
}

// Show all the terms order by alphabetic ---a�adido---

function genetic_show_headers_order2($geneticid,$langname) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_headercards.*
		 FROM {$CFG->prefix}genetic_headercards,{$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_headercards.id_genetic='$geneticid' 
		 AND {$CFG->prefix}genetic_headercards.id={$CFG->prefix}genetic_cards.idheader 
		 AND {$CFG->prefix}genetic_cards.isolang='$langname'
		 AND {$CFG->prefix}genetic_cards.term !=''
		 ORDER BY {$CFG->prefix}genetic_cards.term ASC";
	return $query;
}
//Language exists in the DB
function genetic_exist_lang($langtype) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_lang
		  WHERE language='$langtype'";
	return $query;
}
//exist the language in the diccionary?
function genetic_exist_lang_dic($idlang,$idgenetic) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_lang_has_genetic
		  WHERE genetic_lang_id='$idlang'
		  AND genetic_id='$idgenetic'";
	return $query;
}
//get the isolang from id
function genetic_get_isolang($idlang) {
	global $CFG;
	$query = "SELECT language
	FROM {$CFG->prefix}genetic_lang
	WHERE id='$idlang'";
	return $query;
}
//
function genetic_show_headers_term_exist($geneticid,$langname) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_cards.term
		 FROM {$CFG->prefix}genetic_headercards,{$CFG->prefix}genetic_cards
		  WHERE {$CFG->prefix}genetic_headercards.id={$CFG->prefix}genetic_cards.idheader
		 AND {$CFG->prefix}genetic_headercards.id_genetic='$geneticid' 
		 AND {$CFG->prefix}genetic_cards.isolang='$langname'";
	return $query;
}

//ordenar las fichas segun su fecha de creaci�n si el orden es ASC o DESC
function genetic_show_headers_order($geneticid,$order) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_headercards
 		 WHERE id_genetic = '$geneticid'
		 ORDER BY datecreated $order";
	return $query;
}
// Show all the languages order by name ---a�adido---
function genetic_show_lang() {
	global $CFG;
	$query = "SELECT DISTINCT isolang
		 FROM {$CFG->prefix}genetic_cards
		 ORDER BY isolang ASC";
	return $query;
}
// Show all the languages order by name ---a�adido---
function genetic_show_lang_dic($idgenetic) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_lang_has_genetic
		 WHERE genetic_id='$idgenetic'
		 ORDER BY genetic_lang_id ASC";
	return $query;
}
// Show all the cards fields whose header id is this 
function genetic_show_cards($headerid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idheader = '$headerid'
		 ORDER BY isolang ASC";
	return $query;
}
// Show all the cards fields whose header id is this 
function genetic_show_cards_dic($headerid,$idgenetic) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idheader = '$headerid'
		 AND idgenetic='$idgenetic'
		 ORDER BY isolang ASC";
	return $query;
}
// Show all the cards fields whose header id is this 
function genetic_show_cards_gram($headerid,$gramcat) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idheader = '$headerid'
		 AND gramcat='$gramcat'
		 ORDER BY isolang ASC";
	return $query;
}
//Show the card of a headerid corresponding to a language
function genetic_show_cards2($headerid,$langname) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idheader = '$headerid' AND isolang='$langname'
		 ORDER BY term ASC";
		 
	return $query;
}

//----a�adido---
function genetic_show_images($headerrowni){
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_images.*
		 FROM  {$CFG->prefix}genetic_images_has_genetic_cards, {$CFG->prefix}genetic_images
		 WHERE {$CFG->prefix}genetic_images_has_genetic_cards.genetic_images_id={$CFG->prefix}genetic_images.id 
		 AND {$CFG->prefix}genetic_images_has_genetic_cards.genetic_headercards_id= '$headerrowni'";
	return $query;

}

//function to check if an imagen is included in a header.
function genetic_imagen_used($idim){
	global $CFG;
	$query = "SELECT * FROM {$CFG->prefix}genetic_images_has_genetic_cards WHERE genetic_images_id='$idim'";
	return $query;
	
}

// function that gets the images for a headercard
function genetic_get_images_header($headercardid,$imageid){
	global $CFG;
	$query = "SELECT * from {$CFG->prefix}genetic_images_has_genetic_cards
	WHERE genetic_images_id='$imageid' and genetic_headercards_id='$headercardid'";
	return $query;
}


//----a�adido---
function genetic_show_videos($cardrowid){
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_videos.*  
		 FROM {$CFG->prefix}genetic_videos_has_genetic_cards, {$CFG->prefix}genetic_videos
		 WHERE {$CFG->prefix}genetic_videos_has_genetic_cards.genetic_videos_id={$CFG->prefix}genetic_videos.id 
		 AND {$CFG->prefix}genetic_videos_has_genetic_cards.genetic_cards_id= '$cardrowid'";
	return $query;

}

//function to check if a video is included in a card.
function genetic_video_used($idvi){
	global $CFG;
	$query = "SELECT * FROM {$CFG->prefix}genetic_videos_has_genetic_cards WHERE genetic_videos_id='$idvi'";
	return $query;

}
//----a�adido---
function genetic_show_remissions($cardrowid){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission
		 WHERE idcard= '$cardrowid'";
	return $query;

}
//----a�adido---
function genetic_show_remissions_dist($cardrowid){
	global $CFG;
	$query = "SELECT DISTINCT rem_type 
		 FROM {$CFG->prefix}genetic_remission
		 WHERE idcard= '$cardrowid'";
	return $query;

}
//----a�adido---
function genetic_show_remissions_name($cardrowref,$cardrowid){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission
		 WHERE rem_type= '$cardrowref'
		 AND idcard='$cardrowid'";
	return $query;

}

//----a�adido---
function genetic_show_synonims($cardrowid_remissions,$cardrowid){
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_synonyms.* 
		 FROM {$CFG->prefix}genetic_synonyms, {$CFG->prefix}genetic_synonyms_has_genetic_remission,{$CFG->prefix}genetic_remission,{$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_synonyms_has_genetic_remission.genetic_synonyms_id={$CFG->prefix}genetic_synonyms.id
		 AND {$CFG->prefix}genetic_synonyms_has_genetic_remission.genetic_remission_id= '$cardrowid_remissions' 
		 AND {$CFG->prefix}genetic_remission.idcard={$CFG->prefix}genetic_cards.id
		 AND {$CFG->prefix}genetic_cards.id='$cardrowid'";
	return $query;

}
//----a�adido---
function genetic_show_relatedterms($cardrowid_remissions,$cardrowid){
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_relatedterms.* 
		 FROM {$CFG->prefix}genetic_relatedterms, {$CFG->prefix}genetic_remission_has_genetic_relatedterms,{$CFG->prefix}genetic_remission,{$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_remission_has_genetic_relatedterms.genetic_relatedterms_id={$CFG->prefix}genetic_relatedterms.id
		 AND {$CFG->prefix}genetic_remission_has_genetic_relatedterms.genetic_remission_id= '$cardrowid_remissions'
		 AND {$CFG->prefix}genetic_remission.idcard={$CFG->prefix}genetic_cards.id
		 AND {$CFG->prefix}genetic_cards.id='$cardrowid'";
	return $query;

}
//----a�adido---
function genetic_show_crossrelations($cardrowidremissions,$cardrowid){
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_crossrelations.* 
		 FROM {$CFG->prefix}genetic_crossrelations, {$CFG->prefix}genetic_remission_has_genetic_crossrelations,{$CFG->prefix}genetic_remission,{$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_remission_has_genetic_crossrelations.genetic_crossrelations_id= {$CFG->prefix}genetic_crossrelations.id
		 AND {$CFG->prefix}genetic_remission_has_genetic_crossrelations.genetic_remission_id= '$cardrowidremissions'
		 AND {$CFG->prefix}genetic_remission.idcard={$CFG->prefix}genetic_cards.id
		 AND {$CFG->prefix}genetic_cards.id='$cardrowid'";
	return $query;

}

//----a�adido---
function genetic_show_terms($idgenetic){
	global $CFG;
	
	$query = "SELECT * 
			FROM {$CFG->prefix}genetic_cards
			WHERE idgenetic LIKE '%$idgenetic%'
			";
	return $query;

}
//----a�adido---
function genetic_show_crossrelations2($cardrowterm){
	global $CFG;
	
	$query = "SELECT * 
			FROM {$CFG->prefix}genetic_cards
			WHERE definition LIKE '%$cardrowterm%'
			";
	return $query;

}
//---a�adido--- para ver si existe el termino antes de introducirlo
function genetic_term_exists($term,$idgenetic){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE term= '$term'
		 AND idgenetic='$idgenetic'";
	return $query;

}
// Function that checks if the term exists in that language 
function genetic_term_exists_inlang($term,$idgenetic, $isolang){
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_cards
	WHERE term= '$term' AND isolang='$isolang' 
	AND idgenetic='$idgenetic'";
	return $query;

}
// Function that checks if the term exists in that language but it is not the own card
function genetic_term_exists_inlang2($term,$idgenetic, $isolang,$idheadercard){
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_cards
	WHERE term= '$term' AND isolang='$isolang'
	AND idgenetic='$idgenetic' AND idheader<>'$idheadercard'";
	return $query;

}
//---a�adido--- para ver si existe el termino antes de introducirlo
function genetic_subdomain_exists($name){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_subdomains
		 WHERE name LIKE '%$name%'";
	return $query;

}
//---a�adido--- para ver si existe el sinonimo antes de introducirlo
function genetic_synonym_exists($name, $lang){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 WHERE name='$name'
		 AND synlink='$lang'";
	return $query;

}
//---a�adido--- para ver si existe el termino relacionado antes de introducirlo
function genetic_related_exists($name, $lang){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		 WHERE name='$name'
		 AND rellink='$lang'";
	return $query;

}

//---a�adido--- para ver si existe el termino cruzado antes de introducirlo
function genetic_crossrelated_exists($name, $lang){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_crossrelations
		 WHERE name='$name'
		 AND crosslink='$lang'";
	return $query;

}
//---a�adido---
function genetic_dom_null(){
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_subdomains";
	return $query;
}

// Show all the sources fields whose card id is this
function genetic_show_sources($cardid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_sources
		 WHERE idcard = '$cardid'";
	return $query;
}


//Show AN headercard to edit it
function genetic_choose_header($headerid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
 		 WHERE id = '$headerid'";
	return $query;
}


// Show domains
function genetic_show_domains() {
	global $CFG;
	$query = "SELECT * 
		FROM {$CFG->prefix}genetic_domains
		 ORDER BY name ASC";
	return $query;
}


// Show subdomains
function genetic_show_subdomains() {
	global $CFG;
	$query = "SELECT * 
		FROM {$CFG->prefix}genetic_subdomains
		 ORDER BY name ASC";
	return $query;
}


// Show A domain
function genetic_choose_domain($did) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_domains
		 WHERE id='$did'";
	return $query;
}


// Show A subdomain
function genetic_choose_subdomain($sdid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_subdomains
		 WHERE id='$sdid'";
	return $query;
}


// Show subdomains that depends on a domain
function genetic_father_subdomains($did) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_subdomains
		 WHERE iddom='$did'";
	return $query;
}


// Show the id of the last header
function genetic_show_lastheader() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 ORDER BY id DESC LIMIT 1";
	return $query;
}


// Show the id of the last card
function genetic_show_lastcard() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last image
function genetic_show_lastimage() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last video
function genetic_show_lastvideo() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last video
function genetic_show_lastaudio() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_audio
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last remission
function genetic_show_last_remission() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last synonym
function genetic_show_last_synonym() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 ORDER BY id DESC LIMIT 1";
	return $query;
}
// ----a�adido----Show the id of the last relatedterm
function genetic_show_last_relatedterm() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		 ORDER BY id DESC LIMIT 1";
	return $query;
}

// Show all the authors
function genetic_show_authors() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_authors
		 ORDER BY name ASC";
	return $query;
}
// Show all the authors
function genetic_show_synonyms($lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 WHERE synlink='$lang'
		 ORDER BY name ASC";
	return $query;
}

// Show all the authors
function genetic_show_related($lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		 WHERE rellink='$lang'
		 ORDER BY name ASC";
	return $query;
}
// Show all the authors
function genetic_show_related2() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		
		 ORDER BY name ASC";
	return $query;
}
// Show all the authors
function genetic_show_crossrelated($lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_crossrelations
		 WHERE crosslink='$lang'
		 ORDER BY name ASC";
	return $query;
}

// -----a�adido---Show all the images
function genetic_show_idsyn($synonym) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 WHERE {$CFG->prefix}genetic_synonyms.name='$synonym'
		 ORDER BY id ASC";
	return $query;
}

// -----a�adido---Show all the images
function genetic_show_img() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images
		 ORDER BY fileimage ASC";
	return $query;
}

// -----a�adido---Show all the images
function genetic_show_im() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images
		 ORDER BY fileimage ASC";
	return $query;
}
// -----a�adido---Show all the images
function genetic_show_vi() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos
		 ORDER BY filevideo ASC";
	return $query;
}
// -----a�adido---Show all the audio files 
function genetic_show_au($lang) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_audio.* 
		 FROM {$CFG->prefix}genetic_audio, {$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_audio.idcard={$CFG->prefix}genetic_cards.id
		 AND {$CFG->prefix}genetic_cards.isolang='$lang'
		";
	return $query;
}

function genetic_show_au_lang($lang) {
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_audio 
	WHERE lang='$lang'
	";
	return $query;
}

function genetic_show_audio($cardrowid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards_has_genetic_audio
		 WHERE {$CFG->prefix}genetic_cards_has_genetic_audio.genetic_cards_id='$cardrowid'";
	return $query;
}

// to check if an audio is included in a card
function genetic_audio_used($idau){
	global $CFG;
	$query = "SELECT * FROM {$CFG->prefix}genetic_cards_has_genetic_audio WHERE genetic_audio_id='$idau'";
	return $query;

}

function genetic_is_audio_incard($cardrowid,$audioid) {
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_cards_has_genetic_audio
	WHERE {$CFG->prefix}genetic_cards_has_genetic_audio.genetic_cards_id='$cardrowid' AND {$CFG->prefix}genetic_cards_has_genetic_audio.genetic_audio_id='$audioid'";
	return $query;
}

function genetic_is_video_incard($cardrowid,$videoid) {
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_videos_has_genetic_cards
	WHERE genetic_cards_id='$cardrowid' AND genetic_videos_id='$videoid'";
	return $query;
}
//show all audio files in a language

function genetic_show_audio_files($lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_audio
		 WHERE {$CFG->prefix}genetic_audio.lang='$lang'";
	return $query;
}

//show audio
function genetic_show_audio_id($id) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_audio
		 WHERE {$CFG->prefix}genetic_audio.id='$id'";
	return $query;
}
// Show all the authors
function genetic_show_vid() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos
		 ORDER BY filevideo ASC";
	return $query;
}
// Show AN author
function genetic_choose_author($idauthor) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_authors
		 WHERE id='$idauthor'";
	return $query;
}


// Show author from relation header-author
function genetic_show_rel_author($ni) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_authors.*
		 FROM {$CFG->prefix}genetic_authors, {$CFG->prefix}genetic_rel_headerauthor
		 WHERE {$CFG->prefix}genetic_rel_headerauthor.idheadercard='$ni'
		 AND {$CFG->prefix}genetic_authors.id={$CFG->prefix}genetic_rel_headerauthor.idauthor";
	return $query;
}

// Show author from relation header-author
function genetic_show_rel_subdomain($ni) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_subdomains.*
		 FROM {$CFG->prefix}genetic_subdomains, {$CFG->prefix}genetic_headercards_has_genetic_subdomains
		 WHERE {$CFG->prefix}genetic_headercards_has_genetic_subdomains.genetic_headercards_id='$ni'
		 AND {$CFG->prefix}genetic_subdomains.id={$CFG->prefix}genetic_headercards_has_genetic_subdomains.genetic_subdomains_id";
	return $query;
}
// Show all the departments
function genetic_show_be() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_be
		 ORDER BY name ASC";
	return $query;
}

// Check if a department name already exists
function genetic_checkname_be($name) {
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_be
	where name='$name'";
	return $query;
}

function genetic_checkname_ty($name) {
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_ty
	where name='$name'";
	return $query;
}
function genetic_checkname_author($name,$surname){
	global $CFG;
	$query = "SELECT *
	FROM {$CFG->prefix}genetic_authors
	where name='$name' and surname='$surname'";
	return $query;
}

// Show all the synonyms
function genetic_show_syn() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 ORDER BY name ASC";
	return $query;
}
// Show all the related terms
function genetic_show_rt() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		 ORDER BY name ASC";
	return $query;
}
// Show all the crossrelations
function genetic_show_cr() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_crossrelations
		 ORDER BY name ASC";
	return $query;
}
// Show A department
function genetic_choose_be($be) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_be
		 WHERE id='$be'";
	return $query;
}
// ----a�adido----Show A synonym
function genetic_choose_syn($idsyn) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms
		 WHERE id='$idsyn'";
	return $query;
}
// ----a�adido----Show A synonym
function genetic_choose_rt($idrt) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms
		 WHERE id='$idrt'";
	return $query;
}

// ----a�adido----Show A synonym
function genetic_choose_cr($idcr) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_crossrelations
		 WHERE id='$idcr'";
	return $query;
}
// Show be from relation header-be
function genetic_show_rel_be($ni) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_be.*
		 FROM {$CFG->prefix}genetic_be, {$CFG->prefix}genetic_rel_headerbe
		 WHERE {$CFG->prefix}genetic_rel_headerbe.idheadercard='$ni'
		 AND {$CFG->prefix}genetic_be.id={$CFG->prefix}genetic_rel_headerbe.idbe";
	return $query;
}

// show if the headercard has that be (institution) asssigned
function genetic_header_has_be($idheadercard,$idbe) {
	global $CFG;
	$query = "SELECT * from {$CFG->prefix}genetic_rel_headerbe
	WHERE {$CFG->prefix}genetic_rel_headerbe.idheadercard='$idheadercard'
	AND {$CFG->prefix}genetic_rel_headerbe.idbe='$idbe'";
	return $query;
}

// Show be from relation header-be
function genetic_show_rel_syn($ni) {
	global $CFG;
	$query = "SELECT {$CFG->prefix}genetic_synonyms.*
		 FROM {$CFG->prefix}genetic_synonyms, {$CFG->prefix}genetic_synonyms_has_genetic_remission
		 WHERE {$CFG->prefix}genetic_synonyms_has_genetic_remission.genetic_remission_id='$ni'
		 AND {$CFG->prefix}genetic_synonyms.id={$CFG->prefix}genetic_synonyms_has_genetic_remission.genetic_synonyms_id";
	return $query;
}

// Show all the types
function genetic_show_ty() {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_ty
		 ORDER BY name ASC";
	return $query;
}


// Show A type
function genetic_choose_ty($ty) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_ty
		 WHERE id='$ty'";
	return $query;
}
// gets the id of the ty (project) of the headercard
function get_ty_headercard($headercardid,$idty){
	global $CFG;
	$query = "SELECT * FROM {$CFG->prefix}genetic_headercards where id_genetic='$headercardid' and ty='$idty'";
	return $query;
}
// Show A lang
function genetic_choose_lang($lang) {
	global $CFG;
	$query = "SELECT audiolang 
		 FROM {$CFG->prefix}genetic_videos
		 WHERE audiolang='$lang'";
	return $query;
}
// Show image
function genetic_choose_im($idim) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images
		 WHERE id='$idim'";
	return $query;
}

// Show video
function genetic_choose_vi($idvi) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos
		 WHERE id='$idvi'";
	return $query;
}
// Show audio
function genetic_choose_au($idau) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_audio
		 WHERE id='$idau'";
	return $query;
}
// Show audio
function genetic_choose_audiolang($idcard) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE id='$idcard'";
	return $query;
}

/**********
  SEARCHES
 **********/

 // Search id author from its name
function genetic_exist_author($author) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_authors
		 WHERE name LIKE '%$author%'
		 OR surname LIKE '%$author%'";
	return $query;
}

// Search header from its ty
function genetic_search_header($idgenetic,$idty) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 WHERE ty ='$idty'
		 AND id_genetic='$idgenetic'";
	return $query;
}

// Search rem
function genetic_search_remissions($idcard) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission
		 WHERE idcard='$idcard'";
	return $query;
}
// Search rem
function genetic_search_remissions_rem($remtype,$cardid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission
		 WHERE rem_type='$remtype'
		 AND idcard='$cardid'";
	return $query;
}
// Search header from its id
function genetic_search_header_type($idgenetic,$idheader) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 WHERE id ='$idheader'
		 AND id_genetic='$idgenetic'";
	return $query;
}
// Search card by author
function genetic_search_author($auid) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_rel_headerauthor
		 WHERE idauthor='$auid'";
	return $query;
}


// Search header by dom
function genetic_search_domain_h($idgenetic, $dom) {
	global $CFG;
	
	$query = "SELECT {$CFG->prefix}genetic_headercards.* 
		 FROM {$CFG->prefix}genetic_headercards, {$CFG->prefix}genetic_headercards_has_genetic_subdomains
		 WHERE {$CFG->prefix}genetic_headercards_has_genetic_subdomains.genetic_subdomains_id='$dom' 
		 AND {$CFG->prefix}genetic_headercards.id_genetic='$idgenetic'
		 AND {$CFG->prefix}genetic_headercards.id={$CFG->prefix}genetic_headercards_has_genetic_subdomains.genetic_headercards_id ";
	return $query;
}
// Search card by domain
function genetic_search_domain_f($dom) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_headercards_has_genetic_subdomains
		 WHERE genetic_subdomains_id='$dom'";
	return $query;
}
// Search domain
function genetic_search_domain_name($dom) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_subdomains
		 WHERE id='$dom'";
	return $query;
}

// Search card by term
function genetic_search_term($idgenetic, $term) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND term LIKE '%$term%'";
	return $query;
}

// Search idheader by term in cards
function genetic_search_headerbyterm($idgenetic, $term) {
	global $CFG;
	$query = "select distinct {$CFG->prefix}genetic_headercards.id
		 from {$CFG->prefix}genetic_cards, {$CFG->prefix}genetic_headercards 
		 where {$CFG->prefix}genetic_headercards.id={$CFG->prefix}genetic_cards.idheader
		 and {$CFG->prefix}genetic_headercards.id_genetic='$idgenetic'
		 and {$CFG->prefix}genetic_cards.term like '%$term%'";
	return $query;
}

// Search card by term
function genetic_search_term_exactly($idgenetic, $term) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND term LIKE '$term'";
	return $query;
}
// Search card by term
function genetic_search_term_exactly2($idgenetic, $idterm) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND id='$idterm'";
	return $query;
}
// Search card by term in this language
function genetic_search_term_lang($idgenetic, $term, $lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND term LIKE '$term'
		 AND isolang ='$lang'";
		 
	return $query;
}
// Search ty by name
function genetic_search_ty($idty) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_ty
		 WHERE id='$idty'";
	return $query;
}
// Search image by name
function genetic_search_im($name) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images
		 WHERE fileimage LIKE '%$name%'";
	return $query;
}
// Search video by name
function genetic_search_vi($name) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos
		 WHERE filevideo LIKE '%$name%'";
	return $query;
}
// Search audio by name
function genetic_search_au($name) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_audio
		 WHERE fileaudio='$name'";
	return $query;
}

// Search audio by idcard
function genetic_search_audio($idcard) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards_has_genetic_audio
		 WHERE genetic_cards_id='$idcard'";
	return $query;
}

// Search id of the language
function genetic_search_lang($lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_lang
		 WHERE language='$lang'";
		 
	return $query;
}
// Search name of the language
function genetic_search_lang_name($idlang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_lang
		 WHERE id='$idlang'";
		 
	return $query;
}
// Search card by language
function genetic_search_lang_c($idgenetic, $lang) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND isolang='$lang'";
	return $query;
}
// Search a subdomain
function genetic_search_subdomain($did) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_subdomains
		 WHERE iddom='$did'";
	return $query;
}
// ----a�adido--
function genetic_subdomain_by_id($id) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_subdomains
 		 WHERE id= '$id'";
	return $query;
}
// Search card by gramatic category
function genetic_search_gramcat_c($idgenetic, $gramcat) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND gramcat='$gramcat'";
	return $query;
}
// Search card by proyect
function genetic_search_proyect($idgenetic, $ni) {
	global $CFG;
	$query = "SELECT *
		 FROM {$CFG->prefix}genetic_cards
		 WHERE idgenetic='$idgenetic'
		 AND idheader='$ni'";
	return $query;
}

// Search card by a general "key"
function genetic_search_all($idgenetic, $generalkey) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE (term LIKE '%$generalkey%'
		 OR definition LIKE '%$generalkey%'
		 OR context LIKE '%$generalkey%'
		 OR expression LIKE '%$generalkey%'
		 OR notes LIKE '%$generalkey%')
		 AND idgenetic='$idgenetic'";
	return $query;
}

// Search card by a general "key", returns the idheader of that card
function genetic_search_headerbyall($idgenetic, $generalkey) {
	global $CFG;
	$query = "SELECT distinct {$CFG->prefix}genetic_headercards.id
	FROM {$CFG->prefix}genetic_cards, {$CFG->prefix}genetic_headercards
	WHERE {$CFG->prefix}genetic_headercards.id={$CFG->prefix}genetic_cards.idheader and
	({$CFG->prefix}genetic_cards.term LIKE '%$generalkey%'
	OR {$CFG->prefix}genetic_cards.definition LIKE '%$generalkey%'
	OR {$CFG->prefix}genetic_cards.context LIKE '%$generalkey%'
	OR {$CFG->prefix}genetic_cards.expression LIKE '%$generalkey%'
	OR {$CFG->prefix}genetic_cards.notes LIKE '%$generalkey%')
	AND {$CFG->prefix}genetic_headercards.id_genetic='$idgenetic'";
	return $query;
}

// Search an using department (be) to avoid delete the entry
function genetic_use_be($beid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_rel_headerbe
		 WHERE idbe='$beid'";
	return $query;
}

// Search a card using the selected language
function genetic_use_lang($isolang,$idgenetic) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE {$CFG->prefix}genetic_cards.idgenetic=$idgenetic
		 AND {$CFG->prefix}genetic_cards.isolang='$isolang'";
	return $query;
}
// a�adido--Search an using synonym to avoid delete the entry
function genetic_use_syn($synid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_synonyms_has_genetic_remission
		 WHERE genetic_synonyms_id='$synid'";
	return $query;
}

// Search an using author to avoid delete the entry
function genetic_use_author($auid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_rel_headerauthor
		 WHERE idauthor='$auid'";
	return $query;
}


// Search an using domain to avoid delete the entry
function genetic_use_dom($domid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 WHERE dom = '$domid'";
	return $query;
}


// Search an using subdomain to avoid delete the entry
function genetic_use_subdom($domid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 WHERE subdom = '$domid'";
	return $query;
}


// Search an using card type (ty) to avoid delete the entry
function genetic_use_ty($tyid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_headercards
		 WHERE ty = '$tyid'";
	return $query;
}

// Search an using card type (ty) to avoid delete the entry
function genetic_use_rt($rtid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_remission_has_genetic_relatedterms
		 WHERE genetic_relatedterms_id = '$rtid'";
	return $query;
}
// Search an using card type (ty) to avoid delete the entry
function genetic_use_cr($crid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_relatedterms_has_genetic_crossrelations
		 WHERE genetic_crossrelations_id = '$crid'";
	return $query;
}
// ---a�adido---Search a card using the image to avoid delete the entry
function genetic_use_im($imid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_images_has_genetic_cards
		 WHERE genetic_images_id = '$imid'";
	return $query;
}

// ---a�adido---Search a card using the video to avoid delete the entry
function genetic_use_vi($viid) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_videos_has_genetic_cards
		 WHERE genetic_videos_id = '$viid'";
	return $query;
}
// ---a�adido---Search a card using theaudio to avoid delete the entry
function genetic_use_au($name) {
	global $CFG;
	$query = "SELECT * 
		 FROM {$CFG->prefix}genetic_cards
		 WHERE term = '$name'";
	return $query;
}


/*********
  INSERTS
 *********/

 
 
// Insert a header
function genetic_insert_header($geneticid, $ty,  $datecreated) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_headercards(idgenetic, ty, datecreated)
		VALUES ('$geneticid', '$ty', '$datecreated')";
	return $query;
}
// Insert a header
function genetic_insert_header2($geneticid, $ty, $datecreated) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_headercards(id_genetic, ty,  datecreated)
		VALUES ('$geneticid', '$ty',  '$datecreated')";
	return $query;
}
// Insert Language
function genetic_insert_lang( $lang) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_lang(language)
		VALUES ('$lang')";
	return $query;
}
// Insert Language
function genetic_insert_lang2($geneticid, $lang) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_lang_has_genetic(genetic_id,genetic_lang_id)
		VALUES ('$geneticid', '$lang')";
	return $query;
}
// Insert relation between terminology cards (header) and departments
function genetic_insert_rel_be($ni, $be) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_rel_headerbe(idheadercard, idbe)
		VALUES ('$ni', '$be')";
	return $query;
}


// Insert relation between terminology cards (header) and authors
function genetic_insert_rel_author($ni, $author) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_rel_headerauthor(idheadercard, idauthor)
		VALUES ('$ni', '$author')";
	return $query;
}
// Insert relation between terminology cards (header) and authors
function genetic_insert_rel_subdomain($ni, $domsubdom) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_headercards_has_genetic_subdomains(genetic_headercards_id, genetic_subdomains_id)
		VALUES ('$ni', '$domsubdom')";
	return $query;
}

// Insert card ---modoficada---he quitado campo rv
function genetic_insert_card($idgenetic, $ni, $isolang, $term, $gramcat, $definition, $context, $expression, $notes,$weight_type) {
    global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_cards(idgenetic, idheader, isolang, term, gramcat, definition, context, expression, notes, weighting_mark)
		VALUES ('$idgenetic', '$ni', '$isolang', '$term', '$gramcat', '$definition', '$context', '$expression','$notes','$weight_type')";
	return $query;	
}


// Insert source
function genetic_insert_source($cardid, $sourceterm, $sourcedefinition, $sourcecontext, $sourceexpression, $sourcenotes) {
    global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_sources(idcard, srcterm, srcdefinition, srccontext, srcexpression, srcnotes)
		VALUES ('$cardid', '$sourceterm', '$sourcedefinition', '$sourcecontext', '$sourceexpression', '$sourcenotes')";
	return $query;
}

//---a�adido----
function genetic_insert_remission($cardid,$remission,$rem_type) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_remission(idcard, remission, rem_type)
		VALUES ('$cardid', '$remission', '$rem_type')";
	return $query;
}
//---a�adido----
function genetic_insert_remissions2($cardid, $abreviaturas, $acronyms) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_remission(idcard, abreviaturas, acronims)
		VALUES ('$cardid', '$abreviaturas', '$acronyms')";
	return $query;
}
//---a�adido----
function genetic_insert_has_image($ni, $idimage) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_images_has_genetic_cards(genetic_headercards_id, genetic_images_id)
		VALUES ('$ni', '$idimage')";
	return $query;
}
//---a�adido----
function genetic_insert_has_video($cardid, $idvideo) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_videos_has_genetic_cards(genetic_cards_id, genetic_videos_id)
		VALUES ('$cardid', '$idvideo')";
	return $query;
}
//---a�adido----
function genetic_insert_has_synonym($remissionid, $synonymid) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_synonyms_has_genetic_remission(genetic_remission_id, genetic_synonyms_id)
		VALUES ('$remissionid', '$synonymid')";
	return $query;
}
//---a�adido----
function genetic_insert_has_remission($cardid, $rel_remission) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_rel_remissions(idremission, idcard)
		VALUES ('$rel_remission', '$cardid')";
	return $query;
}

//---a�adido----
function genetic_insert_has_relatedterm($remissionid, $relatedtermid) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_remission_has_genetic_relatedterms(genetic_remission_id, genetic_relatedterms_id)
		VALUES ('$remissionid', '$relatedtermid')";
	return $query;
}
//---a�adido----
function genetic_insert_has_crossrelatedterm($remissionid, $crossrelatedtermid) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_remission_has_genetic_crossrelations(genetic_remission_id, genetic_crossrelations_id)
		VALUES ('$remissionid', '$crossrelatedtermid')";
	return $query;
}


//---a�adido----
function genetic_insert_has_audio($cardid, $audioid) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_cards_has_genetic_audio(genetic_cards_id, genetic_audio_id)
		VALUES ('$cardid', '$audioid')";
	return $query;
}

// Insert a domain
function genetic_insert_domain($name) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_domains(name)
		VALUES ('$name')";
	return $query;
}


// Insert a subdomain
function genetic_insert_subdomain($belongto, $name) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_subdomains(iddom, name)
		VALUES ('$belongto', '$name')";
	return $query;
}


// Insert an author
function genetic_insert_author($type, $name, $surname) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_authors(type, name , surname)
		VALUES ('$type', '$name', '$surname')";
	return $query;
}


// Insert a department
function genetic_insert_be($name) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_be(name)
		VALUES ('$name')";
	return $query;
}


// Insert a card type
function genetic_insert_ty($name) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_ty(name)
		VALUES ('$name')";
	return $query;
}

// Insert a card type
function genetic_insert_rt($name,$rt_link) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_relatedterms(name, rellink)
		VALUES ('$name','$rt_link')";
	return $query;
}
// Insert a card type
function genetic_insert_cr($name,$cross_link) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_crossrelations(name,crosslink)
		VALUES ('$name','$cross_link')";
	return $query;
}
// Insert an image
function genetic_insert_im($pieimagen,$pieimagen_de,$pieimagen_en,$pieimagen_fr,$nombreImagen ,$srcimage) {
	global $CFG;
	
	$query = "INSERT INTO {$CFG->prefix}genetic_images( titleimage_es,titleimage_de,titleimage_en,titleimage_fr,fileimage, srcimage)
		VALUES ('$pieimagen','$pieimagen_de','$pieimagen_en','$pieimagen_fr','$nombreImagen', '$srcimage')";	
	return $query;
}
// Insert a video
function genetic_insert_vi($pievideo,$pievideo_de,$pievideo_en,$pievideo_fr,$nombrevideo ,$srcvideo,$lang) {
	global $CFG;
		$query = "INSERT INTO {$CFG->prefix}genetic_videos( titlevideo_es,titlevideo_de,titlevideo_en,titlevideo_fr,filevideo, srcvideo, audiolang)
		VALUES ('$pievideo','$pievideo_de','$pievideo_en','$pievideo_fr','$nombrevideo', '$srcvideo','$lang')";	
	return $query;
}
// Insert a video
function genetic_insert_au($nombreAudio ,$srcaudio,$lang) {
	global $CFG;
		$query = "INSERT INTO {$CFG->prefix}genetic_audio(fileaudio, srcaudio,lang)
		VALUES ('$nombreAudio','$srcaudio','$lang')";	
	return $query;
}

// Insert a synonym
function genetic_insert_synonym($synonym,$synonym_link) {
	global $CFG;
	$query = "INSERT INTO {$CFG->prefix}genetic_synonyms(name, synlink)
		VALUES ('$synonym', '$synonym_link')";
	return $query;
}



/*********
  UPDATES
 *********/

// Update header
function genetic_update_header($geneticid, $ni, $ty, $datecreated) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_headercards
	    SET id_genetic='$geneticid', ty='$ty', datecreated='$datecreated' 
	    WHERE id='$ni'";
	return $query;	
}


// Update relation between terminology cards (header) and departments
function genetic_update_rel_be($ni, $be) {
	global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_rel_headerbe
		SET idbe='$be'
		WHERE idheadercard='$ni'";
	return $query;
}


// Update relation between terminology cards (header) and authors
function genetic_update_rel_author($ni, $author) {
	global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_rel_headerauthor
		SET idauthor='$author'
		WHERE idheadercard='$ni'";
	return $query;
}


// Update card
function genetic_update_card($cardid, $term, $gramcat, $definition, $context, $expression, $notes,$weight_type) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_cards
	    SET term='$term', definition='$definition', gramcat='$gramcat', context='$context', expression='$expression', notes='$notes' ,weighting_mark='$weight_type'
	    WHERE id='$cardid'";
	return $query;	
}


// Update source
function genetic_update_source($cardid, $sourceterm, $sourcedefinition, $sourcecontext, $sourceexpression, $sourcenotes) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_sources
	    SET srcterm='$sourceterm', srcdefinition='$sourcedefinition', srccontext='$sourcecontext', srcexpression='$sourceexpression',srcnotes='$sourcenotes' 
	    WHERE idcard='$cardid'";
	return $query;
}


// Update domain
function genetic_update_domain($did, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_domains
	    SET name='$name'
	    WHERE id='$did'";
	return $query;
}


// Update subdomain
function genetic_update_subdomain($did, $belongto, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_subdomains
	    SET iddom='$belongto', name='$name'
	    WHERE id='$did'";
	return $query;
}


// Update author
function genetic_update_author($idauthor, $type, $name, $surname) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_authors
	    SET type='$type', name='$name', surname='$surname'
	    WHERE id='$idauthor'";
	return $query;
}


// Update department
function genetic_update_be($idbe, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_be
	    SET name='$name' 
	    WHERE id='$idbe'";
	return $query;
}

// ----a�adido---Update sinonimo
function genetic_update_syn($idsyn, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_synonyms
	    SET name='$name' 
	    WHERE id='$idsyn'";
	return $query;
}

// Update card type
function genetic_update_ty($idty, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_ty
	    SET name='$name' 
	    WHERE id='$idty'";
	return $query;
}

// Update card type
function genetic_update_rm($cardrowidremissions, $cardid, $abr, $acr) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_remission
	    SET idcard='$cardid', acronims='$acr',abreviaturas='$abr' 
	    WHERE id='$cardrowidremissions'";
	return $query;
}
// Update card type
function genetic_update_rt($idrt, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_relatedterms
	    SET name='$name' 
	    WHERE id='$idrt'";
	return $query;
}
// Update card type
function genetic_update_cr($idcr, $name) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_crossrelations
	    SET name='$name' 
	    WHERE id='$idcr'";
	return $query;
}
// Update image
function genetic_update_im($idim, $name,$name_es,$name_de,$name_fr,$name_en,$name3) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_images
	    SET fileimage='$name',titleimage_es='$name_es',titleimage_de='$name_de',titleimage_en='$name_en',titleimage_fr='$name_fr' ,srcimage='$name3'
	    WHERE id='$idim'";
	return $query;
}
// Update video
function genetic_update_vi($idvi, $name,$name2,$name_de,$name_fr,$name_en,$name3,$lang) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_videos
	    SET filevideo='$name',titlevideo_es='$name2',titlevideo_de='$name_de',titlevideo_en='$name_en',titlevideo_fr='$name_fr',srcvideo='$name3', audiolang='$lang'
	    WHERE id='$idvi'";
	return $query;
}
// Update audio
function genetic_update_au($idau,$name,$name3,$lang) {
    global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_audio
	    SET srcaudio='$name3',lang='$lang', fileaudio='$name'
	    WHERE id='$idau'";
	return $query;
}

//---a�adido----
function genetic_update_has_synonym($remissionid, $synonymid) {
	global $CFG;
	$query = "UPDATE {$CFG->prefix}genetic_synonyms_has_genetic_remission
		SET  genetic_synonyms_id='$synonymid'
		WHERE genetic_remission_id='$remissionid',";
	return $query;
}




/*********
  DELETES
 *********/

// Delete a header
function genetic_delete_header($headerid) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_headercards
 		 WHERE id = '$headerid'";
	return $query;
}
// Delete a header
function genetic_delete_lang_dic($langid,$idgenetic) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_lang_has_genetic
 		 WHERE genetic_lang_id = '$langid'
		 AND genetic_id='$idgenetic'";
	return $query;
}

// Delete relation between header and be
function genetic_delete_rel_headerbe($ni) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_rel_headerbe
 		 WHERE idheadercard = '$ni'";
	return $query;
}


// Delete relation between header and author
function genetic_delete_rel_headerauthor($ni) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_rel_headerauthor
 		 WHERE idheadercard = '$ni'";
	return $query;
}
// Delete relation between header and subdomain
function genetic_delete_rel_subdomain($ni) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_headercards_has_genetic_subdomains
 		 WHERE genetic_headercards_id = '$ni'";
	return $query;
}

// Delete cards
function genetic_delete_card($headerid) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_cards
 		 WHERE idheader = '$headerid'";
	return $query;
}
// Delete images
function genetic_delete_image($headerni) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_images_has_genetic_cards
 		 WHERE genetic_headercards_id = '$headerni'";
	return $query;
}

// Delete videos
function genetic_delete_video($cardid) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_videos_has_genetic_cards
 		 WHERE genetic_cards_id = '$cardid'";
	return $query;
}
// Delete remissions
function genetic_delete_remissions($cardid) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_remission
 		 WHERE idcard = '$cardid'";
	return $query;
}

// Delete synonyms
function genetic_delete_synonym($remid) {
	global $CFG;
	$query = "DELETE 
		 FROM {$CFG->prefix}genetic_synonyms_has_genetic_remission
 		 WHERE {$CFG->prefix}genetic_synonyms_has_genetic_remission.genetic_remission_id='$remid'";
	return $query;
}
// Delete synonyms
function genetic_delete_has_synonym($cardrowidremissions) {
	
	global $CFG;
	$query = "DELETE {$CFG->prefix}genetic_synonyms_has_genetic_remission.*
		 FROM {$CFG->prefix}genetic_synonyms_has_genetic_remission 
 		 WHERE genetic_remission_id='$cardrowidremissions'";
	return $query;
}
// Delete remissions
function genetic_delete_has_remissions($cardrowidremissions) {
	
	global $CFG;
	$query = "DELETE {$CFG->prefix}genetic_remission.*
		 FROM {$CFG->prefix}genetic_remission
 		 WHERE id='$cardrowidremissions'";
	return $query;
}

// Delete synonyms
function genetic_delete_has_related($cardrowidremissions) {
	
	global $CFG;
	$query = "DELETE 
		 FROM {$CFG->prefix}genetic_remission_has_genetic_relatedterms 
 		 WHERE genetic_remission_id='$cardrowidremissions'";
	return $query;
}
// Delete synonyms
function genetic_delete_has_crossrelated($cardrowidremissions) {
	
	global $CFG;
	$query = "DELETE {$CFG->prefix}genetic_remission_has_genetic_crossrelations.*
		 FROM {$CFG->prefix}genetic_remission_has_genetic_crossrelations 
 		 WHERE genetic_remission_id='$cardrowidremissions'";
	return $query;
}


// Delete crossrelterm
function genetic_delete_crossrelterm($cardid,$remid) {
	global $CFG;
	$query = "DELETE {$CFG->prefix}genetic_relatedterms_has_genetic_crossrelations.*
		 FROM {$CFG->prefix}genetic_relatedterms_has_genetic_crossrelations, {$CFG->prefix}genetic_remission
 		 WHERE {$CFG->prefix}genetic_remission.idcard = '$cardid' AND {$CFG->prefix}genetic_relatedterms_has_genetic_crossrelations.genetic_remission_id='$remid'";
	return $query;
}
// Delete sources
function genetic_delete_source($cardid) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_sources
 		 WHERE idcard = '$cardid'";
	return $query;
}


// Delete a domain
function genetic_delete_domain($did) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_domains
 		 WHERE id = '$did'";
	return $query;
}


// Delete a subdomain
function genetic_delete_subdomain($did) {
	
	global $CFG;
	$query = "DELETE 
		 FROM {$CFG->prefix}genetic_subdomains
 		 WHERE id = '$did'";
	return $query;
}


// Delete an author
function genetic_delete_author($idauthor) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_authors
 		 WHERE id = '$idauthor'";
	return $query;
}


// Delete a department
function genetic_delete_be($idbe) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_be
 		 WHERE id = '$idbe'";
	return $query;
}
// Delete a department
function genetic_delete_syn($idsyn) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_synonyms
 		 WHERE id = '$idsyn'";
	return $query;
}

// Delete a card type
function genetic_delete_ty($idty) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_ty
 		 WHERE id = '$idty'";
	return $query;
}

// Delete a card type
function genetic_delete_rt($idrt) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_relatedterms
 		 WHERE id = '$idrt'";
	return $query;
}
// Delete a card type
function genetic_delete_cr($idcr) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_crossrelations
 		 WHERE id = '$idcr'";
	return $query;
}
// Delete an image file
function genetic_delete_im($idim) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_images
 		 WHERE id = '$idim'";
	return $query;
}
// Delete a video file
function genetic_delete_vi($idvi) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_videos
 		 WHERE id = '$idvi'";
	return $query;
}


// Delete a audio file
function genetic_delete_audio($idcard) {
	global $CFG;
	$query = "DELETE
		 FROM {$CFG->prefix}genetic_cards_has_genetic_audio
 		 WHERE genetic_cards_id = '$idcard'";
	return $query;
}
// Delete all relations of an audio with cards
function genetic_remove_audiocards($idaudio){
	global $CFG;
	$query = "DELETE
	FROM {$CFG->prefix}genetic_cards_has_genetic_audio
	WHERE genetic_audio_id = '$idaudio'";
	return $query;
}
// Delete the audio data
function genetic_remove_audio($idaudio){
	global $CFG;
	$query = "DELETE
	FROM {$CFG->prefix}genetic_audio
	WHERE id = '$idaudio'";
	return $query;
}
// ----a�adido---arbol
function genetic_arbol($nivel) {
	global $CFG;
	$query = "SELECT id, name, iddom 
		 FROM {$CFG->prefix}genetic_subdomains
 		 WHERE iddom= '$nivel'";
	return $query;
}
// ----a�adido---arbol2
function genetic_arbol2($iddom) {
	global $CFG;
	$query = "SELECT id
		 FROM {$CFG->prefix}genetic_subdomains
 		 WHERE iddom= '$iddom'";
	return $query;
}
// ----a�adido---arbol2
function genetic_arbol3($iddom) {
	global $CFG;
	$query = "SELECT id
		 FROM {$CFG->prefix}genetic_subdomains
 		 WHERE id= '$iddom'";
	return $query;
}



?>