# Expressions

Expression is a concept extending Symbol, indeed it IS de-facto a Symbol too, but the Expression class does not extends Symbol because of the damnation of Barbara Liskov 🤬 .
The "extension" of an entity logic should be separated of "subtype" logic in programming languages, since the second is an old, obsolete and useless legacy of dark ages and leads to a lot of code duplication. Subtypes has nothing to do with OOP and polymorphysm. Let our signatures be free!

Anyway, Expression is a wrapper for Symbol wich has Operation as its value. Dont be confused, its simple:
```php
use irrevion\science\Math\Symbols\{Symbol, Symbols, Operations, Expression, ExpressionStatement};

$expr1 = new Expression(Operations::op('Multiply')->over(3)->with(7));
$expr2 = new Expression('3+7');
```
as you can see, Expression has built-in parser.