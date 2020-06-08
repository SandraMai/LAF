<?php
    class PicUpload{

        private $picToUpload;
        private $timeStamp;
        public $error;
        public $imageFileType;
        public $fileName;
        private $fileSizeLimit;
        private $myTempImage;
        private $myNewImage;

        function __construct($picToUpload, $fileSizeLimit){
		  $this->error = null;//1 - pole pildifail, 2 - liiga suur, pole lubatud tüüp
		  $this->picToUpload = $picToUpload;
		  $this->fileSizeLimit = $fileSizeLimit;
		  $this->timeStamp = microtime(1) * 10000;
		  $this->checkImageForUpload();
	    }

        function __destruct(){
            if($this->error == null){
                isset($this->myTempImage);
            }
            imagedestroy($this->myTempImage);
        }

        public function createFileName($filenamePrefix){
			$this->fileName = $filenamePrefix .$this->timeStamp ."." .$this->imageFileType;
        }     
        
        private function checkImageForUpload(){
            //kas on pilt
            $check = getimagesize($this->picToUpload["tmp_name"]);
            if($check == false){
                $this->error = 1;
            }

            //failitüüp
            if($check["mime"] == "image/jpeg"){
                $this->imageFileType = "jpg";
            }
            if($check["mime"] == "image/png"){
                $this->imageFileType = "png";
            }

            //kas sobiv suurus
            if ($this->error == null and $this->picToUpload["size"] > $this->fileSizeLimit){
                $this->error = 2;
            }

            //kas lubatud tüüp
            if($this->imageFileType != "jpg" and $this->imageFileType != "png"){
                $this->error = 3;
            }
            
            //kui kõik sobib, teeme vajaliku pildiobjekti
            if($this->error == null){
                $this->myTempImage = $this->createImageFromFile($this->picToUpload["tmp_name"]);
            }
            
        }
        
        private function createImageFromFile($imageFile){
            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                $image = imagecreatefromjpeg($imageFile);
            }
            if($this->imageFileType == "png"){
                $image = imagecreatefrompng($imageFile);
            }
            return $image;
        }

        public function resizeImage($picMaxW, $picMaxH){
            //pildi originaalmõõt
            $imageW = imagesx($this->myTempImage);
            $imageH = imagesy($this->myTempImage);
            //kui on liiga suur
            if($imageW > $picMaxW or $imageH > $picMaxH){
                //muudame suurust
                if($imageW / $picMaxW > $imageH / $picMaxH){
                    $picSizeRatio = $imageW / $picMaxW;
                } else {
                    $picSizeRatio = $imageH / $picMaxH;
                }
                //uus pildiobjekti uute mõõtudega
                $newW = round($imageW / $picSizeRatio, 0);
                $newH = round($imageH / $picSizeRatio, 0);
                $this->myNewImage = $this->setPicSize($this->myTempImage, $imageW, $imageH, $newW, $newH);
                
            } else {
                //kui pole piisavalt suur, et vähendada, siis originaalsuurus
                $this->myNewImage = $this->createImageFromFile($this->picToUpload["tmp_name"]);
            }
        }
        
        private function setPicSize($myTempImage, $imageW, $imageH, $imageNewW, $imageNewH){
            $myNewImage = imagecreatetruecolor($imageNewW, $imageNewH);
            //kui on läbipaistvusega png pildid, siis on vaja säilitada läbipaistvusega
            imagesavealpha($myNewImage, true);
            $transColor = imagecolorallocatealpha($myNewImage, 0, 0, 0, 127);
            imagefill($myNewImage, 0, 0, $transColor);
            $cutX = 0;
            $cutY = 0;
            $cutW = $imageW;
            $cutH = $imageH;
            //kui ruudukujuline pilt, siis vaja kärpida ehk õigest kohast lõigata
            if($imageNewW == $imageNewH){
                //kui pilt on "landscape"
                if($imageW > $imageH){
                    $cutX = round(($imageW - $imageH) / 2, 0);
                    $cutY = 0;
                    $cutW = $imageH;
                } else {
                    $cutX = 0;
                    $cutY = round(($imageH - $imageW) / 2, 0);
                    $cutH = $imageW;
                }
            }
            //lisame tegeliku pildiinfo
            imagecopyresampled($myNewImage, $myTempImage, 0, 0, $cutX, $cutY, $imageNewW, $imageNewH, $cutW, $cutH);
            return $myNewImage;
        }
       
        public function saveImage($filename){
            if($this->imageFileType == "jpg" or $this->imageFileType == "jpeg"){
                if(imagejpeg($this->myNewImage, $filename, 90)){
                    $notice = "Pildi salvestamine õnnestus!";
                } else {
                    $notice = "Pildi salvestamine ei õnnestunud!";
                }
            }
            if($this->imageFileType == "png"){
                if(imagepng($this->myNewImage, $filename, 6)){
                    $notice = "Pildi salvestamine õnnestus!";
                } else {
                    $notice = "Pildi salvestamine ei õnnestunud!";
                }
            }
            imagedestroy($this->myNewImage);
            return $notice;
          }

    }
?>