<template>
    <div class="content">
        <button class="btn btn-primary" @click="showAddModal">Add new</button>
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
                    <td>{{ limit(article.name, 10) }}</td>
                    <td>{{ limit(article.author, 10) }}</td>
                    <td class="action">
                        <button class="btn btn-warning" @click="showEditModal(article)">Edit</button>
                        <button class="btn btn-danger" @click="showConfirmDeleteModal(article.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
        <add-component v-if="isShowAddComponent" @createNewArticle="createNewArticle" @closeAddModal="closeAddModal"></add-component>
        <confirm-delete-component v-if="isShowConfirmDeleteComponent" :articleId="articleId" @deleteArticle="deleteArticle" @closeConfirmDeleteModal="closeConfirmDeleteModal"></confirm-delete-component>
        <edit-component v-if="isShowEditComponent" :article="article" @editArticle="editArticle" @closeEditModal="closeEditModal"></edit-component>
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
                article: {
                    type: Object,
                    default: function () {
                        return {
                            name: '',
                            author: '',
                        }
                    }
                },
                isShowAddComponent: false,
                isShowConfirmDeleteComponent: false,
                isShowEditComponent: false,
            }
        },

        async created() {
            this.articles = await this.getArticles();
        },

        methods: {
            limit: function (str, len) {
                return (str.length > len) ? str.substr(0, len) + '...' : str;
            },

            getArticles: async function () {
                return await axios.get(laroute.route('articles.index')).then(response => response.data);
            },

            showModal: function (flag, el) {
                this[flag] = true;
                this.$nextTick(() => {
                    window.$(el).modal({
                        backdrop: 'static',
                        keyboard: false,
                    });
                });
            },

            closeModal: function (flag, el) {
                window.$(el).on('hidden.bs.modal', () => {
                    this[flag] = false;
                }).modal('hide');
            },

            showAddModal: function () {
                this.showModal('isShowAddComponent', '#addModal');
            },

            closeAddModal: function () {
                this.closeModal('isShowAddComponent', '#addModal');
            },

            createNewArticle: function (article) {
                this.closeAddModal();
                this.articles.push(article);
            },

            showConfirmDeleteModal: function (articleId) {
                this.articleId = articleId;
                this.showModal('isShowConfirmDeleteComponent', '#deleteModal');
            },

            closeConfirmDeleteModal: function () {
                this.closeModal('isShowConfirmDeleteComponent', '#deleteModal');
            },

            deleteArticle: function (response) {
                this.closeConfirmDeleteModal();

                if (response.status === 200) {
                    // delete article from list articles
                    for (let articleId = 0; articleId < this.articles.length; articleId++) {
                        if (this.articles[articleId].id === this.articleId) {
                            this.articles.splice(articleId, 1);
                            break;
                        }
                    }
                }
            },

            showEditModal: function (article) {
                this.article = article;
                this.showModal('isShowEditComponent', '#editModal');
            },

            closeEditModal: function () {
                this.closeModal('isShowEditComponent', '#editModal');
            },

            editArticle: function (article) {
                this.closeEditModal();

                // update article
                for (let articleId = 0; articleId < this.articles.length; articleId++) {
                    if (this.articles[articleId].id === this.article.id) {
                        this.articles[articleId] = article;
                        break;
                    }
                }
            },
        }
    }
</script>
