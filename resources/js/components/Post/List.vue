<template>
    <div>
        <table class="table table-hovered">
            <thead>
            <tr>
                <th width="1">#</th>
                <th>Title</th>
                <th width="1" class="text-nowrap">Categories</th>
                <th width="1" class="text-nowrap">Author</th>
                <th width="1" class="text-nowrap">Created</th>
                <th width="1" class="text-nowrap">Active</th>
                <th width="1"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="post in posts">
                <td class="text-muted">{{ post.id }}</td>
                <td>{{ post.title }}</td>
                <td class="text-nowrap">{{ getCategories(post.categories) }}</td>
                <td class="text-nowrap">{{ post.author.name }}</td>
                <td class="text-nowrap">{{ post.created_at }}</td>
                <td class="text-nowrap text-center">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" :id="`active_${post.id}`" :checked="post.is_active" @change="switchActive(post)" />
                        <label class="custom-control-label" :for="`active_${post.id}`"></label>
                    </div>
                </td>
                <td class="text-nowrap text-center">
                    <a @click.prevent="editPost(post)" href="#">Edit</a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: {
            endpoint: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                posts: [],
            }
        },
        mounted() {
            this.url = this.endpoint
            this.retrievePosts()

            this.$root.$on('post-update-list', () => {
                this.retrievePosts()
            })
        },
        methods: {
            retrievePosts() {
                this.loading = true
                let url = window.location.href;

                axios
                    .get(url)
                    .then(({ data }) => {
                        this.posts = data.data
                        this.loading = false
                    })
            },
            switchActive(post, update_api = true) {
                let postClone = _.clone(post);
                postClone.is_active = !postClone.is_active;

                // Prevent bubble
                if(update_api) {
                    axios
                        .put(`${this.endpoint}/${post.id}`, postClone)
                        .then(response => {
                            // Ok : mutate original
                            post.is_active = postClone.is_active
                        })
                        .catch(({ response }) => {
                            alert(response.data.error)
                            // Not authorized, rollback
                            if(response.status === 401) {
                                document.getElementById(`active_${post.id}`).checked = !postClone.is_active;
                                this.switchActive(postClone, false)
                            }
                        })
                }
                else {
                    // Mutate original
                    post.is_active = postClone.is_active
                }
            },
            editPost(post) {
                this.$root.$emit('post-form', post)
            },
            getCategories(categories) {
                return categories.length ? _.map(categories, (c) => c.name).join(', ') : '--'
            }
        },
    }
</script>
