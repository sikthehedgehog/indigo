# Indigo operating system

The Indigo operating system turns your Mega Drive into a computer! It's
currently in early stages of development so don't expect much. You can take
a look at the screenshots in the `screenshots` directory!

If you want to emulate it, you can try using BlastEm (and make sure the
second port has a mouse), other emulators may or may not work.

## System requirements

Note that technically only the ROM is required, but if you intend to use the
operating system at its fullest you'll want to fill in as many as possible.
BlastEm can emulate this set up, in case you wonder (though you may need to
change the config to include the peripherals).

- Cartridge
  - 2MB ROM (mapped at `$000000` - `$1FFFFF`)
  - 2MB RAM (mapped at `$200000` - `$3FFFFF`)
- Peripherals
  - Mega or Sega Mouse in 2P port

Most flashcarts don't include the required RAM. The Mega Everdrive does
(through its mapper), but currently isn't being set up to do it (when I
figure out a way to reliably detect a Mega Everdrive, I will add that).

> Currently the cartridge RAM isn't used at all so that's not an issue, but
> I'm including it since I'm intending to make use of it in the future and
> could be a problem by then.

## Build requirements

The source code is in the `source` directory. You will probably need to
change the lines early in `build.sh` to change the paths to wherever you've
put the tools (or if they need different arguments).

- Linux or whatever that can handle Unix shell scripts
- An assembler with asm68k-like syntax
- mdtiler (part of [mdtools](https://github.com/sikthehedgehog/mdtools/))

## Troubleshooting

### Why not port Contiki?

Because that isn't fun :P

### How do I quit a program?

Click the **Apps** button to go back to the desktop.

### The mouse doesn't work

Make sure it's connected in the 2P port. Currently Indigo isn't smart enough
to try to detect which devices are connected in each port.

### The mouse moves upside down

Assuming you can cope with the annoyance: go to the Settings (the cogwheels
at the bottom right) then change the mouse type. That should fix the issue.
You can change the sensitivity here too, while we're at it.

### The terminal doesn't work

There's no keyboard support yet (having emulation issues), so for now you're
stuck with a non-functional terminal. Sorry! (the amount of memory it reports
*is* actually being detected though, in case you have a non-standard console)

### Calculator gave me a wrong result

Fill a bug report about it and make sure to mention the calculation and
the result you expected.

Note however, that it's a rather primitive calculator. It doesn't handle
operator priority (maybe in the future), and it's limited to 10 digits so
it loses precision rather quickly (and there are no guard digits either).
It's just there mostly as a proof of concept.

### The settings aren't saved

Known issue, they will be once Indigo becomes able to use permanent storage.
