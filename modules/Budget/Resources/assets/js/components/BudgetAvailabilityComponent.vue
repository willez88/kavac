<template>
    <div class="form-horizontal">
        <div class="card-body">
            <div class="row">
                <div class="col-4" id="budgetAvailabilityInitDate">
                    <label><strong>Desde:</strong></label>
                    <div class="form-group is-required mt-2">
                        <label class="control-label"
                            >Partida Presupuestaria</label
                        >
                        <select2
                            v-model="initialCode"
                            :options="budgetItemsArray"
                        ></select2>
                    </div>
                    <div class="form-group is-required mt-3">
                        <label class="control-label">Fecha</label>
                        <input
                            class="form-control input-sm"
                            data-toggle="tooltip"
                            type="date"
                            v-model="initialDate"
                        />
                    </div>
                </div>
                <div class="col-4" id="budgetAvailabilityEndDate">
                    <label><strong>Hasta:</strong></label>
                    <div class="form-group is-required mt-2">
                        <label class="control-label"
                            >Partida Presupuestaria</label
                        >
                        <select2
                            v-model="finalCode"
                            :options="budgetItemsArray"
                        ></select2>
                    </div>
                    <div class="form-group is-required mt-3">
                        <label class="control-label">Fecha</label
                        ><input
                            class="form-control input-sm"
                            data-toggle="tooltip"
                            type="date"
                            v-model="finalDate"
                        />
                    </div>
                </div>
                <div class="col-4" id="budgetAvailabilityWithoutMovements">
                    <div class="form-group">
                        <label class="text-center">
                            <strong>Quitar cuentas sin movimientos</strong>
                        </label>
                        <div class="col-12 bootstrap-switch-mini mt-4">
                            <input
                                id="zero"
                                data-on-label="SI"
                                data-off-label="NO"
                                name="zero"
                                type="checkbox"
                                class="form-control text-center bootstrap-switch"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <button
                class="btn btn-primary btn-sm"
                data-toggle="tooltip"
                title="Generar Reporte"
                @click="generateReport"
                id="budgetAvailabilityGenerateReport"
            >
                <span>Generar reporte</span>
                <i class="fa fa-print"></i>
            </button>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        budgetItems: {
            type: String,
            default: '[]'
        },
        url: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            initialDate: '',
            finalDate: '2021-12-31',

            initialCode: 0,
            finalCode: 0,

            budgetItemsArray: JSON.parse(this.budgetItems)
        };
    },
    created() {
        console.log('BudgetAvailabiltyComponet');
    },
    methods: {
        generateReport: async function() {
            try {
                const config = {
                    params: {
                        initialDate: this.initialDate,
                        finalDate: this.finalDate,
                        initialCode: this.initialCode,
                        finalCode: this.finalCode
                    }
                };
                console.log(this.url);
                window.location.href = `${this.url}?initialDate=${this.initialDate}&finalDate=${this.finalDate}&initialCode=${this.initialCode}&finalCode=${this.finalCode}`;

                // const response = await axios.get(this.url, config);
                // console.log(response.data);
            } catch (error) {
                console.error(error);
            }
        }
    }
};
</script>
