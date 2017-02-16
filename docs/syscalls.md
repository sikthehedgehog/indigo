# Syscalls

- System settings
   - [`OS_GETMOUSESWAP`](#os_getmouseswap)
   - [`OS_SETMOUSESWAP`](#os_setmouseswap)
   - [`OS_GETMOUSETYPE`](#os_getmousetype)
   - [`OS_SETMOUSETYPE`](#os_setmousetype)
   - [`OS_GETMOUSESPEED`](#os_getmousespeed)
   - [`OS_SETMOUSESPEED`](#os_setmousespeed)

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
