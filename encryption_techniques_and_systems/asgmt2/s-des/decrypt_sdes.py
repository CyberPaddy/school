def print_permutations(rules, permutation):    
    print ("Permutation " + permutation + ": (",end='')
    for i, k in enumerate(rules):
        if i != len(rules) -1:
            print ("k" + str(k) + ", " , end='')
        else:
            print ("k" + str(k) + ")")

# Prints initial values of P, K and P10
def print_begin_values(P, K, P8, P10):
    print ("\nCiphertext =", P)
    print ("Key K =", K)
    print_permutations(P8, "P8")
    print_permutations(P10,"P10")

def get_permutation(key, permutation_rule):
    new_key = ''
    for perm in permutation_rule:
        new_key += key[perm-1]
    return new_key

# Permutes the key according to permutation P10
def p10_permutation(K, P10):
    return get_permutation(K, P10)

# Circular left shift
def ls_1(key):
    return key[1:len(key)] + key[0]

def p8_permutation(B1, B2, P8):
    new_key = ''
    temp = B1 + B2
    return get_permutation(temp, P8)[:-2]

# Apply two circular left shifts (LS-2)
def ls_2(key):
    return ls_1(ls_1(key))

def xor(bits1, bits2):
    return str(bin(int(bits1, 2) ^ int(bits2, 2)))[2:]

def add_trailing_zeroes_to_binary(binary_str, bit_amt):
    if len(binary_str) < bit_amt:
        binary_str = '0' * (bit_amt - len(binary_str)) + binary_str
    return binary_str

def fk_function(e1, e2, S0, S1, IP1, EP, P4, round_no):
    
    e_xor = add_trailing_zeroes_to_binary(xor(e1, e2), 8)
    print ("Compute XOR with K"+ str(round_no) +"\nResult: " + e_xor + "\n")

    S0_row = int( (e_xor[0] + e_xor[3] ), 2)
    S0_col = int( (e_xor[1] + e_xor[2] ), 2)
    S1_row = int( (e_xor[4] + e_xor[7] ), 2)
    S1_col = int( (e_xor[5] + e_xor[6] ), 2)

    fk_bits =  add_trailing_zeroes_to_binary(str(bin(S0[S0_row][S0_col]))[2:], 2)
    fk_bits += add_trailing_zeroes_to_binary(str(bin(S1[S1_row][S1_col]))[2:], 2)
    
    print ("Compute first four bits with S0 and last four bits with S1\nResult: " + fk_bits + "\n")

    fk_bits = get_permutation(fk_bits, P4)
    print ("Do P4 permutation to previous bits\nResult: " + fk_bits + "\n")
    
    IP1_fk_xor = add_trailing_zeroes_to_binary(xor(IP1[0:4], fk_bits), 4)
    xor_element = "IP" if round_no == 1 else "SW function"
    print ("Perform XOR between the first 4 bits obtained in the " + xor_element + " (" + IP1[0:4] + ") and these P4 bits (" + fk_bits + "):\nResult: " + IP1_fk_xor + "\n")

    fk_bits = IP1_fk_xor + IP1[4:]  
    print ("Add last four bits of " + xor_element + " (" + IP1[4:] + ")\nResult: " + fk_bits + "\n")
    return fk_bits
 
def inverse_permutation(bits, IP_):
    return get_permutation(bits, IP_)

def main(P):
    if P == '':
        P   = '10010010'      # Ciphertext
    else:
        P = add_trailing_zeroes_to_binary(P, 8)

    # Keys and permutation rules
    K   = '1011010011'    # Key
    P8  = [ 6, 3, 7, 4, 8, 5, 10, 9, 2, 1]  # 2 last elements are just padding
    P10 = [ 3, 5, 2, 7, 4, 10, 1, 9, 8, 6 ]
    print_begin_values(P, K, P8, P10)

    KP = p10_permutation(K, P10) # permutes the key according to permutation P10
    print ("\nKey after permutation P10:", KP, end='\n\n')
    
    print ("Split the key to two groups of 5 bits:")
    B1, B2 = KP[0:5], KP[5:] # Split results in two groups of 5 bits 
    print ("5-bits 1 =", B1, "\n5-bits 2 =", B2, end='\n\n')

    print ("Perform a circular left shift (LS-1) for groups of 5 bits:")
    B1 = ls_1(B1)
    B2 = ls_1(B2)
    print ("5-bits 1 =", B1, "\n5-bits 2 =", B2, end='\n\n')

    K1 = p8_permutation(B1, B2, P8)
    print ("K1 =", K1, end='\n\n')
 
    print ("Perform a circular left shift two times(LS-2) for groups of 5 bits:")
    B1 = ls_2(B1)
    B2 = ls_2(B2)
    print ("5-bits 1 =", B1, "\n5-bits 2 =", B2, end='\n\n')

    K2 = p8_permutation(B1, B2, P8)
    print ("K2 =", K2, end='\n\n')

    ######### f(k) function ##########

    print ("### THE FIRST f(k) ###")
    
    IP  = [ 2, 6, 3, 1, 4, 8, 5, 7 ]
    IP_ = [ 4, 1, 3, 5, 7, 2, 8, 6 ]
    EP  = [ 4, 1, 2, 3, 2, 3, 4, 1 ]

    IP1 = get_permutation(P, IP)
    print ("IP =",IP1 + "\n")

    IP_bits1, IP_bits2 = IP1[0:4], IP1[4:]
    EP_bits1 = get_permutation(IP_bits2, EP)

    S0 = [  [1, 0, 3, 2],   # 0
            [3, 2, 1, 0],   # 1
            [0, 2, 1, 3],   # 2
            [3, 1, 3, 2]]   # 3

    S1 = [  [0, 1, 2, 3],   # 0
            [2, 0, 1, 3],   # 1
            [3, 0, 1, 0],   # 2
            [2, 1, 0, 3]]   # 3

    P4 =    [2, 4, 3, 1]
    
    fk_bits = fk_function(EP_bits1, K2, S0, S1, IP1, EP, P4, 1)
    
    ######### SW function ##########
    
    switched_fk_bits = fk_bits[4:] + fk_bits[0:4]
    print ("### SWITCH FUNCTION ###\nSwitch the two 4 bits sequences:\n" + switched_fk_bits + "\n")

    
    ######### Second f(k) function ##########
    
    EP_bits2 = get_permutation(switched_fk_bits[4:], EP)
    print ("### SECOND f(k) function ###\nApply E/P to the last 4 bits:\n" + EP_bits2 + "\n")
    
    fk_bits = fk_function(EP_bits2, K1, S0, S1, switched_fk_bits, EP, P4, 1)

    ######### Inverse permutation ###########

    print ("### INVERSE PERMUTATION ###")
    plaintext = inverse_permutation(fk_bits, IP_)
    print ("To obtain plaintext, apply IP^-1 = (4 1 3 5 7 2 8 6)\nPlaintext for ciphertext " + P + ": " + plaintext + "\n")

import sys

# If command line arguments are given
if len(sys.argv) > 1 and __name__ == '__main__':
    for arg in sys.argv[1:]:
        # Test if the argument only consists of binary
        b = True
        t = '01'
        for char in arg:
            if char not in t:
                print ("Argument " + arg + " is not binary string!\n")
                b = False
                break
        
        # Handle binary in one byte blocks (pass one byte of binary to main)
        while (b):
            block_index = 0
            block = ''
            for binary in arg:
                block += str(binary)
                block_index += 1
                if block_index == 8:
                    main(block)
                    block = ''
                    block_index = 0
            main(block)
            break

elif __name__ == '__main__':
    main('')
