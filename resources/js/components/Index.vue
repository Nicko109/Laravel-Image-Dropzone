<template>
    <div class="w-25">
        <input v-model="title" type="text" placeholder="title" class="form-control mb-3">
        <div ref="dropzone" class="btn d-block  p-5 bg-dark text-center text-light mb-3">
            Upload
        </div>
        <div class="mb-3">
            <vue-editor useCustomImageHandler @image-added="handleImageAdded" v-model="content"/>
        </div>
        <input @click.prevent="store" type="submit" placeholder="title" value="Add" class="btn btn-primary">

        <div v-if="post" class="mt-5">
            <h4>{{ post.title }}</h4>
            <div v-for="image in post.images" class="mb-3">
                <img :src="image.preview_url" class="mb-3">
                <img :src="image.url">
            </div>
            <div class="ql-editor" v-html="post.content"></div>
        </div>
    </div>
</template>

<script>
import {VueEditor} from "vue3-editor"
import Dropzone from 'dropzone'
import axios from "axios";

export default {
    name: "Index",

    data() {
        return {
            dropzone: null,
            title: null,
            post: null,
            content: null,
        }
    },

    components: {
        VueEditor
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
            data.append('content', this.content)
            this.title = ''
            this.content = ''
            axios.post('/api/posts', data)
                .then(res => {
                    this.getPost()
                })
        },
        getPost() {
            axios.get('/api/posts')
                .then(res => {
                    this.post = res.data.data
                })
        },

        handleImageAdded(file, Editor, cursorLocation, resetUploader) {
            const formData = new FormData();
            formData.append("image", file);

            axios.post('/api/posts/images', formData)
                .then(result => {
                    const url = result.data.url; // Get url from response
                    Editor.insertEmbed(cursorLocation, "image", url);
                    resetUploader();
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
}
</script>

<style>

.dz-success-mark,
.dz-error-mark {
    display: none;
}

</style>
