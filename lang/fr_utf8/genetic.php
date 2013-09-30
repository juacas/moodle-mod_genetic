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
$string['abreviaturas'] = 'Abréviations :';
$string['accept'] = 'Accepter';
$string['action'] = 'Action';
//---a�adido---
$string['acronyms'] = 'Acronymes :';
$string['advaudio'] = 'Le nom du fichier audio doit suivre le modèle suivant : nom_terme.extension';
$string['addaudio'] = 'Ajouter un son';
$string['addauthor'] = 'Ajouter un nouveau auteur';
$string['addbe'] = 'Ajouter une nouvelle institution';
$string['addcard'] = 'Ajouter une fiche';
$string['addcardf'] = 'Ajouter une nouvelle fiche terminologique';
$string['adddom'] = 'Ajouter un nouveau domaine';
//---a�adido---
$string['addim'] = 'Ajouter une nouvelle image';
$string['addlang'] = 'Ajouter une nouvelle langue';
$string['addau'] = 'Ajouter un nouveau son';
$string['addvi'] = 'Ajouter une nouvelle vidéo';
$string['addrt'] = 'Ajouter un nouveau terme lié';
$string['addcr'] = 'Ajouter un nouveau terme en relation croisée';
$string['addsubdom'] = 'Ajouter un nouveau sous-domaine';
$string['addsynonym'] = 'Ajouter un nouveau synonyme';
$string['addty'] = 'Ajouter un nouveau projet';
$string['admin'] = 'Administrateur';
$string['alphaorder'] = 'Par ordre alphabétique :';

$string['ar'] = 'arabe';
$string['asc'] = 'Date ASC';
$string['author'] = 'Auteur/s';
$string['audio'] = 'Son';
$string['audio_video'] = 'Langue audio de la vidéo';
$string['be'] = 'Institution/s';
$string['belongto'] = 'Appartient à';
$string['buttonaddau'] = 'Ajouter un auteur';
$string['buttonaddaudio'] = 'Ajouter un son';
$string['buttonaddbe'] = 'Ajouter une institution';
$string['buttonadddom'] = 'Ajouter une langue';
//a�adido
$string['buttonaddim'] = 'Ajouter une image';
$string['buttonaddrt'] = 'Ajouter un terme lié';
$string['buttonaddcr'] = 'Ajouter un terme en relation croisée';
$string['buttonaddlang'] = 'Ajouter une langue';
$string['buttonaddty'] = 'Ajouter un projet';
$string['buttonaddsubdom'] = 'Ajouter un sous-domaine';
$string['buttonaddsyn'] = 'Ajouter un synonyme';
$string['buttonaddvi'] = 'Ajouter une vidéo';
$string['buttongeneralsearch'] = 'Recherche général';
$string['cancel'] = 'Annuler';
$string['cards'] = 'Fiches';
$string['category'] = 'Catégorie';
$string['chooselang'] = 'choisir une langue:';
$string['commonheaderdata'] = 'Données communes aux langues de la fiche terminologique';
$string['context'] = 'Contexte';
$string['continue'] = 'Continuer';
$string['criteria'] = 'Critère de recherche';
//---a�adido---
$string['crossrelatedterms'] = 'Termes croisés';
$string['crosstermsentence'] = 'Ce terme apparait aussi dans les entrées suivantes';
$string['datecreated'] = 'Date de création / modification';
$string['indexuse'] = 'Utilisez cet onglet pour ranger les fiches selon la date de création / modification ou en ordre alphabétique en choisissant la langue:';
$string['datemodified'] = 'Date de modification';
$string['date'] = 'Date :';
//---a�adido---
$string['de'] = 'Allemand ';
$string['definition'] = 'Définition';
$string['delete'] = 'Supprimer';
$string['deleteau'] = 'Supprimer le son';
$string['deleteausure'] = ' Voulez-vous vraiment supprimer ce son?? ?';
$string['deleteauused'] = 'Il n\'est pas possible de supprimer l\'auteur. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deleteauthor'] = 'Supprimer l\'auteur';
$string['deleteauthorused'] = "L'auteur ne peut pas être supprimer car il est utilisé dans le dictionnaire.";
$string['deleteaunok'] = 'Erreur à la suppression de l\'auteur';
$string['deleteauok'] = 'L\'auteur a été supprimé correctement';
$string['deleteauthorsure'] = ' Voulez-vous vraiment supprimer l\'auteur ?';
$string['deletebe'] = 'Supprimer l\'institution';
$string['deletebeused'] = 'Il n\'est pas possible de supprimer l\'institution. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletebenok'] = 'Erreur à la suppression de l\'institution';
$string['deletebeok'] = 'L\'institution a été supprimée correctement';
$string['deletebesure'] = ' Voulez-vous vraiment supprimer l\'institution ?';
$string['deleteremission'] = 'Supprimer un renvoi';
$string['deletesynsure'] = ' Voulez-vous vraiment supprimer le synonyme ?';
$string['deletecard'] = 'Supprimer une fiche terminologique';
$string['deletecardsure'] = ' Voulez-vous vraiment supprimer la fiche terminologique ?';
$string['deletedomused'] = 'Il n\'est pas possible de supprimer le sous-domaine. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletedom'] = 'Supprimer un domaine';
$string['deletedomparent'] = 'Il n\'est pas possible de supprimer le domaine; il en contient d\'autres';
//---a�adido---
$string['deleteim'] = 'Supprimer l\'image';
$string['deletevi'] = 'Supprimer la vidéo';
$string['deleteimnok'] = 'Erreur à la suppression de l\'image';
$string['deleteaunok'] = 'Erreur à la suppression du son';
$string['deleteimok'] = 'L\'imagen a été supprimée correctement';
$string['deletelangok'] = 'La langue a été supprimée correctement';
$string['deletelangnok'] = 'Erreur à a suppression de la langue';
$string['deleteaudiook'] = 'Le son a été supprimé correctement';
$string['deletevinok'] = 'Erreur à la suppression de la vidéo';
$string['deleteviok'] = 'La vidéo a été supprimée correctement';
$string['deleteauused'] = 'Il n\'est pas possible de supprimer le son. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deleteimused'] = 'Il n\'est pas possible de supprimer l\'image. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletelangused'] = 'Il n\'est pas possible de supprimer la langue. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deleteviused'] = 'Il n\'est pas possible de supprimer la vidéo. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletedomsdnok'] = 'Erreur à la suppression du sous-domaine';
$string['deletedomsdok'] = 'Le sous-domaine a été supprimé correctement';
$string['deletedomsdsure'] = ' Voulez-vous vraiment supprimer le sous-domaine ?';

