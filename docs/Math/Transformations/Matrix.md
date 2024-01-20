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

$is_equal = $M->isEqual(new Matrix([[1, 2], [3, 4]])); // true
$is_near = $M->isNear(new Matrix([[(1+1e-13), 2], [3, 4]])); // true
$is_square = $M->isSquare(); // true
$D = $M->determinant();
$V = $M->applyTo(new Vector([7, -2]));
$M2 = $M->composeWith(new Matrix([[1, 0], [-2, 1]]));
$M3 = $M->multiplyScalar(new Scalar(5));
$M4 = $M->divideScalar(new Scalar(2));
$M5 = $M->multiply($M2);
$M6 = $M->exp();
$M7 = $M->pow(3);
$M8 = $M->transpose();
$M9 = $M->minor();
$M10 = $M->cofactorMatrix();
$M11 = $M->adjugate();
$M12 = $M->reverseTransformation();
$n = $M->trace();
$M13 = $M->entrywiseSum($M3); // addition of matrices
$M14 = $M->toREF(); // transform matrix to row echelon form using Gaussian elimination
$is_ref = $M14->isREF(); // check of matrix is in echelon form
$M17 = $M->toRREF(); // transform matrix to reduced row echelon form using Gauss-Jordan elimination
$is_rref = $M14->isRREF(); // check of matrix is in reduced row echelon form
$M15 = $M4->map(fn($val, $col, $row) => (($col===$row)? $val: 0)); // apply callback to matrix values
$M16 = Matrix::fromTemplate('2x2', 'identity'); // create new matrix using one of predefined templates
```