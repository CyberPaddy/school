import sys

#Is there right amount of parameters
if len(sys.argv) != 2:
    print ("Give only one filename (e.g. 'asgmt29.py text1.txt')")

else:
    #Test if file exists
    try:
        temp = open(sys.argv[1], "r")
    except:
        print ("File not found")
    else:
        #Open file and read its lines
        f = open(sys.argv[1], "r")
        temp_text = f.readlines()

        #Remove .readlines() -method made characters between lines
        text = ("".join(temp_text))
        print (text)
