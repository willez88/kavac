<template>
    <section id="SaleReportForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>

           
        </div>
    </section>
</template>

<script>

</script>
