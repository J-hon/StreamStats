<template>
    <div class="mb-5">
        <h6 class="text-sm font-semibold">Top 1000 streams you're following</h6>

        <div v-if="!ready">
            <div class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <table-component
                 :headers="['ID', 'Title', 'Game Id', 'Game Name', 'Viewer Count']"
                 :data="userFollowedTopStreams">
            </table-component>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ready: false,
                userFollowedTopStreams: [],
            }
        },

        mounted() {
            this.getUserFollowedTopStreams();
        },

        methods: {
            async getUserFollowedTopStreams() {
                let vm = this;
                await axios.get('https://e323-102-89-32-81.ngrok.io/api/dashboard/stats/user-followed-top-streams')
                    .then((response) => {
                        vm.userFollowedTopStreams = response.data.data;
                        vm.ready = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