$string['deletenok'] = 'Erreur à la suppression de la fiche terminologique';
$string['deletelangsure'] = ' Voulez-vous vraiment supprimer la langue ?';
$string['deleteok'] = 'La fiche terminologique a été supprimée correctement';
$string['deletert']='Supprimer le terme lié';
$string['deletecr']='Supprimer le terme en relation croisée';
$string['deletertnok'] = 'Erreur à la suppression du terme lié';
$string['deletertok'] = 'Le terme lié a été supprimé correctement';
$string['deletecrok'] = 'Le terme en relation croisée a été supprimé correctement';
$string['deletertsure'] = ' Voulez-vous vraiment supprimer le terme lié ?';
$string['deletecrsure'] = ' Voulez-vous vraiment supprimer le terme en relation croisée ?';
$string['deletertused'] = 'Supprimer le terme lié';
$string['deletecrused'] = 'Supprimer le terme en relation croisée';
$string['deletesubdom'] = 'Supprimer le sous-domaine';
$string['deletesubdomused'] = 'Il n\'est pas possible de supprimer le sous-domaine. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletesynonym']='Supprimer le synonyme';
$string['deletety'] = 'Supprimer le projet';
$string['deletetyused'] = 'Il n\'est pas possible de supprimer le projet. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletesynused'] = 'Il n\'est pas possible de supprimer le synonyme. L\'entrée est en cours d\'utilisation par une fiche terminologique.';
$string['deletesynnok'] = 'Erreur à la suppression du synonyme';
$string['deletesynok'] = 'Le synonyme a été supprimé correctement';
$string['deletetynok'] = 'Erreur à la suppression du projet';
$string['deletecrnok'] = 'Erreur à la suppression du terme croisé';
$string['deletetyok'] = 'Le projet a été supprimé correctement';
$string['deletetysure'] = ' Voulez-vous vraiment supprimer le projet ?';
$string['deleteimsure'] = ' Voulez-vous vraiment supprimer l\'image ?';
$string['deletevisure'] = ' Voulez-vous vraiment supprimer la vidéo ?';
$string['desc'] = 'Date DESC';
$string['description'] = 'Description';
$string['detail'] = 'Voir les détails';
$string['dom'] = 'Domaine';
$string['subdomview'] = 'Vue hiérarchisée des sous-domaine:';
$string['edit'] = 'Editer';
$string['editau'] = 'Editer le son';
$string['editauthor'] = 'Editer l\'auteur';
$string['editbe'] = 'Editer l\'institution';
$string['editcard'] = 'Editer la fiche terminologique';
$string['editdom'] = 'Editer le domaine';
//---a�adido---

