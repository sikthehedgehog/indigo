<?php
   $img = imagecreatefrompng($argv[1]);
   $numcolors = imagecolorstotal($img);
   
   if ($numcolors == 0) {
      echo "Error: \"".$argv[1]."\" is a truecolor image\n";
      return 1;
   }
   if ($numcolors > 16) {
      echo "Error: \"".$argv[1]."\" has too many colors\n";
      return 1;
   }
   
   $palette = [ 0,0,0,0, 0,0,0,0, 0,0,0,0, 0,0,0,0 ];
   
   for ($i = 0; $i < $numcolors; $i++) {
      $color = imagecolorsforindex($img, $i);
      $r = $color["red"] >> 5;
      $g = $color["green"] >> 5;
      $b = $color["blue"] >> 5;
      $palette[$i] = $b << 9 | $g << 5 | $r << 1;
   }
   
   $blob = "";
   for ($i = 0; $i < 0x10; $i++) {
      $byte1 = $palette[$i] >> 8;
      $byte2 = $palette[$i] & 0xFF;
      $blob = $blob.chr($byte1).chr($byte2);
   }
   
   if (file_put_contents($argv[2], $blob) != 0x20) {
      echo "Error: couldn't write to \"".$argv[2]."\"\n";
      return 1;
   }
   
   return 0;
?>
