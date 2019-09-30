# First two bytes implies how long will the message be
# so the max length of one message is 2^16 = 65536 bytes
def hex_to_two_bytes(hex_str):

    hex_str = hex_str[2:] # Take '0x' off from the beginning of hex

    # 2 bytes equals four hexadecimal numbers
    for i in range (0, 4-len(hex_str)):
        hex_str = "0" + hex_str
    
    from binascii import unhexlify
    return unhexlify(hex_str)

# Message format: msg_len (2 bytes) + message
def msg_to_socket(message):
    return hex_to_two_bytes(hex(len(message))) + bytes(message, 'utf-8')

# Returns the message string without header
def recv_from_socket(sock):
    # Message format: msg_len (2 bytes) + message
    msg_len = int.from_bytes(sock.recv(2), byteorder = 'big')
    
    received_message = ''
    
    # Receive until received_message matches the length of message implied in the header
    while len(received_message) < msg_len:
        received_message += received_message + str(sock.recv(1024), 'utf-8')

    return received_message
