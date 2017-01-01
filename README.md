# User-Hierarchy

=======================================================================================================================

For every user, the administrator can select a list of users (existing in system) for both fields: “People reporting to
User” & “User reports to People”. 

Admin Module

1. Add new user.
2. Delete an existing user
3. Update the user details
4. Set reporting rights by adding or deleting an existing reporting relationship

User Module

1. View data of subordinates
2. View immediate superiror

The user hierarchy is going to be used to show the user his own data as well as of all the people
below him (all levels).

=======================================================================================================================

Example :

Users B,C report to A. Users D,E,F report to B. Users G,H report to F. Users I,J report to C.
So user A will see data of all users (i .e. B,C,D,E,F,G,H,I,J) below him and his own data. User B
will see data of all below him (i .e. D,E,F,G,H) below him.


=======================================================================================================================
Storing and querying hierarchical data in any RDBMS using Closure Table
