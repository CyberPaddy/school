import socket

# Create socket object to variable 's'
# AF_INET --> IPv4, SOCK_STREAM --> TCP socket
# The'with' -syntax automatically closes the socket (s.close())
# when the code block below has been executed
with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
    
    SERVER_IP   = '127.0.0.1'   # Localhost
    SERVER_PORT = 13337         # Server's port

    s.connect((SERVER_IP, SERVER_PORT)) # Connect to server
    s.sendall(b'Terrwe kawerri')        # Send data to server
    
    server_echo = str(s.recv(1024), 'utf-8')    # Get data back from server
    print("The server whispers:", server_echo)

print("Connection closed")
