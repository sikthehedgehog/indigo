<?php
   $table = [];
   for ($i = 0; $i < 0x100; $i++)
      $table[$i] = [ "\0", "\0" ];
   
   $table[0x1C] = [ "a", "A" ];
   $table[0x32] = [ "b", "B" ];
   $table[0x21] = [ "c", "C" ];
   $table[0x23] = [ "d", "D" ];
   $table[0x24] = [ "e", "E" ];
   $table[0x2B] = [ "f", "F" ];
   $table[0x34] = [ "g", "G" ];
   $table[0x33] = [ "h", "H" ];
   $table[0x43] = [ "i", "I" ];
   $table[0x3B] = [ "j", "J" ];
   $table[0x42] = [ "k", "K" ];
   $table[0x4B] = [ "l", "L" ];
   $table[0x3A] = [ "m", "M" ];
   $table[0x31] = [ "n", "N" ];
   $table[0x44] = [ "o", "O" ];
   $table[0x4D] = [ "p", "P" ];
   $table[0x15] = [ "q", "Q" ];
   $table[0x2D] = [ "r", "R" ];
   $table[0x1B] = [ "s", "S" ];
   $table[0x2C] = [ "t", "T" ];
   $table[0x3C] = [ "u", "U" ];
   $table[0x2A] = [ "v", "V" ];
   $table[0x1D] = [ "w", "W" ];
   $table[0x22] = [ "x", "X" ];
   $table[0x35] = [ "y", "Y" ];
   $table[0x1A] = [ "z", "Z" ];
   
   $table[0x16] = [ "1", "!" ];
   $table[0x1E] = [ "2", "@" ];
   $table[0x26] = [ "3", "#" ];
   $table[0x25] = [ "4", "\$" ];
   $table[0x2E] = [ "5", "%" ];
   $table[0x36] = [ "6", "^" ];
   $table[0x3D] = [ "7", "&" ];
   $table[0x3E] = [ "8", "*" ];
   $table[0x46] = [ "9", "(" ];
   $table[0x45] = [ "0", ")" ];
   
   $table[0x0E] = [ "`", "~" ];
   $table[0x4E] = [ "-", "_" ];
   $table[0x55] = [ "=", "+" ];
   $table[0x54] = [ "[", "{" ];
   $table[0x5B] = [ "]", "}" ];
   $table[0x4C] = [ ";", ":" ];
   $table[0x52] = [ "'", "\"" ];
   $table[0x41] = [ ",", "<" ];
   $table[0x49] = [ ".", ">" ];
   $table[0x4A] = [ "/", "?" ];
   $table[0x5D] = [ "\\", "|" ];
   
   $table[0x29] = [ " ", " " ];
   
   $table[0x70] = [ "0", "0" ];
   $table[0x69] = [ "1", "1" ];
   $table[0x72] = [ "2", "2" ];
   $table[0x7A] = [ "3", "3" ];
   $table[0x6B] = [ "4", "4" ];
   $table[0x73] = [ "5", "5" ];
   $table[0x74] = [ "6", "6" ];
   $table[0x6C] = [ "7", "7" ];
   $table[0x75] = [ "8", "8" ];
   $table[0x7D] = [ "9", "9" ];
   $table[0x71] = [ ".", "." ];
   $table[0x79] = [ "+", "+" ];
   $table[0x7B] = [ "-", "-" ];
   $table[0x7C] = [ "*", "*" ];
   $table[0x80] = [ "/", "/" ];
   
   $table[0x5A] = [ "\x0A", "\x0A" ];
   $table[0x19] = [ "\x0A", "\x0A" ];
   $table[0x66] = [ "\x08", "\x08" ];
   $table[0x0D] = [ "\x09", "\x09" ];
   $table[0x76] = [ "\x1B", "\x1B" ];
   
   $blob1 = "";
   $blob2 = "";
   for ($i = 0; $i < 0x100; $i++) {
      $blob1 = $blob1.$table[$i][0];
      $blob2 = $blob2.$table[$i][1];
   }
   $blob = $blob1.$blob2;
   
   file_put_contents("kernel/blob/ascii.blob", $blob);
?>
