import socket
# Handle ConnectionRefusedError
def connection_refused_error():
    print ("Connection to server failed!\nServer is not active / Wrong IP-address or port.")
    exit(1)

# Handle ConnectionResetError
def connection_reset_error(error_message):
    print ("\nPeer closed the connection\nError message:", error_message)
    exit(1)

def unicode_decode_error(error_message):
    print ("\nIllegal characher for UTF-8!\nError message:", error_message)
    exit(1)

def connection_aborted_error():
    print ("An established connection was aborted by the software in your host machine")
    exit(1)

def socket_timeout_error():
    print ("Socket timed out")
    exit(1)

# Handle all other exceptions than
# ConnectionRefusedError or ConnectionResetError
def general_exception(error_message):
    print ("\nException happened! Error message:", error_message)
    exit(1)

# Returns byte representation of hex number
# with zeroes as padding to match byte_amount
def hex_to_bytes(hex_str, byte_amount):
    hex_str = hex_str[2:] # Take '0x' off from the beginning of hex

    # 2 bytes equals four hexadecimal numbers
    # If hex_str is f.ex '3b' append two zeroes in front
    for i in range (0, 2*byte_amount - len(hex_str)):
        hex_str = "0" + hex_str
    
    from binascii import unhexlify
    return unhexlify(hex_str)

# Makes sure everything of the message is sent to the socket
def send_file_to_socket(sock, NAME, FILE, SIZE):
    sock.settimeout(1) # If data could not be sent in 1 second, raise timeout error
    sent_name_bytes = 0
    sent_bytes = 0

    # Send 2+4 byte header which tells how big the file name and file contents are
    sock.send(hex_to_bytes(str(hex(len(NAME))), 2))
    sock.send(hex_to_bytes(str(hex(SIZE)), 4))
    
    # Send file name
    while sent_name_bytes < len(NAME):
        try:
            sent_name_bytes += sock.send(bytes(NAME, 'utf-8'))
        except socket.timeout:
            socket_timeout_error()

    # Send bytes until the whole file is transferred
    while sent_bytes < SIZE:
        try:
            sent_bytes += sock.send(FILE.read())
        except socket.timeout:
            socket_timeout_error()
    
    print("File sent successfully!")

# Returns received files name and its contents
def recv_from_socket(sock):
    sock.settimeout(1.5) # If no data is received in 1,5 seconds, raise 'timeout' error
    
    # Message format: file_name_len (4 bytes) + file_len (2 bytes) + file_name + file_contents
    try:
        file_name_len = int.from_bytes(sock.recv(2), byteorder = 'big')
        file_len      = int.from_bytes(sock.recv(4), byteorder = 'big')
        file_name     = str(sock.recv(file_name_len), 'utf-8')

    except ConnectionRefusedError:
        connection_refused_error()
    except ConnectionResetError as e:
        connection_reset_error(e)
    except ConnectionAbortedError:
        connection_aborted_error()
    except socket.timeout:
        socket_timeout_error()
    except Exception as e:
        general_exception(e)    

    received_file = b''
    
    # Receive until received_file matches the length of message implied in the header
    while len(received_file) < file_len:
        try:
            received_file = received_file + sock.recv(1024)

        except ConnectionRefusedError:
            connection_refused_error()
        except ConnectionResetError as e:
            connection_reset_error(e)
        except UnicodeDecodeError as e:
            unicode_decode_error(e)
        except ConnectionAbortedError:
            connection_aborted_error()
        except socket.timeout:
            socket_timeout_error() 
        except Exception as e:
            general_exception(e)
    
    # Check if exactly the right amount of bytes was received
    if len(received_file) != file_len:
        print("File was not received correctly\nServer is shutting down...")
        exit(1)
    return file_name, received_file
