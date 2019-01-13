def calculator(operation, num1, num2):

    #Try if num1 or num2 are numbers
    try:
        temp = num1 + 2
        temp2 = num2 + 2

    #If TypeError
    except:
        return "You can only count numbers"
    
    if operation == 'add':
        result = num1 + num2
    elif operation == 'sub':
        result = num1 - num2
    elif operation == 'multiply':
        result = num1 * num2
    elif operation == 'divide':
        try:
            santas_lil_helper = num1 / num2
        except:
            return "You cannot divide by 0"
        else:
            result = num1 / num2    #If you try to divide 5 by 2, function
                                    #returns 2, because 5%2 leaves 1
    else:
        result = "Wrong operation inserted"

    return result


print (calculator('add', 1, 2))
print (calculator('add', 1.25, 2))
print (calculator('sub', "Kaneli", 2))
print (calculator('multiply', 1, "koira"))
print (calculator('divide', "pulla", "mosso"))
print (calculator('divide', 5, 0))
print (calculator('kana', 1, 2))
