<!-- Contenido -->
<div id="app" class="w3-container">

    <!-- nuevo cliente -->
    <div class="btn_nuevo">
        <button onclick="document.getElementById('id01').style.display = 'block'" class="w3-button w3-blue"> + Nuevo
            Cliente</button>
    </div>

    <hr>

    <!-- listado de clientes -->
    <div class="tabla_clientes">
        <h2>Clientes Registrados</h2>
        <div class="w3-responsive">
            <table class="w3-table-all">
                <tr class="w3-dark-grey">
                    <th>Número documento</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Editar</th>
                    <th>Agregar Vehículo</th>
                    <th>Vehículos</th>
                </tr>
                <tr v-for="item in clientes" :key="item.id">
                    <td>{{ item.numero_documento }}</td>
                    <td>{{ item.nombre }}</td>
                    <td>{{ item.apellidos }}</td>
                    <td>
                        <button class="w3-button w3-highway-blue" v-on:click="abrirModalEditar(item)">Editar</button>
                    </td>
                    <td>
                        <button class="w3-button w3-highway-orange" v-on:click="abrirModalAgregar(item)">
                            Agregar</button>
                    </td>
                    <td>
                        <button class="w3-button w3-highway-green" v-on:click="abrirModalVehiculos(item)">
                            Ver</button>
                    </td>
                </tr>
            </table>
        </div>

    </div>


    <!-- Modal Nuevo  -->
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h2>Nuevo Cliente</h2>
            </header>
            <div class="w3-container">
                <form v-on:submit.prevent="insertar()">
                    <p>
                        <input v-model="numero_documento" class="w3-input w3-border" maxlength="50" type="text" placeholder="Número Documento " required>
                    </p>
                    <p>
                        <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre" required>
                    </p>
                    <p>
                        <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50" placeholder="Apellidos" required>
                    </p>
                    <h4>Datos del vehículo</h4>
                    <p>
                        <input v-model="placa" class="w3-input w3-border" type="text" maxlength="50" placeholder="Placa - Serial" required>
                    </p>

                    <p>
                        <select class="w3-select w3-border" v-model="tipo">
                            <option value="" disabled selected>Tipo</option>
                            <option value="Automovil">Automóvil</option>
                            <option value="Moto">Moto</option>
                            <option value="Bicicleta">Bicicleta</option>
                        </select>
                    </p>

                    <hr>

                    <p>
                        <button class="w3-button w3-blue w3-padding-large" type="submit">Guardar</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar  -->
    <div id="id02" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h2>Editar Cliente</h2>
            </header>
            <div class="w3-container">
                <form v-on:submit.prevent="actualizar()">
                    <p>
                        <input v-model="numero_documento" class="w3-input w3-border" maxlength="50" type="text" placeholder="Número Documento " required>
                    </p>
                    <p>
                        <input v-model="nombre" class="w3-input w3-border" type="text" maxlength="50" placeholder="Nombre" required>
                    </p>
                    <p>
                        <input v-model="apellidos" class="w3-input w3-border" type="text" maxlength="50" placeholder="Apellidos" required>
                    </p>
                    <p>
                        <button class="w3-button w3-blue w3-padding-large" type="submit">Guardar</button>
                        <button v-on:click="eliminar" class="w3-button w3-red w3-padding-large btn_eliminar" type="button">Eliminar</button>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <!-- modal ver vehiculos -->
    <div id="id03" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h2>Vehículos del Cliente</h2>
            </header>
            <div class="w3-container">
                <div class="w3-responsive">
                    <table class="w3-table-all ">
                        <tr class="w3-dark-grey">
                            <th>Placa</th>
                            <th>Tipo</th>
                        </tr>
                        <tr v-for="item in vehiculos" :key="item.id">
                            <td>{{ item.placa}}</td>
                            <td>{{ item.tipo }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <br>
            <br>
        </div>
    </div>

    <!-- Modal agregar vehiculo  -->
    <div id="id04" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h3>Datos del vehículo</h3>
            </header>
            <div class="w3-container">
                <form v-on:submit.prevent="agregarVehiculo()">
                    <p>
                        <input v-model="placa" class="w3-input w3-border" type="text" maxlength="50" placeholder="Placa - Serial" required>
                    </p>

                    <p>
                        <select class="w3-select w3-border" v-model="tipo">
                            <option value="" disabled selected>Tipo</option>
                            <option value="Automovil">Automóvil</option>
                            <option value="Moto">Moto</option>
                            <option value="Bicicleta">Bicicleta</option>
                        </select>
                    </p>

                    <hr>

                    <p>
                        <button class="w3-button w3-blue w3-padding-large" type="submit">Guardar</button>
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
            //datos del cliente
            id: '',
            numero_documento: '',
            nombre: '',
            apellidos: '',
            clientes: [],
            //datos vehiculo
            placa: '',
            tipo: '',
            id_cliente: '',
            vehiculos: [],
        },
        methods: {
            listar: function() {
                axios.get("cliente/index").then((result) => {
                    this.clientes = result.data.clientes;
                })
            },

            insertar: function() {
                let post = {
                    numero_documento: this.numero_documento,
                    nombre: this.nombre,
                    apellidos: this.apellidos,
                    placa: this.placa.toUpperCase(),
                    tipo: this.tipo,
                };
                axios.post("cliente/store", post)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert('Cliente registrado')
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            //this.errores = error.response.data.errors;
                            alert("Error");
                        }
                    });
            },

            agregarVehiculo: function() {
                let post = {
                    id_cliente: this.id,
                    placa: this.placa.toUpperCase(),
                    tipo: this.tipo,
                };
                axios.post("vehiculo/agregar", post)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert("Vehículo registrado");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errores = error.response.data.errors;
                            alert("Error");
                        }
                    });
            },

            actualizar: function() {
                let post = {
                    numero_documento: this.numero_documento,
                    nombre: this.nombre,
                    apellidos: this.apellidos,
                };
                axios.post("cliente/update/" + this.id, post)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert('Cliente actualizado');
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errores = error.response.data.errors;
                            alert("Error");
                        }
                    });
            },

            eliminar: function() {
                axios.post("cliente/destroy/" + this.id)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert("Cliente elimidado")
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errores = error.response.data.errors;
                            alert("No se puede eliminar el registro");
                        }
                    });
            },

            cancelar: function() {
                //limpiar todos los campos 
                this.id = '';
                this.numero_documento = '';
                this.nombre = '';
                this.apellidos = '';
                this.placa = '';
                this.tipo = '';
                //cerrar modales
                document.getElementById('id01').style.display = 'none';
                document.getElementById('id02').style.display = 'none';
                document.getElementById('id03').style.display = 'none';
                document.getElementById('id04').style.display = 'none';
            },

            abrirModalEditar(objeto) {
                //colocar valores
                this.id = objeto.id;
                this.numero_documento = objeto.numero_documento;
                this.nombre = objeto.nombre;
                this.apellidos = objeto.apellidos;
                //abril modal editar
                document.getElementById('id02').style.display = 'block';
            },

            abrirModalVehiculos(objeto) {
                //consultar vehiculos
                this.id_cliente = objeto.id;
                this.listarVehiculos();
                //abril modal editar
                document.getElementById('id03').style.display = 'block';
            },

            abrirModalAgregar(objeto) {
                //colocar valores
                this.id = objeto.id;
                //abril modal editar
                document.getElementById('id04').style.display = 'block';
            },

            listarVehiculos: function() {
                axios.get("vehiculo/listarIdCliente/" + this.id_cliente).then((result) => {
                    this.vehiculos = result.data.vehiculos;
                })
            },

        },
        created() {
            this.listar();
        }
    })
</script>