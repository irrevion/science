# Matrices

Operations with matrices are available after Matrix class instance creation using namespace:
```php
use irrevion\science\Math\Transformations\Matrix;
```
Matrix is linear transformation rather than a classic math value entity, thats why it has separate namespace and does not implements Entity interface. While it can be expressed as value via Determinant ( transformation strength ), and consists of values, the matrix concept is a set of operations with basis vectors - rotation, expansion or contraction, etc.

## Quick overview

```php
$M = new Matrix([[1, 2], [3, 4]]);
/*
This will create matrix from array of columns, not rows as in NumPy, be cautious
 | 1 3 |
 | 2 4 |
vs NumPy
 | 1 2 |
 | 3 4 |
*/
$size = $M->rows.'x'.$M->cols; // 2x2
```