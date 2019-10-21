import socket
import time
def main(HOST, PORT, COMMAND):
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
        sock.connect((HOST, PORT))
        sock.sendall(bytes( (COMMAND + '\r\n'), 'utf-8') )
        print(sock.recv(1024).decode('utf-8'))

import sys
if __name__ == '__main__' and len(sys.argv) == 2:
    main('localhost', 13337, sys.argv[1])
elif __name__ == '__main__':
    main('localhost', 13337, "DOWNLOAD test.txt;")
