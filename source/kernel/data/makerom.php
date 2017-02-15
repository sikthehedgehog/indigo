<?php
   exec("cd rom ; find -type f ; cd ..", $files);
   exec("cd rom ; find -type d ; cd ..", $dirs);
   
   $output = "";
   
   $dir_id = 0;
   foreach ($dirs as $dirname) {
      $output = $output.
                "Dir_".sprintf("%d", $dir_id).":\n";
      $file_id = -1;
      foreach ($files as $filename) {
         $file_id++;
         if ($dirname == dirname($filename)) {
            $output = $output.
                      "    dc.w    \$4000\n".
                      "    dc.w    File_".sprintf("%d", $file_id).">>5\n".
                      "    dc.l    FileEnd_".sprintf("%d", $file_id).
                                    "-File_".sprintf("%d", $file_id)."\n".
                      "    dc.b    '".basename($filename)."'\n".
                      "    dcb.b   \$08-(*&\$07), \$00\n";
         }
      }
      $output = $output.
                "    dc.w    \$FFFF\n".
                "DirEnd_".sprintf("%d", $dir_id).":\n".
                "    dcb.b   \$20-(*&\$1F), \$FF\n";
      $dir_id++;
   }
   
   $file_id = 0;
   foreach ($files as $filename) {
      $output = $output.
                "File_".sprintf("%d", $file_id).":\n".
                "    incbin  \"./rom/".$filename."\"\n".
                "FileEnd_".sprintf("%d", $file_id).":\n".
                "    dcb.b   \$20-(*&\$1F), \$FF\n";
      $file_id++;
   }
   
   file_put_contents("kernel/data/rom_fs.68k", $output);
?>
