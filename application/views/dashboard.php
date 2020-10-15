<!-- contenido  -->
<div id="app">
    <!-- formulario -->
    <div class="formulario">
        <div class="w3-card-4">
            <div class="w3-container w3-dark-grey">
                <h3></i>Ingresar Vehículo</h3>
            </div>

            <form v-on:submit.prevent="ingresarVehiculo()" class="w3-container">
                <p>
                    <label class="w3-text-grey"><b>Placa - Serial del vehículo</b></label> <a class="btn_eliminar" href="clientes">Registrar</a>
                    <input class="w3-input w3-border" v-on:keyup="getParqueaderos()" required maxlength="50" v-model="placa" type="text">
                </p>

                <div v-if="parqueaderos.length == 0">
                    <div v-if="placa.length > 0">
                        <h5>Placa -serial no registrada</h5>
                    </div>
                </div>
                <div v-else>
                    <p>
                        <label class="w3-text-grey"><b>Seleccione parqueadero</b></label>
                        <select class="w3-select w3-border" required v-model="parqueadero">
                            <option v-for="item in  parqueaderos" :value="item.parqueadero">{{item.parqueadero}}
                            </option>
                        </select>
                    </p>
                    <p>
                        <button class="w3-btn w3-blue">Ingresar vehículo</button>

                    </p>
                </div>

            </form>
        </div>

    </div>

    <!-- parqueadero -->
    <br>
    <div class="w3-card-4 parqueadero">
        <div class="w3-container w3-dark-grey">
            <h3>Parqueaderos</h3>
        </div>

        <div class="autos">

            <div v-for="item in automoviles" :key="item.id">
                <div class="tooltip cubiculo" v-if="item.estado == 'Disponible'">
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                </div>

                <div class="tooltip cubiculoOcupado" v-else>
                    <span v-if="item.estado == 'No disponible'">Placa: {{item.placa}} </span>
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                    <div v-if="item.estado == 'No disponible'" class="tooltiptext">
                        <p>Parqueadero: {{ item.parqueadero}} </p>
                        <p>Nombre: {{ item.cliente[0].nombre}} </p>
                        <p>Apellidos: {{ item.cliente[0].apellidos}} </p>
                        <p>N° Documento: {{ item.cliente[0].numero_documento}} </p>
                        <hr>
                        <input type="button" v-on:click="moverAuto(item)" class="w3-button w3-blue" value="Mover">
                        <hr>
                        <input type="button" v-on:click="terminarServicio(item)" class="w3-button w3-red" value="Terminar servicio">
                    </div>
                </div>
            </div>
            <div class="restaurar"></div>
        </div>


        <div class="bicicletas">

            <div v-for="item in bicicletas" :key="item.id">
                <div class="tooltip cubiculo" v-if="item.estado == 'Disponible'">
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                </div>

                <div class="tooltip cubiculoOcupado" v-else>
                    <span v-if="item.estado == 'No disponible'">Placa: {{item.placa}} </span>
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                    <div v-if="item.estado == 'No disponible'" class="tooltiptext">
                        <p>Parqueadero: {{ item.parqueadero}} </p>
                        <p>Nombre: {{ item.cliente[0].nombre}} </p>
                        <p>Apellidos: {{ item.cliente[0].apellidos}} </p>
                        <p>N° Documento: {{ item.cliente[0].numero_documento}} </p>
                        <hr>
                        <input type="button" v-on:click="moverBicicleta(item)" class="w3-button w3-blue" value="Mover">
                        <hr>
                        <input type="button" v-on:click="terminarServicio(item)" class="w3-button w3-red" value="Terminar servicio">
                    </div>
                </div>
            </div>
            <div class="restaurar"></div>
        </div>


        <div class="motos">
            <div v-for="item in motos" :key="item.id">
                <div class="tooltip cubiculo" v-if="item.estado == 'Disponible'">
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                </div>

                <div class="tooltip cubiculoOcupado" v-else>
                    <span v-if="item.estado == 'No disponible'">Placa: {{item.placa}} </span>
                    <span v-if="item.estado == 'Disponible'">{{item.parqueadero}} </span>
                    <div v-if="item.estado == 'No disponible'" class="tooltiptext">
                        <p>Parqueadero: {{ item.parqueadero}} </p>
                        <p>Nombre: {{ item.cliente[0].nombre}} </p>
                        <p>Apellidos: {{ item.cliente[0].apellidos}} </p>
                        <p>N° Documento: {{ item.cliente[0].numero_documento}} </p>
                        <hr>
                        <input type="button" v-on:click="moverMoto(item)" class="w3-button w3-blue" value="Mover">
                        <hr>
                        <input type="button" v-on:click="terminarServicio(item)" class="w3-button w3-red" value="Terminar servicio">
                    </div>
                </div>
            </div>
            <div class="restaurar"></div>
        </div>

    </div>


    <!-- Modal mover  -->
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h2>Nuevo Parqueadero</h2>
            </header>
            <div class="w3-container">
                <form v-on:submit.prevent="mover()">
                    <p>
                        <label class="w3-text-grey"><b>Parqueadero</b></label>
                        <select class="w3-select w3-border" required v-model="parqueadero_nuevo">
                            <option v-for="item in  parqueaderosMover" :value="item.parqueadero">{{item.parqueadero}}
                            </option>
                        </select>
                    </p>
                    <p>
                        <button class="w3-btn w3-blue">Mover vehículo</button>
                    </p>
                </form>
            </div>
        </div>
    </div>


