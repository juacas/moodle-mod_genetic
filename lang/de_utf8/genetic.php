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
//---hinzugefügt---
$string['abreviaturas'] = 'Abkürzungen :';
$string['accept'] = 'Annehmen';
$string['action'] = 'Aktion';
//---hinzugefügt---
$string['acronyms'] = 'Akronyme :';
$string['advaudio'] = 'Der Audiodateiname muss das folgende Muster haben: Name_Begriff.Erweiterung';
$string['addaudio'] = 'Audio hinzufügen';
$string['addauthor'] = 'Neuen Autor/Neue Autorin hinzufügen';
$string['addbe'] = 'Neue Institution hinzufügen';
$string['addcard'] = 'Karteikarte hinzufügen';
$string['addcardf'] = 'Neue terminologische Karteikarte hinzufügen';
$string['adddom'] = 'Neuen Bereich hinzufügen';
//---hinzugefügt---
$string['addim'] = 'Neues Bild hinzufügen';
$string['addlang'] = 'Neue Sprache hinzufügen';
$string['addau'] = 'Neues Audio hinzufügen';
$string['addvi'] = 'Neues Video hinzufügen';
$string['addrt'] = 'Neuen verwandten Begriff hinzufügen';
$string['addcr'] = 'Neuen verknüpften Begriff hinzufügen';
$string['addsubdom'] = 'Neuen Unterbereich hinzufügen';
$string['addsynonym'] = 'Neues Synonym hinzufügen';
$string['addty'] = 'Neues Projekt hinzufügen';
$string['admin'] = 'Administrator';
$string['alphaorder'] = 'Alphabetisch sortiert:';

$string['ar'] = 'Arabisch';
$string['asc'] = 'Datum ASC';
$string['author'] = 'Autor/en';
$string['audio'] = 'Audio';
$string['audio_video'] = 'Sprache des Audios im Video';
$string['be'] = 'Institution/en';
$string['belongto'] = 'Gehört';
$string['buttonaddau'] = 'Autor hinzufügen';
$string['buttonaddaudio'] = 'Audio hinzufügen';
$string['buttonaddbe'] = 'Institution hinzufügen';
$string['buttonadddom'] = 'Bereich hinzufügen';
//hinzugefügt
$string['buttonaddim'] = 'Bild hinzufügen';
$string['buttonaddrt'] = 'Verwandten Begriff hinzufügen';
$string['buttonaddcr'] = 'Verknüpften Begriff hinzufügen';
$string['buttonaddlang'] = 'Sprache hinzufügen';
$string['buttonaddty'] = 'Projekt hinzufügen';
$string['buttonaddsubdom'] = 'Unterbereich hinzufügen';
$string['buttonaddsyn'] = 'Synonym hinzufügen';
$string['buttonaddvi'] = 'Video hinzufügen';
$string['buttongeneralsearch'] = 'Allgemeine Suche' ;
$string['cancel'] = 'Abbrechen';
$string['cards'] = 'Karteikarten';
$string['category'] = 'Kategorie';
$string['chooselang'] = 'Sprache auswählen:';
$string['commonheaderdata'] = 'Gemeinsame Daten für alle Sprachen der terminologischen Karteikarte';
$string['context'] = 'Kontext';
$string['continue'] = 'Fortsetzen';
$string['criteria'] = 'Suchkriterium';
//---hinzugefügt---
$string['crossrelatedterms'] = 'Verknüpfte Begriffe';
$string['crosstermsentence'] = 'Dieser Begriff kommt auch in den folgenden Einträgen vor';
$string['datecreated'] = 'Erstellungsdatum / Änderungsdatum ';
$string['indexuse'] = 'Verwenden Sie diesen Index, um die Karteikarten nach dem Datum der Erstellung / Änderung oder alphabetisch entsprechend der ausgewählten Sprache zu sortieren:';
$string['datemodified'] = 'Änderungsdatum ';
$string['date'] = 'Datum:';
//---hinzugefügt---
$string['de'] = 'Deutsch ';
$string['definition'] = 'Definition';
$string['delete'] = 'Löschen';
$string['deleteau'] = 'Audio löschen';
$string['deleteausure'] = ' Sind Sie sicher, dass Sie das Audio löschen wollen?';
$string['deleteauused'] = 'Der Autor kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet';
$string['deleteauthor'] = 'Autor/in löschen';
$string['deleteauthorused'] = "Der Autor kann nicht gelöscht werden, da er im Wörterbuch verwendet wird.";
$string['deleteaunok'] = 'Fehler beim Löschen des Autors/ der Autorin';
$string['deleteauok'] = 'Autor/in erfolgreich gelöscht';
$string['deleteauthorsure'] = ' Sind Sie sicher, dass Sie den Autor/ die Autorin löschen wollen?';
$string['deletebe'] = 'Institution löschen';
$string['deletebeused'] = 'Die Institution kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletebenok'] = 'Fehler beim Löschen der Institution';
$string['deletebeok'] = 'Institution erfolgreich gelöscht';
$string['deletebesure'] = ' Sind Sie sicher, dass Sie die Institution löschen wollen?';
$string['deleteremission'] = 'Verweis löschen';
$string['deletesynsure'] = ' Sind Sie sicher, dass Sie das Synonym löschen wollen?';
$string['deletecard'] = 'Terminologische Karteikarte löschen';
$string['deletecardsure'] = ' Sind Sie sicher, dass Sie die terminologische Karteikarte löschen wollen?';
$string['deletedomused'] = 'Der Unterbereich kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletedom'] = 'Bereich löschen';
$string['deletedomparent'] = 'Der Unterbereich kann nicht gelöscht werden; er kommt noch an einer anderen Stelle vor';
//---hinzugefügt---
$string['deleteim'] = 'Bild löschen';
$string['deletevi'] = 'Video löschen';
$string['deleteimnok'] = 'Fehler beim Löschen des Bildes';
$string['deleteaunok'] = 'Fehler beim Löschen des Audios';
$string['deleteimok'] = 'Bild erfolgreich gelöscht';
$string['deletelangok'] = 'Sprache erfolgreich gelöscht';
$string['deletelangnok'] = 'Fehler beim Löschen der Sprache';
$string['deleteaudiook'] = 'Audio erfolgreich gelöscht';
$string['deletevinok'] = 'Fehler beim Löschen des Videos';
$string['deleteviok'] = 'Video erfolgreich gelöscht';
$string['deleteauused'] = 'Das Audio kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deleteimused'] = 'Das Bild kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet';
$string['deletelangused'] = 'Die Sprache kann nicht gelöscht werden. Die Sprache wird von einer terminologischen Karteikarte verwendet.';
$string['deleteviused'] = 'Das Video kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletedomsdnok'] = 'Fehler beim Löschen des Unterbereiches';
$string['deletedomsdok'] = 'Unterbereich erfolgreich gelöscht';
$string['deletedomsdsure'] = ' Sind Sie sicher,  dass Sie den Unterbereich löschen wollen?';

