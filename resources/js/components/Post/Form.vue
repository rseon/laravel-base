<template>
    <div>
        <ul class="text-danger" v-if="errors">
            <li v-for="error in errors" v-html="error.join('<br>')"></li>
        </ul>
        <p class="text-success" v-if="success">Success :)</p>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" :class="{'is-invalid': errors['title']}" v-model="post.title" />
            <span class="invalid-feedback" v-if="errors['title']" v-html="errors['content'].join('<br>')"></span>
        </div>

        <div class="form-group">
            <label for="title">Content</label>
            <textarea class="form-control" :class="{'is-invalid': errors['title']}" v-model="post.content" />
            <span class="invalid-feedback" v-if="errors['title']" v-html="errors['content'].join('<br>')"></span>
        </div>

        <div class="form-group">
            <label for="title">Categories</label>
            <div class="form-check" v-for="category in categories">
                <input class="form-check-input" type="checkbox" v-model="postCategories" :value="category.id" :id="`cat_${category.id}`">
                <label class="form-check-label" :for="`cat_${category.id}`">
                    {{ category.name }}
                </label>
            </div>
            <span class="invalid-feedback" v-if="errors['categories']" v-html="errors['categories'].join('<br>')"></span>
        </div>

        <hr>

        <button class="btn btn-danger float-right" @click.prevent="onDelete" :disabled="loading" v-if="post.id">Delete</button>
        <button class="btn btn-primary" @click.prevent="onSubmit" :disabled="loading">Save</button>
        <a href="#" class="btn btn-link" @click.prevent="close" :disabled="loading">Cancel</a>
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
                post: {},
                loading: false,
                errors: {},
                success: false,
                categories: [],
                postCategories: [],
            }
        },
        created() {
            axios
                .get('/manager/categories')
                .then(({ data }) => {
                    this.categories = data
                })

        },
        mounted() {
            this.$root.$on('post-form-populate', (post = {}) => {
                this.post = _.clone(post) // To not mutate original object
                this.initComponent()
                this.postCategories = []

                if(this.post.categories) {
                    this.postCategories = _.map(this.post.categories, (o) => o.id)
                }
            })
        },
        methods: {
            initComponent() {
                this.success = false
                this.errors = {}
            },
            onSubmit() {
                this.initComponent()
                this.loading = true

                let response;
                if(this.post.id) {
                    response = this.onUpdate()
                }
                else {
                    response = this.onCreate()
                }

                response
                    .then(({ data }) => {
                        this.success = true
                        this.$root.$emit('post-update-list')

                        if(data) {
                            this.$root.$emit('post-form-populate', data.data)
                        }
                    })
                    .catch(({ response }) => {
                        if(response.data.errors) {
                            this.errors = response.data.errors
                        }
                        else {
                            this.errors[response.status] = [
                                `Error ${response.status} ${response.statusText}`,
                                response.data.message,
                            ]
                        }
                    })
                    .finally(() => {
                        this.loading = false
                    })
            },
            onCreate() {
                return axios
                    .post(`${this.endpoint}`, this.post)

            },
            onUpdate() {
                return axios
                    .put(`${this.endpoint}/${this.post.id}`, this.post)
            },
            onDelete() {
                if(confirm('Are you sure ?')) {
                    axios
                        .delete(`${this.endpoint}/${this.post.id}`)
                        .then(({ data }) => {
                            this.loading = false
                            this.$root.$emit('postform-update-list')
                            this.close()
                        })
                }
            },
            close() {
                this.$root.$emit('post-form', false)
            },
        },
        watch: {
            postCategories() {
                this.post.categories = this.postCategories
            }
        }
    }
</script>
