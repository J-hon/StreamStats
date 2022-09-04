<template>
    <div class="mx-auto bg-gray-100 rounded-md w-1/4 my-48 p-5">
        <div class="flex-column">
            <h2 class="text-xl font-semibold mb-5">Welcome To StreamStats</h2>
            <button
                class="rounded-md bg-black py-2 px-3 text-[0.8125rem] font-semibold leading-5 text-white hover:bg-gray-700"
                @click.prevent="login">
                Login to Twitch
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                processing: false
            }
        },

        methods: {
            login() {
                axios.get('sanctum/csrf-cookie').then(response => {
                    axios.get('auth/twitch/redirect')
                        .then((response) => {
                            let data = response.data.data;
                            window.location.href = data.redirect_url;
                        })
                        .catch((error) => {
                            console.log(error);
                        });
                });

            }
        }
    }
</script>
