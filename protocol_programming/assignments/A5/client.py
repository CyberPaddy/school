import socket

def print_error(command, error):
    if error == 'ERROR 500':
        print ("Unrecognized command: '" + command + "'\n")

    if error == 'ERROR 501':
        print ("This command is reserved for servers\n")
    
    if error == 'ERROR 502':
        print ("Syntax error, please check command!\n")

def create_file(response):
    print (response)
    mark = response.find(b';')            # The spot of first semicolon in response

    file_name   = str( response[ response.find(b' ')+1 : mark ], 'utf-8' )
    data_start  = mark + 1                                  # Start index of <DATA>
    data_end    = response.find(b';\r\n', data_start+1)     # End index of <DATA>
    data = response[ data_start : data_end ]

    try:
        with open (file_name, 'wb') as f:
            f.write(data)
    except Exception as e:
        print (e)
    else:
        print ("Downloaded file", file_name)
            

def handle_response(response):
    if response == b'ERROR 403;\r\n':
        print ("You are unauthorized to download that file!\n") 

    if response == b'ERROR 404;\r\n':
        print ("File was not found from the server\nCheck available files with LIST command\n")

    if response[:4] == b'FILE':
        create_file(response)
                    
    if response[:2] == b'LS':
        print( str(response[3:-3], 'utf-8') )   # Prints files separated with SP


def main(HOST, PORT):
    while True:
        try:
            with socket.socket(socket.AF_INET, socket.SOCK_STREAM) as sock:
                sock.connect((HOST, PORT))
                command = input("\nGive command: ")
                bytes_to_server = bytes(command + '\r\n', 'utf-8')

                sock.sendall(bytes_to_server)
                
                # Get ACK or ERROR message from server
                recv_ack = sock.recv(16).decode('utf-8')
                msg_type = 'acknowledgement:' if recv_ack == 'ACK 200;\r\n' else 'error:'
                print ("\nServer sent" , msg_type, recv_ack[:-3])

                if command == 'QUIT;':
                    break
                
                # Handle ERROR messages from server
                if recv_ack != 'ACK 200;\r\n':
                    print_error( command, recv_ack[:-3] )
                
                else:
                    response = b''
                    while True:
                        response += sock.recv(1024)
                        if response[-2:] == b'\r\n':
                            break
                    
                    handle_response(response)

        except ConnectionRefusedError:
            print ("Server is not active at", HOST, "port", PORT)
            exit(1)



if __name__ == '__main__':
    main('localhost', 13337)
