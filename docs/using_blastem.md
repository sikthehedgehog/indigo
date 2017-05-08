# Testing Indigo on BlastEm

## Get BlastEm

First you'll need to get BlastEm. Make sure you get the *latest* version (and
I mean newer than what's in the BlastEm page) since Indigo needs some of the
newest features. If you don't want to build it manually you can get a nightly
version from here:

[https://www.retrodev.com/blastem/nightlies]

**Note:** currently the list is not sorted by date... It builds once a day so
try searching for the latest date (which would be either today, yesterday or
the day before that, depending on the current time and your timezone).

## Set up BlastEm

Next you need to change the configuration so the correct peripherals are
used. Either edit `default.cfg` or copy it to the relevant place for your
OS (e.g. `~/.config/blastem/blastem.cfg` on Linux). Look for a line that
has "`devices {`" in it and change what's there as follows:

```
   devices {
      1 saturn keyboard
      2 mouse.1
   }
```

## Running Indigo

Now call BlastEm from the command line or a batch file as follows (change
the paths as needed):

```
blastem indigo.bin
```

To use the keyboard you need to press Right Ctrl first (press it again to
let go of the keyboard). To quit press Alt+F4.
