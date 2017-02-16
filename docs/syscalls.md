# Syscalls

- Drawing graphics
   - [`OS_DRAWTILES`](#os_drawtiles)
   - [`OS_FILLTILES`](#os_filltiles)
   - [`OS_ERASETILES`](#os_erasetiles)
   - [`OS_DRAWTILEMAP`](#os_drawtilemap)
   - [`OS_FILLFRAME`](#os_fillframe)
   - [`OS_DRAWLABELS`](#os_drawlabels)
   - [`OS_FILLBACKGROUND`](#os_fillbackground)
- System settings
   - [`OS_GETMOUSESWAP`](#os_getmouseswap)
   - [`OS_SETMOUSESWAP`](#os_setmouseswap)
   - [`OS_GETMOUSETYPE`](#os_getmousetype)
   - [`OS_SETMOUSETYPE`](#os_setmousetype)
   - [`OS_GETMOUSESPEED`](#os_getmousespeed)
   - [`OS_SETMOUSESPEED`](#os_setmousespeed)
   - [`OS_GETRAMSIZE`](#os_getramsize)
   - [`OS_GETVRAMSIZE`](#os_getvramsize)

## Drawing graphics

### `OS_DRAWTILES`

Draws a block of tiles using consecutive patterns.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)
- `a4.w` ← First pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_FILLTILES`

Fills a block of tiles using a single pattern.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)
- `a4.w` ← Pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_ERASETILES`

Fills a block of tiles using a blank pattern. Pretty much the same as calling
`OS_FILLTILES` using pattern `$07FF`.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_DRAWTILEMAP`

Draws a block of tiles using the given list of patterns (essentially, a
tilemap).

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)
- `a4.l` ← Pointer to list of patterns

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_FILLFRAME`

Draws tiles with a filled frame (i.e. border and the inner area). The frame
requires 9 consecutive patterns (see below). A good example would be the body
of the calculator or the screen in the terminal.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles, inner area)
- `a5.w` ← Height (in tiles, inner area)
- `a4.w` ← First pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

**Pattern order:**

1. Top left
2. Top inner
3. Top right
4. Left
5. Inner
6. Right
7. Bottom left
8. Bottom inner
9. Bottom right

### `OS_DRAWLABELS`

Helper function used to draw a lot of labels on screen (e.g. the settings app
makes use of this to draw its labels). You pass in a list of all labels to be
displayed (see format below) and this function takes care of drawing all of
them. The text must be already in VRAM, this only draws the tiles.

**Input:**

- `a6.l` ← Pointer to label list

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

**Format of the list:**

Each label entry has the following format:

```
    dc.b    x          ; X coordinate
    dc.b    y          ; Y coordinate
    dc.b    plane      ; Plane ID (0 or 1)
    dc.b    width      ; Width in tiles
    dc.w    pattern    ; First pattern ID
```

The end of the list is marked as follows:

```
    dc.w    $FFFF
```

### `OS_FILLBACKGROUND`

Used to draw the background in the desktop and the calculator. It takes four
patterns (arranged as 2×2) and fills plane B with them.

**Input:**

- `d7.w` ← Top left pattern ID
- `d6.w` ← Top right pattern ID
- `a6.w` ← Bottom left pattern ID
- `a5.w` ← Bottom right pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

## System settings

### `OS_GETMOUSESWAP`

Retrieves whether the mouse buttons are swapped or not. The value is 0 for
a right handed configuration (left button primary), or 1 for a left handed
configuration (right button primary).

**Output:**

- `d7.b` → Mouse button setting

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSESWAP`

Changes whether the mouse buttons are swapped or not. The value is 0 for
a right handed configuration (left button primary), or 1 for a left handed
configuration (right button primary).

**Input:**

- `d7.b` ← Mouse button setting

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETMOUSETYPE`

Retrieves which kind of mouse is in use (based on the settings only). The
value is 0 for a Mega Mouse (American, 4 buttons), or 1 for a Sega Mouse
(Japanese, 2 buttons).

**Output:**

- `d7.b` → Mouse type

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSETYPE`

Changes the setting for the kind of mouse in use. The value is 0 for a Mega
Mouse (American, 4 buttons), or 1 for a Sega Mouse (Japanese, 2 buttons).

**Input:**

- `d7.b` ← Mouse type

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETMOUSESPEED`

Retrieves the current sensivity setting for the mouse. The sensivity ranges
from 0 (slowest) to 64 (fastest).

**Output:**

- `d7.b` → Mouse sensivity

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSESPEED`

Changes the current sensivity setting for the mouse. The sensivity ranges
from 0 (slowest) to 64 (fastest).

**Input:**

- `d7.b` ← Mouse sensivity

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETRAMSIZE`

Retrieves the RAM size in KB. Indigo doesn't make use of the extra RAM, but a
program may detect this and make use of the extra memory on its own.

A stock Mega Drive will have 64KB of RAM, a Tera Drive may provide more.

**Output:**

- `d7.w` → RAM size in KB

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETVRAMSIZE`

Retrieves the VRAM (video memory) size in KB. Note that currently Indigo
makes no provision for making use of the extra VRAM.

A stock Mega Drive will have 64KB of VRAM, while a Tera Drive will have
128KB of VRAM.

**Output:**

- `d7.w` → VRAM size in KB

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`
