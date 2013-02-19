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

//To add a new subdomain
function genetic_select_subdomains($nivel=0)
{$query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
   
   $query_rsRegistro2 = genetic_arbol2(0);
	$rsRegistro2 = mysql_query($query_rsRegistro2);
                  
   $row_rsRegistro2 = mysql_fetch_assoc($rsRegistro2);
   $totalRows_rsRegistro2 = mysql_num_rows($rsRegistro2);
	if( $totalRows_rsRegistro2 ==0){echo "<NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</NOBR>";}
   // Comprobamos que no esta vacia
   else if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
		
		$route='http://eurogene.open.ac.uk/theme';
		//$destiny=$route.'/'.$row_rsRegistro['name'];
		
          echo "<li><NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"".$row_rsRegistro['id']."\"><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";

		  
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
         genetic_select_subdomains($row_rsRegistro['id']);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));

      echo '</ul>';
	 
   }
   
}

//To edit a subdomain

function genetic_select_subdomains2($nivel=0,$belongto2)
{$query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
	
   $query_rsRegistro2 = genetic_arbol2(0);
	$rsRegistro2 = mysql_query($query_rsRegistro2);
                  
   $row_rsRegistro2 = mysql_fetch_assoc($rsRegistro2);
   $totalRows_rsRegistro2 = mysql_num_rows($rsRegistro2);
	if( $totalRows_rsRegistro2 ==0){echo "<NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</NOBR>";}
   // Comprobamos que no esta vacia
   else if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
		
		
		if($row_rsRegistro['id']==$belongto2){
			echo "<li><NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"".$row_rsRegistro['id']."\" checked><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
			
		}
		
		else{
			echo "<li><NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"".$row_rsRegistro['id']."\"><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
			
		}	
		  
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
         genetic_select_subdomains2($row_rsRegistro['id'],$belongto2);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));
	
      echo '</ul>';
	 
   }
   
}
//To add a new card, choose subdomain
function genetic_select_subdomains3($nivel=0,$domselected=null)
{$query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
   
   $query_rsRegistro2 = genetic_arbol2(0);
	$rsRegistro2 = mysql_query($query_rsRegistro2);
                  
   $row_rsRegistro2 = mysql_fetch_assoc($rsRegistro2);
   $totalRows_rsRegistro2 = mysql_num_rows($rsRegistro2);
	if( $totalRows_rsRegistro2 ==0){echo "<NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</NOBR>";}
   // Comprobamos que no esta vacia
   else if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
		
		$route='http://eurogene.open.ac.uk/theme';
		//$destiny=$route.'/'.$row_rsRegistro['name'];
		
		$isselected = 0;
		for($i=0;$i<count($domselected);$i++)
		{
			if($row_rsRegistro['id']==$domselected[$i])$isselected=1;
		}
		if($isselected==1){
			echo "<li><NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"".$row_rsRegistro['id']."\" checked><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
		}else{
			echo "<li><NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"".$row_rsRegistro['id']."\"><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
		}
		  
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
         genetic_select_subdomains3($row_rsRegistro['id'],$domselected);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));

      echo '</ul>';
	 
   }
   
}
//To edit a subdomain

function genetic_select_subdomains4($nivel=0)
{$query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
	
   $query_rsRegistro2 = genetic_arbol2(0);
	$rsRegistro2 = mysql_query($query_rsRegistro2);
                  
   $row_rsRegistro2 = mysql_fetch_assoc($rsRegistro2);
   $totalRows_rsRegistro2 = mysql_num_rows($rsRegistro2);
	if( $totalRows_rsRegistro2 ==0){echo "<NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</NOBR>";}
   // Comprobamos que no esta vacia
   else if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
		
		
			echo "<li><NOBR><INPUT TYPE=\"radio\" NAME=\"belongto\" VALUE=\"".$row_rsRegistro['id']."\"><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
			
		  
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
         genetic_select_subdomains4($row_rsRegistro['id'],$belongto2);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));
	
      echo '</ul>';
	 
   }
   
}
//To add a new card, choose subdomain
function genetic_select_subdomains5($nivel=0,$headerni)

{
	$query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
   
   $query_rsRegistro2 = genetic_arbol2(0);
	$rsRegistro2 = mysql_query($query_rsRegistro2);
                  
   $row_rsRegistro2 = mysql_fetch_assoc($rsRegistro2);
   $totalRows_rsRegistro2 = mysql_num_rows($rsRegistro2);
	if( $totalRows_rsRegistro2 ==0){echo "<NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"0\">".$str = get_string("nodefined", "genetic")."</NOBR>";}
	
   // Comprobamos que no esta vacia
   else if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
			$g=0;
			$queryaux = genetic_show_rel_subdomain($headerni);
			$resultaux = mysql_query($queryaux);
			
			while($rowaux = mysql_fetch_array($resultaux)){
			
				$preselected=$rowaux['id'];
				if($preselected==$row_rsRegistro['id']){$g=1;}
			}
			
			if($g==1){
			echo "<li><NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"".$row_rsRegistro['id']."\" checked><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
			
			}
			else{
			echo "<li><NOBR><INPUT TYPE=\"checkbox\" NAME=\"domsubdom[]\" VALUE=\"".$row_rsRegistro['id']."\"><FONT COLOR=\"#238E23\">".$row_rsRegistro['name']."</FONT></A></NOBR>";
			
			}
		 
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
			
         genetic_select_subdomains5($row_rsRegistro['id'],$headerni);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));

      echo '</ul>';
	 
   }
   
}
//Calcular la ruta de subdominios al origen

function calcular_ruta_subdominios($headerrowsubdomiddom,$cadena){
	
	
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
 									
	echo "" .$cadena." ";
												
}	
if($subdomparentid>0){	

$query2= genetic_subdomain_by_id($subdomparentid, $subdomparent );
$resultdom2 = mysql_query($query2);
										
$row2=mysql_fetch_array($resultdom2);
												
//Subdominio de la ficha												
$subdomparent = stripslashes($row2['name']);												
$subdomparentid = stripslashes($row2['iddom']);
//$cadena=$subdomparent;
											
calcular_ruta_subdominios($subdomparentid,$cadena);	

																									
}
												
										
}
								

								

?>

