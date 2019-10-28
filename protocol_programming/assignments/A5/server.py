import os, sys, socket, my_ftp
from pathlib import Path    # Converts forward slashes into the correct kind of slash for OS

def test_one_parameter_functions(command, request, mark):
    if request[mark] != ' ':
        print("SP Missing")
        return []

    COMMAND_PARAM = ''

    for i in range(mark+1, len(request)-3):
        if request[i] == ' ' or request[i] == ';': # These commands should not have multiple parameters
            return []
        COMMAND_PARAM += request[i]

    print ("COMMAND_PARAM:", COMMAND_PARAM)
    return [command, COMMAND_PARAM]

# Syntax example: LS text.txt pic.jpg;CRLF
def test_ls_syntax(command, request, mark):
    if request[mark] != ' ':
        print("SP Missing")
        return []
    
    files = []
    COMMAND_PARAM = ''

    for i in range(mark+1, len(request)-3):
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




    


def test_file_syntax(request, mark):
    return


def test_command_parameters(command, request, mark):
    if len(request) < mark+3: # LIST;CRLF
        return []   # Empty list means syntax error 501
    
    if (request[-3:] != ';\r\n'):
        print(";CRLF missing:")
        return []

    # LIST and QUIT commands do not want parameters
    if command == 'LIST' or command == 'QUIT':
        if len(request) > mark+3:
            return []
        return [request]

    COMMAND_PARAM = ''

    # These commands allow only one parameter
    if command == 'DOWNLOAD' or command == 'ACK' or command == 'ERROR':
        return test_one_parameter_functions(command, request, mark)

    elif command == 'LS':
        return test_ls_syntax(command, request, mark)

    return test_file_syntax(command, request, mark) # The only remaining command to test is FILE
    
    


# SYNTAX: <COMMAND>[SP<COMMAND_PARAM>[;<DATA_SIZE>;<DATA>]];CRLF
def parse_request(request):
    
    real_command = False
    
    # Test if the command is valid
    for valid_command in my_ftp.COMMANDS:
        mark = len(valid_command)
        COMMAND = request[:mark]
        if COMMAND == valid_command:
            real_command = True
            break
    
    # function_params is empty if <COMMAND> was not recognized
    if not real_command:
        return [], b'ERROR 500;\r\n'  # Command not recognised
    
    print (request[mark:])

    function_params = test_command_parameters(COMMAND, request, mark)
    if function_params == []:
        return [], b'ERROR 501;\r\n'
    
    return function_params, b'ACK 200;\r\n'
    

def main(HOST, PORT, PATH):
    print ("Starting server!\nHOST: " + HOST + "\nPORT: " + str(PORT) + "\nPATH: " + PATH)

    with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
        sock.bind((HOST, PORT))
        sock.listen(5)

        while True:
            print ("\nListening for connections on port", PORT)
            (client, addr) = sock.accept()
            print ("\nReceived a connection from", addr[0])

            request = ''
            while True:
                request += client.recv(1024).decode('utf-8')
                if request[-2:] == '\r\n':
                    print ("Client's command:", request)
                    break

            function_params, ack_bytes = parse_request(request)
            client.sendall(ack_bytes)

            client.sendall(ack_bytes)
            


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

    main(HOST, PORT, PATH)

elif __name__ == '__main__':
    main('localhost', 13337, 'share/')
