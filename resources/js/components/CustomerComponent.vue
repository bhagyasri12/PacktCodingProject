<template>
    <div class="text-center align-items-center d-flex">
        <form class="w-100 d-flex align-items-center" v-on:submit.prevent="getBooks()">
            <label class="mx-4 fw-bold">Search</label>
            <input type="text" class="w-25 form-control" v-model="search_string"
                   placeholder="search with title, author, isbn, genre">

            <label class="mx-3">Published On</label>
            <input type="date" class="w-25 form-control" v-model="published_date">
            <input type="submit" value="Search" class="btn btn-primary m-lg-2">
        </form>
    </div>
    <div class="container">
        <div class="container-fluid grid-container">
            <a v-for="book in books" class="grid-item card" v-bind:href="'/books/'+book['id']">
                <div>
                    <img v-bind:src="book['image']" width="150" class="mb-3">
                    <div>
                        <div class="mb-1">
                            <span class="fw-bold">Title : </span>
                            <span class="">{{ book['title'] }}</span>
                        </div>
                        <div class="mb-1">
                            <span class="fw-bold">Author : </span>
                            <span class="">{{ book['author'] }}</span>
                        </div>
                        <div class="mb-1">
                            <span class="fw-bold">Published On : </span>
                            <span class="">{{ book['published'] }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: "CustomerComponent",
    search_string: '',
    published_date: null,
    data() {
        return {
            books: [],
        }
    },
    created() {
        this.getBooks()
    },
    methods: {
        getBooks() {
            let post_data = {
                search: this.search_string,
                date: this.published_date
            }
            axios.post('/search-books', post_data).then(({data}) => {
                this.books = data;
            }).catch(error => {

            });
        },
    }
}
</script>

<style scoped>
.grid-container {
    display: grid;
    grid-template-columns: auto auto auto;
    padding: 10px;
}

.grid-item {
    max-width: 100%;
    background-color: rgba(255, 255, 255, 0.8);
    border: 1px solid rgba(0, 0, 0, 0.25);
    padding: 20px;
    margin: 10px;
    text-align: center;
}

.card:hover {
    box-shadow: 2px 2px 4px 3px #cccccc;
}

a {
    text-decoration: none;
    color: #444444;
}
</style>
