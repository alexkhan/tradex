<?php


/*

The Line Graph generator by Ashish Kasturia (http://www.123ashish.com)
Copyright (C) 2003 Ashish Kasturia (ashish at 123ashish.com)


The Line Graph generator is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, 
USA.

*/



include("linemaker.php");

$l = new Line();

$l->SetBGJPEGImage("../catherine.jpg");
$l->SetTitleColor(255, 255, 255);
$l->SetTitle("Catherine's ice cream consumption!");
$l->AddValue("Week 1", array(2, 4, 5));
$l->AddValue("Week 2", array(3, 10, 3));
$l->AddValue("Week 3", array(1, 7, 4));
$l->AddValue("Week 1", array(4, 6, 2));
$l->AddValue("Week 2", array(3, 11, 7));
$l->AddValue("Week 3", array(5, 3, 10));
$l->SetSeriesLabels(Array("Chocolate", "Strawberry", "Vanilla"));

$l->spit("jpg");


?>
