<template>
    Logged in
</template>

<script>
export default {
    props: ['response'],
    data() {
        return {
            //
        }
    },
    mounted() {
        console.log(this.response);
    }
}
</script>

<style scoped>

</style>
