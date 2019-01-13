#säilyttää kaikkien opiskelijoiden nimet ja optunnukset
#filter_by_course() -funktiota varten
student_instances = []

class Student:

    #Kun uusi objekti lisätään Student classiin
    def __init__(self, name, age, student_id):

        self.name = name
        self.age = age
        self.student_id = student_id
        self.course_list = []
        instance_info = name + " " + student_id
        
        student_instances.append(instance_info)

        #Rakennetaan student-data.txt:n lisättävä teksti
        #Muutetaan ikä-muuttuja int --> str
        temp_age = str(age)

        #Teksti muotoon "nimi;ikä;student_id;\n"
        file_text = name+";"+temp_age+";"+student_id+";\n"

        #Lisätään tekstinpätkä filen loppuun
        f = open("student-data.txt", "a")
        f.writelines(file_text)
        f.close()
        
    def add_course(self, course):

        #Luodaan uusi listapaikka course_list:n arvolla course
        self.course_list.append(course)

        #Avataan student-data.txt read-modessa ja luodaan
        #teksti (text), joka pitäisi laittaa tiedostoon
        #kyseisen henkilön tämänhetkisten tietojen tilalle
        with open("student-data.txt","r") as f:

            #file sisältää tiedon filen riveistä
            file = f.readlines()
            
            #f.seek(0) laittaa "kursorin" filen alkuun
            f.seek(0)

            for line in file:
                if self.name in line:

                    #Jos kyseessä on ensimmäinen henkilölle lisättävä kurssi
                    if line[-2] == ';':
                        text = line[0:-1] + course + "\n"
                        break

                    #Jos henkilöllä on jo kursseja ennestään
                    else:
                        text = line[0:-1] + "," + course + "\n"
                        break
            f.close()

        #Kirjoitetaan kaikki muut rivit uudestaan,
        #mutta jätetään muutettava rivi kirjoittamatta
        f = open("student-data.txt","w")

        for line in file:
            if not line.startswith(self.name):
                f.write(line)
        f.close()

        #Kirjoitetaan muutettu rivi tiedoston loppuun
        #(avataan "append"-modessa)
        f = open("student-data.txt","a")
        f.write(text)
            
        return self.course_list

    #Listaa tietyn henkilön lisätyt kurssit
    def list_courses(self):
        return self.course_list

#Kertoo kaikkien oppilaiden nimet ja optunnukset
def read_student_data(filename):
    try:
        f = open(filename, "r")
    except:
        return "Invalid filename\n"
    
    file = f.readlines()
    temp = ("".join(file))

    #Luodaan muuttuja lopulta tulostettavalle opiskelijalistalle
    output=''

    '''Käydään jokaisen rivin kirjaimet läpi ja lisätään sieltä
    tarvittavat tiedot output-muuttujaan (nimi ja optunnus).
    Poikkeustapaukset (eli kirjaimet, joita ei oteta output
    -muuttujaan) on lueteltu sisemmän for-loopin
    if ja elif lauseissa.'''

    #Looppi jokaisen rivin käymiseen
    for line in file:
        
        index = 0 #kuvaa sitä, mones sana riviltä on käsittelyssä   
        letters_in_line = 0 #mones kirjain riviltä on käsittelyssä

        #Looppi jokaisen kirjaimen käymiseen yhdeltä riviltä
        for char in line:
            if char == ';' and index == 0:
                index += 1
                output = output + " "

            #Kun ollaan päästy kolmannen sanan (optunnus) loppuun,
            #lisätään rivinvaihto ja siirrytään seuraavaan riviin
            #tiedostossa (ulompi for-looppi)
            elif index == 2 and char == ';':
                output = output + "\n"
                break

            elif index == 1 and char == ';':
                index += 1
            
            elif index == 1:
                letters_in_line += 1
                continue

            #Otetaan uusi kirjain ylös output-muuttujaan,
            #kun ollaan tarpeellisen kirjaimen kohdalla
            else:
                output = output + line[letters_in_line]
            letters_in_line += 1

    
    return output
      
def filter_by_course(student_instances, course):
    f = open("student-data.txt", "r+")
    file = f.readlines()
    f.seek(0)

    #Luodaan muuttuja opiskelijalistalle
    output = ''

    '''read_student_data -funktiosta tuttu sisäkkäinen for looppi,
    joka tällä kertaa lisää output -muuttujaan ainoastaan ne henkilöt,
    jotka ovat course -parametrin kurssilla (loopin kommentit löytyvät
    read_student_data -funktiosta'''
    
    for line in file:
        index = 0
        letters_in_line = 0

        #Jos course -parametri löytyy riviltä, lisätään ko.
        #henkilön tiedot output -muuttujaan
        if course in line:
            for char in line:
                if char == ';' and index == 0:
                    index += 1
                    output = output + " "

                elif index == 2 and char == ';':
                    output = output + "\n"
                    break

                elif index == 1 and char == ';':
                    index += 1
                
                elif index == 1:
                    letters_in_line += 1
                    continue

                else:
                    output = output + line[letters_in_line]
                letters_in_line += 1

    #Jos output-muuttujan arvo ei ole muuttunut,
    #kurssille ei ole osallistujia
    if output == '':
        return "This course has no participants... Yet"
                
    return output
    

#Kun ohjelma aloitetaan, luodaan student-data.txt.
#Jos se on olemassa varmistetaan, että tiedosto on tyhjä
f = open("student-data.txt", "w")
f.truncate()
f.close()

#Lisätään Student -classille objekteja (bob, joe ja josie)
bob = Student("Bob", "23", "D3344")
joe = Student("Joe", 25, "F1234")
josie = Student("Josie", 21, "F5678")
teemu = Student("Teemu", 21, "T1551")

#Lisäillään kursseja henkilöille, sekä uusia henkilöitä
joe.add_course("Pelailu")
teemu.add_course("Puunpoltto 420")
josie.add_course("Leikkiminen 3")
jonathan = Student("Jonathan", "32", "F2468")
joe.add_course("Perunankeitto 26")
jonathan.add_course("Puunpoltto 420")
bob.add_course("Mathematics 3")
kana = Student("Kana", 102, "K4200")
josie.add_course("Sairaus ja taudit")
kana.add_course("Puunpoltto 420")
bob.add_course("Physics 3")
bob.add_course("Algorithms and data structures")
kana.add_course("Pelailu")

#Tulostetaan ensin kokonainen opiskelijalista
#ja sitten kolmen kurssin osallistujalistat
print(read_student_data("student-data.txt"))
print(read_student_data("kananpoika.txt"))
print(filter_by_course(student_instances, "Puunpoltto 420"))
print(filter_by_course(student_instances, "Pelailu"))
print(filter_by_course(student_instances, "Koiranulkoiluttaminen"))


