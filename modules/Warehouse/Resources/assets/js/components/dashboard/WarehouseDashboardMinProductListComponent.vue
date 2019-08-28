<template>
    <v-client-table :columns="columns" :data="records" :options="table_options">
        <div slot="code" slot-scope="props" class="text-center">
            <span>
                {{ props.row.code }}
            </span>
        </div>
        <div slot="description" slot-scope="props">
            <span>
                <b> {{ (props.row.warehouse_product)?
                    props.row.warehouse_product.name+': ':''
                }} </b>
                {{ (props.row.warehouse_product)?
                        props.row.warehouse_product.description:''
                }}
            </span>
            <span>
                <div v-for="att in props.row.warehouse_product_values">
                    <b>{{att.warehouse_product_attribute.name +":"}}</b> {{ att.value}}
                </div>
                    <b>Valor:</b> {{props.row.unit_value}} {{(props.row.currency)?props.row.currency.name:''}}
            </span>
        </div>
        <div slot="inventory" slot-scope="props">
            <span>
                <b>Almacén:</b> {{
                    props.row.warehouse_institution_warehouse.warehouse.name
                    }} <br>
                <b>Existencia:</b> {{ props.row.exist }}<br>
                <b>Reservados:</b> {{ (props.row.reserved === null)? '0':props.row.reserved }}
            </span>
        </div>
        <div slot="free" slot-scope="props" class="text-center">
            <div v-if="props.row.free > 50">
                <span class="badge badge-success" style="font-size: 0.8em;">
                    <strong>{{ format_number(props.row.free) }} %</strong>
                </span>
            </div>
            <div v-else-if="props.row.free > 5">
                <span class="badge badge-warning" style="font-size: 0.8em;">
                    <strong>{{ format_number(props.row.free) }} %</strong>
                </span>
            </div>
            <div v-else>
                <span class="badge badge-danger" style="font-size: 0.8em;">
                    <strong>{{ format_number(props.row.free) }} %</strong>
                </span>
            </div>
        </div>
    </v-client-table>           
</template>

<script>
    export default {
        data() {
            return {
                record: {
                    id: '',
                },
                records: [],
                columns: ['code', 'description', 'inventory', 'free'],
            }
        },
        created () {
            this.table_options.headings = {
                code: 'Código',
                description: 'Descripción',
                inventory: 'Inventario',
                free: 'Porcentaje disponible'
            };
            this.table_options.sortable = ['code', 'description', 'inventory', 'free'];
            this.table_options.filterable = ['code', 'description', 'inventory', 'free'];
        },
        mounted () {
            this.initRecords(this.route_list, '');
        },
        methods: {
            /**
             * Inicializa los datos del formulario
             *
             * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
             */
            reset() {
                this.record = {
                    id: '',
                };
            },
            format_number(number, digit = 4) {
                return (number * (10 ** digit)).toFixed(0) / (10 ** digit);

            }
        }
    };
</script>
