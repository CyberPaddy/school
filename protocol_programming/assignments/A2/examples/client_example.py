import socket

# create socket
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# connect to server (in this case on the same machine)
s.connect(("localhost", 8888))

# send "hello" to server
s.send("hello world")

# print whatever server sends back.
print s.recv(1024),

# close the socket and exit the program
s.close()