$string['editim'] = 'Editer l\'image';
$string['editsyn'] = 'Editer la synonyme';
$string['editvi'] = 'Editer la vidéo';
$string['editrt'] = 'Editer le terme lié';
$string['editcr'] = 'Editer le terme en relation croisée';
$string['editsubdom'] = 'Editer le sous-domaine';
$string['editty'] = 'Editer le projet';
$string['emptyfield'] = 'Champs obligatoire vide. Vérifiez les données antérieures';
$string['emptyfieldterm'] = 'Champ vide. Ecrivez le terme que vous cherchez.';
$string['emptyfieldauthor'] = 'Champ vide. Ecrivez le nom de l\'auteur que vous cherchez.';
$string['emptyfielddom'] = 'Champ vide. Ecrivez le domaine que vous cherchez.';
$string['emptyfieldgramcat'] = 'Champ vide. Vous devez sélectionner una catégorie grammaticale.';
$string['emptyfieldheader'] = 'Champ obligatoire de tête non sélectionnée. Vérifiez les données communes aux fiches terminologiques.';
$string['emptyfieldisolang'] = 'Champs vide. Sélectionez la langue que vous cherchez.';
$string['emptyfieldlanguage'] = 'Champs obligatoire de la langue vide. Vérifiez les données en rapport avec les termes.';
$string['emptysearchtype'] = 'Vous devez sélectionner un critère de recherche et le remplir';
//---a�adido---
$string['en'] = 'Anglais ';
$string['errordb'] = 'Il s\'est produit une erreur à la sélection de la base de données correspondant à l\'activité. Réessayez.';
$string['errorvideoextension'] = "L'extension ou la taille des archives n'est pas correcte. <br><br><table><tr><td><li>Permet d'archiver en .wav ou .avi ou .wmv<br><li>permet d'archiver 100 MB maximum.</td></tr></table>";
$string['es'] = 'Espagnol ';
$string['expression'] = 'Phraséologie';
$string['errextensionimage']="L'extension ou la taille des archives n'est pas correcte. <br><br><table><tr><td><li>Permet d'archiver en .gif ou .jpg<br><li>permet d'archiver 100 MB maximum.</td></tr></table>";
$string['errnameimageexists'] = 'Le nom du fichier existe déjà.<br><br><table><tr><td><li>Il n\'est pas possible d\'enregister deux fichier avec le même nom.</td></tr></table>';
$string['errnamevideoexists'] = 'Le nom du fichier existe déjà.<br><br><table><tr><td><li>Il n\'est pas possible d\'enregister deux fichier avec le même nom.</td></tr></table>';
$string['fileuploadcorrect']='L\'archive a été correctement chargée.';
$string['footsentences'] = 'Avec la collaboration de la Consejería de Educación de la Junta de Castille et Léon.';
$string['fr'] = 'Français ';
$string['genetic'] = 'Génétique';
$string['gramcat'] = 'catégorie grammaticale';
$string['guest'] = 'Invité';
$string['imagenes'] = 'Images :';
$string['insertaunok'] = 'Erreur à l\'insertion de l\'auteur';
$string['insertaudiook'] = 'Le son a été correctement inséré';
$string['insertaudionok'] = 'Erreur à l\'insertion du son';
$string['insertauok'] = 'L\'auteur a été correctement inséré';
$string['insertbenok'] = 'Erreur à l\'insertion de l\'institution';
$string['insertbeok'] = 'L\'institution a été correctement insérée';
$string['insertdomsdnok'] = 'Erreur à l\'insertion du sous-domaine';
$string['insertdomsdok'] = 'Le sous-domaine a été correctement inséré';
$string['insertlangok'] = 'La langue a été correctement insérée';
$string['insertdomsexist'] = 'Erreur d\'insertion. Le sous-domaine existe déjà';
$string['insertauexist'] = 'Erreur d\'insertion. Le nom du fichier audio existe déjà';
$string['insertimexist'] = 'Erreur d\'insertion. Le nom du fichier de l\'image existe déjà';
$string['insertviexist'] = 'Erreur d\'insertion. Le nom du fichier de la vidéo existe déjà';
$string['insertimnok'] = 'Erreur à l\'insertion de l\'image';
$string['insertimok'] = 'L\'image a été correctement insérée';
$string['insertvinok'] = 'Erreur à l\'insertion de la vidéo';
$string['insertviok'] = 'La vidéo a été correctement insérée';
$string['insertnok'] = 'Erreur à l\'insertion de la fiche terminologique';
$string['insertok'] = 'La fiche terminologique a été correctement insérée';
$string['insertrtnok'] = 'Erreur à l\'insertion du terme lié';
$string['insertrtused'] = 'Le terme lié existe déjà dans cette langue dans le dictionnaire.';
$string['insertcrnok'] = 'Erreur à l\'insertion du terme en relation croisée';
$string['insertcrused'] = 'Le terme en relation croisée existe déjà dans cette langue dans le dictionnaire';
$string['insertrtok'] = 'Le terme lié a été correctement inséré';
$string['insertcrok'] = 'Le terme en relation croisée a été correctement inséré';
$string['insertsynok'] = 'Le synonyme a été correctement inséré';
$string['insertsynnok'] = 'Le synonyme a été correctement inséré';
$string['insertsynused'] = 'Le synonyme existe déjà dans cette langue dans le dictionnaire';
$string['inserttynok'] = 'Erreur à l\'insertion du projet';
$string['inserttyok'] = 'Le projet a été correctement inséré';
$string['labelspecial'] = 'Montrez les fiches dont le terme ne commence pas par un lettre';
//---a�adido---
$string['lang'] = 'Langue';
$string['langdicexist'] = ' existe déjà dans le dictionnaire';
$string['languagecarddata'] = 'Données particulières de chaque langue de la fiche terminologique';
$string['link'] = 'Lien';
$string['linksubd'] = 'Cliquer sur chaque sous-domaine pour accéder au topic browser de Eurogene.';
$string['maximumchars'] = 'Nombre maximum de caractères';
$string['modau'] = 'Modifiez le son';
$string['modimagen'] = 'Modifier l\'image';
$string['name'] = 'Nom';
$string['nameexists'] = 'Le nom existe déjà';
$string['newsearch'] = 'Nouvelle recherche';
$string['ni'] = 'Numéro d\'identification';
$string['noaudiofound'] = 'Il n\'y a pas de fichier audio dans cette langue';
$string['nodefined'] = 'Non défini';
$string['nodescrlang'] = 'Il n\'y a pas de description';
$string['noentries'] = 'Aucune fiche terminologique n\'a été trouvée';
$string['noentriesterm'] = 'Aucun terme n\'a été introduit dans cette langue';
$string['noexistauthor'] = 'L\'auteur recherché n\'apparait pas dans les bases de données.';
$string['noinsertlangdic'] = 'Langue non insérée dans le dictionnaire.';
$string['nolang'] = 'Aucune langue n\'a été inclue dans le distionnaire.';
$string['noresultauthor'] = 'Aucun auteur correspondant n\'a été trouvé';
$string['noresultdom'] = 'Aucune fiche terminologiques n\'a été trouvée dans le domaine sélectionné.';
$string['noresultgeneral'] = 'Aucune correspondance n\'a été trouvée dans les fiches terminologiques.';
$string['noresultgramcat'] = 'Aucune fiche terminologique n\'a été trouvée dans la catégorie grammaticale sélectionnée.';
$string['noresultisolang'] = 'Aucune fiche terminologique n\'a été trouvée dans la langue sélectionnée.';
$string['noresultterm'] = 'Aucun terme correspondant n\'a été trouvé';
$string['nosources'] = 'Aucune source n\'a été trouvée pour le terme';
$string['nosrcimage'] = 'Aucune source n\'a été trouvée pour l\'image';
$string['nosrcvideo'] = 'Aucune source n\'a été trouvée pour la vidéo';
$string['notermsadded'] = 'Aucun terme n\'a été ajouté dans aucune langue';
$string['notes'] = 'Notes';
$string['nummatch'] = 'Numéro de correspondance';
//----a�adido---
$string['pieimagen'] = 'Description de l\'image (es)';
$string['pieimagen_fr'] = 'Description de l\'image (fr)';
$string['pieimagen_en'] = 'Description de l\'image (en)';
$string['pieimagen_de'] = 'Description de l\'image (de)';
$string['pievideo'] = 'Description de la vidéo (es)';
$string['pievideo_fr'] = 'Description de la vidéo (fr)';
$string['pievideo_en'] = 'Description de la vidéo (en)';
$string['pievideo_de'] = 'Description de la vidéo (de)';
$string['reference'] = 'Renvois';
//---a�adido---
$string['relatedterms'] = 'Termes liés';
$string['reliabilitycode'] = 'Code de fiabilité';
$string['requiredfields'] = '(*) Champs obligatoires. Il n\'est pas nécessaire de remplir toutes les langues';
$string['resultsearch'] = 'Résultat de la recherche';
$string['rv'] = 'Renvois';
$string['save'] = 'Sauvegarder';
$string['search'] = 'Rechercher';
$string['searchauthor'] = 'Rechercher par auteur';
$string['searchcard'] = 'Rechercher une fiche terminologique';
$string['searchcards'] = 'Rechercher des fiches';
$string['searchdom'] = 'Rechercher par sous-domaine';
$string['searchlanguage'] = 'Rechercher par langue';
$string['searchproyect'] = 'Rechercher par projet';
$string['searchterm'] = 'Rechercher par terme';
$string['searchtopdf'] = 'Résultat de la recherche en PDF';
$string['searchword'] = 'Mot/s indroduit';
$string['seealso'] = 'Voir aussi:';
//--a�adido--
$string['selimagen'] = 'Ajouter une image';
$string['selvideo'] = 'Ajouter une vidéo';
$string['seltypesearch'] = 'Sélectionnez le critère de recherche et écrivez/choisissez la case correspondante';
$string['setlang'] = 'Choix de la langue';
$string['showauthors'] = 'Gérer les auteurs';
$string['showaudio'] = 'Gérer les sons';
$string['showbe'] = 'Voir les instructions';
$string['showcards'] = 'Voir les fiches';
$string['showcr'] = 'Voir les références croisées';
$string['showimagen'] = 'Gérer les images';
$string['showlang'] = 'Gérer les langues';
$string['showsubdom'] = 'Voir les domaines';
$string['showsubdoms'] = 'Gérer les sous-domaine';
$string['showrt'] = 'Voir les termes liés';
$string['showty'] = 'Voir les projets';
$string['showsyn'] = 'Voir les synonymes';
$string['showvideo'] = 'Gérer les vidéos';

