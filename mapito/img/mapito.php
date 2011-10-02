<?php
/*


*/

class shTile {

    // x und y 0-1
    public $PosX, $PosY;
    public $DivW, $DivH;
    public $TileFile;

    // HTML stuff
    public $ViewW, $ViewH;
    public $OffsetX, $OffsetY;

    //private $FilePath, $TileW, $TileH;
    private $RootPath, $RootCachePath;

    //gr�sse der einzelnen Kacheln
    private $TileW, $TileH;

    // speichert die Gr�sse des Originalbildes
    public $PicOrigW, $PicOrigH;

    // speichert die Gr�sse des skallierten Bildes
    private $PicScaleW, $PicScaleH;

    // die berechneten shifts
    private $TilesCountX, $TilesCountY, $TileStartX, $TileStartY;

    // die erlaubten ZoomLevels
    public $ZoomLevels;
    private $ZoomLevel;

    // original tile
    private $imgOrig = null;


    function __construct( ) {
        // later; do it by prefs
        $this->RootPath = './';
        $this->RootCachePath = $this->RootPath.'cache/';
        $this->TileFile('world.png');

        $this->ZoomLevel = 1; // Index of zoom level
        $this->ZoomLevels = array(0.15, 0.25, 0.5, 0.8, 1);

        $this->PosX = 0.5;
        $this->PosY = 0.5;
        $this->DivW = 400;
        $this->DivH = 250;

        $this->DivXshift = 0;
        $this->DivYshift = 0;

        $this->TileW = 200;
        $this->TileH = 200;
    }


    function setZoom($myZoom) {

        if ( in_array($myZoom, $this->ZoomLevels) ) {
            $this->ZoomLevel = $myZoom;
        }
    }


    function getZoom() {
        return $this->ZoomLevel;
    }


    function TileFile($myTileFile ) {
        $this->TileFile = $myTileFile;

        // Get new dimensions
        list($this->PicOrigW, $this->PicOrigH) = getimagesize($this->RootPath.$this->TileFile);
        //$this->PicOrigW = 14000;
        //$this->PicOrigH = 6140;
    }

    function genDrag( ) {
        $myOut = "";

        $this->PicScaleW = $this->PicOrigW * $this->ZoomLevel;
        $this->PicScaleH = $this->PicOrigH * $this->ZoomLevel;

        // wo liegt nun die mitte auf dem skallierten Bild?
        $PicCenterPosX = $this->PicScaleW * $this->PosX;
        $PicCenterPosY = $this->PicScaleH * $this->PosY;

        // berechnet, bei wievielen tiles von links und ober begonnen werden muss. floor = abgerundet
        $this->TileStartX = floor(($PicCenterPosX-($this->DivW/2)) / $this->TileW);
        $this->TileStartY = floor(($PicCenterPosY-($this->DivH/2)) / $this->TileH);


        // berechnet nun, um wieviel das ganze verschoben werden muss um die grobe Kachelung auszugleichen
        // ergibt einen Negativ-Wert im Div?shift
        $this->DivXshift = ($this->TileW * $this->TileStartX) - ($PicCenterPosX-($this->DivW/2));
        $this->DivYshift = ($this->TileH * $this->TileStartY) - ($PicCenterPosY-($this->DivH/2));

        // berechnet die Anzahl Kacheln, die gerechnet werden m�ssen. ceil = aufgerundet
        $this->TilesCountX = ceil((abs($this->DivXshift)+$this->DivW) / $this->TileW) ;
        $this->TilesCountY = ceil((abs($this->DivYshift)+$this->DivH) / $this->TileH) ;

        $myOut .= "<div id='txtContainer' style='width: ".$this->TilesCountX*$this->TileW."px; height: ".$this->TilesCountY*$this->TileH."px; left: ".$this->DivXshift."px; top: ".$this->DivYshift."px;'>";

        $myOut .= "<div id='hideContainer'  style='display: none;'>";
        $myOut .= "</div>";




        include_once "./../../needles.php";
        // $myPointers = dynPointers();



        for ($i = 0; $i < count($myPointers); $i++) {


            $myCurrentPoint = $myPointers[$i];
            // zh on new map
            $PointX    = $myCurrentPoint["PointX"];
            //print_r ($myCurrentPoint["PointX"]);

            $PointY    = $myCurrentPoint["PointY"];

            $PointText = $myCurrentPoint["PointText"];
            $Link   = $myCurrentPoint["Link"];



            $PointerPicW     = 25;
            $PointerPicWHalf = 12;
            $PointerPicH     = 41;


            // gibt an, wo die linke bildkante liegt
            $pxPointX =  ($this->DivW/2) - ($this->PicScaleW*$this->PosX) + ($this->PicScaleW * $PointX);
            $pxPointY =  ($this->DivH/2) - ($this->PicScaleH*$this->PosY) + ($this->PicScaleH * $PointY);

            //            DIV
            //            689	/   2
            //                           345

            $EndPointX = $pxPointX - $this->DivXshift - $PointerPicWHalf ;
            $EndPointY = $pxPointY - $this->DivYshift - $PointerPicH ;


            $myOut .= "<div  class='pointerDiv' style='height: ".$PointerPicH."px; left: ".floor($EndPointX)."px; top: ".floor($EndPointY)."px;'>";


            $myOut .= "<div id='leg_".$i."' class='legPointer'>";
            $myOut .= $PointText;
            $myOut .= "</div>";


            $myOut .= "<div id='point_".$i."' class='imgPointer'>";

            $myOut .= "<img ";
            // $myOut .= "id='point_".$Link."'";
            // $myOut .= "onClick='pointerAction(".$Link.",\"".$PointText."\")'";



            $myOut .= "onClick='parent.location=\"".$Link."\"' ";
            $myOut .= "onmouseover='pointerRollover(".$i.")' ";
            $myOut .= "onmouseout='pointerRolloverEnd(".$i.")' ";


            $myOut .= "style='width: ".$PointerPicW."px; height: ".$PointerPicH."px; class='PointerImage' ";
            $myOut .= "src='./mapito/img/pointer.png'/>";

            $myOut .= "</div>";

            $myOut .= "</div>";

        }


        $myOut .= '</div>';
        $myOut .= '</div>';

        $myOut .= "<div id='mapContainer' style='width: ".$this->TilesCountX*$this->TileW."px; height: ".$this->TilesCountY*$this->TileH."px; left: ".$this->DivXshift."px; top: ".$this->DivYshift."px;'>";
        $myOut .= $this->generateDIV();
        $myOut .= '</div>';

        return $myOut;
    }


