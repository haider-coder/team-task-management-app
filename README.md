# Task-management-app
task management application where users can perform CRUD operations on tasks.

**CRUD Operations:**<br>
Create, read, update, and delete tasks.<br>
Each task have a title, description, and status (e.g., "To Do," "In Progress," "Completed").<br><br>
**Web Hooks:**<br>
Implement a Web Hook system that triggers notifications when a task is created and admin or manager can further notify the user about that task.<br>
Notifications are sent via email.<br><br>
**Front-end:**<br>
Use HTML and Bootstrap 5 to create a simple and intuitive task management interface.<br>
<br>
**ACL (Access Control List):**<br>
Implement ACL to control access to certain tasks based on user roles.<br>
Defined roles such as "Admin," "Manager," and "User."<br>
Assigned permissions to roles (e.g., Admin can perform all actions, Manager can edit tasks, User can only view
tasks).<br><br>
**User Authentication and Authorization:**<br>
Integrated Laravel Auth UI for user authentication.<br>
Implemented middleware to check user permissions before allowing access to certain routes.<br>
Include a feature that allows users to provide feedback on tasks.<br><br>

**Implementation Guidelines:**
Used Laravel's Eloquent ORM for interacting with the database.
Designed a database schema to store task information.
Defined routes for CRUD operations.
Created separate controllers for handling task-related actions.
Used Blade templates for rendering views.
Implemented event listeners and events for Web Hooks.
Implemented middleware to check user permissions.
Enhanced UI to reflect user roles and permissions.
<br>
<hr>
****Some Home Screens****<br><hr>
**User's home** <br>
![image](https://github.com/UmerFarooq966/Task-management-app---Laravel-10/assets/94523330/3c8405f5-b2bd-456e-ba51-f98cd7e7d7f4) <br>
**Admin Home**<br>
![image](https://github.com/UmerFarooq966/Task-management-app---Laravel-10/assets/94523330/65b67a76-c5ea-4dae-a7d1-ca09f408a22e) <br>
**Manager Home**<br>
![image](https://github.com/UmerFarooq966/Task-management-app---Laravel-10/assets/94523330/f0ed81ef-31d2-4cf9-8a39-1b8a8d03b4b2)



