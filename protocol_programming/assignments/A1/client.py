# Function to handle ConnectionRefusedError
def cre():
    print ("Server is not active or wrong IP or port.")
    exit(0)

# Requested function from Assignment 1:
# The function should send all of the data to the socket
# remember, send() might not send everything!
def send_data_to_socket(sock, data):
    
    # send() might not send everything
    # but it returns the amount of bytes it sent
    bytes_sent = 0
    while bytes_sent < len(data):
    
        try:
            # Send data starting from the last byte that was not sent last iteration
            bytes_sent += sock.send( bytes(data[bytes_sent:], 'utf-8') )

        # CRE is raised if server is not active / wrong IP or port
        except ConnectionRefusedError:
            cre()

        except Exception as e:
            print (e)

        print(bytes_sent)

def main():
    # Create socket object to variable 's'
    # AF_INET --> IPv4, SOCK_STREAM --> TCP socket
    # The'with' -syntax automatically closes the socket (s.close())
    # when the code block below has been executed
    import socket
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        
    SERVER_IP   = '127.0.0.1'   # Localhost
    SERVER_PORT = 13337         # Server's port
    
    try:
        s.connect((SERVER_IP, SERVER_PORT)) # Connect to server

    # Quit the program if server is not active or wrong IP/port is given
    except ConnectionRefusedError as cre:
        cre()

    except Exception as e:
        print (e)
        exit(0)

    else:
        print ("Connected to", SERVER_IP, "port", SERVER_PORT)
    
    # Args: Socket, Message
    send_data_to_socket(s, 'Terrwe kawerrri')
    
    # Close the connection
    s.close()
    print("Connection closed")

if __name__ == '__main__':
    main()
