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
print('magnitude')
print(qz.magnitude)

x = np.array([0., 1., 0., 0.])
y = np.array([0., 0., 1., 0.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx / qy
print(qz)
qz = qy / qx
print(qz)

x = np.array([0., 15., 0., 0.])
y = np.array([0., 0., 3., 0.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx / qy
print(qz)
qz = qy / qx
print(qz)
qz = qx / 5
print(qz)

x = np.array([0., 0., 0., 0.03])
y = np.array([0., 0., 89305.2, 0.])
qx = Quaternion(x)
qy = Quaternion(y)
qz = qx / qy
print(qz)
qz = qy / qx
print(qz)

qy = Quaternion(np.array([0., 0., 6., 0.]))
z = 12 / qy
print(z)

qy = Quaternion(3., 7., 11., 19.)
print('reciprocal')
print(1/qy)
qx = Quaternion([2., 4., 8., 16.])
print('division')
print(qy/qx)
