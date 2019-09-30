import socket

def main():
    # Start of copy from assignment page
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    sock.bind(("localhost", 8888))
    sock.listen(5)
    (client, addr) = sock.accept()
    print("Received a connection from ", addr)
    # End of copy
   
    from my_utils import recv_from_socket, msg_to_socket
    # recv_from_socket handles receiving all data from client
    # and returns the received message
    received_message = recv_from_socket(client)

    print("Received data from client:", received_message)
    
    # Echo message back to client
    # msg_to_socket returns message to be sent in bytes
    # including 2 byte header which implies message length
    print ("Sending message back to the client")
    client.send(msg_to_socket(received_message))

    print ("\nClosing the server...")
    sock.close()

if __name__ == "__main__":
    main()
