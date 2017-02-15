<?php
   $table = "@Table:\n";
   
   for ($i = 0; $i < 32; $i++) {
      $val = 1 << $i;
      $table = $table."    dc.b    ".
               "\$".sprintf("%02u", $val / 100000000).",".
               "\$".sprintf("%02u", $val / 1000000 % 100).",".
               "\$".sprintf("%02u", $val / 10000 % 100).",".
               "\$".sprintf("%02u", $val / 100 % 100).",".
               "\$".sprintf("%02u", $val % 100)."\n";
   }
   
   echo $table;
?>
