<?php



function echo_hidden_form($id,$bes,$authors,$ty,$domsubdom,$prevformimagen,$audio,$isolang,$term,$gramcat,$definition,$formcontext,$expression,$notes,$weight_type,$sourceterm,$sourcedefinition,$sourcecontext,$sourceexpression,$sourcerv,$sourcenotes,$rem_type,$remission)
{
																	
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
	
	for($i=0;$i<count($audio);$i++){
			echo "<INPUT TYPE=\"hidden\" NAME=\"audio[]\" VALUE=\"".$audio[$i]."\"\>";
	}

	$num_languages=count($isolang);
	for($i=0;$i<$num_languages;$i++){
		echo "<INPUT TYPE=\"hidden\" NAME=\"term[]\" value=\"".$term[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"gramcat[]\" value=\"".$gramcat[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"definition[]\" value=\"".$definition[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"context[]\" value=\"".$formcontext[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"expression[]\" value=\"".$expression[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"notes[]\" value=\"".$notes[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"weight_type[]\" value=\"".$weight_type[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourceterm[]\" value=\"".$sourceterm[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcedefinition[]\" value=\"".$sourcedefinition[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcecontext[]\" value=\"".$sourcecontext[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourceexpression[]\" value=\"".$sourceexpression[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcerv[]\" value=\"".$sourcerv[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"sourcenotes[]\" value=\"".$sourcenotes[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"rem_type[]\" value=\"".$rem_type[$i]."\"\>";
		echo "<INPUT TYPE=\"hidden\" NAME=\"remission[]\" value=\"".$remission[$i]."\"\>";
	}
	
	echo "<INPUT TYPE=\"button\" VALUE=\"".$str = get_string("continue", "genetic")."\" NAME=\"buttoncontinue\" onClick=\"this.form.action='addcard_form.php?id=$id';this.form.submit();\"/>";
	
	echo "</FORM>";
}
	
?>