//---a�adido---
$string['showim'] = 'Voir les images';
$string['showvi'] = 'Voir les vidéos';
$string['showau'] = 'Son';
$string['siglas'] = 'Sigles';
$string['sources'] = 'Sources';
//---a�adido---
$string['src'] = 'Source:';
$string['src_image'] = 'Sources de l\'image';
//---a�adido---
$string['src_video'] = 'Sources de la vidéo';
$string['student'] = 'Elève';
$string['subdom'] = 'Sous-domaines';
$string['subdomain'] = 'Sous-domaine';
$string['surname'] = 'Nom';
//---a�adido---
$string['synonym'] = 'Synonymes :';
$string['synonymm'] = 'Synonyme';


//---a�adido---
$string['symbols'] = 'Symbole';
$string['teacher'] = 'Professeur';
$string['term'] = 'Terme';
$string['termnoexists'] = 'Le terme n\'existe pas dans le dictionnaire';
$string['termnoexistslang'] = 'Le terme n\'est pas disponible dans cette langue dans le dictionnaire';
//--a�adido---
$string['term_already_exists'] = 'Le terme existe déjà. Voulez-vous vraiment introduire une autre fois le terme?';
//--a�adido---
$string['title_image'] = 'Titre de l\'image';
$string['title_video'] = 'Titre de la vidéo';

