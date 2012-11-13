<?php  // $Id: tabs.php,v 1.0 2012/06/26 18:47:00 Ana María Lozano de la Fuente Exp $
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

/**
* prints the tabbed bar
*
* @version $Id: tabs.php,v 1.3 2007/07/07 21:43:28 agrabs Exp $
* @author Andreas Grabs
* @license http://www.gnu.org/copyleft/gpl.html GNU Public License
* @package genetic
*/

    $tabs = array();
    $row  = array();
    $inactive = array();
    $activated = array();

    $courseid = optional_param('courseid', false, PARAM_INT);
    $current_tab = $SESSION->genetic->current_tab;

    // Show all Cards tab
        $row[] = new tabobject('cards', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/view.php?id='.$id), 
								get_string('showcards', 'genetic'));
		
    // Add new Cards tab
        $row[] = new tabobject('addcard', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/addcard_form.php?id='.$id), 
								get_string('addcard', 'genetic'));
		
    // Add new Search tab
        $row[] = new tabobject('searchcard', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/search_form.php?id='.$id), 
								get_string('searchcards', 'genetic'));
								
	// Add new Authors tab
        $row[] = new tabobject('showaus', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewauthor.php?id='.$id), 
								get_string('showauthors', 'genetic'));
		
    // Add new Domains/Subdomains tab
        $row[] = new tabobject('showdom', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewdom.php?id='.$id), 
								get_string('showsubdoms', 'genetic'));

	// Add new Departments tab
        $row[] = new tabobject('showbe', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewbe.php?id='.$id), 
								get_string('showbe', 'genetic'));
								
	// Add new Card Types tab
        $row[] = new tabobject('showty', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewty.php?id='.$id), 
								get_string('showty', 'genetic'));
	// Set languages
        $row[] = new tabobject('showlang', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewlang.php?id='.$id), 
								get_string('showlang', 'genetic'));
							
	// Add new syn
      /*  $row[] = new tabobject('showsyn', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewsyn.php?id='.$id), 
								get_string('showsyn', 'genetic'));
		*/												
	// Add new images
       /* $row[] = new tabobject('showim', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewim.php?id='.$id), 
								get_string('showim', 'genetic'));
		*/						
	// Add new videos
       /* $row[] = new tabobject('showvi', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewvi.php?id='.$id), 
								get_string('showvi', 'genetic'));	
		*/
	// Add new audio
       /* $row[] = new tabobject('showau', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewau.php?id='.$id), 
								get_string('showau', 'genetic'));
		*/						
	// Add new Card Types related terms
       /* $row[] = new tabobject('showrt', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewrt.php?id='.$id), 
								get_string('showrt', 'genetic'));
		*/						
	// Add new Card Types crossrelations
       /* $row[] = new tabobject('showcr', 
								$CFG->wwwroot.htmlspecialchars('/mod/genetic/viewcr.php?id='.$id), 
								get_string('showcr', 'genetic'));							
		*/													
    if(count($row) > 1) {
        $tabs[] = $row;

        print_tabs($tabs, $current_tab, $inactive, $activated);
    }
	
?>
