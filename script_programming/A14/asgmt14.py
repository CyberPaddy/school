def symbols(sana):
    if ((sana[0] or sana[len(sana)]) != '=' and (sana[0] or sana[len(sana)]) != '+'):
        return False
    for i, char in enumerate(sana):
        if ((char != '+' and char != '=') and (sana[i-1] != '+' or sana[i+1] != '+')):
            return False
    return True


print (symbols('+++===+'))
print (symbols('+A+a+a+'))
print (symbols('a++===+'))
print (symbols('+++===a'))
print (symbols('+++=a+a+'))
print (symbols('+++Aa+a+'))
print (symbols("+a+====+b+"))
print (symbols("+a+==x==+b+"))
