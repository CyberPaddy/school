# Python 2

def get_cipher(k, text):
    cipher_text = ''

    # This script should work with every positive value of k
    # There is 26 letters in the english alphabet
    k = k % 26

    for char in text:
        # Ascii number of current character
        asc_num = ord(char)

        # Uppercase ascii 65-90, lowercase 97-122
        is_upper = asc_num <= 90

        # Test if current character is not in [a-zA-Z]
        if asc_num < 65 or (asc_num > 90 and asc_num < 97) or asc_num > 122:
            cipher_text += chr(asc_num)
        elif asc_num + k > 122 or (is_upper and asc_num + k > 90):
            cipher_text += chr(asc_num + k - 26)
        else:
            cipher_text += chr(asc_num + k)
    
    return cipher_text

# Program starts from her
def main():
    # Get k and text to be ciphered
    k = int(raw_input("Insert k for Ceasar Encrypt: "))
    text = raw_input("Insert Plaintext for Ceasar Encrypt: ")
    
    # Function returns cipher text from given k and text
    print "Ciphertext =", get_cipher(k, text)

if __name__ == '__main__':
    main()
