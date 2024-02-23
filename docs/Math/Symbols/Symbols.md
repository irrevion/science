# Symbols

Symbols is a core concept in symbolic calculations module. It is very close to the variable concept, except symbols are more abstract and may not have value to be used. They allows to construct expressions and then assign values to substitute and calculate them.

Symbols available at the namespace
```php
use irrevion\science\Math\Symbols\Symbol;
```

## Creating symbols

Creating symbol directly is not necessary to most use cases, however you can do it like this:
```php
use irrevion\science\Math\Symbols\{Symbol, Symbols};

$a = new Symbol('a'); // the simplest way to create Symbol object
print $a; // outputs "{a}"
```
Note that you cannot create symbol with the same name that way. It will `throw new \Error('Symbol name cannot be reused');`.

But there is another option to get [Symbol](src/Math/Symbols/Symbol.php):
```php
$a = Symbols::symbol('a');
```
When symbol already exists it returns its instance, otherwise it creates a new Symbol object. Here we are using static class [Symbols](https://github.com/irrevion/science/blob/main/src/Math/Symbols/Symbols.php) which provides some helper tools.

Also, you can omit symbol name and some free name is going to be taken automatically:
```php
$symbol = new Symbol(); // for example, takes unused name {Y} randomly
```

It is also possible to define multiple symbols simultaneously:
```php
list($x, $y, $z) = Symbols::let('x', 'y', 'z');
```

## Value assignation

Any value can be assigned to the Symbol. The most common use cases is Entity object, Expression object or plain numeric value (int|float).

Examples:
```php
$k = new Symbol('k', \irrevion\science\Physics\Physics::BOLTZMANN);
```
here we're assigning symbols value during construction of the object.

```php
$q = Symbols::symbol('x')->assign(['x' => 74.16]);
```
here we're assigning value to {x} after creation of instance.

```php
$z = Symbols::wrap(new Complex(-3, 5.75));
```
here we're wrapping any value or object to symbol with preassigned value. Any Symbol or Expression passed to this method returns unchanged, thus it can be used to ensure all variables to be a Symbol. Note that Symbol created that way is treated as constant (prints to a string like value "[-3 + 5.75i]" instead of symbol name {Const_537}).


## Predefined symbols

There are some predefined symbols with already assigned values that can be used as constants:
```php
Symbols::takeName('π')->assign(Math::PI);
Symbols::takeName('τ')->assign(Math::TAU);
Symbols::takeName('e')->assign(Math::E);
Symbols::takeName('i')->assign(new \irrevion\science\Math\Entities\Imaginary(1));
Symbols::takeName('α')->assign(Physics::α);
Symbols::takeName('c')->assign(Physics::c);
Symbols::takeName('G')->assign(Physics::G);
Symbols::takeName('h')->assign(Physics::h);
Symbols::takeName('ℏ')->assign(Physics::ℏ);
```
Just get them this way:
```php
$pi = Symbols::symbol('π');
$h = Symbols::symbol('ℏ')->multiply('τ')->evaluate();

print $pi.":".Delegator::getType($pi); // outputs {π}:irrevion\science\Math\Symbols\Symbol
print $h.":".Delegator::getType($h); // outputs 6.62607014594E-34:irrevion\science\Math\Entities\Scalar
```


## Direct operations over symbols

It is possible to operate with symbols directly, which results in Expression object to be created:
```php
$q = Symbols::symbol('x')->add(new Quaternion([2, 3.7, 0.12, 7.26]))->assign(['x' => 74.16])->evaluate();
```

Another example:
```php
$k = new Symbol('k', \irrevion\science\Physics\Physics::BOLTZMANN)->asConst();
$E = $k->multiply('T');
$R = $E->divide('T')->multiply(\irrevion\science\Physics\Physics::AVOGADRO);

print $k.":".Delegator::getType($k)."\n"; // outputs 1.380649E-23:irrevion\science\Math\Symbols\Symbol
print $E.":".Delegator::getType($E)."\n"; // outputs ( 1.380649E-23 * {T} ):irrevion\science\Math\Symbols\Expression
print $R.":".Delegator::getType($R)."\n"; // outputs ( ( ( 1.380649E-23 * {T} ) / {T} ) * 6.02214076E+23 ):irrevion\science\Math\Symbols\Expression

$R = $R->assign(['T' => 300])->evaluate();
print $R.":".Delegator::getType($R)."\n"; // outputs 8.3144626181532:irrevion\science\Math\Entities\Scalar, which is https://en.wikipedia.org/wiki/Gas_constant
```

Symbols itself has limited utility, so in most cases you'll be finding yoursef using [Expressions](./Expressions.md).

<!--
## See also

- [Operations](./Operations.md)
- [Expressions](./Expressions.md)
-->