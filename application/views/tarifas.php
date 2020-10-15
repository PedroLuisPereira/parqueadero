<!-- contenido -->
<div id="app">
    <!-- formulario -->
    <div class="formulario">
        <div class="w3-card-4">
            <div class="w3-container w3-dark-grey">
                <h2>Tarifas</h2>
            </div>

            <form v-on:submit.prevent="insertar()" class="w3-container">
                <p>
                    <label for="">Valor Minuto Automoviles</label>
                    <input v-model="minuto_autos" class="w3-input w3-border" type="number" min="0" step="0.01" placeholder="Valor Minuto Automoviles " required>
                </p>
                <p>
                    <label for="">Valor Minutos Motos</label>
                    <input v-model="minuto_motos" class="w3-input w3-border" type="number" min="0" step="0.01" placeholder="Valor Minutos Motos" required>
                </p>
                <p>
                    <label for="">Valor Minutos Bicicletas</label>
                    <input v-model="minuto_bicicletas" class="w3-input w3-border" type="number" min="0" step="0.01" placeholder="Valor Minutos Bicicletas" required>
                </p>
                <h4>Descuentos</h4>
                <p>
                    <label for="">Minuto para obtener el descuento</label>
                    <input v-model="minutos" class="w3-input w3-border" type="number" placeholder="Placa-Serial" min="0" required>
                </p>
                <p>
                    <label for="">Descuento %</label>
                    <input v-model="descuento" class="w3-input w3-border" type="number" placeholder="Placa-Serial" min="0" step="0.01" required>
                </p>


                <p>
                    <button class="w3-button w3-blue w3-padding-large" type="submit">Guardar</button>
                </p>


            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            minuto_autos: '',
            minuto_bicicletas: '',
            minuto_motos: '',
            descuento: '',
            minutos: '',
            tarifas: [],
        },
        methods: {
            listar: function() {
                axios.get("tarifa/index").then((result) => {
                    this.tarifas = result.data.tarifa;
                    this.minuto_autos = this.tarifas[0].minuto_autos;
                    this.minuto_bicicletas = this.tarifas[0].minuto_bicicletas;
                    this.minuto_motos = this.tarifas[0].minuto_motos;
                    this.descuento = this.tarifas[0].descuento;
                    this.minutos = this.tarifas[0].minutos;
                })
            },

            insertar: function() {
                let post = {
                    minuto_autos: this.minuto_autos,
                    minuto_bicicletas: this.minuto_bicicletas,
                    minuto_motos: this.minuto_motos,
                    descuento: this.descuento,
                    minutos: this.minutos,
                };
                axios.post("tarifa/update", post)
                    .then(response => {
                        this.listar();
                        alert("Tarifas actualizadas");
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errores = error.response.data.errors;
                        }
                    });
            },
        },
        created() {
            this.listar();
        }
    })
</script>