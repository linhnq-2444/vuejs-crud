<template>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Article</h5>
                    <button type="button" class="close" @click="closeEditModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="newArticle.name">
                    </div>
                    <div class="form-group">
                        <label for="author">Author: </label>
                        <input type="text" class="form-control" id="author" placeholder="Author" v-model="newArticle.author">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeEditModal">Close</button>
                    <button type="button" class="btn btn-primary" @click="editArticle">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        article: {
            type: Object,
            default: function () {
                return {
                    name: '',
                    author: '',
                }
            },
        },
    },

    data: function () {
        return {
            newArticle: _.cloneDeep(this.article),
        }
    },

    methods: {
        editArticle: function () {
            axios.patch(laroute.route('articles.update', {article: this.article.id}), this.newArticle)
                .then(response => {
                    this.$emit('editArticle', response.data);
                }
            );
        },

        closeEditModal: function () {
            this.$emit('closeEditModal');
        },
    }
}
</script>
