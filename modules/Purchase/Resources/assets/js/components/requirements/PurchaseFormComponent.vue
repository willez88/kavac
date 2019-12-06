<template>
    <div>
        <form>
            <div class="row">
                <div class="col-3">
                    <label for="date">Fecha</label>
                    <input type="date" id="date" class="form-control">
                </div>
                <div class="col-3">
                    <label for="financial_year">Ejercicio económico</label>
                    <input type="date" id="financial_year" class="form-control">
                </div>
                <div class="col-3">
                    <label for="contracting">Unidad contratante</label>
                    <!-- <select2 name="" id="contracting"></select2> -->
                </div>
                <div class="col-3">
                    <label for="usury">Unidad usuaria</label>
                    <!-- <select2 name="" id="usury"></select2> -->
                </div>
                <div class="col-3">
                    <label for="type_requirement">Tipo</label>
                    <!-- <select class="form-control select2" id="type_requirement" v-model='record_select'>
                        <option v-for="item in supplier_objects" :value="item.id">
                            {{ item.text }}
                        </option>
                    </select> -->
                    <sel :options="supplier_objects" v-model='record_select'></sel>
                </div>
                <div class="col-3">
                    <label for="denomination">Denominación</label>
                    <input type="text" id="denomination" class="form-control">
                </div>
                <div class="col-3">
                    <label for="description_requirement">Descripción</label>
                    <!-- <select2 name="" id="description_requirement"></select2> -->
                </div>

                <div class="col-12">
                    <table class="table table-formulation">
                        <thead>
                            <tr>
                                <td><strong>Producto</strong></td>
                                <td><strong>Descripción</strong></td>
                                <td><strong>Especificaciones técnicas</strong></td>
                                <td><strong>unidad de medida</strong></td>
                                <td><strong>cantidad</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <select :options="acc" v-model="record_select"></select>
                                </td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- <tr v-for="item in acc">
                                <td>N - {{ item.id }}</td>
                                <td>{{ item.denomination }}</td>
                                <td>Especificaciones técnicas</td>
                                <td>unidad de medida</td>
                                <td>cantidad</td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    export default{
        props:['supplier_objects','date','year','acc'],
        data(){
            return {
                record_select:'',
            }
        },
        mounted(){
            
        }
    };
</script>
