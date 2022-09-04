<template>
    <div class="my-auto py-10 bg-gray-200 min-h-screen max-w-7xl mx-auto px-8">
        <div class="flex-column">
            <h2 class="text-3xl font-semibold mb-5">Welcome Back</h2>

            <div>
                <button
                    @click="logout()"
                    type="button"
                    class="float-right inline-flex items-center rounded border border-transparent bg-indigo-600 px-2.5 py-1.5 text-xs
                    font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2
                    focus:ring-indigo-500 focus:ring-offset-2">
                    Logout
                </button>
            </div>

            <top-stream-component></top-stream-component>

            <top-streams-by-viewer-count-component></top-streams-by-viewer-count-component>

            <streams-by-start-time-component></streams-by-start-time-component>

            <user-following-top-streams-component></user-following-top-streams-component>

            <user-sharing-tags-with-top-streams-component></user-sharing-tags-with-top-streams-component>

            <div class="mb-5">
                <h6 class="text-sm font-semibold">
                    How many viewers does the lowest viewer count stream that you're following need to gain in order to make it into the top 1000 streams?
                </h6> {{ viewerCountDiff }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                viewerCountDiff: '',
            }
        },

        mounted() {
            this.getUserViewerCountDifference();
        },

        methods: {
            async getUserViewerCountDifference() {
                let vm = this;
                await axios.get('api/dashboard/stats/user-viewer-count-difference')
                    .then((response) => {
                        vm.viewerCountDiff = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            async logout() {
                let vm = this;
                await axios.get('api/logout')
                    .then((response) => {
                        window.location.href = 'http://localhost:8000';
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
