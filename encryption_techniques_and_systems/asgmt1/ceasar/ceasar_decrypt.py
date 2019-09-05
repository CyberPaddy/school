# Python 2

def decrypt_cipher(k, text):
    decrypted_text = ''

    # This script should work with every positive value of k
    # There is 26 letters in the english alphabet
    k = k % 26

    for char in text:
        # Ascii number of current character
        asc_num = ord(char)

        # Uppercase ascii 65-90, lowercase 97-122
        is_lower = asc_num >= 97

        # Test if current character is not in [a-zA-Z]
        if asc_num < 65 or (asc_num > 90 and asc_num < 97) or asc_num > 122:
            decrypted_text += chr(asc_num)
        elif asc_num - k < 65 or (is_lower and asc_num - k < 97):
            decrypted_text += chr(ord(char) - k + 26)
        else:
            decrypted_text += chr(ord(char) - k)
    
    return decrypted_text

# Program starts from her
def main():
    # Get k and text to be encrypted
    k = int(raw_input("Insert k for Ceasar Decrypt: "))
    text = raw_input("Insert ciphertext for Ceasar Decrypt: ")
    
    # Function returns plaintext from given k and cipher
    print "Plaintext =", decrypt_cipher(k, text)

if __name__ == '__main__':
    main()
