<template>
    <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0">
        <div class="-mt-px flex w-0 flex-1" v-if="pagination.current_page > 1">
            <a href="javascript:void(0)"
               aria-label="Previous" @click.prevent="changePage(pagination.current_page - 1)"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">

                <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0
                        111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z"
                        clip-rule="evenodd" />
                </svg>
                Previous
            </a>
        </div>

        <div class="md:-mt-px md:flex">
            <a href="javascript:void(0)" v-for="page in pagesNumber"
               class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700"
               :aria-current="page == pagination.current_page"
               :class="{'border-indigo-500 text-indigo-600' : page == pagination.current_page}"
               @click.prevent="changePage(page)"
            >{{ page }}</a>
        </div>

        <div class="-mt-px flex w-0 flex-1 justify-end" v-if="pagination.current_page < pagination.last_page">
            <a href="javascript:void(0)" aria-label="Next" @click.prevent="changePage(pagination.current_page + 1)"
               class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
                Next
                <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd"
                        d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0
                        11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
    </nav>
</template>

<script>
    export default {
    props: {
        pagination: {
            type: Object,
            required: true
        },
        offset: {
            type: Number,
            default: 4
        }
    },
    computed: {
        pagesNumber() {
            if (!this.pagination.to) {
                return [];
            }

            let from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            let to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            let pagesArray = [];
            for (let page = from; page <= to; page++) {
                pagesArray.push(page);
            }
            return pagesArray;
        }
    },
    methods : {
        changePage(page) {
            this.pagination.current_page = page;
            this.$emit('paginate');
        }
    }
}
</script>
