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

if ($_GET["dev"]== 1) {
    ?>
<div  style='background-color: #f0f; z-index: 215; position: absolute; width:100%; height:1px; left: 0px; top: 50%;'>

</div>

<div  style='background-color: #f0f; z-index: 210; position: absolute; width:1px; height:100%; left:  50%; top: 0px;'>

</div>

<div id="infobox" style='color: #666; z-index: 810; position: absolute; left: 50px;'></div>

<?php
}
?><html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="iso-8859-1"/>
    <!--
        ********************************************
        *  Programming, HTML & CSS by              *
        *  Stefan Huber | signalwerk.ch            *
        ********************************************
    -->

    <title>mapito</title>
    <meta content="mapito" name="generator">
    <meta content="GNU v3" name="copyright">

    <link media="all" href="./mapito/css/mapito.css" type="text/css" rel="stylesheet">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="./mapito/js/mapito.js"></script>

</head>
<body>

<div unselectable="on" class="olControlPanZoomBar olControlNoSelect" id="PanZoomBar">
    <div id="zoomout">
        <img alt="" src="./mapito/img/minus.png" style="position: relative; width: 18px; height: 18px;"
             id="zoomout_innerImage">
    </div>
    <div id="zoomin">
        <img alt="" src="./mapito/img/plus.png" style="position: relative; width: 18px; height: 18px;" id="zoomin_innerImage">
    </div>
</div>

<div style="background-color: #666; width: 100%; height: 100%;" id="mask">
    <div style="cursor: move; position: absolute; top: 0px; left: 0px;" class="drag" id="dynLoad">
    </div>
</div>

</body>
</html>