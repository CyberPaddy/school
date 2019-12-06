import os, sys, socket, my_ftp
from pathlib import Path    # Converts forward slashes into the correct kind of slash for OS

# Test if the received command is in VALID_LIST
def is_valid_command(command, VALID_LIST):
    for valid_command in VALID_LIST:
        mark = len(valid_command)
        parsed_command = command[:mark]
        if parsed_command == valid_command:
            return True, parsed_command, mark
    return False, None, None

def test_one_parameter_functions(command, request, mark):
    if request[mark] != ' ':
        print("SP Missing for one parameter function", command)
        return []

    REQUEST_PARAM = ''

    for i in range(mark+1, len(request)-3):
        print (request[i])
        if request[i] == ' ' or request[i] == ';': # These commands should not have multiple parameters
            return []
        REQUEST_PARAM += request[i]

    print ("REQUEST_PARAM:", REQUEST_PARAM)
    return [command, REQUEST_PARAM]


def test_request_params(command, request, mark):

    print ("test_request_params", request)

    if len(request) < mark+3: # LIST;CRLF
        print("Some part missing")
        return []   # Empty list means syntax error 502
    
    if (request[-3:] != ';\r\n'):
        print(";CRLF missing:")
        return []

    # LIST and QUIT commands do not want parameters
    if command == 'LIST' or command == 'QUIT':
        if len(request) > mark+3:
            return []
        print ("Good command:", command)
        return [request]

    # DOWNLOAD only allows one parameter
    if command == 'DOWNLOAD':
        return test_one_parameter_functions(command, request, mark)

    return [] 


# SYNTAX: <COMMAND>[SP<COMMAND_PARAM>[;<DATA_SIZE>;<DATA>]];CRLF
def parse_request(request):
    # Is received request a valid COMMAND
    real_command = is_valid_command(request, my_ftp.COMMANDS)
    if not real_command:
        return [], ( b'ERROR 500;\r\n' ) # 500 -> COMMAND unrecognized

    # Test if the command is valid REQUEST. Variable 'mark' is the end index for <COMMAND>
    real_request, command, mark = is_valid_command(request, my_ftp.REQUESTS)
    if not real_request:
        return [], ( b'ERROR 501;\r\n' ) # 501 -> Not implemented

    # Return received REQUEST and its params in a list. Empty list = syntax error
    function_params = test_request_params(command, request, mark)
    if function_params == []:
        return [], ( b'ERROR 502;\r\n' ) # 502 -> Syntax error
    
    return function_params, ( b'ACK 200;\r\n' ) # 200 -> Alles gud

def handle_function(param_list):
    return

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
                request += client.recv(1024).decode()
                print (bytes(request[-2:], 'utf-8'))
                if request[-2:] == '\r\n':
                    print ("Client's command:", request[:-3]) # Don't print CRLF
                    break
            
            function_params, ack_bytes = parse_request(request)
            print("ack_bytes:",ack_bytes)
            client.sendall(ack_bytes)

            if ack_bytes == b'ACK 200;\r\n':
                print ("function_params:",function_params)
                handle_function(function_params)

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
    main('localhost', 13338, 'share/')
