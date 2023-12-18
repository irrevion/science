import numpy as np
from pyquaternion import Quaternion

x = np.array([3., 0., 0., 0.])
y = np.array([5., 0., 0., 0.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx * qy
print(qz)

x = np.array([3., 0., 0., 0.])
y = np.array([0., 5., 7., 9.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx * qy
print(qz)

x = np.array([0., 3., -2., 4.])
y = np.array([0., 5., 7., 9.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx * qy
print(qz)

x = np.array([4.1, 8.2, 16.4, 32.8])
y = np.array([-0.2, 7.843, 194.34, 9999.9999])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx * qy
print(qz)