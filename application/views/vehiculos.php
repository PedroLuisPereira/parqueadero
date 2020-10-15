<!-- Contenido -->
<div id="app" class="w3-container">

    <!-- listado de clientes -->
    <div class="tabla_clientes">
        <h2>Vehículos Registrados</h2>
        <div class="w3-responsive">
            <table class="w3-table-all">
                <tr class="w3-dark-grey">
                    <th>Placa - Serial</th>
                    <th>Tipo</th>
                    <th>Cliente</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
                <tr v-for="item in vehiculos" :key="item.id">
                    <td>{{ item.placa }}</td>
                    <td>{{ item.tipo }}</td>
                    <td>{{ item.nombre}} {{ item.apellidos}}</td>
                    <td>
                        <button class="w3-button w3-highway-blue" v-on:click="abrirModalEditar(item)">Editar</button>
                    </td>
                    <td>
                        <button class="w3-button w3-highway-red" v-on:click="eliminar(item)">Eliminar</button>
                    </td>
                </tr>
            </table>
        </div>

    </div>


    <!-- Modal Editar  -->
    <div id="id01" class="w3-modal">
        <div class="w3-modal-content">
            <header class="w3-container w3-light-grey">
                <span v-on:click="cancelar()" class="w3-button w3-display-topright">&times;</span>
                <h2>Editar vehículo</h2>
            </header>
            <div class="w3-container">
                <form v-on:submit.prevent>
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
                    <p>
                        <button v-on:click="actualizar()" class="w3-button w3-blue w3-padding-large" type="submit">Guardar</button>
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
            //datos vehiculo
            placa: '',
            tipo: '',
            id_cliente: '',
            vehiculos: [],
        },
        methods: {
            listar: function() {
                axios.get("vehiculo/index").then((result) => {
                    this.vehiculos = result.data.vehiculos;
                })
            },

            actualizar: function() {
                let post = {
                    placa: this.placa.toUpperCase(),
                    tipo: this.tipo,
                };
                axios.post("vehiculo/update/" + this.id, post)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert("Vehiculo actualizado");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            alert("Error al actualizar");
                        }
                    });
            },

            eliminar: function(objeto) {
                this.id = objeto.id;
                axios.post("vehiculo/destroy/" + this.id)
                    .then(response => {
                        this.cancelar();
                        this.listar();
                        alert("Vehiculo elimindado")
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errores = error.response.data.errors;
                        }
                    });
            },

            cancelar: function() {
                //limpiar todos los campos 
                this.id = '';
                this.placa = '';
                this.tipo = '';
                //cerrar modales
                document.getElementById('id01').style.display = 'none';
            },

            abrirModalEditar(objeto) {
                //colocar valores
                this.id = objeto.id;
                this.placa = objeto.placa;
                this.tipo = objeto.tipo;
                //abril modal editar
                document.getElementById('id01').style.display = 'block';
            },

        },
        created() {
            this.listar();
        }
    })
</script>