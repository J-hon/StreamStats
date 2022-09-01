<template>
    <div class="mx-auto bg-gray-100 rounded-md max-w-6xl my-auto p-5">
        <div class="flex-column">
            <h2 class="text-3xl font-semibold mb-5">Welcome Back</h2>

            <div class="mb-6">
                <top-stream-component></top-stream-component>
            </div>

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
                await axios.get('https://e323-102-89-32-81.ngrok.io/api/dashboard/stats/user-viewer-count-difference')
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
