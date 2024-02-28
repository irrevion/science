# Symbolic Math / Expressions

Expression is a concept extending Symbol, indeed it IS de-facto a Symbol too, but the Expression class does not extends Symbol because of the damnation of Barbara Liskov 🤬 .

The "extension" or "enhancement" of an entity logic should be separated from "subtype" logic in programming languages, since the second is an old, obsolete and useless legacy of dark ages and leads to a lot of code duplication. Subtypes has nothing to do with OOP and polymorphysm. Let our signatures be free!

> "inheritance is not enough for evolution  
> there is no evolution without mutations  
> you cannot treat fungus and cheetah same way because they have same ancestor"  
>
> © me

Anyway, Expression is a wrapper for Symbol wich has Operation as its value. Dont be confused, its simple:
```php
use irrevion\science\Math\Symbols\{Symbol, Symbols, Operations, Expression, ExpressionStatement};

$expr1 = new Expression(Operations::op('Multiply')->over(3)->with(7));
$expr2 = new Expression('3+7');
```
as you can see, Expression has built-in parser.

Expressions can be nested:
```php
$expr3 = new Expression(Operations::op('Negative')->over($expr1));
$expr4 = new Expression('-(3+7)');
```

Even single Symbol can be an Expression:
```php
$wtf = new Expression('{x}'); // short and clean
$wtf2 = new Expression(Operations::op('NoOp')->over(Symbols::symbol('x'))); // not so graceful solution, agree
```
As you've noticed, constructor of Expression accepts either string to parse or Operation to embed.


## Parser

Here is examples of valid expression statements to be parsed:
```php
$xpr = new Expression('-{x} + {y}'); // variables in curly braces
$xpr = new Expression('{x}+({a} + {b}+7) +{y}'); // subexpression in parentesis
$xpr = new Expression('.0! + 3{i} + (2e-5(700 * -2e3) - 4.89)'); // factorial, scientific notation of the numbers and predefined imaginary one symbol
$xpr = new Expression('5**5'); // power 💪
$xpr = new Expression('{e}**({π}{i})'); // imaginary power in the left part of legendary Euler's™ formula
$xpr = new Expression('(3-2)avg(-0.9, pow(5-6, 3), (abs({x}-1)*-1))'); // lot of functions here
$xpr = new Expression('cos({π})+{i}sin({π})'); // trigonometric functions
$xpr = new Expression('ln( (1e2 - 99) / ( 1 + {e}**(-3{x})))'); // natural logarythm
$xpr = new Expression('exp(2 - 4.6{i})'); // exponent of a complex number
```

So, as you can see, expression statement can consist of numbers, variables, operators, functions and subexpressions (parentesis). In fact, every operator creates its own subexpression forming a chain of nested expressions. You can notice it when printing parsed expression:
```php
print (new Expression('{x}+({a} + {b}+7) +{y}'));
// outputs ( ( {x} + ( ( {a} + {b} ) + 7 ) ) + {y} )
```
and it is always obvious in which order operations will be performed.


## See also

<!-- - [Operations](./Operations.md)-->
- [Symbols](./Symbols.md)