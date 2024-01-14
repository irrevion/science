import math
import numpy as np
import sympy
   
def matrix_cofactor(matrix):
    try:
        determinant = np.linalg.det(matrix)
        if(determinant!=0):
            cofactor = None
            cofactor = np.linalg.inv(matrix).T * determinant
            # return cofactor matrix of the given matrix
            return cofactor
        else:
            raise Exception("singular matrix")
    except Exception as e:
        print("could not find cofactor matrix due to",e)
   
print('matrix_cofactor([[1, 2], [3, 4]])')
print(matrix_cofactor([[1, 2], [3, 4]]))
# print(matrix_cofactor(np.array([[1, 2], [3, 4]]).T))

print('matrix_cofactor([[3, 4, 5], [6, 7, 8], [9, 10, 11]])')
print(matrix_cofactor([[3., 4, 5], [6, 7., 8], [9, 10, 11.0001]]))

print('matrix_cofactor([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27]])')
print(matrix_cofactor([[3, 4, 7, 18, 19], [5, 6, 8, 20, 21], [9, 10, 11, 22, 23], [12, 13, 14, 24, 25], [15, 16, 17, 26, 27.0001]]))
   
print('inv([[1, 2], [3, 4]])')
print(np.linalg.inv([[1, 2], [3, 4]]))

print('ref([[1, 2], [3, 4]])')
M = sympy.Matrix([[1, 2], [3, 4]])
REF = M.echelon_form();
print(REF);

print('ref([[1, 3], [2, 4]])')
M = sympy.Matrix([[1, 3], [2, 4]])
REF = M.echelon_form();
print(REF);

print('ref([[3, 1, 2], [2, 1, 3]])')
M = sympy.Matrix([[3, 1, 2], [2, 1, 3]])
REF = M.echelon_form();
print(REF);

print('ref([[0,0,0,0], [1,1,2,4], [1,1,2,4], [1,2,1,4], [1,3,2,6], [1,2,1,4]])')
M = sympy.Matrix([
    [0,1,1,1,1,1],
    [0,1,1,2,3,2],
    [0,2,2,1,2,1],
    [0,4,4,4,6,4]
])
REF = M.echelon_form();
print(REF);