<template>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                    <button type="button" class="btn btn-secondary" @click="closeAddModal">Close</button>
                    <button type="button" class="btn btn-primary" @click="addNewArticle">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                name: null,
                author: null,
            }
        },

        methods: {
            addNewArticle: function () {
                axios.post('/articles', {
                    name: this.name,
                    author: this.author,
                }).then(response => {
                    this.$emit('createNewArticle', response.data);
                });
            },

            closeAddModal: function () {
                this.$emit('closeAddModal', false);
            },
        }
    }
</script>
