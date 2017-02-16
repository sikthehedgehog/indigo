# How the GUI works

First you need to define which widgets your program is going to use: this is
the GUI layout (see `gui_layout.md` for details). You pass the layout to the
`OS_PARSELAYOUT` syscall in order to set up the GUI. If you need to change
the default state of any widget, you should call `OS_SETSTATE` for each of
them before that.

Next, you simply keep calling the `OS_GUILOOP` syscall in a loop. Whenever an
event happens, the syscall will return with info about the event, then the
program does whatever it needs to do and just returns back to calling the
syscall again to keep going (hence the loop).

## GUI action and states

The core of the GUI functionality are GUI actions and states. There are 256
states, which are an 8-bit variable each representing the current value of
a widget (e.g. 0 or 1 for a checkbox, the selected option for a radiobox,
the position of a scroller, etc.).

Each widget can be tied to either of these 256 states (their GUI "action"),
and when an event related to them is fired, this action is passed back to
the program alongside the new value of its corresponding state.
