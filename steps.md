1. Step 1. I decided to use Figma as my UI design. 

: There will be three pages - 

The first page will handle the user when they login using a 4-digit code;
to take the user to the Second page. This will either take them to a blank document or the initial document they were already handling. 

The third page will have their saved ideas, the generated ideas that were called using an api to help the author continue writing.

2. The Pages were created via Figma
    
3. The Models were created migrations for users, documents, and saved_ideas tables.
- Created users table with id and user_codefor user identification.
- Created documents table linked to users with user_id foreign key; stores content and google_doc_id.
- Created saved_ideas table linked to users with the user_id; stores idea_text.

4. Generated a visual ERD for a better representation of the relationships.

5. Ran the laravel app using the php artisan serve to start building the routes

6. Created the documentController to accepts the 4-digit code, create the user or finds them with their new or previous document. the controller will also show the dashboard, save, and delete the document. This uses the basis of CRUD.

7. The routes have been added.