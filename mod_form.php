<?php  // $Id: mod_form.php,v 1.0 2012/06/08 18:32:00 Ana María Lozano de la Fuente Exp $
 
require_once ($CFG->dirroot.'/course/moodleform_mod.php');

class mod_genetic_mod_form extends moodleform_mod {

	function definition() {

		global $COURSE;
		$mform    =& $this->_form;

//-------------------------------------------------------------------------------
    // Adding the "general" fieldset, where all the common settings are showed
        $mform->addElement('header', 'general', get_string('general', 'form'));
		
    // Adding the standard "name" field
        $mform->addElement('text', 'name', get_string('name', 'genetic'), array('size'=>'64'));		
		if (!empty($CFG->formatstringstriptags)) {
            $mform->setType('name', PARAM_TEXT);
        } else {
            $mform->setType('name', PARAM_CLEAN);
        }
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', 'genetic', 255), 'maxlength', 255, 'client');
				
    // Adding the optional "description"
        $mform->addElement('htmleditor', 'description', get_string('description', 'genetic'));
        $mform->setType('description', PARAM_RAW);
        $mform->addRule('description', get_string('required'), 'required', null, 'client');
        $mform->setHelpButton('description', array('writing', 'questions', 'text'), false, 'editorhelpbutton');
		
	/*
	//Add a new language
    $mform->addElement('header', 'general', get_string('setlang', 'genetic'));
	
	//$mform->addElement('hidden', 'genetic_id', '$course->id');
		$isolang = genetic_array_isolang();
			$numlang=count ($isolang);
			 
		for($i=0;$i<$numlang;$i++){	
		
					$mform->addElement('checkbox','language[]',get_string($isolang[$i], 'genetic'),array('group' => 1), array(0, 1));
					$mform->setType('language', PARAM_TEXT);
					$mform->addRule('language', get_string('lang', 'genetic'), 'not required', null, 'server');
			
					//$checkboxes = array('checkbox','language',get_string($isolang[$i], 'genetic'));
	
		}
		*/	
//-------------------------------------------------------------------------------
        $this->standard_coursemodule_elements(array('groups'=>false, 'groupmembersonly'=>true));

//-------------------------------------------------------------------------------

        // buttons
        $this->add_action_buttons();
//------------------------------------------------		
    }
	
}
?>