<template>
    <div class="my-auto py-10 bg-gray-200 min-h-screen max-w-7xl mx-auto px-8">
        <div class="flex-column">
            <h2 class="text-3xl font-semibold mb-5">Welcome Back</h2>

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
                await axios.get('http://localhost:8000/api/dashboard/stats/user-viewer-count-difference')
                    .then((response) => {
                        vm.viewerCountDiff = response.data.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        }
    }
</script>
