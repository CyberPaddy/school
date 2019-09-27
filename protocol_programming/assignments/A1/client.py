# Handle all other exceptions than
# ConnectionRefusedError or ConnectionResetError
def general_exception(error_message):
    print ("\nException happened! Error message:", error_message)
    exit(1)

# Function to handle ConnectionRefusedError
def cre():
    print ("Server is not active / Wrong IP-address or port.")
    exit(1)

# Requested function from Assignment 1:
# The function should send all of the data to the socket
# remember, send() might not send everything!
def send_data_to_socket(sock, data):
    
    print ("Sending message '" + data + "' to", sock.getsockname()[0])

    # send() might not send everything
    # but it returns the amount of bytes it sent.
    # bytes_sent keeps tract of the amount of sent bytes
    bytes_sent = 0
    while bytes_sent < len(data):
    
        try:
            # Send data starting from the last byte that was not sent last iteration
            bytes_sent += sock.send( bytes(data[bytes_sent:], 'utf-8') )

        # ConnectionRefusedError is raised if server is not active / wrong IP or port
        except ConnectionRefusedError:
            cre()
        
        # ConnectionResetError is raised if server closes the connection
        except ConnectionResetError as e:
            print ("\nServer closed the connection\nError message:", e)
            exit(1)

        # Handle other exceptions
        except Exception as e:
            general_exception(e)

    print ("Message sent!")

def main():
    # Create socket object to variable 's'
    # AF_INET --> IPv4, SOCK_STREAM --> TCP socket
    import socket
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
        
    SERVER_IP   = '127.0.0.1'   # Localhost
    SERVER_PORT = 13337         # Server's port
    
    try:
        s.connect((SERVER_IP, SERVER_PORT)) # Connect to server

    # Quit the program if server is not active or wrong IP/port is given
    except ConnectionRefusedError:
        cre()
    
    # Handle other possible exceptions
    except Exception as e:
        general_exception(e)

    else:
        print ("Connected to", SERVER_IP, "port", SERVER_PORT)
    
    # Args: Socket, Message
    send_data_to_socket(s, "Terrwe kawerrrri")
    
    # Close the connection
    s.close()
    print("\nConnection closed")

if __name__ == '__main__':
    main()
