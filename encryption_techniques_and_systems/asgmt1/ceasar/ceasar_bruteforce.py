# Python 2
from __future__ import print_function       # 'sep' argument to print function
from ceasar_encrypt import get_cipher       # Returns ciphertext from given k and text 

# Program starts from her
def main():
    # Get k and text to be ciphered
    cipher_text = raw_input("Insert ciphertext for Bruteforce: ")
    keyword = raw_input("Insert keyword for Bruteforce (optional): ")
    
    if not keyword:
        keyword = ''

    # Function returns cipher text from given k and text
    for k in range(0, 26):
        decrypted_text = get_cipher(k, cipher_text)
        
        # Only print out plaintexts that contains keyword
        if keyword in decrypted_text:
            print ("Key ", k, ": Decryption = ", decrypted_text, sep='')

if __name__ == '__main__':
    main()
