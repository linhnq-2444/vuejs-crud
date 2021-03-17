<template>
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" @click="deleteArticle">Yes</button>
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

        methods: {
            deleteArticle: function () {
                axios.delete(`/articles/${this.articleId}`).then(response => {
                    this.$emit('deleteArticle', response.data);
                });
            }
        },
    }
</script>
