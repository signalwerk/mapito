=====================================================================================
mapito                 Version 0.1                                               2011
=====================================================================================
 
Stefan Huber           signalwerk.ch
-------------------------------------------------------------------------------------

With mapito you can realize smal map-tools like you can see it on 
http://www.caminantes-grafico.org/


Latest Version
-------------------------------------------------------------------------------------
https://github.com/signalwerk/mapito


Requirement
-------------------------------------------------------------------------------------
– Php 5.x
– ImageMagick


ToDo
-------------------------------------------------------------------------------------
– At the moment the HTML-Code after a drag is coming from a php-Script. It could be 
  done in pure JavaScript and therefore without the requirement for PHP-Server.
– The coordinate system would be nice to have it in geo-coordinates.
– The quality of the code is not best. Refactoring should be done.

Install
-------------------------------------------------------------------------------------
– Copy the whole Project to your Server
– Convert the world.svg to a png (world.png) by browsing to the following URL:
  path_to_your_installation/mapito/img/svg2png.php
– Generate the cache for the tiles by browsing to the following URL:
  path_to_your_installation/mapito/img/genCache.php
  ATTENTION! This process generates 4970 png-Files in the subfolder 
  path_to_your_installation/mapito/img/cache
  To generate this cache it can take several hours and you may have a time
  limit to run php-Scripts on your server. Solution: ssh access to your server
  and run "php genCache.php"
– Brows to your path of the installation and enjoy mapito.


Configuration
-------------------------------------------------------------------------------------
– To edit the needles on the map edit the following file:
  path_to_your_installation/needles.php
– For position-help brows to the following URL:
  path_to_your_installation/index.php?dev=1


Links
-------------------------------------------------------------------------------------

Worldmaps
https://www.cia.gov/library/publications/the-world-factbook/docs/refmaps.html
http://commons.wikimedia.org/wiki/File:BlankMap-World6.svg
http://commons.wikimedia.org/wiki/File:World_Blank_Map_%28Mercator_projection%29.svg

Coordinate-Systems
http://www.phpclasses.org/package/2542-PHP-Convert-geographic-coordinates-between-projections.html#files
http://de.wikipedia.org/wiki/Mercator-Projektion
http://www.informatik.uni-leipzig.de/~sosna/karten/mercator1.html


License
-------------------------------------------------------------------------------------
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