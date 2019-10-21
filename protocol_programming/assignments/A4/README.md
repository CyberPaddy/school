# Assignment 4
<p>Design a simple file transfer protocol.</p>

<p>The protocol client has to have at least two possible request</p>

  * LIST which lists the filenames of the files available on the server.
  * DOWNLOAD which downloads a file. A filename has to be provided.

<p>The protocol server has to have at least two possible responses:</p>

  * ERROR which tells the client that the request could not be processed. The error message can be describe several different kinds of errors.
  * FILE which returns the data to the client.

<p><b>YOU DON’T HAVE TO IMPLEMENT THE CLIENT AND THE SERVER.</b> You have to write a protocol design document that specifies a protocol that implements the requirements mentioned earlier. The protocol design document does not have to really formal like the RFCs. Try to make it as clear as possible. The document has to be written in English. Please remember that the protocol specification does not have to describe the implementation, the specification specifies the protocol!</p>

<p>In your protocol specification, try to come up with possible error conditions that could occur. For example what happens if the client requests to download a file that does not exist?</p>

<p>Try to think of possible security related restrictions for your protocol as well!</p>

<p><b>Hint:</b> Start working on this assignment early, so if you have trouble getting started you have time to ask questions from the lecturer!</p>

<p>Get familiar with the kind of words you can use in your protocol specification by reading RFC2119. It is really short!</p>
