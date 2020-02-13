<template></template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        methods: {
            
        },
        created() {
            Echo.join(`chat.${roomId}`)
    .here((users) => {
        //
    })
    .joining((user) => {
        console.log(user.name);
    })
    .leaving((user) => {
        console.log(user.name);
    });
        },
    };
</script>
