<?php  // $Id: projectmanagement.php,v 1.0 2012/06/11 18:11:00 Ana Mar�a Lozano de la Fuente Exp $
/**
 * Library of functions and constants for module terminology
 * This file should have two well differenced parts:
 *   - All the core Moodle functions, neeeded to allow
 *     the module to work integrated in Moodle.
 *   - All the newmodule specific functions, needed
 *     to implement all the module logic. Please, note
 *     that, if the module become complex and this lib
 *     grows a lot, it's HIGHLY recommended to move all
 *     these module specific functions to a new php file,
 *     called "locallib.php" (see forum, quiz...). This will
 *     help to save some memory when Moodle is performing
 *     actions across all modules.
 */

$genetic_CONSTANT = 7;     /// for example

/**
 * Given an object containing all the necessary data, 
 * (defined by the form in mod.html) this function 
 * will create a new instance and return the id number 
 * of the new instance.
 *
 * @param object $instance An object from the form in mod.html
 * @return int The id of the newly inserted newmodule record
 **/
function genetic_add_instance($genetic) {
    
    // temp added for debugging
    echo "ADD INSTANCE CALLED";
    print_object($genetic);
    
	//Si a�adimos campos en mod_form, evaluar aqui si se marcaron o por defecto se definen aqui
	//(ejemplo, lib de glossary)
	
	//insert_record($genetic_lang, $language, $returnid=true, $primarykey=�id�);
	//$genetic->insert_record("genetic_lang", $language, $returnid=true, $primarykey=�id�);

    $genetic->timecreated = time();
	$genetic->timemodified = $genetic->timecreated;
	
	if ($returnid = insert_record("genetic", $genetic)) {
        $genetic->id = $returnid;
        $genetic = stripslashes_recursive($genetic);
	}
	
    return $returnid;    
}


/**
 * Given an object containing all the necessary data, 
 * (defined by the form in mod.html) this function 
 * will update an existing instance with new data.
 *
 * @param object $instance An object from the form in mod.html
 * @return boolean Success/Fail
 **/
function genetic_update_instance($genetic) {

    $genetic->timemodified = time();
    $genetic->id = $genetic->instance;

    return update_record("genetic", $genetic);
}


/**
 * Given an ID of an instance of this module, 
 * this function will permanently delete the instance 
 * and any data that depends on it. 
 *
 * @param int $id Id of the module instance
 * @return boolean Success/Failure
 **/
function genetic_delete_instance($id) {

    if (! $genetic = get_record("genetic", "id", "$id")) {
        return false;
    }

    $result = true;

    /*Datos dependientes de la instancia que tenga que borrar???????????????????????????????????*/

    if (! delete_records("genetic", "id", "$genetic->id")) {
        $result = false;
    }

    return $result;
}


/**
 * Return a small object with summary information about what a 
 * user has done with a given particular instance of this module
 * Used for user activity reports.
 * $return->time = the time they did it
 * $return->info = a short text description
 *
 * @return null
 * @todo Finish documenting this function
 **/
function genetic_user_outline($course, $user, $mod, $genetic) {
    return $return;
}

/**
 * Print a detailed representation of what a user has done with 
 * a given particular instance of this module, for user activity reports.
 *
 * @return boolean
 * @todo Finish documenting this function
 **/
function genetic_user_complete($course, $user, $mod, $genetic) {
    return true;
}

/**
 * Given a course and a time, this module should find recent activity 
 * that has occurred in newmodule activities and print it out. 
 * Return true if there was output, or false is there was none. 
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 **/
function genetic_print_recent_activity($course, $isteacher, $timestart) {
    global $CFG;

    return false;  //  True if anything was printed, otherwise false 
}

/**
 * Function to be run periodically according to the moodle cron
 * This function searches for things that need to be done, such 
 * as sending out mail, toggling flags etc ... 
 *
 * @uses $CFG
 * @return boolean
 * @todo Finish documenting this function
 **/
function genetic_cron () {
    global $CFG;

    return true;
}

/**
 * Must return an array of grades for a given instance of this module, 
 * indexed by user.  It also returns a maximum allowed grade.
 * 
 * Example:
 *    $return->grades = array of grades;
 *    $return->maxgrade = maximum allowed grade;
 *
 *    return $return;
 *
 * @param int $newmoduleid ID of an instance of this module
 * @return mixed Null or object with an array of grades and with the maximum grade
 **/
function genetic_grades($geneticid) {
   return NULL;
}

/**
 * Must return an array of user records (all data) who are participants
 * for a given instance of newmodule. Must include every user involved
 * in the instance, independient of his role (student, teacher, admin...)
 * See other modules as example.
 *
 * @param int $newmoduleid ID of an instance of this module
 * @return mixed boolean/array of students
 **/
