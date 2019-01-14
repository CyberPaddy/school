### Assignment 3

##### Make the following modifications to the server example from assignment 2:
<p>Add two command line parameters to the program:</p>

<ul>
<li>Address</li>
<li>Port</li>
</ul>

<p>If these two values are not given from the command line the server should print an error message and exit immediately<br />
These two values should be used for binding the server socket with <i>bind()</i><br />
Keep the server running after a single connection has been handled.</p>
<ul>
<li>You don’t have to be able to handle multiple connections at the same time!</li>
<li>Once a connection has been handled the server should go back to waiting new connection (<i>accept()</i>-method)</li>
</ul>

##### Make the following modifications to the client example from assignment 2:
<p style="padding-left='20px'">Add two command line parameters to the program:</p>
<ul>
<li>Address</li>
<li>Port</li>
</ul>

<p>If these two values are not given from the command line the client should print an error message and exit immediately<br />
Handle the exceptions from <i>connect()</i> and <i>send()</i> and print a human readable error message if an error occurs</p>
