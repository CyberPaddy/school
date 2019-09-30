import socket

def main(HOST, PORT):
    # Start of copy from assignment page
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    try:
        sock.bind((HOST, PORT))
    except OSError:
        print ("Port", PORT, "is already occupied by another process. Please use different port!")
        exit(1)
    

    sock.listen(5)

    while True:
        (client, addr) = sock.accept()
        print("Received a connection from ", addr)
        # End of copy
       
        # recv_from_socket handles receiving all data from client
        # and returns the received message
        from my_utils import recv_from_socket, get_header_and_message_as_bytes
        received_message = recv_from_socket(client)

        print("Received data from client:", received_message)
        
        # Echo message back to client
        # get_header_and_message_as_bytes returns message to be sent in bytes
        # including 2 byte header which implies message length
        print ("Sending message back to the client")
        client.send(get_header_and_message_as_bytes(received_message))

    print ("\nClosing the server...")
    sock.close()

import sys
# Program needs to have two command line arguments (host and port)
if __name__ == "__main__" and len(sys.argv) == 3:
    try:
        PORT = int(sys.argv[2])
    except ValueError:
        print ("Please give integer value as <PORT>\nSyntax: server.py <HOST> <PORT>")
        exit(1)

    main(sys.argv[1], PORT) # Args: HOST, PORT

elif __name__ == "__main__":
    print("Please give two command line arguments!\nSyntax: server.py <HOST> <PORT>")
