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

# First two bytes implies how long will the message be
# so the max length of one message is 2^16 = 65536 bytes
def hex_to_two_bytes(hex_str):

    hex_str = hex_str[2:] # Take '0x' off from the beginning of hex

    # 2 bytes equals four hexadecimal numbers
    # If hex_str is f.ex '3b' append two zeroes in front
    for i in range (0, 4-len(hex_str)):
        hex_str = "0" + hex_str
    
    from binascii import unhexlify
    return unhexlify(hex_str)

# Message format: msg_len (2 bytes) + message
def get_header_and_message_as_bytes(message):
    return hex_to_two_bytes(hex(len(message))) + bytes(message, 'utf-8')

# Makes sure everything of the message is sent to the socket
def send_message_to_socket(sock, message):
    sock.settimeout(1) # If data could not be sent in 1 second, raise timeout error
    sent_bytes = 0
    while sent_bytes < len(message):
        try:
            sent_bytes += sock.send(get_header_and_message_as_bytes(message))
        except socket.timeout:
            socket_timeout_error()
    
        message = message[sent_bytes:]
    print("Message sent successfully!")

# Returns the message string without header
def recv_from_socket(sock):
    sock.settimeout(1.5) # If no data is received in 1,5 seconds, raise 'timeout' error
    
    # Message format: msg_len (2 bytes) + message
    try:
        msg_len = int.from_bytes(sock.recv(2), byteorder = 'big')

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

    
    
    received_message = ''
    
    # Receive until received_message matches the length of message implied in the header
    while len(received_message) < msg_len:
        try:
            received_message += received_message + str(sock.recv(1024), 'utf-8')

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

    return received_message
