<template>
  <div>
    <h2>Список книг</h2>

    <form @submit.prevent='addBook()' class='mb-3'>
      <div class="form-group">
        <input type="text" class="form-control" placeholder='Название' v-model='book.name'>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder='Автор' v-model='book.author'>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder='Количество страниц' v-model='book.page_number'>
      </div>
      <button type="submit" class='btn btn-light btn-block'>Добавить</button>
    </form>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class='[{disabled: !pagination.prev_page_url}]' class="page-item"><a @click='fetchBooks(pagination.prev_page_url)' class="page-link" href="#">Предыдущая</a></li>
        <li class="page-item disabled"><a class="page-link text-dark" href="#">Страница {{ pagination.current_page }} из {{ pagination.last_page }}</a></li>
        <li v-bind:class='[{disabled: !pagination.next_page_url}]' class="page-item"><a @click='fetchBooks(pagination.next_page_url)' class="page-link" href="#">Следующая</a></li>
      </ul>
    </nav>

    <table class="table">
      <thead>
        <tr>
          <th scope="col">№</th>
          <th scope="col">Название</th>
          <th scope="col">Автор</th>
          <th scope="col">Количество страниц</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for='book in books' v-bind:key='book.id'>
          <th scope="row">{{ book.id }}</th>
          <td>{{ book.name }}</td>
          <td>{{ book.author }}</td>
          <td>{{ book.page_number }}</td>
          <td>
            <div class="btn-group-vertical buttons-container">
              <button @click='editBook(book)' class="btn btn-warning mb-2">Редактировать</button>
              <button @click='deleteBook(book.id)' class="btn btn-danger">Удалить</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div> 
</template>

<script>
  export default {
    data() {
      return {
        books: [],
        book: {
          id: '',
          author: '',
          name: '',
          page_number: ''
        },
        book_id: '',
        pagination: {},
        edit: false
      }
    },

    created() {
      this.fetchBooks();
    },

    methods: {
      fetchBooks(page_url) {
        let vm = this;
        page_url = page_url || '/bookslist/public/api/books'
        fetch(page_url)
          .then(response => response.json())
          .then(response => {
            console.log(response.data);
            this.books = response.data;
            vm.makePagination(response.meta, response.links);
          })
          .catch(error => console.log(error))
      },
      makePagination(meta, links) {
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev
        }

        this.pagination = pagination;
      },

      deleteBook(id) {
        if(confirm('Вы уверены?')) {
          fetch(`/bookslist/public/api/book/${id}`, {
            method: 'delete'
          })
          .then(response => response.json())
          .then(data => {
            alert('Книга удалена');
            this.fetchBooks();
          })
          .catch(error => console.log(error));
        }
      },

      addBook() {
        if(this.edit === false) {
          // Добавить книгу
          fetch('/bookslist/public/api/book', {
            method: 'post',
            body: JSON.stringify(this.book),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            this.book.name = '';
            this.book.author = '';
            this.book.page_number = '';
            this.fetchBooks();
          })
          .catch(error => console.log(error))
        } else {
          // Обновить данные книги
          fetch('/bookslist/public/api/book', {
            method: 'put',
            body: JSON.stringify(this.book),
            headers: {
              'content-type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            this.book.name = '';
            this.book.author = '';
            this.book.page_number = '';
            this.fetchBooks();
          })
          .catch(error => console.log(error));

          this.edit = false;
          this.book.book_id = '';
        }
      },

      editBook(book) {
        this.edit = true;
        this.book.id  = book.id;
        this.book.book_id = book.id;
        this.book.name = book.name;
        this.book.author = book.author;
        this.book.page_number = book.page_number;
      }
    }
  }
</script>