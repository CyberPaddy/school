# Python 3

# Add trailing zero in front of hex number if needed to make byte long str (2 characters)
def add_trailing_zero(hex_str):
    if len(hex_str) == 1:
        hex_str = '0' + hex_str
    return hex_str

# Return the encrypted string representation of the hex
# made by XORing unencrypted_hex with repeating key
def repeating_key_xor(hex_key, hex_str):

    encrypted = ''
    key_ind = 1
   
    for i in range (1, len(hex_str), 2):
        # XOR current byte with the correct byte from key    
        enc_dec = int( (hex_str[i-1] + hex_str[i]), 16) ^ int( (hex_key[key_ind -1] + hex_key[key_ind]), 16)
        
        encrypted += add_trailing_zero(str(hex(enc_dec))[2:])

        if key_ind == 5:
            key_ind = 1
        else:
            key_ind += 2

    return encrypted

# Returns the encrypted string in hex form
def encrypt(key, msg):

    print ("\nOriginal message: " , msg)

    # repeating_key_xor function takes key and message in hexlified string form
    import binascii
    encrypted = repeating_key_xor( binascii.hexlify(bytes(key, 'utf-8')).decode('utf-8') , binascii.hexlify(bytes(msg, 'utf-8')).decode('utf-8') )

    return encrypted

# Program starts here if no command line parameters are given
def main():
    
    # The answer and example message is from Cryptopals Set 1, Challenge 5
    # https://cryptopals.com/sets/1/challenges/5
    my_answer = encrypt("ICE", "Burning 'em, if you ain't quick and nimble\nI go crazy when I hear a cymbal")
    cryptopals_answer = "0b3637272a2b2e63622c2e69692a23693a2a3c6324202d623d63343c2a26226324272765272a282b2f20430a652e2c652a3124333a653e2b2027630c692b20283165286326302e27282f"
    
    print ("\nMy answer:" , my_answer)
    print ("CP answer:" , cryptopals_answer)
    
    # Test if my function's return value matches with Cryptopal challenge's answer
    if my_answer == cryptopals_answer:
        print ("Repeating key XOR works!")
    else:
        print ("Wrong answer!")

import sys

# Encrypt any messages from command line:
# ch5.py "key" "Example message"
if len(sys.argv) == 3:
    print("\nEncrypted message:" , encrypt(sys.argv[1], sys.argv[2]))

elif len(sys.argv) == 2 or len(sys.argv) > 3:
    print ("\nPlease provide key and message!\nExample: ch5.py 'KEY' 'MESSAGE'")

# If no command line parameters are given and this .py file is directly run
elif __name__ == '__main__' and len(sys.argv) <= 1:
    main()
