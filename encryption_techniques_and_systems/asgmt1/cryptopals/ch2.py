# Python 2
hex1 = raw_input("Give first hex:  ")
hex2 = raw_input("Give second hex: ")

# print hex representation of XOR between first and second hex
print "first ^ second =", ''.join('%x' % (int(hex1, 16) ^ int(hex2, 16)))
