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

$is_equal = $M->isEqual(new Matrix([[1, 2], [3, 4]])); // true if size and all elements are equal
$is_near = $M->isNear(new Matrix([[(1+1e-13), 2], [3, 4]])); // true if size is equal and elements values are almost equal (how close depends on Math::EPSILON)
$is_square = $M->isSquare(); // true if rows number and columns number are equal
$D = $M->determinant(); // returns Scalar entity with determinant value, use $M->det() to obtain int|float value
$V = $M->applyTo(new Vector([7, -2])); // transform vector using matrix i.e. "multiply"
$M2 = $M->composeWith(new Matrix([[1, 0], [-2, 1]])); // compose two transformations into one i.e. matrix multiplication
$M3 = $M->multiplyScalar(new Scalar(5)); // scale transformation
$M4 = $M->divideScalar(new Scalar(2)); // elementwise division of a matrix
$M5 = $M->multiply($M2); // combines multiplyScalar(), applyTo() and composeWith() regarding argument type
$M6 = $M->exp(); // getting matrix exponent
$M7 = $M->pow(3); // calculates matrix in power of given argument (only integers allowed for now)
$M8 = $M->transpose(); // make rows be columns
$M9 = $M->minor(0, 0); // get minor matrix for specified by column index and row index element
$M10 = $M->cofactorMatrix(); // returns cofactor matrix
$M11 = $M->adjugate(); // returns adjugate of thee given matrix https://en.wikipedia.org/wiki/Adjugate_matrix
$M12 = $M->reverseTransformation(); // M**-1 (matrix inverce)
$n = $M->trace(); // the trace of a matrix is the sum of the diagonal elements of the matrix
$M13 = $M->entrywiseSum($M3); // addition of matrices
$M14 = $M->toREF(); // transform matrix to row echelon form using Gaussian elimination
$is_ref = $M14->isREF(); // check of matrix is in echelon form
$M17 = $M->toRREF(); // transform matrix to reduced row echelon form using Gauss-Jordan elimination
$is_rref = $M14->isRREF(); // check of matrix is in reduced row echelon form
$rank = $M->rank(); // the rank of a matrix is the number of linearly independent (nonzero rows) in the reduced matrix
$nullity = $M->nullity(); // number of zero rows in RREF form of matrix
$M15 = $M4->map(fn($val, $col, $row) => (($col===$row)? $val: 0)); // apply callback to matrix values
$M16 = Matrix::fromTemplate('2x2', 'identity'); // create new matrix using one of predefined templates
```