function genetic_get_participants($geneticid) {
    return false;
}

/**
 * This function returns if a scale is being used by one newmodule
 * it it has support for grading and scales. Commented code should be
 * modified if necessary. See forum, glossary or journal modules
 * as reference.
 *
 * @param int $newmoduleid ID of an instance of this module
 * @return mixed
 * @todo Finish documenting this function
 **/
function genetic_scale_used ($geneticid,$scaleid) {
    $return = false;

    //$rec = get_record("newmodule","id","$newmoduleid","scale","-$scaleid");
    //
    //if (!empty($rec)  && !empty($scaleid)) {
    //    $return = true;
    //}
   
    return $return;
}

/**
 * Checks if scale is being used by any instance of newmodule.
 * This function was added in 1.9
 *
 * This is used to find out if scale used anywhere
 * @param $scaleid int
 * @return boolean True if the scale is used by any newmodule
 */
function genetic_scale_used_anywhere($scaleid) {
    if ($scaleid and record_exists('genetic', 'grade', -$scaleid)) {
        return true;
    } else {
        return false;
    }
}




//////////////////////////////////////////////////////////////////////////////////////
/// Any other newmodule functions go here.  Each of them must have a name that 
/// starts with newmodule_
/// Remember (see note in first lines) that, if this section grows, it's HIGHLY
/// recommended to move all funcions below to a new "localib.php" file.

/**
 * Checks the text fields array extracted from a form
 * If the param (not NULL) is empty "" return 1.
 *
 */
 function genetic_field_not_null ($array, $narray) {
 
	$empty = 0;
	for($i=0; $i<$narray; $i++) {

		if ($array[$i]=='') {
			
			return ($empty=1);
			
		}
	}
}

// Function that returns the number of empty elements of an array.
function count_genetic_field_null($term , $definition, $gramcat, $context) {
	$empty = 0;
	if(($gramcat=='none')||($gramcat==null))$empty++;
	if($term==null)$empty++;
	if($definition==null)$empty++;
	if($context==null)$empty++;	
	return $empty;
}

function genetic_field_which_null ($array, $narray) {
 
	$empty = 0;
	for($i=0; $i<$narray; $i++) {

		if ($array[$i]=='') {
			
			return ($i);
			
		}
	}
}

/**
 * Checks the numerical fields array extracted from a form
 * If the param (not NULL) is zero '0', return 1.
 *
 */
 function genetic_field_not_zero ($array, $narray) {
 
	$empty = 0;
	for($i=0; $i<$narray; $i++) {

		if ($array[$i]==0) {
			return ($empty=1);
		}
	}
}
 function genetic_field_zero_data ($array, $narray) {
 
	$empty = 0;
	for($i=0; $i<$narray; $i++) {

		if ($array[$i]==0) {
		
			return ($i);
		}
	}
}

/**
 * Checks the selected fields extracted from a form
 * If the param (not NULL) is zero '0', return 1.
 *
 */
 function genetic_field_not_selected ($param) {
 
	$empty = 0;
	if ($param == 0) {
		return ($empty=1);
	}
}


/**
 * Checks the fields array extracted from a form
 * If the param (not NULL) is zero '0', return 1.
 *
 */
 function genetic_field_not_selected_null ($param) {
 
	$empty = 0;
	if ($param == '') {
			return ($empty=1);
	}
}


/**
 * Creates an array with gramatic categories and return it to the form. *
 */
 function genetic_array_gramcat ($namelang) {

	// Get the gramatical categories in the specified language
	

	// Make an array with this categories
	if($namelang=='de'){
	  $gramcat = array ("f", "m", "n", "adj", "adv", "vtr", "vintr"); // German includes also neutral 
	} else{		
	$gramcat = array ("f", "m", "adj", "adv", "vtr", "vintr");
	}
	
	return ($gramcat);
}

/**
 * Creates an array with weighting mark and return it to the form. *
 */
 function genetic_array_weighting_mark () {
	
	$weighting_mark = array ("nor", "neo", "pen", "reject");

	return ($weighting_mark);
}

/**
 * Creates an array with weighting mark and return it to the form. *
 */
 function genetic_array_type_rem () {
	
	$type_rem = array ("sin", "fv", "acr", "abr", "abrform", "sci_na", "sim", "diat_var", "diaf_var", "hiper", "hipo", "cohipo", "anton", "reject_form", "obs");

	return ($type_rem);
}
/**
 * Creates an array with languages and return it to the form. *
 */
 function genetic_array_isolang () {

	$a_isolang = array ("de", "es", "fr","en");

	return ($a_isolang);
}

?>
