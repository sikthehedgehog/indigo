# Text formatting

The `OS_RENDERTEXT` syscall is used to render text into patterns. It normally
takes only ASCII text (currently) i.e. glyphs between U+0020 and U+007E
(non-ASCII glyphs become placeholder characters). However, some control codes
are handled in a particular way that makes it possible to have some text
formatting in the strings.

- `$00` `NUL`: end of string
- `$0E` `SO`: turns on bold (since 0.10)
- `$0F` `SI`: turns off bold (since 0.10)
- `$11` `XON`: normal text (since 0.20)
- `$13` `XOFF`: grayed text (since 0.20)

## Important notes

* Bold text can be harder to read due to lack of spacing. It's not as bad as
  it sounds in practice, but you should limit yourself to use it sparsely
  (i.e. don't make huge chunks of bold text).
* Graying out text (`XON` and `XOFF` control codes) are intended for
  deemphasizing in places like text fields or lists that have a white
  background. Grayed out text *will be literally invisible* against the
  normal gray background (it's the same color).
* Grayed out text is slower to render than normal text. This does *not* apply
  to bold text thankfully. And yes, you can mix both.
