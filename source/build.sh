#!/bin/sh
asm() { ./sik-asmx -b 0 -C 68000 -o $2 $1 ; }
gfx() { ./mdtiler $1 ; }

rm -rf rom
mkdir -p rom
mkdir -p rom/apps
mkdir -p rom/dummy/dummy
mkdir -p rom/dummy/empty
cp dummy.text rom/dummy
cp dummy.text rom/dummy/dummy/dummy1.text
cp dummy.text rom/dummy/dummy/dummy2.text

gfx filecabinet/data/gfxbuild
asm filecabinet/buildme.68k rom/apps/filecabinet.ixec

gfx calculator/data/gfxbuild
asm calculator/buildme.68k rom/apps/calculator.ixec

gfx desktop/data/gfxbuild
asm desktop/buildme.68k rom/apps/desktop.ixec

gfx settings/data/gfxbuild
asm settings/buildme.68k rom/apps/settings.ixec

gfx solitaire/data/gfxbuild
asm solitaire/buildme.68k rom/apps/solitaire.ixec

gfx terminal/data/gfxbuild
php terminal/data/makefont.php
asm terminal/buildme.68k rom/apps/terminal.ixec

gfx kernel/data/gfxbuild
php kernel/data/key2ascii.php
php kernel/data/makefont.php
php kernel/data/makerom.php
asm kernel/data/rom_fs.68k kernel/blob/rom_fs.blob
asm kernel/buildme.68k indigo.bin
