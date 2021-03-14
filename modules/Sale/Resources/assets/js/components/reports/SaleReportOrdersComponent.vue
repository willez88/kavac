<template>
    <section id="SaleReportForm">
        <div class="card-body">
            <div class="alert alert-danger" v-if="errors.length > 0">
                <ul>
                    <li v-for="error in errors">{{ error }}</li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="name">Número del Pedido:</label>
                        <input type="text" id="name" placeholder="Número del Pedido"
                        class="form-control input-sm" v-model="record.name" data-toggle="tooltip"
                        title="Indique el nombre (requerido)">
                        <input type="hidden" name="id" id="id" v-model="record.id">
                    </div>
                </div>
                <div class="col-md-3" id="helpDailyBookEndDate">
                    <div class="form-group is-required">
                        <label class="control-label">Fecha de Solicitud:</label>
                        <input type="date" class="form-control input-sm"
                            v-model="dateEnd">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Nombre del Ciente:</label>
                        <input type="text" id="description" placeholder="Nombre del Ciente"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Tipo de Cliente:</label>
                        <input type="text" id="description" placeholder="Tipo de Cliente"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Código del Producto o Servicio:</label>
                        <input type="text" id="description" placeholder="Código del Producto o Servicio"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Categoría:</label>
                        <input type="text" id="description" placeholder="Categoría"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Cantidad:</label>
                        <input type="text" id="description" placeholder="Cantidad"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Precio:</label>
                        <input type="text" id="description" placeholder="Precio"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group is-required">
                        <label for="description">Estatus:</label>
                        <input type="text" id="description" placeholder="Estatus"
                        class="form-control input-sm" v-model="record.description" data-toggle="tooltip"
                        title="Indique la descripción (requerido)">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right" >
            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Generar Reporte"
                    v-on:click="OpenPdf(getUrlReport(), '_blank')" id="saleOrderGenerateReport">
                <span>Generar reporte</span>
                <i class="fa fa-print"></i>
            </button>
        </div>     
    </section>
</template>

<script>
export default {
    data() {
        return {
            record: {
                id: '',
                name: '',
                description: ''
            },
            errors: [],
            records: [],
            columns: ['name', 'description', 'id'],
        }
    },
    methods: {
/**
* Método que borra todos los datos del formulario
*
* @author  Miguel Narvaez <mnarvaez@cenditel.gob.ve>
*/
reset() {
    this.record = {
        id: '',
        name: '',
        description: ''
    };
},
},
created() {
    this.table_options.headings = {
        'name': 'Nombre',
        'description': 'Descripción',
        'id': 'Acción'
    };
    this.table_options.sortable = ['name'];
    this.table_options.filterable = ['name'];
    this.table_options.columnsClasses = {
        'name': 'col-md-5',
        'description': 'col-md-5',
        'id': 'col-md-2'
    };
},
};
</script>