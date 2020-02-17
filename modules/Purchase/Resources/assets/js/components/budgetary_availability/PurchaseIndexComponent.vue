<template>
    <section>
        <div>
            Hola
        </div>
    </section>
</template>
<script>
export default{
    props:{
        record:{
            type:Object,
            default: function() {
                return null;
            }
        },
    },
};
</script>
