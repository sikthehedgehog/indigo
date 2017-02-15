<?php
   function get_character($img, $ascii) {
      $ascii -= 0x20;
      $basex = ($ascii & 0x0F) * 6;
      $basey = ($ascii >> 4) * 8;
      
      $blob = "";
      
      for ($x = 0; $x < 6; $x += 2)
      for ($y = 0; $y < 8; $y++) {
         $pixel1 = imagecolorat($img, $x+$basex, $y+$basey);
         $pixel2 = imagecolorat($img, $x+$basex+1, $y+$basey);
         
         $byte = 0xEE;
         if ($pixel1) $byte |= 0xF0;
         if ($pixel2) $byte |= 0x0F;
         $blob = $blob.chr($byte);
      }
      
      for ($i = 0; $i < 8; $i++)
         $blob = $blob.chr(0xFF);
      
      return $blob;
   }
   
   $img = imagecreatefrompng("terminal/data/font.png");
   $blob = "";
   
   for ($ascii = 0x20; $ascii < 0x80; $ascii++)
      $blob = $blob.get_character($img, $ascii);
   
   file_put_contents("terminal/blob/font.blob", $blob);
?>
