import socket

def main():
    # create the socket
    sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    # bind the socket to an address and port
    sock.bind(("localhost", 8888))
    # start listening for new connections
    sock.listen(5)
    # wait for a client using accept()
    # accept() returns a client socket and the address from which
    # the client connected
    (client, addr) = sock.accept()
    print "Received a connection from", addr
    # read and print whatever the client sends us
    print client.recv(1024),
    # send "hello world!" back to the client
    client.send("hello world!\n")
    # the server proram terminates after sending the reply

if __name__ == "__main__":
    main()