$string['ty'] = 'Projet';
$string['updateaudionok'] = 'Erreur à l\'actualisation du son';
$string['updateaudiook'] = 'Le son a été actualisé correctement';
$string['updateaunok'] = 'Erreur à l\'actualisation de l\'auteur';
$string['updateauok'] = 'L\'auteur a été actualisé correctement';
$string['updatebenok'] = 'Erreur à l\'actualisation de l\'institution';
$string['updatebeok'] = 'L\'institution a été actualisée correctement';
$string['updatesynnok'] = 'Erreur à l\'actualisation du synonyme';
$string['updatesynok'] = 'Le synonyme a été actualisé correctement';
$string['updatedomsdnok'] = 'Erreur à l\'actualisation du sous-domaine';
$string['updatedomsdok'] = 'Le sous-domaine a été actualisé correctement';
$string['updateimok'] = 'L\'image a été actualisée correctement';
$string['updateimnok'] = 'Erreur à l\'actualisation de l\'image';
$string['updateviok'] = 'La vidéo a été actualisée correctement';
$string['updatevinok'] = 'Erreur à l\'actualisation de la vidéo';
$string['updatenok'] = 'Erreur à l\'actualisation de la fiche terminologique';

$string['updateok'] = 'La fiche terminologique a été actualisée correctement';
$string['updatertnok'] = 'Erreur à l\'actualisation du terme lié';
$string['updatecrnok'] = 'Erreur à l\'actualisation du terme en relation croisée';
$string['updatertok'] = 'Le terme lié a été actualisé correctement';
$string['updatecrok'] = 'Le terme en relation croisée a été actualisé correctement';
$string['updatetynok'] = 'Erreur à l\'actualisation du projet';
$string['updatetyok'] = 'Le projet a été actualisé correctement';
$string['usernotable'] = 'Erreur, vous ne pouvez pas accéder à l\'activité.';
$string['f'] = 'Féminin';
$string['m'] = 'Masculin';
$string['adj'] = 'Adjectif';
$string['adv'] = 'Adverbe';
$string['vtr'] = 'Verbe transitif';
$string['vintr'] = 'Verbe intransitif';
$string['videos'] = 'Vidéos:';
$string['viewfullcard'] = 'Voir la fiche complète';
$string['viewlang'] = 'Voir les langues';

