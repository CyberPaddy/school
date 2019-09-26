import socket

def close_server():
    print ("Closing the server...")
    exit(0)

def main():
    # Create socket object to variable 's'
    # AF_INET --> IPv4, SOCK_STREAM --> TCP socket
    # The'with' -syntax automatically closes the socket (s.close())
    # when the code block below has been executed
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as s:
        
        SERVER_IP   = '127.0.0.1'   # Localhost
        SERVER_PORT = 13337         # Server's port
        
        # Bind IP and port for server and listen for maximum of 4 connections
        s.bind((SERVER_IP, SERVER_PORT))
        s.listen(4)
        
        # Accept a connection from client
        connection, client_address = s.accept()
    
        with connection: 
    
            # Loop breaks when all data is received from the client
            while True: 
                try:
                    received_data = connection.recv(1024)
                except ConnectionResetError as cre:
                    print ("Client closed the connection")
                    close_server()
                
                if not received_data:
                    print("Closing the connection with client...\n")
                    close_server()
                
                print("Client sended:", str(received_data, 'utf-8'), "\nEchoing data back to client...")
                connection.sendall(received_data) # Echo data back to client
    

# __name__ built-in variable is equal to '__main__'
# if the file is being run directly
if __name__ == '__main__':
    main()
