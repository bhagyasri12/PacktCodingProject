<template>
    <div>
        <table id="customers" class="w-100">
            <tr>
                <th>#</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Genre</th>
                <th>Description</th>
                <th scope="col">Isbn</th>
                <th scope="col">Published</th>
                <th scope="col">Publisher</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            <tr v-for="book in books">
                <td>{{ book['id'] }}</td>
                <td>{{ book['title'] }}</td>
                <td>{{ book['author'] }}</td>
                <td>{{ book['genre'] }}</td>
                <td>{{ book['description'] }}</td>
                <td>{{ book['isbn'] }}</td>
                <td style="width: 100px;">{{ book['published'] }}</td>
                <td>{{ book['publisher'] }}</td>
                <td>
                    <a v-bind:href="'/books/'+book['id']+'/edit'">Edit</a>
                </td>
                <td>
                    <div class="delete_link" @click="deleteBook(book['id'],index)">Delete</div>
                </td>
            </tr>
        </table>

        <div class="my-4" v-if="page_count>1">
            <paginate
                :page-count="page_count"
                :page-range="9"
                :click-handler="handlePaginate"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'"
                :page-class="'page-item'"
                :page-link-class="'page-link'"
                :prev-link-class="'page-link'"
                :next-link-class="'page-link'"
            >
            </paginate>
        </div>
    </div>
</template>

<script>
import Paginate from "vuejs-paginate-next";

export default {
    name: "Books",
    components: {
        Paginate
    },
    data() {
        return {
            books: [],
            page_count: 1
        }
    },
    created() {
        this.getBooks()
    },
    methods: {
        getBooks(page = 1) {
            let url = '/get-books?page=' + page;
            axios.post(url).then(({data}) => {
                this.books = data.data;
                this.page_count = data.last_page;
            }).catch(error => {

            });
        },
        handlePaginate(page) {
            this.getBooks(page)
        },
        deleteBook(id, index) {
            axios.delete('/books/' + id).then(({data}) => {
                console.log(data)
                if(data['success']){
                    this.books.splice(index,1)
                }
            }).catch(error => {
            });
        }
    },
}
</script>

<style scoped>
#customers {
    font-family: Arial, Helvetica, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

#customers td, #customers th {
    border: 1px solid #ddd;
    padding: 8px;
}

#customers tr:nth-child(even) {
    background-color: #f5f5f5;
}

#customers tr:hover {
    background-color: #ddd;
}

#customers th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #888888;
    color: white;
}

.delete_link {
    text-decoration: underline;
    color: blue;
    cursor: pointer;
}

.delete_link:hover {
    opacity: 0.8;
}
</style>
