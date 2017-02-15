# GUI layouts

GUI layouts are passed to the `OS_PARSELAYOUT` syscall and they're used to
indicate which widgets are there. They're a list of widgets made using
`OSUI_*` macros (taking different arguments each), with the last entry being
`OSUI_End`.

An example of a simple layout may be as follows (when calling
`OS_PARSELAYOUT`, you'd be giving it the address for `Layout`):

```
Layout:
    OSUI_Button ID_CALCULATOR, 2,1,   3,3, VramCalculator
    OSUI_Button ID_TERMINAL,   31,21, 3,3, VramTerminal
    OSUI_Button ID_SETTINGS,   35,21, 3,3, VramSettings
    OSUI_End
```

## Widgets reference

### OSUI_End

Indicates the end of the layout.

### OSUI_Button

Places a standard button. It fires an event when you click on it (its
associated GUI state is not modified).

The pattern ID is the first pattern used by the button. You need as many
patterns needed to cover the button's size, twice: the first half for when
the button is released, the other half for when it's pressed.

**Arguments:**

- GUI state ID
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Width (in tiles)
- Height (in tiles)
- Pattern ID

### OSUI_Hold

Exactly the same as `OSUI_Button`, but instead of firing an event once when
clicking on it, the same event is fired every frame for as long as the button
is held down.

**Arguments:**

- GUI state ID
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Width (in tiles)
- Height (in tiles)
- Pattern ID

### OSUI_Toggle

Similar to `OSUI_Button`, but its associated GUI state is toggled between 0
and 1. It can be used to implement checkboxes or similar widgets (like a
button that can be toggled).

When its GUI state is 1, the widget will look the same as when being pressed
(i.e. it'll use its second graphic).

**Arguments:**

- GUI state ID
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Width (in tiles)
- Height (in tiles)
- Pattern ID

### OSUI_Radio

Similar to `OSUI_Button`, but it has a value associated to it: when clicked,
it changes the associated GUI state to that value. It can be used for things
like radio buttons or other things with similar behavior (like the buttons
in a painting program toolbox).

When its GUI state matches its associated value, the widget will look the
same as when being pressed (i.e. it'll use its second graphic).

**Arguments:**

- GUI state ID
- Widget value
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Width (in tiles)
- Height (in tiles)
- Pattern ID

### OSUI_HScroll

Places a horizontal scroller (used for things like scrollbars or sliders).
It has a 16×16 px knob you can drag with the mouse, the GUI state will
reflect the current position (measured in pixels) and an event will be fired
every frame until the mouse button is released.

There's also a background placed under the knob, it takes up 6 patterns used
to draw a bar.

**Arguments:**

- GUI state ID
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Width (in tiles, inner area)
- Pattern ID for sprite (2×2 tiles)
- Pattern ID for background (see below)

**Pattern order for background:**

1. Top left
2. Top inner
3. Top right
4. Bottom left
5. Bottom inner
6. Bottom right

### OSUI_VScroll

Like `OSUI_HScroll`, but places a vertical scroller.

**Arguments:**

- GUI state ID
- X coordinate (in tiles)
- Y coordinate (in tiles)
- Height (in tiles, inner area)
- Pattern ID for sprite (2×2 tiles)
- Pattern ID for background (see below)

**Pattern order for background:**

1. Left top
2. Left inner
3. Left bottom
4. Right top
5. Right inner
6. Right bottom

## Events reference

The following can be included in the layout list as usual, but they're *not*
widgets. Instead, they're used to set up miscellaneous events that we want
to handle as well, regardless of what the user is doing with the widgets.

Since they aren't widgets, they do *not* add to the widget total.

### OSUI_Timer

It sets up the GUI timer to fire an event every so often (you can check it's
the timer since you can assign an ID to it as usual). You can use this for
things that need to be done every so often even if the user is idling (e.g.
the blinking cursor in the terminal does this).

**Arguments:**

- GUI state ID
- Delay between events (in frames)
