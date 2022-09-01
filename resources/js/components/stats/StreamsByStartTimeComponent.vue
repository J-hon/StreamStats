<template>
    <div class="mb-5">
        <h6 class="text-md font-semibold">Streams by start time</h6>
        <div v-if="!ready">
            <div class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <table-component
                 :headers="['Start Time (Y-m-d H)', 'Stream Count', 'Viewer Count Sum']"
                 :data="streamsByStartTime.data">
            </table-component>

            <pagination-component :pagination="streamsByStartTime" @paginate="getStreamsByStartTime()" :offset="4"></pagination-component>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ready: false,
                streamsByStartTime: []
            }
        },

        mounted() {
            this.getStreamsByStartTime();
        },

        methods: {
            async getStreamsByStartTime() {
                let vm = this;
                await axios.get(`https://e323-102-89-32-81.ngrok.io/api/dashboard/stats/streams-by-start-time?page=${vm.streamsByStartTime.current_page}`)
                    .then((response) => {
                        vm.streamsByStartTime = response.data.data;
                        vm.ready = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },
        }
    }
</script>
