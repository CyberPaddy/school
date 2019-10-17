from my_utils import get_header_and_message_as_bytes, connection_refused_error, general_exception, send_file_to_socket
import socket, os

def main(PATH, HOST, PORT):
    s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

    try:
        s.connect((HOST, PORT))
    
    except ConnectionRefusedError:
        connection_refused_error() # Prints error message and exit program (connection to server failed)
    
    except Exception as e:
        general_exception(e) # Handle all other exceptions
    
    try:
        FILE = open(PATH, 'rb') # Open file as binary
    except FileNotFoundError:
        print ("File", f, "does not exist. Please check file path!")
        exit(1)

    # Get file size
    FILE_SIZE = os.path.getsize(PATH)

    # get_header_and_message_as_bytes returns message to be sent in bytes
    # including 2 byte header which implies message length
    print ("Sending file to server:", os.path.split(PATH)[-1] + "\nFile size:", FILE_SIZE, "bytes")

    # Parse message to correct form and make sure everything will be sent
    send_file_to_socket(s, FILE, FILE_SIZE)
        
    s.close() # Close the connection


import sys
# Program needs to have three command line arguments (path, address, port)
if __name__ == "__main__" and len(sys.argv) == 4:
    PATH = sys.argv[1]
    try:
        PORT = int(sys.argv[3])
        # Do not use well-known ports 0-1023
        if PORT < 1024 or PORT > 65535:
            raise ValueError
    except ValueError:
        print ("Please give integer value between 1024-65535 as <PORT>\nSyntax: client.py <FILEPATH> <HOST> <PORT>")
        exit(1)

    main(PATH, sys.argv[2], PORT) # Args: FILE, HOST, PORT

elif __name__ == "__main__":
    print("Please give three command line arguments!\nSyntax: client.py <FILEPATH> <HOST> <PORT>")
