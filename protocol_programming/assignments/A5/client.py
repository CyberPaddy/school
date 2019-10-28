import socket

def main(HOST, PORT):
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
        sock.connect((HOST, PORT))

        COMMAND = input("Give command: ")
        sock.sendall(bytes( (COMMAND + '\r\n'), 'utf-8') )
            
        print(sock.recv(1024).decode('utf-8'))

import sys
if __name__ == '__main__':
    main('localhost', 13337)
