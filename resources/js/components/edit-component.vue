<template>
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name: </label>
                        <input type="text" class="form-control" id="name" placeholder="Name" v-model="name">
                    </div>
                    <div class="form-group">
                        <label for="author">Author: </label>
                        <input type="text" class="form-control" id="author" placeholder="Author" v-model="author">
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
        articleId: {
            type: Number,
            default: 0,
        },
    },

    data: function () {
        return {
            name: null,
            author: null,
        }
    },

    beforeCreate: function () {
        console.log('beforeCreate');
    },

    created: function () {
        console.log('created');
    },

    beforeMount: function () {
        console.log('beforeMount');
    },

    mounted: function () {
        console.log('mounted');
    },

    beforeUpdate: function () {
        console.log('beforeUpdate');
    },

    updated: function () {
        console.log('updated');
    },

    beforeDestroy: function () {
        console.log('beforeDestroy');
    },

    destroyed: function () {
        console.log('destroyed');
    },

    // mounted: function () {
    //     console.log(this.articleId);
    //     axios.get(`/articles/${this.articleId}/edit`).then(response => {
    //         this.name = response.data.name;
    //         this.author = response.data.author;
    //     });
    // },

    methods: {
        editArticle: function () {
            axios.patch(`/articles/${this.articleId}`, {
                name: this.name,
                author: this.author,
            }).then(response => {
                this.$emit('editArticle', {
                    success: response.data,
                    name: this.name,
                    author: this.author,
                });
            });
        },

        closeEditModal: function () {
            this.$emit('closeEditModal', false);
        },
    }
}
</script>
