# Text formatting

The `OS_RENDERTEXT` syscall is used to render text into patterns. It normally
takes only ASCII text (currently) i.e. glyphs between U+0020 and U+007E
(non-ASCII glyphs become placeholder characters). However, some control codes
are handled in a particular way that makes it possible to have some text
formatting in the strings.

- `$00`: end of string
- `$0E`: turns on bold
- `$0F`: turns off bold
