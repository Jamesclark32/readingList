<template>
  <div>
    <button @click="showAddBookModal()"
            class="rounded bg-indigo-600 text-indigo-200 border border-indigo-600 p-5 py-1 m-5 shadow-sm">
      Add a book
    </button>

    Sorted by <select v-model="orderedBooksKey" class="p-0 pl-5 pr-10 rounded bg-gray-100 text-xs">
    <option value="title">Title</option>
    <option value="author">Author</option>
    <option value="read_sequence">Read Order</option>
  </select>
    <table>
      <thead class="bg-gray-300">
      <tr>
        <th class="px-5">
          Action
        </th>
        <th class="px-5">
          Title
        </th>
        <th class="px-5">
          Author
        </th>
        <th class="px-5">
          Read Order
        </th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="book in orderedBooks">
        <td>
          <button @click="showBook(book)"
                  class="rounded bg-indigo-50 text-indigo-900 border border-indigo-100 px-2 py-0 text-xs shadow-sm">
            Show
          </button>
          <button @click="editBook(book)"
                  class="rounded bg-indigo-50 text-indigo-900 border border-indigo-100 px-2 py-0 text-xs shadow-sm">
            Edit
          </button>
          <button @click="deleteBook(book)"
                  class="rounded bg-red-100 text-red-900 border border-red-200 px-2 py-0 text-xs shadow-sm">Delete
          </button>
        </td>
        <td class="text-sm text-center">
          {{ book.title }}
        </td>
        <td class="text-sm text-center">
          {{ book.author }}
        </td>
        <td class="text-sm text-center">
          {{ book.read_sequence }}
        </td>
      </tr>
      </tbody>
    </table>
    <div>

      <modal v-if="addBookModalDisplayed">
        <template v-slot:title>
          Add Book
        </template>
        <template v-slot:body>
          <form>
            <div>
              <label for="title" class="left-0 block text-sm font-medium text-gray-700 pt-8">Title</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="title"
                    type="text"
                    v-model="newBookTitle"
                >
              </div>
            </div>
            <div>
              <label for="author" class="left-0 block text-sm font-medium text-gray-700 pt-8">Author</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="author"
                    type="text"
                    v-model="newBookAuthor"
                >
              </div>
            </div>
          </form>
        </template>
        <template v-slot:footer>
          <button type="button" @click="submitBookForm()"
                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Save
          </button>
          <button type="button" @click="cancelBookForm()"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Cancel
          </button>
        </template>
      </modal>

      <modal v-if="showActiveBookModalDisplayed">
        <template v-slot:title>
          {{ activeBook.title }}
        </template>
        <template v-slot:body>
          <div class="grid grid-cols-2 gap-4">
            <div>
              <div class="font-extrabold">{{ activeBook.title }}</div>
              <div>by <span class="font-bold">{{ activeBook.author }}</span></div>
              <div class="text-sm">ISBN: {{ activeBook.isbn }}</div>
              <div class="text-sm">Read Order Position: {{ activeBook.read_sequence }}</div>
            </div>
            <div>
              <div v-if="activeBook.cover_image_src">
                <img :src="activeBook.cover_image_src" class="shadow-md">
              </div>
              <div v-else>
                Cover Image Not Available :'(
              </div>
            </div>
          </div>
        </template>
        <template v-slot:footer>

          <button type="button" @click="hideActiveBookModal()"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Close
          </button>
        </template>
      </modal>


      <modal v-if="editActiveBookModalDisplayed">
        <template v-slot:title>
          Edit Book
        </template>
        <template v-slot:body>
          <form>
            <div>
              <label for="title" class="left-0 block text-sm font-medium text-gray-700 pt-8">Title</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="title"
                    type="text"
                    v-model="activeBook.title"
                >
              </div>
            </div>
            <div>
              <label for="author" class="left-0 block text-sm font-medium text-gray-700 pt-8">Author</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="author"
                    type="text"
                    v-model="activeBook.author"
                >
              </div>
            </div>
            <div>
              <label for="isbn" class="left-0 block text-sm font-medium text-gray-700 pt-8">ISBN</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="isbn"
                    type="text"
                    v-model="activeBook.isbn"
                >
              </div>
            </div>
            <div>
              <label for="read_sequence" class="left-0 block text-sm font-medium text-gray-700 pt-8">Read Order</label>
              <div class="mt-0">
                <input
                    autocomplete="off"
                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md"
                    name="read_sequence"
                    type="text"
                    v-model="activeBook.read_sequence"
                >
              </div>
            </div>
          </form>
        </template>
        <template v-slot:footer>
          <button type="button" @click="submitEditBookForm()"
                  class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
            Save
          </button>
          <button type="button" @click="cancelEditBookForm()"
                  class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
            Cancel
          </button>
        </template>
      </modal>

    </div>
  </div>
</template>

<script>
import Modal from "./modal";

export default {
  components: {Modal},
  props: {
    urls: Object,
  },

  data() {
    return {
      books: {},
      addBookModalDisplayed: false,
      editBookModalDisplayed: false,
      newBookTitle: null,
      newBookAuthor: null,
      orderedBooksKey: 'read_sequence',
      showActiveBookModalDisplayed: false,
      editActiveBookModalDisplayed: false,
      activeBook: {},
    }
  },
  methods: {
    hideActiveBookModal() {
      this.showActiveBookModalDisplayed = false;
    },
    deleteBook(book) {
      if (confirm('Are you certain you want to delete ' + book.title + '?')) {
        axios.delete(book.destroyUrl)
            .then(response => {
              this.reloadBooks();
            });
      }
    },
    editBook(book) {
      this.activeBook = _.clone(book);
      this.editActiveBookModalDisplayed = true;
    },
    showBook(book) {
      axios.get(book.showUrl)
          .then(response => {
            this.activeBook = response.data.book;
            this.showActiveBookModalDisplayed = true;
          });
    },
    reloadBooks() {
      axios.get(this.urls.books.index)
          .then(response => {
            this.books = response.data.books;
          });
    },
    showAddBookModal() {
      this.addBookModalDisplayed = true;
    },
    submitBookForm() {
      axios.post(this.urls.books.store, {
        title: this.newBookTitle,
        author: this.newBookAuthor,
      })
          .then(response => {
            this.reloadBooks();
          });
      this.addBookModalDisplayed = false;
      this.clearBookForm();
    },
    submitEditBookForm(){
      axios.post(this.activeBook.updateUrl, {
        title: this.activeBook.title,
        author: this.activeBook.author,
        isbn: this.activeBook.isbn,
        read_sequence: this.activeBook.read_sequence,
      })
          .then(response => {
            this.reloadBooks();
            this.editActiveBookModalDisplayed = false;
          });
    },
    cancelEditBookForm(){
      this.editActiveBookModalDisplayed = false;
    },
    cancelBookForm() {
      this.addBookModalDisplayed = false;
      this.clearBookForm();
    },
    clearBookForm() {
      this.newBookTitle = null;
      this.newBookAuthor = null;
    },
  },
  computed: {
    orderedBooks: function () {
      return _.orderBy(this.books, this.orderedBooksKey);
    }
  },
  mounted() {
    this.reloadBooks();
  },
};
</script>
