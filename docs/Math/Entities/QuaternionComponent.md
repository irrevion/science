# Quaternion component

The `QuaternionComponent` class is an intermediary class allowing multiplication of imaginary components of quaternion ( i, j, k ).

This rules are defined by William Rowan Hamilton in form that $`i² = j² = k² = ijk = -1`$.

Of course there are other rules such as $`-j * k = -i`$ ( because it is right-handed multiplication if `i` looks left, `j` looks up and `k` looks to our face, sign of multiplication result is the same as direction of fingers folding, align thumb finger within 1st operand, pointing finger within the 2nd operand and direction of your middlefinger will be the result, just make sure you are alone at this moment ).

And finally here is some division examples:

$`j/k = ji/ki = -kk/jk = 1/i`$

or identical

$`j/k = jj/kj = -1/-i = 1/i `$

or

$`i/j = ii/ji = -1/-k = 1/k `$.

Since imaginary units is a part of Quaternion numbers this class is not very useful by itself, it just represents gradual approach to its superset.


## Basic usage

```php
use irrevion\science\Math\Entities\QuaternionComponent;


$i = new QuaternionComponent(1);
$j = new QuaternionComponent(1, 'j');
$k = new QuaternionComponent(1, 'k');
$Q = $k->add($j); // 1k + 1j = [0 + 0i + 1j + 1k] irrevion\science\Math\Entities\Quaternion
```


## Constructor

You can create an instance of a QuaternionComponent in different ways. The most trivial was already shown above:
```php
$i = new QuaternionComponent(1);
$j = new QuaternionComponent(1, 'j');
$k = new QuaternionComponent(1, 'k');
```

You can also create a copy of another QuaternionComponent:
```php
$q1 = new QuaternionComponent(2, 'i');
$q2 = new QuaternionComponent($q1);
```

## Addition / Subtraction

As denoted above, there are methods for addition and subtraction of quaternion components:
```php
$i = new QuaternionComponent(1);
$j = new QuaternionComponent(1, 'j');
$k = new QuaternionComponent(1, 'k');

$sum = $i->add($j); // result is [0 + 1i + 1j + 0k]
$diff = $i->subtract($j); // result is [0 + 1i - 1j + 0k]
```

## Multiplication / Division

Quaternion component multiplication and division methods are also available:
```php
$prod = $i->multiply($j); // result is [0 + 0i + 0j + 1k]
$quotient = $i->divide($j); // result is [0 + 0i + 0j - 1k]
```

## Other methods

Conjugate:
```php
$conjugate = $i->conjugate(); // result is [-1i]
```

Magnitude:
```php
$magnitude = $i->abs(); // result is 1
```

## See also

- [Quaternion](./Quaternion.md)
- [Complex](./Complex.md)
- [Imaginary](./Imaginary.md)
- [Scalar](./Scalar.md)
- [Fraction](./Fraction.md)