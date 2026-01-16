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

7. The routes have been added. No session.

8. The challange I faced was trying to implement and use google docs API. I created a cloud project and account using the 90-day-trial with 300 credits. However, this seemed to be challanging when implementing it in code as the resources weren't enough. Implementing Gemini wasn't the original plan, it was an extra feature built on google docs. Gemini proved to be efficient with my requirements, free, does not consume quota and enough for a school project that could be enhanced later.

9. The AIController was easy enough, since there was no need for extra funds from my side as long as i don't jump the quota. I'm using gemini and it was 3 easy steps to set it up.

10. The sorting and filtering was applied to the saved-idea cards, where it will be easier for the user to search and filter through them.

11. Added some Comments 