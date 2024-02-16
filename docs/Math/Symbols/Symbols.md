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

But there is another option to get Symbol:
```php
Symbols::symbol('a');
```
When symbol already exists it returns its instance, otherwise it creates a new Symbol object.

Also, you can omit symbol name and some free name is going to be taken automatically:
```php
$symbol = new Symbol(); // for example, takes unused name {Y} randomly
```

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