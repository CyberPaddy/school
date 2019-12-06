import socket

def main(HOST, PORT):
    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
        sock.connect((HOST, PORT))

        command = input("Give command: ")
        bytes_to_server = bytes(command, 'utf-8')

        sock.sendall(bytes_to_server)
            
        print(sock.recv(1024))

import sys
if __name__ == '__main__':
    main('localhost', 13338)
