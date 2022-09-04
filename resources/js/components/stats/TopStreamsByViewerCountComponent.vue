<template>
    <div class="mb-5">
        <h6 class="text-sm font-semibold">Top 100 streams by viewer count</h6>

        <div v-if="!ready">
            <div class="flex justify-center items-center">
                <div class="spinner-border animate-spin inline-block w-8 h-8 border-4 rounded-full" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div v-else>
            <div class="mt-8 flex flex-col">
                <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <td class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</td>
                                        <td class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Title</td>
                                        <td class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Viewer Count
                                            <button @click="sortViewerCount()">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 w-3 h-3"
                                                     aria-hidden="true" fill="currentColor"
                                                     viewBox="0 0 320 512">
                                                    <path d="M27.66 224h264.7c24.6 0
                                                36.89-29.78 19.54-47.12l-132.3-136.8c-5.406-5.406-12.47-8.107-19.53-8.107c-7.055 0-14.09 2.701-19.45
                                                8.107L8.119 176.9C-9.229 194.2 3.055 224 27.66 224zM292.3 288H27.66c-24.6 0-36.89 29.77-19.54
                                                47.12l132.5 136.8C145.9 477.3 152.1 480 160 480c7.053 0 14.12-2.703 19.53-8.109l132.3-136.8C329.2
                                                317.8 316.9 288 292.3 288z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <tr v-for="(datum, index) in topStreamsByViewerCount" :key="index">
                                        <td class="whitespace-nowrap break-words py-4 pl-4 pr-3 text-sm font-medium text-black sm:pl-6"
                                            v-for="(item, itemIndex) in datum" :key="itemIndex">
                                            {{ topStreamsByViewerCount[index][itemIndex] }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <pagination-component :pagination="topStreamsByViewerCount" @paginate="getTopStreamsByViewerCountStats()" :offset="4"></pagination-component>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                ready: false,
                sort: 'desc',
                sortByDesc: false,
                topStreamsByViewerCount: [],
            }
        },

        mounted() {
            this.getTopStreamsByViewerCountStats();
        },

        methods: {
            async getTopStreamsByViewerCountStats(sort = 'desc') {
                let vm = this;
                await axios.get(`api/dashboard/stats/top-100-streams-by-viewer-count?sort=${sort}&page=${vm.topStreamsByViewerCount.current_page}`)
                    .then((response) => {
                        vm.topStreamsByViewerCount = response.data.data.data;
                        vm.ready = true;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            },

            sortViewerCount() {
                this.sortByDesc = !this.sortByDesc;
                if (this.sortByDesc) {
                    this.sort = 'asc';
                }
                else {
                    this.sort = 'desc';
                }

                this.getTopStreamsByViewerCountStats(this.sort);
            }
        }
    }
</script>
