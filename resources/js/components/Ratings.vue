<template>
    <div class="likes text-right">
        <a @click="sendRating('like')" :class="{ active: currentStatus == 'like' }">
            <i class="fa fa-thumbs-up"></i> {{ likesCount }}
        </a>
        <a @click="sendRating('dislike')" :class="{ active: currentStatus == 'dislike' }">
            <i class="fa fa-thumbs-down"></i> {{ dislikesCount }}
        </a>
    </div>
</template>

<script>
export default {
    props: {
        'postId': Number,
        'status': String,
        'likes': Number,
        'dislikes': Number
    },

    data() {
        return {
            'likesCount': this.likes,
            'dislikesCount': this.dislikes,
            'currentStatus': this.status,
            'unrated': ''
        };
    },

    computed: {
        successMessage: function () {
            return 'You have ' + (this.currentStatus || this.unrated) + 'd this post';
        }
    },

    methods: {
        sendRating: function (type) {
            axios.post('/posts/rate', {
                post_id: this.postId,
                type
            })
            .then(({data}) => {
                this.likesCount = data.likes;
                this.dislikesCount = data.dislikes;
                this.unrated = data.unrated ? ('un' + type) : '';
                this.currentStatus = !data.unrated ? type : '';
                this.$swal(
                    'Success!',
                    this.successMessage,
                    'success'
                );
            })
            .catch(({response}) => {
                var message = response.data.errors && response.data.errors[Object.keys(response.data.errors)[0]] ?
                    response.data.errors[Object.keys(response.data.errors)[0]][0] :
                    response.data.message;
                this.$swal(
                    'Error!',
                    message,
                    'error'
                );
            });
        }
    }
}
</script>

<style scoped>
.likes a {
    font-size: 1rem;
    color: #cccccc;
    padding-left: 0.5rem;
    cursor: pointer;
}
.likes a:hover {
    color: #777777;
}
.likes .active {
    color: #999999;
}
</style>
