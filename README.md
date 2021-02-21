# Reading List

This application provides rudimentary reading list management functionality. 
Books can be added, edited, deleted, listed, or shown via the exposed api or via the web interface.


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

### Destroy

DELETE /api/v1/books/{book-slug}