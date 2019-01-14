### Assignment 01 (1 point)
Write a function that takes two (2) parameters
..* Socket
..* Data
Function should send all of the data to the socket
__send()__ might not send everything!
Function should raise an exception if some error occurs

This can be any error and exception can be your own string
##### Optional step:

Create a server side function that does the opposite (receives until the message is fully received)
Hints:
..* How you know how many bytes your string is?
..* send()-method returns something usefull
..* Compare something until 2 values match with each other
