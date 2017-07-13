<?php
   function list_files($dirname) {
      $filelist = [];
      $dirlist = [];
      
      $data = scandir($dirname);
      foreach ($data as &$name) {
         if ($name == ".") continue;
         if ($name == "..") continue;
         $name = $dirname."/".$name;
         
         if (is_dir($name))
            array_push($dirlist, $name);
         else
            array_push($filelist, $name);
      }
      
      $scanlist = $dirlist;
      foreach ($scanlist as &$subdir) {
         $sublists = list_files($subdir);
         $filelist = array_merge($filelist, $sublists[0]);
         $dirlist = array_merge($dirlist, $sublists[1]);
      }
      
      return [$filelist, $dirlist];
   }
   
   chdir("rom");
   $lists = list_files(".");
   $files = $lists[0];
   $dirs = array_merge(["."], $lists[1]);
   chdir("..");
   
   $output = "";
   
   $dir_id = 0;
   foreach ($dirs as $dirname) {
      $output = $output.
                "Dir_".sprintf("%d", $dir_id).":\n";
      
      $file_id = -1;
      foreach ($dirs as $filename) {
         $file_id++;
         if ($dirname == $filename)
            continue;
         if ($dirname == dirname($filename)) {
            $output = $output.
                      "    dc.w    \$C000\n".
                      "    dc.w    Dir_".sprintf("%d", $file_id).">>5\n".
                      "    dc.l    DirEnd_".sprintf("%d", $file_id).
                                    "-Dir_".sprintf("%d", $file_id)."\n".
                      "    dc.b    '".basename($filename)."'\n".
                      "    dcb.b   \$08-(*&\$07), \$00\n";
         }
      }
      
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
