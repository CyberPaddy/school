# Start copy from assignment page
import socket

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect(("localhost", 8888))
# End of copy

message = "hello world"

from my_utils import msg_to_socket, recv_from_socket

# msg_to_socket returns message to be sent in bytes
# including 2 byte header which implies message length
s.send(msg_to_socket(message))

# recv_from_socket handles receiving all data from client
# and returns the received message 
print(recv_from_socket(s))

s.close() # Close the connection
