<style scoped>
/*inicio  Style for modal */
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, .5);
  display: table;
  transition: opacity .3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;

}
/*Fin  Style for modal */

/*Inicio  Style for button redondo */
.modal-header .close {
    float: right !important;
    margin-right: -35px !important;
    margin-top: -40px !important;
    background-color: black !important;
    border-radius: 200% !important;
    width: 50px !important;
    height: 50px !important;
    opacity: 1 !important;
    color: white !important;
    font-size: 18px !important;
    font-weight: normal !important;
}
.modal-header .close:hover{
    font-size: 20px !important;
    font-weight: bold !important;
}
/*FIn  Style for button redondo */

/*Inicio style for table */
table td,th {
    text-align: center;
}
table td:first-child,th:first-child{
    text-align: left;
}


/*Fin style for table */
</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="buscar">
            </div>
            <div class="col-md-3 offset-md-5">
                <button type="button" @click="showModal = true" class="btn btn-dark float-md-right">Crear Producto</button>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped table-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Producto</th>
                            <th scope="col">Bodega</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Gestión</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="producto in arrayProductos" :key="producto.id">
                            <td v-text="producto.producto"></td>
                            <td v-text="producto.bodega"></td>
                            <td v-text="producto.cantidad"></td>
                            <td v-text="producto.estado"></td>
                            <td>
                                <button type="button" class="btn btn-dark btn-sm">Cambiar estado</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--Inicio Ventana Modal-->
          <div v-if="showModal">
            <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-bold w-100 text-center">Crear Producto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" @click="showModal = false">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="inputProducto">Producto</label>
                                <input type="text" v-model="producto" class="form-control" id="inputProducto">
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-sm-6">
                                    <label for="inputCantidad">Cantidad</label>
                                    <input type="number" v-model="cantidad" class="form-control" id="inputCantidad">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="selectEstado">Estado</label>
                                    <select v-model="estado" class="form-control" id="selectEstado">
                                        <option selected>Elige...</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBodega">Bodega</label>
                                <input type="text" v-model="bodega" class="form-control" id="inputBodega">
                            </div>
                            <div class="form-group">
                                <label for="inputObservaciones">Observaciones</label>
                                <textarea v-model="observaciones" class="form-control" id="inputObservaciones"  rows="2">
                                </textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-dark" @click="storeProductos">Guardar</button>
                        <button type="button" class="btn btn-outline-dark" @click="showModal = false">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </transition>
  </div>
        <!--Fin Ventana Modal-->
    </div>
</template>



<script>
    export default {
        data() {
            return {
                showModal: false,
                producto:'',
                cantidad:'',
                estado:'',
                bodega:'',
                observaciones:'',
                arrayProductos: []
            }
        },
        methods:{
            getProductos(){
                let me = this;
                let url = '/productos'
                axios.get(url).then(function(response){
                    me.arrayProductos = response.data;
                }).catch(function(error){
                    console.log(error);
                });
            },
            storeProductos(){
                let me = this;
                let url = '/productos/guardar'
                axios.post(url,{
                    'producto': this.producto,
                    'cantidad':this.cantidad,
                    'estado':this.estado,
                    'bodega':this.bodega,
                    'observaciones': this.observaciones
                }).then(function(response){
                    me.clearData();
                    me.getProductos();
                }).catch(function(error){
                    console.log(error);
                });
            },
            clearData(){
                this.showModal= false,
                this.producto='',
                this.cantidad='',
                this.estado='',
                this.bodega='',
                this.observaciones=''
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getProductos();
        }
    }
</script>
