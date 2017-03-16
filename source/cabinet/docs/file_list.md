# File list format

## Entry format

Each entry has the following format:

```
    dc.w    (pointer_to_last_entry)&$FFFF
    dc.w    (pointer_to_next_entry)&$FFFF
    dc.b    icon
    dc.b    $20
    dc.b    "filename", 0
    even
```

Whenever a pointer is unused (this happens in the first and last entries of
the list), the value is 0 instead. Since variables are stored at `$FF0000` we
can safely assume that 0 is not a valid offset.

The `$20` is an ASCII space and it's used to add padding between icons and
the filenames. It's included while rendering and skipped over when we want
the actual filename.

## How it's used

Accessing an arbitrary entry would require going through the whole list up
to that point. This is not exactly the best idea, so instead we cache the
addresses to the entries that are visible in the list (see `FileListPtr`).

* When the list is first opened, we just scan through the beginning until we
  have cached enough entries to fill the visible area (or we run out of
  entries, if it's short enough).

* When scrolling down, we get the address of the last visible entry from the
  cache and use it to hop forwards in the list. Scrolling up is done in a
  similar way (using the first visible entry).