$string['deletenok'] = 'Fehler beim Löschen der terminologischen Karteikarte';
$string['deletelangsure'] = ' Sind Sie sicher, dass Sie die Sprache löschen wollen?';
$string['deleteok'] = 'Terminologische Karteikarte erfolgreich gelöscht';
$string['deletert']='Verwandten Begriff löschen';
$string['deletecr']='Verknüpften Begriff löschen';
$string['deletertnok'] = 'Fehler beim Löschen des verwandten Begriffs';
$string['deletertok'] = 'Verwandter Begriff erfolgreich gelöscht';
$string['deletecrok'] = 'Verknüpfter Begriff wurde erfolgreich gelöscht';
$string['deletertsure'] = ' Sind Sie sicher, dass Sie den verwandten Begriff löschen wollen ?';
$string['deletecrsure'] = ' Sind Sie sicher,  dass Sie den  verknüpften Begriff löschen wollen ?';
$string['deletertused'] = 'Verwandten Begriff löschen';
$string['deletecrused'] = 'Verknüpften Begriff löschen';
$string['deletesubdom'] = 'Unterbereich löschen';
$string['deletesubdomused'] = 'Der Unterbereich kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletesynonym']='Synonym löschen';
$string['deletety'] = 'Projekt löschen';
$string['deletetyused'] = 'Das Projekt kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletesynused'] = 'Das Synonym kann nicht gelöscht werden. Der Eintrag wird von einer terminologischen Karteikarte verwendet.';
$string['deletesynnok'] = 'Fehler beim Löschen des Synonyms';
$string['deletesynok'] = 'Synonym erfolgreich gelöscht';
$string['deletetynok'] = 'Fehler beim Löschen des Projekts';
$string['deletecrnok'] = 'Fehler beim Löschen des verknüpften Begriffs';
$string['deletetyok'] = 'Projekt erfolgreich gelöscht';
$string['deletetysure'] = ' Sind Sie sicher, dass Sie das Projekt löschen wollen?';
$string['deleteimsure'] = ' Sind Sie sicher, dass Sie das Bild löschen wollen?';
$string['deletevisure'] = ' Sind Sie sicher, dass Sie das Video löschen wollen?';
$string['desc'] = 'Datum DESC';
$string['description'] = 'Beschreibung';
$string['detail'] = 'Details ansehen';
$string['dom'] = 'Bereich';
$string['subdomview'] = 'Hierarchische Ansicht der Unterbereiche';
$string['edit'] = 'Bearbeiten';
$string['editau'] = 'Audio bearbeiten';
$string['editauthor'] = 'Autor/in bearbeiten';
$string['editbe'] = 'Institution bearbeiten';
$string['editcard'] = 'Terminologische Karteikarte bearbeiten';
$string['editdom'] = 'Bereich bearbeiten';
//---hinzugefügt---

