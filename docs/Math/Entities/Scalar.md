# Scalar entity

Most basic and simple entity is Scalar class (object constructor). It is a wrapper for real numbers.
Namespace and dependencies:
```php
namespace irrevion\science\Math\Entities;

use irrevion\science\Math\Math;
use irrevion\science\Helpers\Delegator;

class Scalar implements Entity {}
```


## Quick overview / Basic usage

```php
use irrevion\science\Math\Entities\{NaN, Scalar};

$x = new Scalar(5);
$y = new Scalar(3);
$z = $x->multiply($y);
```