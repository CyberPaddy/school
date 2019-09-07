import binascii

encoded_hex = '1b37373331363f78151b7f2b783431333d78397828372d363c78373e783a393b3736'
encoded_bytes = binascii.unhexlify(encoded_hex)

# XOR encoded_hex against every single ascii character (0-255)
# and put possible outcomes to variable
possible_outcomes = (''.join(chr(byte ^ key) for byte in encoded_bytes) for key in range(256))

# The outcome with most space characters should be real sentence
best_outcome = max(possible_outcomes, key = lambda s: s.count(' '))

# Test that the outcome with most spaces really is the right answer
from langdetect import detect
if detect(best_outcome) == 'en':
    print (best_outcome)
    exit()

print ("Try different tactic")