//Remisiones
$string['rem'] = 'Renvois';
$string['sin'] = 'Synonymes';
$string['fv'] = 'Variante formelle';
$string['acr'] = 'Acronyme';
$string['abr'] = 'Abréviation';
$string['abrform'] = 'Forme abréviée';
$string['sci_na'] = 'Nom scientifique';
$string['sim'] = 'symbole';
$string['diat_var'] = 'Variante diatopique';
$string['diaf_var'] = 'Variante diafasique';
$string['hiper'] = 'Hyperonyme';
$string['hipo'] = 'Hyponyme';
$string['cohipo'] = 'Cohyponyme';
$string['anton'] = 'Antonyme';
$string['reject_form'] = 'Forme contestable';
$string['obs'] = 'Terme obsoléte';
//marca de ponderacion
$string['wm'] = 'Marque de pondération';
$string['nor'] = 'Terme réglementaire ou normalisé ';
$string['neo'] = 'Neologisme en approbation';
$string['pen'] = 'Terme en étude';
$string['reject'] = 'Terme contestable';


//$string['terminology'] = 'Terminologie';
$string['modulename'] = 'Dictionnaire Eurogene';
$string['modulenameplural'] = 'Dictionnaires Eurogene';


//$string['newmodulefieldset'] = 'Custom example fieldset';
//$string['newmoduleintro'] = 'newmodule Intro';
//$string['newmodulename'] = 'newmodule Name';

?>
