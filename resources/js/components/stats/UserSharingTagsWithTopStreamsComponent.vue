<template>
    <div class="mb-5">
        <h6 class="text-sm font-semibold">Your shared tags with top 1000 streams</h6>

        <div v-if="!ready">
            <div class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <table-component
                 :headers="['Name', 'Description']"
                 :data="userSharedTagsWithTopStreams.data">
            </table-component>

            <pagination-component :pagination="userSharedTagsWithTopStreams" @paginate="getUserSharedTagsWithTopStreams()" :offset="4"></pagination-component>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ready: false,
                userSharedTagsWithTopStreams: []
            }
        },

        mounted() {
            this.getUserSharedTagsWithTopStreams();
        },

        methods: {
            async getUserSharedTagsWithTopStreams() {
                let vm = this;
                await axios.get(`api/dashboard/stats/user-shared-tags-with-top-streams?page=${vm.userSharedTagsWithTopStreams.current_page}`)
                    .then((response) => {
                        vm.userSharedTagsWithTopStreams = response.data.data;
                        vm.ready = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
