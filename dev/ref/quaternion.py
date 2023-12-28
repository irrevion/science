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

qx = Quaternion([2.4, 4.81, 9.621, 19.2431])
print('pow-5')
print(qx**-5)
print(1/(qx**5))

qx = Quaternion([0.00067225, 0.03, -5.21e-7, 1e-35])
print('[0.00067225, 0.03, -5.21e-7, 1e-35]**-5')
print(qx**-5)
print(1/(qx**5))

qx = Quaternion(0.97, -1.001, 0, 1)
print('[0.97, -1.001, 0, 1]**999')
print(qx**999)

qx = Quaternion([2.4, 4.81, 9.621, 19.2431])
print('[2.4, 4.81, 9.621, 19.2431]**1/2')
print(qx**(1/2))
print('[2.4, 4.81, 9.621, 19.2431]**2/3')
print(qx**(2/3))
print('[2.4, 4.81, 9.621, 19.2431]**0.9')
print(qx**0.9)