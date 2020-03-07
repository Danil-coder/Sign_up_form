# Sign_up_form

Registration and authorization form with a simple personal profile
-----------------------------------

General description
-----------------------------------
The project includes three web pages: sign in, sign up and privat user page. Authorization produces by checking the username and password. The registration page contains four required fields (username, email, password, and re-password) and three optional fields (first name, last name, and phone). The ability to upload photos with a size up to 5 MB in jpeg, png or gif is also provided. A personal profile is a stylized page that displays user data.

Safety
-----------------------------------
Data verification and validation takes place on the server and on the client side. If entered data is invalid, the user receives a hint that will help fix it. The submit button remains blocked until the required fields are filled in correctly.

Language switching
-----------------------------------
All three pages are provided with the ability to choose the language (English or Russian). The language is changed on the server, and the dictionary of used phrases is located in the "wordlist.php". The module responsible for changing the language is located in the "lang_switcher.php".

Database structure
-----------------------------------
The database dump is contained in the "database_dump" folder. The database structure is a single table with a B-tree indexed "username" column.

Responsiveness
-----------------------------------
Design responsiveness is provided by both elements of fluid layout (using relative units of length) and elements of adaptive layout (using media expressions).

Example
-----------------------------------
The working version of this form can be found at: [https://spacyfox.gq/signup.php]
