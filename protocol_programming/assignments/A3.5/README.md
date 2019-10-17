# Assignment 3.5
<p>Write a client and a server program that can be used to send files to the server. You have to come up with a simple protocol (you don’t have to document the protocol, but you can) which allows the transfer of files. The protocol should be able to transmit name, size and contents of the file being sent. It is up to you to implmement this. The client HAS to send this information:</p>

  1. name of the file
  2. size of the file (in bytes!)
  3. contents of the file (actual bytes of the file from disk)

<p>When the server receives the connection, it uses this information to:</p>

  1. create a new file with the same name
  2. receive the total size of the file to receive (in bytes)
  3. Receive the contents of the file and write them to a file on disk.
    * under the received files directory.
    * name of the file has to be same as the one that the client sent

### Client

<p>The client takes three command line parameters:</p>

  1. path of the file to send
  2. server address
  3. server port

<p>The client will print an error message and exits if any of the following conditions are met:</p>

  1. The file is missing
  2. The file cannot be read from
  3. The client cannot connect to the server
  4. any others that you can think of

### Server

<p>The server takes three command line arguments:</p>

  1. path to a folder where to store the received files
  2. server address
  3. server port

<p>Once started, the server will listen for clients and receive files from the clients one by one. Each time a file is received the name of that file should be printed.</p>

<p>The server will print an error message and exits if any of the following conditions are met:</p>

  1. The target folder doesn’t exist
  2. Receiving a file failed
  3. Any other that you can think of

### Example

<p>Server has been started with the following arguments (you can use the same command line argument names if you want):</p>

  1. receive-directory: received-files\ (the directory is empty when the server is started for the first time)
  2. bind-addr: localhost
  3. bind-port: 8888

<p>Client is used with the following arguments (you can use the same command line argument names if you want):</p>

  1. file-to-send: house.jpg
  2. server-addr: localhost
  3. server-port: 8888

<p>After the client has finished, the server has house.jpg under received-files directory (received-files\house.jpg)</p>
