# Syscalls

- Running programs
   - [`OS_LOADPROCESS`](#os_loadprocess-since-010): run another program
   - [`OS_QUITPROCESS`](#os_quitprocess-since-010): return to desktop
- Loading graphics
   - [`OS_LOADPATTERNS`](#os_loadpatterns-since-010): load patterns into VRAM
   - [`OS_FILLPATTERNS`](#os_fillpatterns-since-010): fill patterns with a solid color
   - [`OS_RENDERTEXT`](#os_rendertext-since-010): renders text into patterns
   - [`OS_LOADTEXTLIST`](#os_loadtextlist-since-010): renders many strings into patterns and loads them
   - [`OS_LOADPALETTE`](#os_loadpalette-since-010): load a palette into CRAM
- Drawing graphics
   - [`OS_DRAWTILES`](#os_drawtiles-since-010): draws tiles with consecutive patterns
   - [`OS_FILLTILES`](#os_filltiles-since-010): fills tiles with a single pattern
   - [`OS_ERASETILES`](#os_erasetiles-since-010): fills tiles with a blank pattern
   - [`OS_DRAWTILEMAP`](#os_drawtilemap-since-010): draws tiles using a list of patterns
   - [`OS_FILLFRAME`](#os_fillframe-since-010): draws a filled frame
   - [`OS_DRAWLABELS`](#os_drawlabels-since-010): draws a bunch of labels
   - [`OS_FILLBACKGROUND`](#os_fillbackground-since-010): draws a background like in the desktop
- System settings
   - [`OS_GETMOUSESWAP`](#os_getmouseswap-since-010): gets if mouse button are swapped
   - [`OS_SETMOUSESWAP`](#os_setmouseswap-since-010): changes if mouse button are swapped
   - [`OS_GETMOUSETYPE`](#os_getmousetype-since-010): gets mouse type
   - [`OS_SETMOUSETYPE`](#os_setmousetype-since-010): changes mouse type
   - [`OS_GETMOUSESPEED`](#os_getmousespeed-since-010): gets mouse sensivity
   - [`OS_SETMOUSESPEED`](#os_setmousespeed-since-010): changes mouse sensivity
   - [`OS_GETRAMSIZE`](#os_getramsize-since-010): gets RAM size in KB
   - [`OS_GETVRAMSIZE`](#os_getvramsize-since-010): gets VRAM size in KB
- String functions
   - [`OS_INT2ASCII`](#os_int2ascii-since-010): turns an int32 into a string
   - [`OS_UINT2ASCII`](#os_uint2ascii-since-010): turns an uint32 into a string

## Running programs

### `OS_LOADPROCESS` (since 0.10)

Quits the current program and loads the one specified by the filename (if
the program doesn't exist, Indigo will crash with a bluescreen).

**Input:**

- `a6.l` ← Pointer to filename

### `OS_QUITPROCESS` (since 0.10)

Quits the current program and returns back to the desktop. Normally there
isn't a real need for this since you can just click the *Apps* button for
the same effect.

## Loading graphics

### `OS_LOADPATTERNS` (since 0.10)

Loads patterns into VRAM.

**Input:**

- `a6.l` ← Pointer to patterns
- `d7.w` ← First pattern ID
- `d6.w` ← Number of patterns

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_FILLPATTERNS` (since 0.10)

Fills patterns in VRAM with a solid color. Useful to clear them with an
initial state if you're planning to modify them later (e.g. the terminal does
this for the display itself).

**Input:**

- `d7.w` ← First pattern ID
- `d6.w` ← Number of patterns
- `d5.b` ← Color (0 to 15)

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_RENDERTEXT` (since 0.10)

Renders a string of text into patterns, and stores the result in RAM (so you
can later load it wherever you want). The string is ASCII and nul-terminated
(with some formatting allowed, see `text_formatting.md`). If the string is
smaller than the given space the rest will be filled with background, if the
string is larger then it'll be truncated to fit.

Color 0 is used for the background and color 15 is used for the foreground.

**Input:**

- `a6.l` ← Pointer to string
- `a5.l` ← Pointer to output buffer
- `d7.w` ← Width in tiles

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_LOADTEXTLIST` (since 0.10)

Helper function that's used to render a lot of strings into patterns and
loads them into VRAM (like calling `OS_RENDERTEXT` and `OS_LOADPATTERNS` for
each of them). Meant to be used when you need to render the text for a lot of
labels (like in the Settings app). Pass the list to it and it'll take care of
the rest.

**Input:**

- `a6.l` ← Pointer to list
- `d7.w` ← First pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

**Format of the list:**

Each label entry has the following format:

```
    dc.b    width         ; Width (in tiles)
    dc.b    'string',0    ; Nul-terminated string
```

The end of the list is marked as follows:

```
    dc.b    0
    even
```

### `OS_LOADPALETTE` (since 0.10)

Loads a palette into CRAM. A palette consists of 16 words, each word being
a color (in `xxxxBBBxGGGxRRRx` format). Note that palette 0 is the default
GUI palette, so you shouldn't touch it unless you know what you're doing.

**Input:**

- `a6.l` ← Pointer to palette
- `d7.w` ← Palette ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

## Drawing graphics

### `OS_DRAWTILES` (since 0.10)

Draws a block of tiles using consecutive patterns.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)
- `a4.w` ← First pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_FILLTILES` (since 0.10)

Fills a block of tiles using a single pattern.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)
- `a4.w` ← Pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_ERASETILES` (since 0.10)

Fills a block of tiles using a blank pattern. Pretty much the same as calling
`OS_FILLTILES` using pattern `$07FF`.

**Input:**

- `d7.w` ← X coordinate (in tiles)
- `d6.w` ← Y coordinate (in tiles)
- `d5.w` ← Plane ID (0 or 1)
- `a6.w` ← Width (in tiles)
- `a5.w` ← Height (in tiles)

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_DRAWTILEMAP` (since 0.10)

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

### `OS_FILLFRAME` (since 0.10)

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

### `OS_DRAWLABELS` (since 0.10)

Helper function used to draw a lot of labels on screen (e.g. the Settings app
makes use of this to draw its labels). You pass in a list of all labels to be
displayed (see format below) and this function takes care of drawing all of
them. The text must be already in VRAM, this only draws the tiles.

**Input:**

- `a6.l` ← Pointer to label list

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

**Format of the list:**

Each label entry has the following format:

```
    dc.b    x          ; X coordinate (in tiles)
    dc.b    y          ; Y coordinate (in tiles)
    dc.b    plane      ; Plane ID (0 or 1)
    dc.b    width      ; Width (in tiles)
    dc.w    pattern    ; First pattern ID
```

The end of the list is marked as follows:

```
    dc.w    $FFFF
```

### `OS_FILLBACKGROUND` (since 0.10)

Used to draw the background in the desktop and the calculator. It takes four
patterns (arranged as 2×2) and fills plane B with them.

**Input:**

- `d7.w` ← Top left pattern ID
- `d6.w` ← Top right pattern ID
- `a6.w` ← Bottom left pattern ID
- `a5.w` ← Bottom right pattern ID

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

## System settings

### `OS_GETMOUSESWAP` (since 0.10)

Retrieves whether the mouse buttons are swapped or not. The value is 0 for
a right handed configuration (left button primary), or 1 for a left handed
configuration (right button primary).

**Output:**

- `d7.b` → Mouse button setting

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSESWAP` (since 0.10)

Changes whether the mouse buttons are swapped or not. The value is 0 for
a right handed configuration (left button primary), or 1 for a left handed
configuration (right button primary).

**Input:**

- `d7.b` ← Mouse button setting

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETMOUSETYPE` (since 0.10)

Retrieves which kind of mouse is in use (based on the settings only). The
value is 0 for a Mega Mouse (American, 4 buttons), or 1 for a Sega Mouse
(Japanese, 2 buttons).

**Output:**

- `d7.b` → Mouse type

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSETYPE` (since 0.10)

Changes the setting for the kind of mouse in use. The value is 0 for a Mega
Mouse (American, 4 buttons), or 1 for a Sega Mouse (Japanese, 2 buttons).

**Input:**

- `d7.b` ← Mouse type

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETMOUSESPEED` (since 0.10)

Retrieves the current sensivity setting for the mouse. The sensivity ranges
from 0 (slowest) to 64 (fastest).

**Output:**

- `d7.b` → Mouse sensivity

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_SETMOUSESPEED` (since 0.10)

Changes the current sensivity setting for the mouse. The sensivity ranges
from 0 (slowest) to 64 (fastest).

**Input:**

- `d7.b` ← Mouse sensivity

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETRAMSIZE` (since 0.10)

Retrieves the RAM size in KB. Indigo doesn't make use of the extra RAM, but a
program may detect this and make use of the extra memory on its own.

A stock Mega Drive will have 64KB of RAM, a Tera Drive may provide more.

**Output:**

- `d7.w` → RAM size in KB

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_GETVRAMSIZE` (since 0.10)

Retrieves the VRAM (video memory) size in KB. Note that currently Indigo
makes no provision for making use of the extra VRAM.

A stock Mega Drive will have 64KB of VRAM, while a Tera Drive will have
128KB of VRAM.

**Output:**

- `d7.w` → VRAM size in KB

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

## String functions

### `OS_INT2ASCII` (since 0.10)

Converts a signed 32-bit integer and turns it into an nul-terminated ASCII
string. The string is stored into the given buffer (you need to reserve at
least 12 bytes to ensure every value may fit).

**Input:**

- `d7.l` ← Integer value
- `a6.l` ← Pointer to output buffer

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`

### `OS_UINT2ASCII` (since 0.10)

Like `OS_INT2ASCII`, but takes an unsigned 32-bit integer.

**Input:**

- `d7.l` ← Integer value
- `a6.l` ← Pointer to output buffer

**Breaks:** `d5`, `d6`, `d7`, `a4`, `a5`, `a6`