</div>


<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            //registrar ingreso
            placa: '',
            parqueadero: '',
            parqueaderos: [],

            //zona de parqueo
            automoviles: [],
            bicicletas: [],
            motos: [],

            //mover vehiculo
            parqueaderosMover: [],
            parqueadero_nuevo: '',

            //clases
            ocupado: true,
            desocupado: true,
        },
        methods: {
            //obtener todos los parqueaderos disponibles
            getParqueaderos: function() {
                if (this.placa != "") {
                    axios.get("vehiculo/listarPlaca/" + this.placa.toUpperCase()).then((result) => {
                        this.parqueaderos = result.data.parqueaderos;
                    })
                }
            },

            //obtener todos los parqueaderos autos
            getAutomoviles: function() {
                axios.get("parqueadero/listarAutos").then((result) => {
                    this.automoviles = result.data.parqueaderos;
                })
            },

            //obtener todos los parqueaderos bicicletas
            getBicicletas: function() {
                axios.get("parqueadero/listarBicicletas").then((result) => {
                    this.bicicletas = result.data.parqueaderos;
                })
            },

            //obtener todos los parqueaderos motos
            getMotos: function() {
                axios.get("parqueadero/listarMotos").then((result) => {
                    this.motos = result.data.parqueaderos;
                })
            },

            //ingresar un nuevo vehiculos a parquear
            ingresarVehiculo: function() {
                let post = {
                    placa: this.placa.toUpperCase(),
                    parqueadero: this.parqueadero,
                };
                axios.post("servicio/nuevoServicio", post)
                    .then(response => {
                        this.cancelar();
                        this.getParqueaderos();
                        this.getAutomoviles();
                        this.getBicicletas();
                        this.getMotos();
                        alert("Servicio registrado");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            //this.errores = error.response.data.errors;
                            alert("Vehículo ya esta en servicio");
                        }
                    });
            },

            //ingresar un nuevo vehiculos a parquear
            terminarServicio: function(objeto) {
                let post = {
                    parqueadero: objeto.parqueadero,
                };
                axios.post("servicio/terminarServicio", post)
                    .then(response => {
                        this.cancelar();
                        this.getParqueaderos();
                        this.getAutomoviles();
                        this.getBicicletas();
                        this.getMotos();
                        alert("Servicio terminado");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            //this.errores = error.response.data.errors;
                            alert("Error al procesar");
                        }
                    });
            },

            moverAuto(objeto) {
                //colocar valores
                this.parqueadero = objeto.parqueadero;

                axios.get("parqueadero/listarAutosMover").then((result) => {
                    this.parqueaderosMover = result.data.parqueaderos;
                })

                //abril modal editar
                document.getElementById('id01').style.display = 'block';
            },

            moverBicicleta(objeto) {
                //colocar valores
                this.parqueadero = objeto.parqueadero;

                axios.get("parqueadero/listarBicicletasMover").then((result) => {
                    this.parqueaderosMover = result.data.parqueaderos;
                })

                //abril modal editar
                document.getElementById('id01').style.display = 'block';
            },

            moverMoto(objeto) {
                //colocar valores
                this.parqueadero = objeto.parqueadero;

                axios.get("parqueadero/listarMotosMover").then((result) => {
                    this.parqueaderosMover = result.data.parqueaderos;
                })

                //abril modal editar
                document.getElementById('id01').style.display = 'block';
            },

            //ingresar un nuevo vehiculos a parquear
            mover: function() {
                let post = {
                    parqueadero_viejo: this.parqueadero,
                    parqueadero_nuevo: this.parqueadero_nuevo,
                };
                axios.post("parqueadero/servicio/mover", post)
                    .then(response => {
                        this.cancelar();
                        this.getParqueaderos();
                        this.getAutomoviles();
                        this.getBicicletas();
                        this.getMotos();
                        alert("Vehículo movido");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            alert("Error al mover el vehiculo");
                        }
                    });
            },

            //limpiar todos los campos 
            cancelar: function() {
                this.placa = '';
                this.parqueadero = '';
                this.parqueaderos = [];
                this.parqueaderosMover = [];
                this.parqueadero_nuevo = '';
                document.getElementById('id01').style.display = 'none';
            },

        },
        created() {
            //this.getParqueaderos();
            this.getAutomoviles();
            this.getBicicletas();
            this.getMotos();
        }
    })
</script>