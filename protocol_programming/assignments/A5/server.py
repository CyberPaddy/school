import os
import sys
import socket
import my_ftp
from pathlib import Path    # Converts forward slashes into the correct kind of slash for OS

def main(HOST, PORT, PATH):
    print ("Starting server!\nHOST: " + HOST + "\nPORT: " + str(PORT) + "\nPATH: " + PATH)

    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
        sock.bind((HOST, PORT))
        sock.listen(5)
        print ("\nListening for connections on port", PORT)

        while True:
            (client, addr) = sock.accept()
            print ("\nReceived a connection from", addr[0])

            request = ''
            while True:
                request += client.recv(1024).decode('utf-8')
                if request[-2:] == '\r\n':
                    print ("Client's command:", request)
                    break
            if request.split(' ')[0] in my_ftp.COMMANDS or request[:5] == 'LIST;':
                client.sendall(b"200")
            else:
                client.sendall(b"ERROR 500;\n")

            


if __name__ == '__main__' and len(sys.argv) == 4:
    HOST = sys.argv[1]
    PATH = sys.argv[3]
    try:
        PORT = int(sys.argv[2])
        # Do not use well-known ports 0-1023
        if PORT < 1024 or PORT > 65535:
            raise ValueError
    except ValueError:
        print ("Please give integer value between 1024-65535 as <PORT>\nSyntax: server.py <HOST> <PORT> <FILEPATH>")
        exit(1)

    run_file_server(HOST, PORT, PATH)

elif __name__ == '__main__':
    main('localhost', 13337, 'share/')
