# File list internal format

## How to use the list

First you need to generate the file list (e.g. each time you go into a
directory). It goes as follows:

1. Call `ClearFileList`
2. Call `AddFileEntry` for every file
3. Call `GetFileListReady`

You *must not* try to do anything with the list but add entries before the
last step, and you *must not* try to modify the list after the last step (if
you need to, you'll have to rebuild the whole list from scratch, sorry).

After this is done you probably want to call `RefreshFileList` to rerender
the whole thing.

## Filenames

First come the filenames (starting at `FileList`). Each filename has the
following format, *not aligned*:

```
    dc.b    icon            ; Icon type
    dc.b    $20             ; Padding
    dc.b    "filename",0    ; File name
```

The icon pretty much just maps to the relevant icon in VRAM. Icon `$00` is
blank (for unused entries when the list is too short), icon `$01` is a folder
(for directories), the rest just indicate for different file types (you can
see a list of them in `data.68k`).

The `$20` (an ASCII space) is just used to add padding between the icon and
the filename in the list (Indigo is told to render it).

The filename is for the most part just an ASCII-terminated string. There's
one catch: the extension is deemphasized, and this is achieved by adding a
`$13` (XOFF) byte right where the extension starts, so code should ignore or
remove this `$13` once it wants to use it as a filename.

> Yes, I know that brings up some potential issues, but it's unlikely to show
> up in a filename and if you use Indigo for anything serious you have bigger
> problems. You can crash the File Cabinet by just having too many files in a
> directory after all (running out of memory).

## Offsets

The big problem is that filename entries are variable length, and so can't
be addressed directly. To solve this a list of pointers to each file is
generated once all entries are in.

The list of offsets is placed after the filenames (aligning to word first if
needed) and its location can be read from `OffsetPtr`. Each pointer is just
16-bit: you get the absolute addresses by adding `$FF0000` to them.

## Scrolling

`ScrollPos` contains the current position of the file list (how many rows
have been scrolled down), `ScrollMax` indicates the last position it can
scroll to. If the list can't scroll, both of them will be 0.

For the most part scrolling is already handled in `scroll.68k`, but if you
want to pick the Nth visible entry on the list or the like, you'll need to
know the scroll value. Simply add `ScrollPos` to whatever row it is on
screen.
