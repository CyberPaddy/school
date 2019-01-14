import random

#Luodaan muuttujat pelaajan jäljellä oleville arvauksille
#ja arvausten määrälle yhteensä
guess_cnt = 1
guess_max = 5

#Kun peli on käynnissä, uusi peli alkaa tästä
while guess_cnt != guess_max + 1:

    print ("\n++ Guessing Game ++\nGuess a number between 0 and 20\n")

    #Luodaan pseudorandom numero väliltä 0 - 20
    rand = random.randint(0,20)

    #Kun arvauksia on vielä jäljellä
    while guess_cnt != guess_max+1:
        while True:
            print ("Guess", guess_cnt, end="")
            print ("/", end="")
            print (guess_max, end=": ")
            guess = input ()

            #Kokeillaan, onko pelaajan antama inputti validi NUMERO
            while True:
                try:
                    guess = int (guess)
                except:
                    print ("Guess should be a NUMBER between 0 and 20, try again")
                    break
                else:
                    guess = int(guess)
                    if guess < 0 or guess > 20:
                        print ("Guess should be between 0 and 20, try again")
                        break

                    #Jos pelaajan arvaus on validi, lisätään arvauslaskuriin +1
                    else:
                        guess_cnt += 1
                        break
            
            break #Jos arvauksia on vielä jäljellä, peli pyytää uutta arvausta

        #Jos pelaajan arvaus on sama kuin arvottu numero, pelaaja voittaa
        #Peli antaa mahdollisuuden aloittaa uusi peli pelaajan niin halutessa
        if guess == rand:
            guess_cnt = 6
            print ("\nYey, you won the game!\nDo you want to play again (Y/N)? ", end="")
            new_game = input ()
            break

    #Jos pelaaja ei ole arvannut lukua arvausten loputtua, pelaaja häviää.
    #Peli kysyy, haluuko pelaaja aloittaa uuden pelin
    if guess != rand:
        print ("\nWhat a n0000b!\nDo you want to play again (Y/N)? ", end="")
        new_game = input ()

    #Vaihtoehdot pelaajan valinnoille uudesta pelistä
    while True:
        if new_game == 'y' or new_game == 'Y':
            guess_cnt = 1
            break
        elif new_game != 'n' and new_game != 'N':
            new_game = input ("Do you want to play again (Choose Y/N)? ")
        else:
            guess_cnt = 6
            break
                              


