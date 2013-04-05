<?php

require_once("../../config.php");
//require_once("db_functions.php");
//require_once("lib.php");

function echo_hidden_form($id,$idheader,$bes,$authors,$ty,$domsubdom,$prevformimagen,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$numfieldsremission,$rem_type,$remission,$audio,$video,$originpage)
{
	global $CFG;
																	
	echo "<FORM NAME=\"endaddimform\" METHOD=\"post\" ACTION=\"\" ENCTYPE=\"multipart/form-data\">";
	//hidden fields for the addcard form to be filled with the data the user previously entered
	for($i=0;$i<count($bes);$i++){
		echo "<INPUT TYPE=\"hidden\" NAME=\"be[]\" VALUE=\"".$bes[$i]."\"\>";
	}
	for($i=0;$i<count($authors);$i++){
		echo "<INPUT TYPE=\"hidden\" NAME=\"author[]\" VALUE=\"".$authors[$i]."\"\>";
	}

	echo "<INPUT TYPE=\"hidden\" NAME=\"ty\" VALUE=\"".$ty."\"\>";
	
	for($i=0;$i<count($domsubdom);$i++){
		echo "<INPUT TYPE=\"hidden\" NAME=\"domsubdom[]\" VALUE=\"".$domsubdom[$i]."\"\>";
	}
	
	for($i=0;$i<count($prevformimagen);$i++){
		echo "<INPUT TYPE=\"hidden\" NAME=\"prevformimagen[]\" VALUE=\"".$prevformimagen[$i]."\"\>";
	}
	
	// Connect to the database
    $link = connect_genetic($CFG->dbhost,$CFG->dbuser,$CFG->dbpass,$CFG->dbname);
    
    // parameter depending on the language
    
    //take the ids of the languages of the dictionary
    $query=genetic_id_lang($id);
    $resultlang = mysql_query($query,$link);
    while($langrow=mysql_fetch_array($resultlang)){
    	
    	$idlanguage=$langrow['genetic_lang_id'];
    	echo "<INPUT TYPE=\"hidden\" NAME=\"isolang$idlanguage.\" value=\"".$isolang[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"term$idlanguage\" value=\"".$term[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"gramcat$idlanguage\" value=\"".$gramcat[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"definition$idlanguage\" value=\"".$definition[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"context$idlanguage\" value=\"".$formcontext[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"expression$idlanguage\" value=\"".$expression[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"notes$idlanguage\" value=\"".$notes[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"weight_type$idlanguage\" value=\"".$weight_type[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourceterm$idlanguage\" value=\"".$sourceterm[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcedefinition$idlanguage\" value=\"".$sourcedefinition[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcecontext$idlanguage\" value=\"".$sourcecontext[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourceexpression$idlanguage\" value=\"".$sourceexpression[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcerv$idlanguage\" value=\"".$sourcerv[$idlanguage]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcenotes$idlanguage\" value=\"".$sourcenotes[$idlanguage]."\"\>";

		$k=0;
		for($z=1;$z<=$numfieldsremission[$idlanguage];$z++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"remtype_".$idlanguage."_".$z."\" value=\"".$rem_type[$idlanguage][$k]."\"\>";
			echo "<INPUT TYPE=\"hidden\" NAME=\"remission_".$idlanguage."_".$z."\" value=\"".$remission[$idlanguage][$k]."\"\>";
			$k++;
		}
		
		echo "<INPUT TYPE=\"hidden\" NAME=\"numfieldsremission$idlanguage\" VALUE=\"".$numfieldsremission[$idlanguage]."\"\>";
		for($r=0;$r<count($audio[$idlanguage]);$r++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"audio".$idlanguage."[]\" VALUE=\"".$audio[$idlanguage][$r]."\"\>";
		}
		
		for($e=0;$e<count($video[$idlanguage]);$e++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"video".$idlanguage."[]\" VALUE=\"".$video[$idlanguage][$e]."\"\>";
		}
		
		
	}
	if($originpage=='edit'){
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("continue", "genetic")."\" NAME=\"buttoncontinue\" onClick=\"this.form.action='editcard_form.php?id=$id&idheader=$idheader';this.form.submit();\"/>";
	}else{
		echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("continue", "genetic")."\" NAME=\"buttoncontinue\" onClick=\"this.form.action='addcard_form.php?id=$id';this.form.submit();\"/>";
	}
	echo "</FORM>";
}
	
?>