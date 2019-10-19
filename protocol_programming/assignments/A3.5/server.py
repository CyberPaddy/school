import socket

# Creates new file to 'received-files' -folder
def create_new_file(name, contents, folder):
    from my_utils import format_folder  # Returns folder path with only forward slashes
    folder = format_folder(folder)

    from pathlib import Path    # Path converts forward slashes into the correct kind of slash for the OS
    try:
        new_file = open( Path(folder) / name, 'wb') 
    except FileNotFoundError:
        print("Folder '" + folder + "' doesn't exist\nServer is shutting down...")
        exit(1)
    except PermissionError as e:
        print("Current user does not have write permission to folder '" + folder + "'\nServer is shutting down...")
        print (e)
        exit(1)
    except IOError:
        print("File", name, "could not be created to '" + folder + "' -folder\nServer is shutting down...")
        exit(1)
    
    new_file.write(contents)
    new_file.close()
    print ("Successfully created new file", name, "to received_files -folder!")

def main(RECV_FOLDER, HOST, PORT):
    s= socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    
    try:
        s.bind((HOST, PORT))
    except OSError:
        print ("Port", PORT, "is already occupied by another process. Please use different port!")
        exit(1) 

    s.listen(5)

    while True:
        (client, addr) = s.accept()
        print("\nReceived a connection from ", addr)
       
        # recv_from_socket handles receiving all data from client
        # and returns the name of the file and its contents
        from my_utils import recv_from_socket
        file_name, received_file = recv_from_socket(client)

        if len(file_name) != 0:
            print ("\nName of the received file:", file_name)
            create_new_file(file_name, received_file, RECV_FOLDER)
        else:
            print("Client did not send any file")
        
    print ("\nClosing the server...")
    s.close()

import sys
# Program needs to have two command line arguments (host and port)
if __name__ == "__main__" and len(sys.argv) == 4:
    try:
        PORT = int(sys.argv[3])
        # Do not use well-known ports 0-1023
        if PORT < 1024 or PORT > 65535:
            raise ValueError
    except ValueError:
        print ("Please give integer value between 1024-65535 as <PORT>\nSyntax: server.py <HOST> <PORT>")
        exit(1)

    main(sys.argv[1], sys.argv[2], PORT) # Args: RECV_DIR HOST, PORT

elif __name__ == "__main__":
    print("Please give two command line arguments!\nSyntax: server.py <HOST> <PORT>")