$string['editim'] = 'Bild bearbeiten';
$string['editsyn'] = 'Synonym bearbeiten';
$string['editvi'] = 'Video bearbeiten';
$string['editrt'] = 'Verwandten Begriff bearbeiten';
$string['editcr'] = 'Verknüpften Begriff bearbeiten';
$string['editsubdom'] = 'Unterbereich bearbeiten';
$string['editty'] = 'Projekt bearbeiten';
$string['emptyfield'] = 'Pflichtfeld leer. Überprüfen Sie die oben genannten Daten';
$string['emptyfieldterm'] = 'Leeres Feld. Geben Sie den Begriff ein, zu dem Sie suchen möchten';
$string['emptyfieldauthor'] = 'Leeres Feld. Geben Sie den Autor ein, zu dem Sie suchen möchten.';
$string['emptyfielddom'] = 'Leeres Feld. Geben Sie den Bereich ein, zu dem Sie suchen möchten.';
$string['emptyfieldgramcat'] = 'Leeres Feld. Bitte wählen Sie eine grammatische Kategorie aus.';
$string['emptyfieldheader'] = 'Pflichtfeld nicht ausgewählt. Überprüfen Sie die gemeinsamen Daten der terminologischen Karteikarten';
$string['emptyfieldisolang'] = 'Leeres Feld. Bitte wählen Sie die Sprache aus, zu der Sie suchen wollen.';
$string['emptyfieldlanguage'] = 'Leeres Pflichtfeld der Sprache. Überprüfen Sie die Daten im Bezug auf die Begriffe.';
$string['emptysearchtype'] = 'Bitte wählen Sie ein Suchkriterium aus und füllen dieses aus.';
//---hinzugefügt---
$string['en'] = 'Englisch';
$string['errordb'] = 'Fehler beim Auswählen der Datenbank bezüglich des aktuellen Vorgangs. Versuchen Sie es erneut.';
$string['errorvideoextension'] = "Die Erweiterung oder die Größe der Dateien ist nicht passend. <br><br><table><tr><td><li>Dateien .wav o .avi o .wmv<br><li> sind erlaubt. Dateien bis maximal 100 MB sind erlaubt.</td></tr></table>";
$string['es'] = 'Spanisch';
$string['expression'] = 'Ausdrucksweise';
$string['errextensionimage']="Die Erweiterung oder die Größe der Dateien ist nicht passend. <br><br><table><tr><td><li> Dateien .gif o .jpg<br><li> sind erlaubt. Dateien bis maximal 100MB sind erlaubt.</td></tr></table>";
$string['errnameimageexists'] = 'Der Dateiname existiert bereits.<br><br><table><tr><td><li>Es ist nicht erlaubt zwei Dateien mit dem gleichen Namen hochzuladen.</td></tr></table>';
$string['errnamevideoexists'] = 'Der Dateiname existiert bereits.<br><br><table><tr><td><li>Es ist nicht erlaubt zwei Dateien mit dem gleichen Namen hochzuladen.</td></tr></table>';
$string['fileuploadcorrect']='Die Datei wurde erfolgreich hochgeladen.';
$string['footsentences'] = 'In Zusammenarbeit mit dem Ministerium für Bildung der Junta de Castilla y León.';
$string['fr'] = 'Französisch';
$string['genetic'] = 'Genetik';
$string['gramcat'] = 'Grammatische Kategorie.';
$string['guest'] = 'Gast';
$string['imagenes'] = 'Bilder :';
$string['insertaunok'] = 'Fehler beim Einfügen des Autors/ der Autorin';
$string['insertaudiook'] = 'Audio erfolgreich eingefügt';
$string['insertaudionok'] = 'Fehler beim Einfügen des Audios';
$string['insertauok'] = 'Autor/in erfolgreich eingefügt';
$string['insertbenok'] = 'Fehler beim Einfügen der Institution';
$string['insertbeok'] = 'Institution erfolgreich eingefügt';
$string['insertdomsdnok'] = 'Fehler beim Einfügen des Unterbereichs';
$string['insertdomsdok'] = 'Unterbereich erfolgreich eingefügt';
$string['insertlangok'] = ' Sprache erfolgreich eingefügt';
$string['insertdomsexist'] = 'Fehler beim Einfügen. Der Unterbereich existiert bereits';
$string['insertauexist'] = 'Fehler beim Einfügen. Der Dateiname des Audios existiert bereits';
$string['insertimexist'] = 'Fehler beim Einfügen. Der Dateiname des Bildes existiert bereits';
$string['insertviexist'] = 'Fehler beim Einfügen. Der Dateiname des Audios existiert bereits';
$string['insertimnok'] = 'Fehler beim Einfügen des Bildes';
$string['insertimok'] = ' Bild erfolgreich eingefügt';
$string['insertvinok'] = 'Fehler beim Einfügen des Videos';
$string['insertviok'] = ' Video erfolgreich eingefügt';
$string['insertnok'] = 'Fehler beim Einfügen der terminologischen Karteikarte';
$string['insertok'] = 'Terminologische Karteikarte erfolgreich eingefügt';
$string['insertrtnok'] = 'Fehler beim Einfügen des verwandten Begriffs';
$string['insertrtused'] = 'Der verwandete Begriff ist in dieser Sprache schon im Wörterbuch vorhanden';
$string['insertcrnok'] = 'Fehler beim Einfügen des verknüpften Begriffs';
$string['insertcrused'] = 'Der verknüpfte Begriff ist in dieser Sprache schon im Wörterbuch vorhanden';
$string['insertrtok'] = 'Verwandeter  Begriff erfolgreich eingefügt';
$string['insertcrok'] = 'Verknüpften Begriff erfolgreich eingefügt';
$string['insertsynok'] = 'Synonym erfolgreich eingefügt';
$string['insertsynnok'] = 'Synonym erfolgreich eingefügt';
$string['insertsynused'] = 'Das Synonym ist in dieser Sprache ist schon im Wörterbuch vorhanden';
$string['inserttynok'] = 'Fehler beim Einfügen des Projekts';
$string['inserttyok'] = 'Projekt erfolgreich eingefügt';
$string['labelspecial'] = 'Karteikarten, deren Begriff nicht mit einem Buchstaben beginnt, anzeigen';
//---hinzugefügt---
$string['lang'] = 'Sprache';
$string['langdicexist'] = ' Es ist schon im Wörterbuch vorhanden';
$string['languagecarddata'] = 'Einzelheiten für jede Sprache der terminologische Karteikarte';
$string['link'] = 'Link';
$string['linksubd'] = 'Auf jeden Unterbereich klicken, um  auf den topic Browser Eurogene zuzugreifen';
$string['maximumchars'] = 'Maximale Anzahl der Zeichen';
$string['modau'] = 'Audio ändern';
$string['modimagen'] = 'Bild ändern';
$string['name'] = 'Name';
$string['nameexists'] = 'Der Name existiert bereits';
$string['newsearch'] = 'Neue Suche';
$string['ni'] = 'Identifikationsnummer';
$string['noaudiofound'] = 'Keine Audio-Dateien in dieser Sprache vorhanden';
$string['nodefined'] = 'Nicht definiert';
$string['nodescrlang'] = 'Keine Beschreibung vorhanden';
$string['noentries'] = 'Keine terminologischen Karteikarten gefunden';
$string['noentriesterm'] = ' Keine Begriffe in dieser Sprache vorhanden';
$string['noexistauthor'] = 'Der gesuchte Autor ist nicht in der Datenbank vorhanden.';
$string['noinsertlangdic'] = 'Sprache nicht im Wörterbuch eingefügt.';
$string['nolang'] = 'Keine Sprachen im Wörterbuch vorhanden';
$string['noresultauthor'] = 'Keine entsprechende(n) Autor(en) gefunden';
$string['noresultdom'] = 'Keine terminologische Karteikarten in dem ausgewählten Bereich gefunden.';
$string['noresultgeneral'] = 'Keine Übereinstimmung in den terminologischen Karteikarten gefunden.';
$string['noresultgramcat'] = 'Keine terminologischen Karteikarten in der ausgewählten grammatischen Kategorie gefunden.';
$string['noresultisolang'] = 'Keine terminologische Karteikarten in der ausgewählten Sprache gefunden.';
$string['noresultterm'] = 'Keinen entsprechenden Begriff(e) gefunden';
$string['nosources'] = 'Keine Quellen für den Begriff gefunden';
$string['nosrcimage'] = 'Keine Quellen für das Bild gefunden';
$string['nosrcvideo'] = 'Keine Quellen für das Video gefunden';
$string['notermsadded'] = 'Es wurden in keiner Sprache Begriffe hinzugefügt';
$string['notes'] = 'Anmerkungen';
$string['nummatch'] = 'Anzahl der Übereinstimmungen';
//----hinzugefügt---
$string['pieimagen'] = 'Bildbeschreibung (es)';
$string['pieimagen_fr'] = 'Bildbeschreibung (fr)';
$string['pieimagen_en'] = 'Bildbeschreibung (en)';
$string['pieimagen_de'] = 'Bildbeschreibung (de)';
$string['pievideo'] = 'Videobeschreibung (es)';
$string['pievideo_fr'] = 'Videobeschreibung (fr)';
$string['pievideo_en'] = 'Videobeschreibung (en) ';
$string['pievideo_de'] = 'Videobeschreibung (de)';
$string['reference'] = 'Verweise';
//---hinzugefügt---
$string['relatedterms'] = 'Verwandte Begriffe';
$string['reliabilitycode'] = 'Zuverlässigkeitsangabe';
$string['requiredfields'] = '(*) Pflichtfelder';
$string['resultsearch'] = 'Suchergebnis';
$string['rv'] = 'Verweise';
$string['save'] = 'Speichern';
$string['search'] = 'Suchen';
$string['searchauthor'] = 'Nach Autor suchen';
$string['searchcard'] = 'Terminologische Karteikarte suchen';
$string['searchcards'] = 'Karteikarten suchen';
$string['searchdom'] = 'Nach Unterbereich suchen';
$string['searchlanguage'] = 'Nach Sprache suchen';
$string['searchproyect'] = 'Nach Projekt suchen';
$string['searchterm'] = 'Nach Begriff suchen';
$string['searchtopdf'] = 'Suchergebnis als pdf';
$string['searchword'] = 'Eingegebene(s) Wort/Wörter';
$string['seealso'] = 'Siehe auch:';
//--hinzugefügt--
$string['selimagen'] = 'Bild hinzufügen';
$string['selvideo'] = 'Video hinzufügen';
$string['seltypesearch'] = 'Wählen Sie das Suchkriterium aus und schreiben/wählen Sie (in) das entsprechende Feld';
$string['setlang'] = 'Spracheinstellungen';
$string['showauthors'] = 'Autoren verwalten';
$string['showaudio'] = 'Audios verwalten';
$string['showbe'] = 'Institutionen anzeigen';
$string['showcards'] = 'Karteikarten anzeigen';
$string['showcr'] = 'Veknüpfte Begriffe anzeigen';
$string['showimagen'] = 'Bilder verwalten';
$string['showlang'] = 'Sprachen verwalten';
$string['showsubdom'] = 'Bereiche anzeigen';
$string['showsubdoms'] = 'Unterbereiche verwalten';
$string['showrt'] = 'Verwandte Begriffe anzeigen';
$string['showty'] = 'Projekte anzeigen';
$string['showsyn'] = 'Synonyme anzeigen';
$string['showvideo'] = 'Videos verwalten';

