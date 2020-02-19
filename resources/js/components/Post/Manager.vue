<template>
    <div>
        <h1>Posts</h1>
        <p><a @click.prevent="openForm()" href="#">New post</a></p>

        <div class="row">
            <div class="col-md-9">
                <post-list :endpoint="endpoint" />
            </div>
            <div class="col-md-3" v-show="form_opened">
                <p><a @click.prevent="closeForm()" href="#">Close form</a></p>
                <post-form :endpoint="endpoint" />
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        components: {
            PostList: () => import(/* webpackChunkName: "component/PostList" */ './List'),
            PostForm: () => import(/* webpackChunkName: "component/PostForm" */ './Form'),
        },
        data() {
            return {
                endpoint: '/manager/posts',
                form_opened: false,
            }
        },
        mounted() {
            this.$root.$on('post-form', (post) => {
                if(post === false) {
                    this.closeForm()
                }
                else {
                    this.openForm(post);
                }
            })
        },
        methods: {
            openForm(post = {}) {
                this.form_opened = true
                this.$root.$emit('post-form-populate', post)
            },
            closeForm() {
                this.form_opened = false
                this.$root.$emit('post-form-populate')
            }
        }
    }
</script>
