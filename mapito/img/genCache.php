<?php
/*
Copyright (C) 2011  Stefan Huber, Signalwerk GmbH

This file is part of mapito.

mapito is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

mapito is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with mapito.  If not, see <http://www.gnu.org/licenses/>.
*/

// to run in ssh do
// php -c/etc/php5/cgi/php.ini genCach.php

// to change the permission to the web-user
// do something like
// chown -R signalwerk:psacln ./img/cach/

set_time_limit(600000); 

include_once "./mapito.php";

$tile = new shTile();
$tile->setZoom(0.125);	
$tile->PosX = 0.5;
$tile->PosY = 0.5;

if (ob_get_level() == 0) ob_start(); 

foreach($tile->ZoomLevels as $myLevel) {

	$tile->setZoom($myLevel);	
	
	$tile->DivW = 15000 * $myLevel;
	$tile->DivH = 15000 * $myLevel;	
    
	$tile->genDrag();
}

print "end";

?>
