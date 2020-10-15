<!-- Contenido -->
<div id="app" class="w3-container">


    <div class="tabla_clientes">
        <!-- Reporte 1 -->
        <div>
            <h3>Parqueadero más usado</h3>
            <form v-on:submit.prevent="getReporte1()">
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_inicial1" class="w3-input w3-border "></label>
                </div>
                <div class="reportes">
                    <label>Fecha final<input type="date" v-model="fecha_final1" class="w3-input w3-border "></label>
                </div>
                <div class="reportes boton">
                    <button class="w3-button w3-highway-blue" type="submit">Consultar</button>
                </div>
                <div class="restaurar"></div>
            </form>

            <div class="w3-responsive">
                <table class="w3-table-all">
                    <tr class="w3-dark-grey">
                        <th>Parqueadero</th>
                    </tr>
                    <tr>
                        <td>{{reporte1}}</td>
                    </tr>
                </table>
            </div>

        </div>

        <hr>
        <div>
            <h3>Transacciones de entrada y salida por cada vehículo</h3>
            <form v-on:submit.prevent="getReporte2()">
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_inicial2" class="w3-input w3-border "></label>
                </div>
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_final2" class="w3-input w3-border "></label>
                </div>
                <div class="reportes boton">
                    <button class="w3-button w3-highway-blue" type="submit">Consultar</button>
                </div>
                <div class="restaurar"></div>
            </form>
            <div class="w3-responsive">
                <table class="w3-table-all">
                    <tr class="w3-dark-grey">
                        <th>Plca del vehículo</th>
                        <th>Servicios</th>
                    </tr>
                    <tr v-for="item in reporte2" :key="item.id">
                        <td>{{item.placa}}</td>
                        <td>{{item.total}}</td>
                    </tr>
                </table>
            </div>
            <hr>
        </div>

        <div>
            <h3>Vehículos por tipos que han ingresado</h3>
            <form v-on:submit.prevent="getReporte3()">
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_inicial3" class="w3-input w3-border "></label>
                </div>
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_final3" class="w3-input w3-border "></label>
                </div>
                <div class="reportes boton">
                    <button class="w3-button w3-highway-blue" type="submit">Consultar</button>
                </div>
                <div class="restaurar"></div>
            </form>

            <div class="w3-responsive">
                <table class="w3-table-all">
                    <tr class="w3-dark-grey">
                        <th>Tipo de vehiculo</th>
                        <th>Total</th>
                    </tr>
                    <tr v-for="item in reporte3" :key="item.id">
                        <td>{{item.tipo}}</td>
                        <td>{{item.total}}</td>
                    </tr>
                </table>
            </div>
            <hr>
        </div>

        <div>
            <h3>Monto obtenidos entre fechas</h3>
            <form v-on:submit.prevent="getReporte4()">
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_inicial4" class="w3-input w3-border "></label>
                </div>
                <div class="reportes">
                    <label>Fecha inicial<input type="date" v-model="fecha_final4" class="w3-input w3-border "></label>
                </div>
                <div class="reportes boton">
                    <button class="w3-button w3-highway-blue" type="submit">Consultar</button>
                </div>
                <div class="restaurar"></div>
            </form>

            <div class="w3-responsive">
                <table class="w3-table-all">
                    <tr class="w3-dark-grey">
                        <th>Total</th>
                    </tr>
                    <tr v-for="item in reporte4" :key="item.id">
                        <td>{{item.total}}</td>
                    </tr>
                </table>
            </div>
            <hr>
        </div>



    </div>




</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            //datos 
            fecha_inicial1: '<?php echo date("Y-m-d") ?>',
            fecha_final1: '<?php echo date("Y-m-d") ?>',

            fecha_inicial2: '<?php echo date("Y-m-d") ?>',
            fecha_final2: '<?php echo date("Y-m-d") ?>',

            fecha_inicial3: '<?php echo date("Y-m-d") ?>',
            fecha_final3: '<?php echo date("Y-m-d") ?>',

            fecha_inicial4: '<?php echo date("Y-m-d") ?>',
            fecha_final4: '<?php echo date("Y-m-d") ?>',

            reporte1: '',
            reporte2: '',
            reporte3: '',
            reporte4: '',

        },
        methods: {
            getReporte1: function() {
                axios.get("servicio/reporte1/" +
                    this.fecha_inicial1 + "/" + this.fecha_final1).then((result) => {
                    this.reporte1 = result.data;
                })
            },

            getReporte2: function() {
                axios.get("servicio/reporte2/" +
                    this.fecha_inicial2 + "/" + this.fecha_final2).then((result) => {
                    this.reporte2 = result.data.reporte;
                })
            },

            getReporte3: function() {
                axios.get("servicio/reporte3/" +
                    this.fecha_inicial3 + "/" + this.fecha_final3).then((result) => {
                    this.reporte3 = result.data.reporte;
                })
            },

            getReporte4: function() {
                axios.get("servicio/reporte4/" +
                    this.fecha_inicial4 + "/" + this.fecha_final4).then((result) => {
                    this.reporte4 = result.data.reporte;
                })
            },


        },
        created() {

        }
    })
</script>