from my_utils import msg_to_socket, recv_from_socket, connection_refused_error, general_exception
import socket

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

try:
    s.connect(("localhost", 8888))

except ConnectionRefusedError:
    connection_refused_error() # Prints error message and exit program (connection to server failed)

except Exception as e:
    general_exception(e) # Handle all other exceptions

message = "hello world"

# msg_to_socket returns message to be sent in bytes
# including 2 byte header which implies message length
print ("Sending message to server:", message)
s.send(msg_to_socket(message))

# recv_from_socket handles receiving all data from client
# and returns the received message 
print("Received data from server:", recv_from_socket(s))
    
s.close() # Close the connection
