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
.modal-header {
    border-bottom: 0 none;
}
.modal-footer {
    border-top: 0 none;
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
table, th, td{
    border-collapse: collapse !important;
    border: 1px solid white !important;
}
table thead{
    border-bottom: 10px solid white !important;
}
/**Aliniacion */
table td,th {
    text-align: center;
}
table td:first-child,th:first-child{
    text-align: left;
}
/**Color Impar */
.table-striped>tbody>tr:nth-child(odd)>td,
.table-striped>tbody>tr:nth-child(odd)>th {
    background-color: rgb(196, 193, 193);
 }
/**Color par */
 .table-striped>tbody>tr:nth-child(even)>td,
.table-striped>tbody>tr:nth-child(even)>th {
    background-color: rgba(232, 232, 233, 0.719);
 }
 /*Fin style for table */


/**Quitar la negrita */
span, th{
    font-weight: normal !important;
}
/**Hacer ancho el spam */
.badge{
    width: 70px;
}


/**Inicio Paginador ::v-deep espara profundidad de los componentes child */
::v-deep .pagination > li > a
{
    background-color: black;
    color: white;
    border-radius: 10%;
    margin: 4px;
}

::v-deep .pagination > li > a:focus,
::v-deep .pagination > li > a:hover,
::v-deep .pagination > li > span:focus,
::v-deep .pagination > li > span:hover
{
    color: black;
    background-color:white;
    border-color: black;
}

::v-deep .pagination > .active > a
{
    color: white;
    background-color: rgba(7, 7, 7, 0.582);
    border: solid 1.5px rgba(2, 0, 8, 0.452);
}
/**Inicio Paginador*/
</style>


<template>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" v-on:keyup="buscar" v-model="buscarProducto" placeholder="buscar">
            </div>
            <div class="col-md-3 offset-md-5">
                <button type="button" @click="showModal = true" class="btn btn-dark float-md-right">Crear Producto</button>
            </div>
        </div>
        <div class="row mt-4 mb-12">
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
                        <tr v-for="producto in objectProductos.data" :key="producto.id">
                            <td v-text="producto.producto"></td>
                            <td v-if="producto.bodega === '1'">
                                Centro
                            </td>
                            <td v-else-if="producto.bodega === '2'">
                                Oriente
                            </td>
                            <td v-else-if="producto.bodega === '3'">
                                Occidente
                            </td>
                            <td v-else>
                                Sur
                            </td>
                            <td v-text="producto.cantidad"></td>
                            <td v-if="producto.estado === '1'">
                                <span class="badge badge-success">Activo</span>
                            </td>
                            <td v-else>
                                <span class="badge badge-danger">Inactivo</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-dark btn-sm" @click="showCambiarEstado=true,id=producto.id">Cambiar estado</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row mt-4 mb-12">
            <div class="col-md-12">
                <pagination :data="objectProductos" @pagination-change-page="getProductos"
                size="small" v-bind:show-disabled="true" align="right">
                    <span slot="prev-nav">Atrás</span>
                    <span slot="next-nav">Adelante</span>
                </pagination>
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
                        <span aria-hidden="true" @click="clearData">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="inputProducto">Producto</label>
                                <input type="text" v-model="producto" class="form-control" id="inputProducto">
                                <div  v-if="errores.producto">
                                        <span  style="color:red" v-text="errores.producto[0]" ></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="form-group col-sm-6">
                                    <label for="inputCantidad">Cantidad</label>
                                    <input type="number" v-model="cantidad" class="form-control" id="inputCantidad">
                                    <div  v-if="errores.cantidad">
                                        <span  style="color:red" v-text="errores.cantidad[0]" ></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="selectEstado">Estado</label>
                                    <select v-model="estado" class="form-control" id="selectEstado">
                                        <option selected>Elige...</option>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                    <div  v-if="errores.estado">
                                        <span  style="color:red" v-text="errores.estado[0]" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBodega">Bodega</label>
                                <select v-model="bodega" class="form-control" id="inputBodega">
                                        <option selected>Elige...</option>
                                        <option value="1">Centro</option>
                                        <option value="2">Oriente</option>
                                        <option value="3">Occidente</option>
                                        <option value="4">Sur</option>
                                    </select>
                                <div  v-if="errores.bodega">
                                        <span  style="color:red" v-text="errores.bodega[0]" ></span>
                                </div>
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
                        <button type="button" class="btn btn-outline-dark" @click="clearData">Cancelar</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </transition>
         </div>
        <!--Fin Ventana Modal-->
        <!--Inicio Ventana Cambiar estado-->
        <div v-if="showCambiarEstado">
            <transition name="modal">
            <div class="modal-mask">
                <div class="modal-wrapper">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showCambiarEstado = false">
                        <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 class="modal-title font-weight-bold w-100 text-center">¿Esta Seguro de querer cambiar el estado?</h4>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-dark" @click="updateEstado">Si</button>
                        <button type="button" class="btn btn-outline-dark" @click="showCambiarEstado = false">No</button>
                    </div>
                    </div>
                </div>
                </div>
            </div>
            </transition>
         </div>
        <!--Fin Ventana Cambiar estado-->
    </div>
</template>



<script>
    export default {
        data() {
            return {
                showModal: false,
                showCambiarEstado: false,
                id:'',
                producto:'',
                cantidad:'',
                estado:'',
                bodega:'',
                observaciones:'',
                objectProductos: {},
                buscarProducto:'',
                errores:""
            }
        },
        methods:{
            getProductos(page){
                if (typeof page === 'undefined') {
                    page = 1;
                }
                let me = this;
                let url = '/productos?page='
                axios.get(url + page).then(function(response){
                    me.objectProductos = response.data;
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
                    me.errores=error.response.data.errors;
                    console.log(error);
                });
            },
            updateEstado(){
                let me = this;
                let url = '/productos/actualizar'
                axios.put(url,{
                    'id': this.id
                }).then(function(response){
                    me.getProductos();
                    me.showCambiarEstado= false;
                }).catch(function(error){
                    console.log(error);
                });
            },
            buscar(){
                let me = this;
                if(me.buscarProducto === ''){
                    me.getProductos();
                }
                else{
                    let url = '/productos/buscar'
                    axios.get(url,{
                         params: {
                            valor: this.buscarProducto
                         }
                    }).then(function(response){
                        me.objectProductos = response.data;
                    }).catch(function(error){
                        console.log(error);
                    });
                }

            },
            clearData(){
                this.showModal= false,
                this.producto='',
                this.cantidad='',
                this.estado='',
                this.bodega='',
                this.observaciones='',
                this.errores=''
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.getProductos();
        }
    }
</script>
