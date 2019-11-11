# Python 3

# Return True if list is empty
def empty_list(students_list):
    if len(students_list) > 0:
        return False
    return True

# Return username to be appended to list
def add_student():
    user_name = input("\nWhat is student's name? ")
    print ("User " + user_name + " added!\n")
    return user_name

# Prints students in list
def print_students(student_list):
    if empty_list(student_list):
        print("Student list is empty!\n")
        return  
    for student in student_list:
        print (student, end=' ')
    print("\n")

# Prints students with 1-based indexes
def print_enumerate_students(students):
    for i, student in enumerate(students):
        print (f"{i+1}: {student}")

# Returns index of student in students list
def delete_student(students):
    print_enumerate_students(students)

    delete_user = None
    # Get integer value corresponding the user to be deleted
    try:
        delete_user = int(input("\nChoose deleted user (1 - " + str(len(students)) + "): "))
    except ValueError as e:
        print("\nCan't convert input to integer: " + str(e))
        delete_student(students)

    if delete_user >= 1 and delete_user <= len(students):
        print ("Deleted " + students[delete_user-1] + " from student list\n")
        return delete_user -1
    print (str(delete_user) + " is invalid index, try again!\n")
    delete_student(students)

# Prompt user to change user's name
def edit_student(students):
    print_enumerate_students(students)

    edit_user = None
    try:
        edit_user = int(input("\nChoose user you want to edit (1 - " + str(len(students)) + "): "))
    except ValueError as e:
        print("\nCan't convert input to integer: " + str(e))
        edit_student(students)

    if edit_user >= 1 and edit_user <= len(students):
        old_user = students[edit_user -1]
        students[edit_user -1] = input("Give new name for " + students[edit_user -1] + ": ")

        print("Changed '" + old_user + "' name to '" + students[edit_user -1] + "'!\n")
        return students

    print (str(edit_user) + " is invalid index, try again!\n")
    edit_student(students)

def main():
    students = []

    while 1:
        print("1: ADD STUDENT")
        print("2: DELETE USER")
        print("3: EDIT USER")
        print("4: PRINT USERS")
        print("0: EXIT")

        try:
            choice = int(input("Choose 1-4: "))
        except ValueError:
            print("\nChoose NUBMER between 1-4")
            continue

        if choice == 1:
            students.append(add_student())

        elif choice == 2:
            if empty_list(students):
                print ("Student list is empty!\n")
            else:
                del students[delete_student(students)]

        elif choice == 3:
            if empty_list(students):
                print ("Student list is empty!\n")
            else:
                students = edit_student(students)

        elif choice == 4:
            print_students(students)

        elif choice == 0:
            print ("\nGoodbye!\n")
            exit (0)

        else:
            print ("INVALID CHOICE\n\n")

if __name__ == '__main__':
    main()
