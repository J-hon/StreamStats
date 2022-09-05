<template>
    <div class="mt-8 flex flex-col">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <td class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                    v-for="(header, headerIndex) in headers" :key="headerIndex">
                                    {{ header }}
                                </td>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(datum, index) in data" :key="index">
                                <td class="whitespace-nowrap break-words py-4 pl-4 pr-3 text-sm font-medium text-black sm:pl-6"
                                    v-for="(item, itemIndex) in datum" :key="itemIndex">
                                    {{ data[index][itemIndex] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
     export default {
        props: {
            headers: Array,
            data: Array
        }
     }
</script>
