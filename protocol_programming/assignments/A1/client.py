# Requested function from Assignment 1:
# The function should send all of the data to the socket
# remember, send() might not send everything!
def send_data_to_socket(sock, data):
    try:
        sock.sendall(data) # Send all data to server
    except Exception as e:
        print (e)

def main():
    # Create socket object to variable 's'
    # AF_INET --> IPv4, SOCK_STREAM --> TCP socket
    # The'with' -syntax automatically closes the socket (s.close())
    # when the code block below has been executed
    import socket
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        
    SERVER_IP   = '127.0.0.1'   # Localhost
    SERVER_PORT = 13337         # Server's port
    
    s.connect((SERVER_IP, SERVER_PORT)) # Connect to server
    print ("Connected to", SERVER_IP, "port", SERVER_PORT)

    send_data_to_socket(s, b'Terrwe kawerrri')
    
    # Close the connection
    s.close()
    print("Connection closed")

if __name__ == '__main__':
    main()
