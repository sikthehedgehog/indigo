# Calculator division

The calculator does decimal arithmetic with ten digits. Most of the
algorithms were rather straightforward (if annoying to implement) but the
division was particularly awful. Just going to leave here an example of how
it's working to give an idea... In hindsight, I think it's just long
division.

Sign and comma are handled separately, this only computes the digits.

```
12345 / 25 = 493.8

1 < 25 --> _
12 < 25 --> _
123 >= 25 --> 1
98 >= 25 --> 2
73 >= 25 --> 3
48 >= 25 --> 4
23 < 25 --> 4_
234 >= 25 --> 41
209 >= 25 --> 42
184 >= 25 --> 43
159 >= 25 --> 44
134 >= 25 --> 45
109 >= 25 --> 46
84 >= 25 --> 47
59 >= 25 --> 48
34 >= 25 --> 49
9 < 25 --> 49_
95 >= 25 --> 491
70 >= 25 --> 492
45 >= 25 --> 493
20 < 25 --> 493_
200 >= 25 --> 4931
175 >= 25 --> 4932
150 >= 25 --> 4933
125 >= 25 --> 4934
100 >= 25 --> 4935
75 >= 25 --> 4936
50 >= 25 --> 4937
25 >= 25 --> 4938
0 < 25 --> 4938_
```