//---hinzugefügt---
$string['showim'] = 'Bilder anzeigen';
$string['showvi'] = 'Videos anzeigen';
$string['showau'] = 'Audio';
$string['siglas'] = 'Abkürzungen';
$string['sources'] = 'Quellen';
//---hinzugefügt---
$string['src'] = 'Quelle:';
$string['src_image'] = 'Bildquellen';
//---hinzugefügt---
$string['src_video'] = 'Videoquellen';
$string['student'] = 'Nutzer';
$string['subdom'] = 'Unterbereiche';
$string['subdomain'] = 'Unterbereich';
$string['surname'] = 'Familiennamen';
//---hinzugefügt---
$string['synonym'] = 'Synonyme :';
$string['synonymm'] = 'Synonym';


//---hinzugefügt---
$string['symbols'] = 'Symbole';
$string['teacher'] = 'Lehrender';
$string['term'] = 'Begriff';
$string['termnoexists'] = 'Der Begriff ist nicht im Wörterbuch vorhanden';
$string['termnoexistslang'] = 'Der Begriff ist in dieser Sprache nicht im Wörterbuch vorhanden';
//--hinzugefügt---
$string['term_already_exists'] = 'Der Begriff existiert bereits. Bitte bestätigen Sie, dass Sie den Begriff nochmal einfügen möchten?';
//--hinzugefügt---
$string['title_image'] = 'Bildtitel';
$string['title_video'] = 'Videotitel';

