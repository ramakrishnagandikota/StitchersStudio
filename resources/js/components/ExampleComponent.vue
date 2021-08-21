<template>

</template>

<script>
    export default {
        data() {
            return {
                user : auth.id,
                messages : []
            };
        },
        mounted() {
            console.log('Component mounted.');


        },
        created(){
            console.log(`Listening for events with-${this.user}`);

            Echo.channel('user-channel')
                .listen('UserEvent', (e) => {
                    console.log(e);
                });

            Echo.private(`notify-user-${this.user}`)
                .listen('.notifyUser', (e) => {
                    console.log(e)
                });
        }
    }
</script>
