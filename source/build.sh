#!/bin/sh
asm() { ./sik-asmx -b 0 -C 68000 -o $2 $1 ; }
gfx() { ./mdtiler $1 ; }

rm -rf rom
mkdir -p rom

gfx cabinet/data/gfxbuild
asm cabinet/buildme.68k rom/cabinet.ixec

gfx calculator/data/gfxbuild
asm calculator/buildme.68k rom/calculator.ixec

gfx desktop/data/gfxbuild
asm desktop/buildme.68k rom/desktop.ixec

gfx settings/data/gfxbuild
asm settings/buildme.68k rom/settings.ixec

gfx solitaire/data/gfxbuild
asm solitaire/buildme.68k rom/solitaire.ixec

gfx terminal/data/gfxbuild
php terminal/data/makefont.php
asm terminal/buildme.68k rom/terminal.ixec

gfx kernel/data/gfxbuild
php kernel/data/makefont.php
php kernel/data/makerom.php
asm kernel/data/rom_fs.68k kernel/blob/rom_fs.blob
asm kernel/buildme.68k indigo.bin
