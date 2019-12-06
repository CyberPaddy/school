import socket

# Syntax example: LS text.txt pic.jpg;CRLF
def test_ls_syntax(command, request, mark):

    if request[mark] != ' ':
        print (request[mark])
        print (type (request[mark]))
        print("SP Missing for LS")
        return []

    files = []
    COMMAND_PARAM = ''

    for i in range(mark+1, len(request)):
        if request[i] == ';': # LS command should only contain SP, not SEMICOLON
            return []
        if request[i] == ' ':
            files.append(COMMAND_PARAM)
            COMMAND_PARAM = ''
            continue

        COMMAND_PARAM += request[i]

    files.append(COMMAND_PARAM)

    print ("FILES =", files)
    return [command, files]

def main(HOST, PORT):
    while True:
        with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
            sock.connect((HOST, PORT))
            command = input("Give command: ")
            bytes_to_server = bytes(command + '\r\n', 'utf-8')

            sock.sendall(bytes_to_server)
                    
            recv_ack = sock.recv(16)
            print ("Got acknowledgement:", recv_ack)

            if (b'200' in recv_ack) and (not 'QUIT' in command):
                response = b''
                while True:
                    response += sock.recv(1024)
                    if response[-2:] == b'\r\n':
                        print ("RESPONSE from server:", response)
                        break

            if 'QUIT' in command:
                break

                # elif command == 'LS':
                    # return test_ls_syntax(command, request, mark)
if __name__ == '__main__':
    main('localhost', 13337)
