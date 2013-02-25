<?php // $Id: index.php,v 1.1 2012/06/30 23:23:00 Ana María lozano de la Fuente Exp $
/**
 * This page lists all the instances of terminology in a particular course
 **/

    require_once("../../config.php");
    require_once("lib.php");
    //require_once("$CFG->dirroot/course/lib.php");

    $id = required_param('id', PARAM_INT);   // course ID

    if (! $course = get_record("course", "id", $id)) {
        error("Course ID is incorrect");
    }

	require_course_login($course);
    $context = get_context_instance(CONTEXT_COURSE, $course->id);
    add_to_log($course->id, "terminology", "view all", "index.php?id=$course->id", "");
	
/// Get all required strings
    $strgenetics = get_string("modulenameplural", "genetic");
    $strgenetic  = get_string("modulename", "genetic");

/// Print the header
    $navlinks = array();
    $navlinks[] = array('name' => $strgenetics, 'link' => "index.php?id=$course->id", 'type' => 'activity');
    $navigation = build_navigation($navlinks);

	print_header_simple("$strgenetics", "", $navigation, "", "", true, "", navmenu($course));
	
/// Get all the appropriate data
    if (! $genetics = get_all_instances_in_course("genetic", $course)) {
        notice(get_string('thereareno', 'moodle', $strgenetics), "../../course/view.php?id=$course->id");
        die;
    }

/// Print the list of instances
    $timenow = time();
    $strname  = get_string("name");
    $strweek  = get_string("week");
    $strtopic  = get_string("topic");
    $strcards  = get_string("cards", "genetic");	

    if ($course->format == "weeks") {
        $table->head  = array ($strweek, $strname, $strcards);
        $table->align = array ("CENTER", "LEFT", "CENTER");
    } else if ($course->format == "topics") {
        $table->head  = array ($strtopic, $strname, $strcards);
        $table->align = array ("CENTER", "LEFT", "CENTER");
    } else {
        $table->head  = array ($strname, $strcards);
        $table->align = array ("LEFT", "CENTER");
    }	

	$currentsection = "";
	
    foreach ($genetics as $genetic) {
        if (!$genetic->visible && has_capability('moodle/course:viewhiddenactivities', $context)) {
            //Show dimmed if the mod is hidden
	        $link = "<A CLASS=\"dimmed\" href=\"view.php?id=$genetic->coursemodule\">".format_string($genetic->name,true)."</A>";
        } else if ($genetic->visible) {
            //Show normal if the mod is visible
            $link = "<A HREF=\"view.php?id=$genetic->coursemodule\">".format_string($genetic->name,true)."</A>";
        } else {
            // Don't show the genetic.
            continue;
        }
		
		$printsection = "";
        if ($genetic->section !== $currentsection) {
            if ($genetic->section) {
                $printsection = $genetic->section;
            }
            if ($currentsection !== "") {
                $table->data[] = 'hr';
            }
            $currentsection = $genetic->section;
        }
		
		// TODO: count only approved if not allowed to see them
        $count = count_records_sql("SELECT COUNT(*) FROM {$CFG->prefix}genetic_headercards where (id_genetic = $genetic->id)");
		
		if ($course->format == "weeks" or $course->format == "topics") {
            $linedata = array ($printsection, $link, $count);
        } else {
            $linedata = array ($link, $count);
        }

        $table->data[] = $linedata;		
    }
	
    echo "<BR />";

    print_table($table);

/// Finish the page
    print_footer($course);

?>
