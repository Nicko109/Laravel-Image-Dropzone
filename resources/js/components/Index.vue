<template>
    <div class="w-25">
        <input v-model="title" type="text" placeholder="title" class="form-control mb-3">
        <div ref="dropzone" class="btn d-block  p-5 bg-dark text-center text-light mb-3">
            Upload
        </div>
        <input @click.prevent="store" type="submit" placeholder="title" value="Add" class="btn btn-primary">
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
        }
    },

    mounted() {
        this.dropzone = new Dropzone(this.$refs.dropzone, {
            url: '/api/posts',
            autoProcessQueue: false,
        })
    },

    methods: {
        store() {
            const images = new FormData()
            const files = this.dropzone.getAcceptedFiles()
            files.forEach(file => {
                images.append('images[]', file)
            })

            axios.post('/api/posts', images)
        }
    }
}
</script>

<style scoped>

</style>
