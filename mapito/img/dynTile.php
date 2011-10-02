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

// error_reporting(E_ALL);
// ini_set('display_errors', '1');

header("Cache-Control: no-cache");
header("Pragma: no-cache");

include_once "./mapito.php";

$tile = new shTile();

$tile->setZoom(floatval($_GET["z"]) );
$tile->PosX = floatval($_GET["x"]);
$tile->PosY = floatval($_GET["y"]);
$tile->DivW = intval($_GET["w"]);
$tile->DivH = intval($_GET["h"]);

print $tile->genDrag();

?>