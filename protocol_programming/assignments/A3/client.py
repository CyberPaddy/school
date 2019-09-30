from my_utils import get_header_and_message_as_bytes, recv_from_socket, connection_refused_error, general_exception, send_message_to_socket
import socket

def main(HOST, PORT):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    try:
        s.connect((HOST, PORT))
    
    except ConnectionRefusedError:
        connection_refused_error() # Prints error message and exit program (connection to server failed)
    
    except Exception as e:
        general_exception(e) # Handle all other exceptions
    
    message = "hello world"
    
    # get_header_and_message_as_bytes returns message to be sent in bytes
    # including 2 byte header which implies message length

    print ("Sending message to server:", message)
    send_message_to_socket(s, message) # Parses message to correct form and makes sure everything will be sent
    
    # recv_from_socket handles receiving all data from client
    # and returns the received message 
    print("Received data from server:", recv_from_socket(s))
        
    s.close() # Close the connection


import sys
# Program needs to have two command line arguments (host and port)
if __name__ == "__main__" and len(sys.argv) == 3:
    try:
        PORT = int(sys.argv[2])
    except ValueError:
        print ("Please give integer value as <PORT>\nSyntax: client.py <HOST> <PORT>")
        exit(1)

    main(sys.argv[1], PORT) # Args: HOST, PORT

elif __name__ == "__main__":
    print("Please give two command line arguments!\nSyntax: client.py <HOST> <PORT>")
