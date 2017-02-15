# Indigo file system

The ROM partition uses a very barebones filesystem (which doesn't have a
name yet). It doesn't store timestamps or anything, just the most minimum
needed to get a basic hierarchy working.

## Generating the ROM drive

In practice, when you build the operating system the whole ROM drive is
generated too (creating the `rom` directory). You tell the build script to
put whatever files you want in it, and then near the end a script is called
(`kernel/data/makerom.php`) that scans this directory and generates the
filesystem from it.

Currently the filesystem support in Indigo is rather minimal so the script
only handles files in the root directory (subdirectories are not going to
work yet). This will be added in the future.

## How files are stored

Each file is made of "clusters" which are 32 bytes each. In the ROM drive,
files are just stored as-is, adding padding to make them a multiple of 32
bytes as needed. Files are just stored one after each other.

The very first file in the filesystem is the root directory (see below for
how directories are stored). Further organization is done just by parsing
the directory entries and moving around as indicated in them.

## Format of a directory

Internally, directories are just otherwise normal files that have a
"directory" flag set in their attributes. This means that as far as the
filesystem code goes, you should handle them the same way files are (the
special treatment is only on a higher level).

A directory is a list of entries (where each entry is a file or a
subdirectory). Each entry starts as follows:

```
    dc.w    attributes
    dc.w    cluster
    dc.w    filesize
```

The `attributes` indicate which kind of file is it (unused bits *must* be set
to 0):

- **Bit 15:** 0 = file, 1 = directory
- **Bit 14:** 0 = read/write, 1 = read-only

(note that since the ROM filesystem is read-only in itself, all files in it
are read-only)

The `cluster` indicates the offset of the file within the filesystem. Just
multiply it by 32 to get the actual offset in bytes.

The `filesize` is just the filesize in bytes (without padding).

After that comes the filename, followed by `$00`. The filename then is padded
with more bytes until it's aligned to an 8 byte boundary (if needed).

Then the list of entries is over we just have this:

```
    dc.w    $FFFF
```

Remember that since a directory is internally just a file, it gets padded
with more bytes until the next 32 byte boundary. But the filesize of the
directory ends right after that `$FFFF`, excluding the padding.
