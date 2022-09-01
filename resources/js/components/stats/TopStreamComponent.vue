<template>
    <div class="bg-danger">
        <h6 class="text-md font-semibold">Top streams per game</h6>

        <div v-if="!ready">
            <div class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <table-component
                :headers="['Game Name', 'Stream Count', 'Viewer Count Sum', 'Viewer Count Average']"
                :data="topStreams.data">
            </table-component>

            <pagination-component :pagination="topStreams" @paginate="getTopStreamStats()" :offset="4"></pagination-component>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ready: false,
                topStreams: [],
                viewerCountDiff: '',
            }
        },

        mounted() {
            this.getTopStreamStats();
        },

        methods: {
            async getTopStreamStats() {
                let vm = this;
                await axios.get(`https://e323-102-89-32-81.ngrok.io/api/dashboard/stats/top-streams?page=${vm.topStreams.current_page}`)
                    .then((response) => {
                        vm.topStreams = response.data.data;
                        vm.ready      = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
