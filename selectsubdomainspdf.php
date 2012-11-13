<?php
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

//Calcular la ruta de subdominios al origen

function calcular_ruta_subdominiospdf($headerrowsubdomiddom,$cadena){
	
	
//encontrar el subdominio con ese id											
$query2= genetic_subdomain_by_id($headerrowsubdomiddom );
$resultdom2 = mysql_query($query2);
										
$row2=mysql_fetch_array($resultdom2);
												
//Subdominio de la ficha												
$subdomparent = stripslashes($row2['name']);												
$subdomparentid = stripslashes($row2['iddom']);
//------------
//busco a su padre
$query3= genetic_subdomain_by_id($subdomparentid);
$resultdom2 = mysql_query($query3);
$row2=mysql_fetch_array($resultdom2);
//-------
												
//Concatenate the subdomains 
$aux= stripslashes($row2['name']);
$auxid= stripslashes($row2['id']);
if(($subdomparent=="")&&($aux=="")){$subdomparent = $aux." ".$subdomparent; }
												
else{$subdomparent = $aux." / ".$subdomparent;}
												
$n = mysql_num_rows($resultdom2);
	
$cadena=$subdomparent."/".$cadena;
	//echo"id: ".$auxid;												
 if($auxid==0){
 									
	//echo "" .$cadena." ";
	$pdf->Cell(5,5,$cadena);
												
}	
if($subdomparentid>0){	

$query2= genetic_subdomain_by_id($subdomparentid, $subdomparent );
$resultdom2 = mysql_query($query2);
										
$row2=mysql_fetch_array($resultdom2);
												
//Subdominio de la ficha												
$subdomparent = stripslashes($row2['name']);												
$subdomparentid = stripslashes($row2['iddom']);
//$cadena=$subdomparent;
											
calcular_ruta_subdominiospdf($subdomparentid,$cadena);																										
}										
}?>
