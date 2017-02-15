<?php
   function do_it($name) {
      $img = imagecreatefrompng("kernel/data/".$name.".png");
      
      $headblob = "";
      $datablob = "";
      $offset = 0x60 * 2;
      
      for ($i = 0x00; $i < 0x60; $i++) {
         $basex = ($i & 0x0F) * 8;
         $basey = ($i >> 4) * 8;
         
         $width = 0;
         for ($x = 0; $x < 8; $x += 2) {
            if (imagecolorat($img, $basex+$x, $basey) == 2) break;
            $width += 2;
         }
         
         $word = $offset | (($width >> 1) - 1);
         $headblob = $headblob.chr($word >> 8).chr($word & 0xFF);
         $offset += $width * 4;
         
         for ($x = 0; $x < $width; $x += 2)
         for ($y = 0; $y < 8; $y++) {
            $byte = 0x00;
            if (imagecolorat($img, $basex+$x, $basey+$y)) $byte |= 0xF0;
            if (imagecolorat($img, $basex+$x+1, $basey+$y)) $byte |= 0x0F;
            $datablob = $datablob.chr($byte);
         }
      }
      
      file_put_contents("kernel/blob/".$name.".blob", $headblob.$datablob);
   }
   
   do_it("font");
   do_it("font_bold");
?>
