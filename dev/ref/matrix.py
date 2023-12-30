import math
import numpy as np
   
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