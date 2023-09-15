<template>
    <div class="w-25">
        <input v-model="title" type="text" placeholder="title" class="form-control mb-3">
        <div ref="dropzone" class="btn d-block  p-5 bg-dark text-center text-light mb-3">
            Upload
        </div>
        <input @click.prevent="store" type="submit" placeholder="title" value="Add" class="btn btn-primary">
        <div v-if="post" class="mt-5">
            <h4>{{ post.title}}</h4>
            <div v-for="image in post.images" class="mb-3">
                <img :src="image.preview_url" class="mb-3">
                <img :src="image.url">
            </div>
        </div>
    </div>
</template>

<script>
import Dropzone from 'dropzone'
import axios from "axios";

export default {
    name: "Index",

    data() {
        return {
            dropzone: null,
            title: null,
            post: null,
        }
    },

    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
            addRemoveLinks: true
        })
        this.getPost()
    },

    methods: {
        store() {
            const data = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                data.append('images[]', file)
                this.dropzone.removeFile(file)
            })
            data.append('title', this.title)
            this.title = ''
            axios.post('/api/posts', data)
                .then( res => {
                    this.getPost()
                })
        },
        getPost() {
           axios.get('/api/posts')
            .then( res => {
                this.post = res.data.data
            })
        }
    }
}
</script>

<style scoped>

</style>
