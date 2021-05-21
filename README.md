# Reading List

This application provides rudimentary reading list management functionality. 
Books can be added, edited, deleted, listed, or shown via the exposed api or via the web interface.

This is certainly a first draft, proof-of-concept and things are rough around the edges. 

The application features:

 - basic integration with OpenLibrary to retrieve isbn numbers and cover images for books.
 - basic CRUD infrastructure via web interface or API interface
 - simple sorting of data on web interface
 - ability to change intended read order via the edit functionality

## Api endpoints 

### Index
GET /api/v1/books

<hr>

### Store

POST /api/v1/books

parameters: 

string **title**

string **author**

<hr>

### Update

POST /api/v1/books/{book-slug}

parameters:

string **title**

string **author**

string **isbn**

string **read_sequence**

<hr>

### A note on coding style

I'm in the practice of favoring lots of small files over a few large files, but believe in only doing this when the right abstraction is found. 

This plays out in things like breaking the routes down into smaller, more digestable files.

I also use command and query helper classes in controllers. I feel like controllers often get abused, and have landed on the mindset that the responsibility of a controller is to translate to and from HTTP. Injecting a "plain old php object" to handle the rest feels clean to me.

I welcome any discussion around these perspectives!

<hr>

### Destroy

DELETE /api/v1/books/{book-slug}

## Next Steps
1. Improve test coverage
2. Refactor home.vue. 
   Tables should be broken out into a component. 
   Form elements should be broken out into helper components.
   Modal is partially abstracted, but needs a lot more clean up, with the various applications of modal abstracted out.
   Lots of inline tailwind classes which should be refactored out.
3. Loading dialog when retrieving books would be really helpful.
4. Rethink OpenLibrary integration and incorporate into update.
5. Refactor to be user specific, and apply auth guards on all routes.
6. Editing with the ability to change read sequence was a quick version of sorting. 
   It works for the most part, but it is possible to encounter problems with it based on the second sort in the resequence procedure, which looks at the ID column.
   Making the table drag-and-droppable would be a much better approach, but requires a bit more UI work than I felt I had time for in this first version.
