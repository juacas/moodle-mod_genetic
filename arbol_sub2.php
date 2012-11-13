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

function genetic_subdominios2($nivel=0)
{
   
   $query_rsRegistro = genetic_arbol($nivel);
   $rsRegistro = mysql_query($query_rsRegistro);
                  
   $row_rsRegistro = mysql_fetch_assoc($rsRegistro);
   $totalRows_rsRegistro = mysql_num_rows($rsRegistro);
	
   // Comprobamos que no esta vacia
   if($totalRows_rsRegistro > 0)
   {
    
      // Inicializamos la lista
      echo '<ul>';

      // Mostramos todos los resultados
      do
      {
		
		$route='http://eurogene.open.ac.uk/theme';
		//$destiny=$route.'/'.$row_rsRegistro['name'];
		$row_rsRegistro2['name']=str_replace(" ","-",$row_rsRegistro['name']);
          echo '<li><A HREF="http://eurogene.open.ac.uk/theme/'.$row_rsRegistro2['name'].'" target=\"blank\" ><FONT COLOR="#238E23">'.$row_rsRegistro['name']."</FONT></A>";

		  
         // Ejecutamos la funcion dentro de si misma
         // Y le pasamos el id del registro actual
         genetic_subdominios2($row_rsRegistro['id']);

         echo '</li>';
      }
      while($row_rsRegistro = mysql_fetch_assoc($rsRegistro));

      echo '</ul>';
	 
   }
}
?>