    public function generateDIV() {

        $myOut = "";

        for ($x = $this->TilesCountX; $x > 0; $x--)
        {
            for ($y = $this->TilesCountY; $y > 0; $y--)
            {
                $myOffsetX = ($x * $this->TileW)-$this->TileW;
                $myOffsetY = ($y * $this->TileH)-$this->TileH;

                $myOut .= '<div style="position: absolute; z-index: 1; left: '.$myOffsetX.'px; top: '.$myOffsetY.'px; width: '.$this->TileW.'px; height: '.$this->TileH.'px;">';

                $myOut .= "<img ";
                $myOut .= "id='tile_x".($this->TileStartX+$x)."_y".($this->TileStartY+$y)."'";
                $myOut .= "style='width: ".$this->TileW."px; height: ".$this->TileH."px; position: relative;' class='TileImage' ";

                $myOut .= "src='".$this->generateIMG($this->TileStartX+$x,$this->TileStartY+$y)."'/>";

                $myOut .= "</div>";
            }
        }

        return $myOut;
    }

    public function generateIMG($x,$y) {

        if ($x < 0) {
            $x = -1;
        }

        if ($y < 0) {
            $y = -1;
        }

        if ($this->TileW * ($x-1) > $this->PicScaleW) {
            $x = -1;
        }
        if ($this->TileH * ($y-1) > $this->PicScaleH) {
            $y = -1;
        }

        $HashTileName = md5(
                            "TileFile_".$this->TileFile.
                            "TileX_".$x.
                            "TileY_".$y.
                            "ZoomLevel_".$this->ZoomLevel.
                            "TileW_".$this->TileW.
                            "TileH_".$this->TileH
                        ).".png";

        $HashTilePath = $this->RootCachePath.$HashTileName;

        if (file_exists($HashTilePath)==false)
        {
            $myX = $this->TileW * $x - $this->TileW;
            $myY = $this->TileH * $y - $this->TileH;

            // Resample
            $imgTile = imagecreatetruecolor($this->TileW, $this->TileH);

            $bg = imagecolorallocate ( $imgTile, 255, 221, 0 );
            imagefill ( $imgTile, 0, 0, $bg );

            // a shorthand hack to speed it up a bit...
            if (is_null($this->imgOrig)) {
                $this->imgOrig = imagecreatefrompng($this->RootPath.$this->TileFile);
            }


            /*

               if you have to generate more than one pic, it would be better to first downsample and afterwards place in the correct postion.


               */

            imagecopyresampled($imgTile, $this->imgOrig, 0-$myX, 0-$myY, 0, 0, $this->PicScaleW, $this->PicScaleH, $this->PicOrigW, $this->PicOrigH);


            // Convert to palette-based with no dithering and 127 colors
            imagetruecolortopalette($imgTile, false, 127);

            imagepng($imgTile, $HashTilePath);

            imagedestroy($imgTile);
        }

        return "./mapito/img/cache/".$HashTileName;
    }

}

?>