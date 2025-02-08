# Quaternion component

The `QuaternionComponent` class is an intermediary class allowing multiplication of imaginary components of quaternion ( i, j, k ).

This rules are defined by William Rowan Hamilton in form that $`i² = j² = k² = ijk = -1`$.

Of course there are other rules such as $`-j * k = -i`$ ( because it is right-handed multiplication if `i` looks left, `j` looks up and `k` looks to our face, sign of multiplication result is the same as direction of fingers folding, align thumb finger within 1st operand, pointing finger within the 2nd operand and direction of your middlefinger will be the result, just make sure you are alone at this moment ).

And finally here is some division examples:

$`j/k = ji/ki = -kk/jk = 1/i`$

and

$`j/k = jj/kj = -1/-i = 1/i `$

Since imaginary units is a part of Quaternion numbers this class is not very useful by itself, it just represents gradual approach to its superset.


## Basic usage

```php
use irrevion\science\Math\Entities\QuaternionComponent;


$i = new QuaternionComponent(1);
$j = new QuaternionComponent(1, 'j');
$k = new QuaternionComponent(1, 'k');
$Q = $k->add($j); // 1k + 1j = [0 + 0i + 1j + 1k] irrevion\science\Math\Entities\Quaternion
```