$string['ty'] = 'Projekt';
$string['updateaudionok'] = 'Fehler beim Aktualisieren des Audios';
$string['updateaudiook'] = 'Audio erfolgreich aktualisiert';
$string['updateaunok'] = 'Fehler beim Aktualisieren des Autors';
$string['updateauok'] = 'Autor erfolgreich aktualisiert';
$string['updatebenok'] = 'Fehler beim Aktualisieren der Institution';
$string['updatebeok'] = 'Institution erfolgreich aktualisiert';
$string['updatesynnok'] = 'Fehler beim Aktualisieren des Synonyms';
$string['updatesynok'] = 'Synonym erfolgreich aktualisiert';
$string['updatedomsdnok'] = 'Fehler beim Aktualisieren des Unterbereiches';
$string['updatedomsdok'] = 'Unterbereich erfolgreich aktualisiert';
$string['updateimok'] = 'Bild erfolgreich aktualisiert';
$string['updateimnok'] = 'Fehler beim Aktualisieren des Bildes';
$string['updateviok'] = 'Video erfolgreich aktualisiert';
$string['updatevinok'] = 'Fehler beim Aktualisieren des Videos';
$string['updatenok'] = 'Fehler beim Aktualisieren der terminologischen Karteikarte';

$string['updateok'] = 'Terminologische Karteikarte erfolgreich aktualisiert';
$string['updatertnok'] = 'Fehler beim Aktualisieren des verwandten Begriffs';
$string['updatecrnok'] = 'Fehler beim Aktualisieren des verknüpften Begriffs';
$string['updatertok'] = 'Verwanter Begriff erfolgreich aktualisiert';
$string['updatecrok'] = 'Verknüpfter Begriff erfolgreich aktualisiert';
$string['updatetynok'] = 'Fehler beim Aktualisieren des Projekts';
$string['updatetyok'] = 'Projekt erfolgreich aktualisiert';
$string['usernotable'] = 'Fehler, Sie haben keinen Zugang zu der Aktivität.';
$string['f'] = 'Feminin';
$string['m'] = 'Maskulin';
$string['adj'] = 'Adjektiv';
$string['adv'] = 'Adverb';
$string['vtr'] = 'Transitives Verb';
$string['vintr'] = 'Intransitives Verb';
$string['videos'] = 'Videos:';
$string['viewfullcard'] = 'Vervollständige Karteikarte anzeigen';
$string['viewlang'] = 'Sprachen anzeigen';

