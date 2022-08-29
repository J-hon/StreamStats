<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login to Twitch</div>

                    <div class="card-body">
                        <button @click.prevent="login">Login</button>
                    </div>
                </div>
            </div>
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
                axios.get('http://streamstats.test/api/auth/twitch/redirect')
                    .then((response) => {
                        let data = response.data.data;
                        window.location.href = data.redirect_url;
                    })
                    .catch((error) => {
                        console.log(error);
                    });

            }
        }
    }
</script>
