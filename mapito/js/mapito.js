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

// dynload
var $myAjax = null;
var PosX = 0.16551;
var PosY = 0.36212;
var DivW = -1;
var DivH = -1;

// orig pic px
var PicOrigW = 14000;
var PicOrigH = 6140;

// zoooom
var ZoomLevels = [0.15, 0.25, 0.5, 0.8, 1];
var ZoomLevel = 2; // the index of the ZoomLevels


//////////////////////////////////////////////////////////////////////////////
// dynload
function doDynLoad()
{

    // update the infobox
    var infobox = 'x='+PosX+'<br/>y='+PosY+'<br/>w='+DivW+'<br/>h='+DivH+'<br/>z='+ZoomLevels[ZoomLevel];
    $('#infobox').html(infobox);

    if ($myAjax != null) {
        $myAjax.abort();
    }

    $myAjax =  $.ajax({
        type: "GET",
        url: "./mapito/img/dynTile.php",
        data: 'x='+PosX+'&y='+PosY+'&w='+DivW+'&h='+DivH+'&z='+ZoomLevels[ZoomLevel],
        success: function(data){

            var myHideState = $('#hideContainer').is(':visible')
            $('#dynLoad').html(data);

            if (myHideState) {
                showcontent();
            }

            $('#dynLoad').css("top", "0px");
            $('#dynLoad').css("left", "0px");

            $("#dynLoad").dblclick(function(e) {
                zoom(+1, true, e);
            });

            $("#dynLoad").draggable(
                {
                    start: function(e) {
                        hidecontent();

                    },
                    stop: function(e) {

                        // neue kalkulation der pos
                        var myPixelX = (PicOrigW * ZoomLevels[ZoomLevel] * PosX) - (parseInt($('#dynLoad').css("left"))) ;
                        var myPixelY = (PicOrigH * ZoomLevels[ZoomLevel] * PosY) - (parseInt($('#dynLoad').css("top"))) ;

                        PosX = 1 / (PicOrigW * ZoomLevels[ZoomLevel]) * myPixelX ;
                        PosY = 1 / (PicOrigH * ZoomLevels[ZoomLevel]) * myPixelY ;

                        getDynLoad();
                    }
                }
            );

        }
    });

    return;
}


//////////////////////////////////////////////////////////////////////////////
// zoom
function zoom(myZoom, dblclick, e)
{
    hidecontent();

    if (ZoomLevel + myZoom < 0 || ZoomLevel + myZoom >= ZoomLevels.length) {
        // don't change the new zoom!
    } else {

        // if dblclick is done also set the new position
        if (dblclick) {

            var XClickPos =  0 - DivW/2 + e.pageX;
            var YClickPos =  0 - DivH/2 + e.pageY;

            var myPixelX = (PicOrigW * ZoomLevels[ZoomLevel] * PosX) + XClickPos ;
            var myPixelY = (PicOrigH * ZoomLevels[ZoomLevel] * PosY) + YClickPos ;

            PosX = 1 / (PicOrigW * ZoomLevels[ZoomLevel]) * myPixelX ;
            PosY = 1 / (PicOrigH * ZoomLevels[ZoomLevel]) * myPixelY ;
        }

        ZoomLevel = ZoomLevel + myZoom;
        doDynLoad();
    }
}


//////////////////////////////////////////////////////////////////////////////
// check after drag if dynload is nessesary
function getDynLoad()
{
    var dynLoad = false ;

    // -----------------------------------------------------------------------------------------
    // check if top left must be loaded
    var dynLoadTop = parseInt($('#dynLoad').css("top"));
    var mapContainerTop = parseInt($('#mapContainer').css("top"));
    var newMapContainerTop = mapContainerTop + dynLoadTop;

    if (newMapContainerTop < 0)  {
        $('#dynLoad').css("top", "0px")

        $('#mapContainer').css("top", newMapContainerTop+"px") ;
        $('#txtContainer').css("top", newMapContainerTop+"px") ;
    } else {
        dynLoad = true ;
    }

    var dynLoadLeft = parseInt($('#dynLoad').css("left"));
    var mapContainerLeft = parseInt($('#mapContainer').css("left"));
    var newMapContainerLeft = mapContainerLeft + dynLoadLeft;

    if (newMapContainerLeft < 0)  {
        $('#dynLoad').css("left", "0px")

        $('#mapContainer').css("left", newMapContainerLeft+"px");
        $('#txtContainer').css("left", newMapContainerLeft+"px");
    } else {
        dynLoad = true ;
    }

    // -----------------------------------------------------------------------------------------
    // check if bottom right must be loaded
    if ( parseInt($('#mapContainer').css("width")) + newMapContainerLeft < DivW ) {
        dynLoad = true ;
    }

    if ( parseInt($('#mapContainer').css("height")) + newMapContainerTop < DivH ) {
        dynLoad = true ;
    }

    // update the infobox
    var infobox = 'x='+PosX+'<br/>y='+PosY+'<br/>w='+DivW+'<br/>h='+DivH+'<br/>z='+ZoomLevels[ZoomLevel];
    $('#infobox').html(infobox);

    if (dynLoad)
    {
        doDynLoad();
    }

    return;
}


//////////////////////////////////////////////////////////////////////////////
// resize

var resizeTimer = null;

function resizeFrame()
{
    DivW = $("#mask").width();
    DivH = $("#mask").height();
    doDynLoad();
}


//////////////////////////////////////////////////////////////////////////////
// pointer handling
function pointerRollover(myID)
{
    $("#leg_"+myID).show();
}

function pointerRolloverEnd(myID)
{
    $("#leg_"+myID).hide();
}


//////////////////////////////////////////////////////////////////////////////
// page load
var LoadBackground = true;


//////////////////////////////////////////////////////////////////////////////
// map & content switch
// this functions are to interact with a content-div 
function hidecontent()
{
    /*
     $("#hidecontent").hide();
     $("#contentcontainer").hide();
     $("#hideContainer").hide();
     */
}

function showcontent()
{
    /*
     $("#contentcontainer").show();
     $("#hidecontent").show();
     $("#hideContainer").show();
     */
}


//////////////////////////////////////////////////////////////////////////////
// start here
$(document).ready(function () {


    // wenn 200ms nicht mehr gesized wird,
    // dann den Inhalt lschen
    $(window).bind('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(resizeFrame, 200);
    });


    //handle the zoomin
    $('#zoomin').click(function(e) {
        zoom(+1, false, e);
    });

    $('#zoomout').click(function(e) {
        zoom(-1, false, e);
    });


    if (LoadBackground) {
        resizeFrame();
        LoadBackground = false;
    }
});