//Verweise 
$string['rem'] = 'Verweise';
$string['sin'] = 'Synonym';
$string['fv'] = 'Formale Variante';
$string['acr'] = 'Akronym';
$string['abr'] = 'Abkürzung';
$string['abrform'] = 'Abgekürzte Form';
$string['sci_na'] = 'Wissenschaftlicher Name';
$string['sim'] = 'Symbol';
$string['diat_var'] = 'diatopische Variante';
$string['diaf_var'] = 'diaphasische Variante';
$string['hiper'] = 'Hyperonym';
$string['hipo'] = 'Hyponym';
$string['cohipo'] = 'Kohyponym';
$string['anton'] = 'Antonym';
$string['reject_form'] = 'Abgelehnte Form';
$string['obs'] = 'Veralteter Begriff';
//Grad der Lexikalisierung (im Wörterbuch)
$string['wm'] = 'Grad der Lexikalisierung (im Wörterbuch)';
$string['nor'] = 'Standardisierter oder normierter Begriff';
$string['neo'] = ' 	Noch nicht anerkannter Neologismus';
$string['pen'] = 'Der Begriff muss noch bearbeitet werden';
$string['reject'] = 'Abgelehnter Begriff';


//$string['terminology'] = 'Terminology';
$string['modulename'] = 'Wörterbuch Eurogene';
$string['modulenameplural'] = 'Wörterbücher Eurogene';


//$string['newmodulefieldset'] = 'Custom example fieldset';
//$string['newmoduleintro'] = 'newmodule Intro';
//$string['newmodulename'] = 'newmodule Name';

?>

