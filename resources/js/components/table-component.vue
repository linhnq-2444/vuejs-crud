<template>
    <div style="width: 35%; margin: 15px auto">
        <button class="btn btn-primary" @click="showModalAddComponent">Add new</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="article in articles">
                    <th scope="row">{{ article.id }}</th>
                    <td>{{ article.name }}</td>
                    <td>{{ article.author }}</td>
                    <td>
                        <button class="btn btn-warning" @click="showEditModal(article.id)">Edit</button>
                        <button class="btn btn-danger" @click="showConfirmDeleteModal(article.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <add-component v-if="isShowAddComponent" @createNewArticle="createNewArticle" @closeAddModal="closeAddModal"></add-component>
        <confirm-delete-component v-if="isShowConfirmDeleteComponent" :articleId="articleId" @deleteArticle="deleteArticle"></confirm-delete-component>
        <edit-component v-if="isShowEditComponent" :articleId="articleId" @editArticle="editArticle" @closeEditModal="closeEditModal"></edit-component>
    </div>
</template>

<script>
    import AddComponent from "./add-component";
    import ConfirmDeleteComponent from "./confirm-delete-component";
    import EditComponent from "./edit-component";

    export default {
        components: {
            AddComponent,
            ConfirmDeleteComponent,
            EditComponent,
        },

        data: function () {
            return {
                articles: [],
                articleId: 0,
                isShowAddComponent: false,
                isShowConfirmDeleteComponent: false,
                isShowEditComponent: false,
            }
        },

        async created() {
            this.articles = await this.getArticles();
        },

        methods: {
            getArticles: async function () {
                return await axios.get('/articles').then(response => response.data);
            },

            showModalAddComponent: function () {
                this.isShowAddComponent = true;
                this.$nextTick(() => {
                    window.$('#addModal').modal('show');
                });
            },

            createNewArticle: function (article) {
                window.$('#addModal').on('hidden.bs.modal', () => {
                    this.isShowAddComponent = false;
                }).modal('hide');
                this.articles.push(article);
            },

            showConfirmDeleteModal: function (articleId) {
                this.articleId = articleId;
                this.isShowConfirmDeleteComponent = true;
                this.$nextTick(() => {
                    window.$('#deleteModal').modal('show');
                });
            },

            deleteArticle: function (response) {
                window.$('#deleteModal').on('hidden.bs.modal', () => {
                    this.isShowConfirmDeleteComponent = false;
                }).modal('hide');

                if (response) {
                    for (let articleId = 0; articleId < this.articles.length; articleId++) {
                        if (this.articles[articleId].id === this.articleId) {
                            this.articles.splice(articleId, 1);
                            break;
                        }
                    }
                }
            },

            showEditModal: function (articleId) {
                // this.isShowEditComponent = false;
                // window.$('#editModal').on('hidden.bs.modal').modal('hide');
                this.articleId = articleId;
                // console.log(this.isShowEditComponent, this.articleId);
                this.isShowEditComponent = true;
                this.$nextTick(() => {
                    window.$('#editModal').modal('show');
                });
            },

            editArticle: function (response) {
                window.$('#editModal').on('hidden.bs.modal', () => {
                    this.isShowEditComponent = false;
                }).modal('hide');

                if (response.success) {
                    for (let articleId = 0; articleId < this.articles.length; articleId++) {
                        if (this.articles[articleId].id === this.articleId) {
                            this.articles[articleId].name = response.name;
                            this.articles[articleId].author = response.author;
                            break;
                        }
                    }
                }
            },

            closeAddModal: function () {
                window.$('#addModal').on('hidden.bs.modal', () => {
                    this.isShowAddComponent = false;
                }).modal('hide');
            },

            closeEditModal: function () {
                window.$('#editModal').on('hidden.bs.modal', () => {
                    this.isShowEditComponent = false;
                }).modal('hide');
            }
        }
    }
</script>
