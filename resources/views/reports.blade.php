<x-admin>
  <x-slot name="imgHeader">{{asset('images/header.jpeg')}}</x-slot>
  <x-slot name="titleHeader">Administrador</x-slot>
  <x-slot name="parHeader">Market Gestion</x-slot>

  <x-slot name="styleSheets">
  </x-slot>

  <x-slot name="content">
    <div id="appAdmin">
      <!-- sidebar -->
      <template>
        <div>
          <b-sidebar v-model="showSidebar" aria-labelledby="sidebar-no-header-title" no-header shadow>
            <template #default="{ visible }">
              <div class="p-3">
                <b-container><br>
                  <div class="text-center">
                    <div class="h1 font-weight-300">
                      <i class="fas fa-store-alt mr-1"></i>
                    </div>
                    <h1 class="h1">
                      Market Admin
                    </h1>
                  </div><br><br>
                  
                    <b-nav pills vertical>
                      <b-button block variant="default mb-3">Admin</b-button>
                      <b-button block variant="default mb-3">Usuarios</b-button>
                      <b-button block variant="default mb-3">Reportes</b-button>
                    </b-nav><br><br>

                  <b-button size="sm" variant="outline-primary" block @click="showSidebar = !showSidebar">Close Sidebar</b-button>
                </b-container>
                <div>

                </div>
              </div>
            </template>
          </b-sidebar>
        </div>
      </template>

      <!-- contenido -->
      <b-container @click="showSidebar = false">
        <div><br>
          <b-alert
            class="position-fixed fixed-top m-6 rounded-1"
            style="z-index: 2000;"
            :show="dismissCountDown"
            dismissible
            :variant="alertColor"
            @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged"
          >
            ${ dismissCountDown  } &nbsp- &nbsp<span class="h2 text-white">${ alertMsg }</span>
          </b-alert>

        </div>
        <!-- tabla -->
        <div class="row">
          <div class="col-12">
            <b-card
            header-tag="header"
            tag="article"
            class="m-3"
            >
              <template #header>
                <h4 class="mb-0">
                  <b-button v-b-toggle.collapse-2 class="btn btn-info mx-0" size="sm">
                    <i class="fa fa-chevron-circle-down"></i>
                  </b-button> Reportes
                </h4>
              </template>
              <b-collapse visible id="collapse-2" class="mt-2">

                <b-card-text>
                  <div class="row">
                    <div class="col-6">
                      <b-form-input v-model="table.keyword" placeholder="Buscar" size="sm"></b-form-input><br>
                    </div>
                    <div class="col-6">
                    <div id="app">
                      <v-select
                        :options="durationProduct" 
                        label="title"
                        @input="filterSelect"
                      ></v-select>
                    </div>
                    
                  </div>
                  <b-table
                    responsive
                    :items="items"
                    :fields="table.fields"
                    :sticky-header="table.stickyHeader"
                    :stacked="table.tableStack"
                    striped
                    :per-page="0"
                    :current-page="currentPage"
                    :keyword="table.keyword"
                  >
                    <template #cell(name)="row">
                      <input v-model="row.item.name" type="text" class="btn px-0">
                    </template>
                    <template #cell(cedula)="row">
                      <input v-model="row.item.cantidad" type="number" class="btn px-0">
                    </template>

                    <template #cell(actions)="row">
                      <b-button size="sm" @click="deleteProduct(row.item.id)" variant="danger">
                        ${row.item.id} <i class="fa fa-trash"></i>
                      </b-button>
                      <b-button size="sm" @click="updateProduct(row.item)" variant="default">
                          <i class="fa fa-edit"></i>
                      </b-button>
                    </template>
                  </b-table>
                </b-card-text>

                <b-button @click="getProducts" variant="primary">Refrescar datos</b-button>
                <pre v-if="debug"><code>${products}</code></pre>
              </b-collapse>
            </b-card>
          </div>
          
        </div>
      </b-container>

    </div>
  </x-slot>

  <x-slot name="scripts">
      <!-- vue app -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/vue-select/3.10.0/vue-select.css" integrity="sha512-HLz+b0Pyj+6RnAjTwAajDUOJfhEIfdLy91cHSph3ydMYt3UN6kp7h+b2ofodXNflk4CNyZe9HP8YAj8hYBiNSA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
      <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-select/3.10.0/vue-select.min.js" integrity="sha512-XxrWOXiVqA2tHMew1fpN3/0A7Nh07Fd5wrxGel3rJtRD9kJDJzJeSGpcAenGUtBt0RJiQFUClIj7/sKTO/v7TQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js" integrity="sha512-LGXaggshOkD/at6PFNcp2V2unf9LzFq6LE+sChH7ceMTDP0g2kn6Vxwgg7wkPP7AAtX+lmPqPdxB47A0Nz0cMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
      <script>
        Vue.component("v-select", VueSelect.VueSelect);
        let appAdmin = new Vue({
          el: '#appAdmin',
          delimiters: ['${', '}'],
          data: {
            durationProduct: [
              { title: "Una semana" },
              { title: "Dos semanas" },
              { title: "Tres semanas" },
              { title: "1 mes" }
            ],
            alertMsg: 'Sin mensaje',
            posts:'',
            sort:'',
            alertColor: 'warning',
            dismissSecs: 10,
            dismissCountDown: 0,
            newProduct: {
              name: 'Manzana', 
              cantidad: '1'
            },
            form: {
              inputs: [
                {label: 'Nombre', key: 'name', colSize: '6', placeholder: '', type: 'text', required: true},
                {label: 'Cantidad', key: 'cantidad', colSize: '6', placeholder: '', type: 'number', required: true}
              ]
            },
            showSidebar: false,
            name: '',
            currentPage: 0,
            table: {
                tableStack: false,
                stickyHeader: false,
                keyword: '',
                fields: [
                    {'key' : 'actions', 'label' : 'ACCIONES'},
                    {'key' : 'name', 'label' : 'NOMBRE', 'sortable' : true},
                    {'key' : 'cantidad', 'label' : 'CANTIDAD', 'sortable' : true},
                ],
            },
            infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
            },
            debug: true,
            products: [],
          },
          methods:{
            async updateProduct(productObj){
              const copyProductData = Object.assign({}, productObj);
              delete copyProductData.created_at
              delete copyProductData.updated_at              
              delete copyProductData.id
              console.log(productObj, copyProductData)
              try {
                let response = await axios.put("{{route('products.index')}}/" + productObj.id, {data: copyProductData}, {headers:{'Content-type': 'application/json'}})
                this.getProducts()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            loadPost(){
                this.post=this.post
            },
            sortValue(){
                axios.post('/filter',{ sort:this.sort })
                .then(response => ( this.post=response.data.post ))
            },
            async deleteProduct(productId){
              try {
                let response = await axios.delete("{{route('products.index')}}/" + productId, {}, {headers:{'Content-type': 'application/json'}})
                this.getProducts()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            async createProduct(){
              try {

                let response = await axios.post("{{route('products.store')}}", {data: this.newProduct}, {headers:{'Content-type': 'application/json'}})
                this.getProducts()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            async getProducts(){
              let response = await axios.get("{{route('products.index')}}", {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
                console.log(response.data.records)
                this.products = response.data.records
                console.log(response.data)
              }else{console.log(response.error)}
            },
            async filterSelect(event){
              let response = await axios.get("{{route('products.index')}}", {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
                this.products = response.data.records

                switch (event.title) {
                  case 'Una semana':
                    //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor1
  
                    var result = response.data.records.filter(result => {
                      var fechaInicio = new Date(result.created_at).getTime();
                      var fechaFin    = new Date().getTime();
                      var diff = fechaFin - fechaInicio;
                      var fecha1 = moment(result.created_at);
                      var fecha2 = moment();
                      return fecha1.diff(fecha2, 'days') <= -7
                    });
                    this.products = result;
                    
                    break;
                  case 'Dos semanas':
                    var result = response.data.records.filter(result => {
                      var fechaInicio = new Date(result.created_at).getTime();
                      var fechaFin    = new Date().getTime();
                      var diff = fechaFin - fechaInicio;
                      var fecha1 = moment(result.created_at);
                      var fecha2 = moment();
                      return fecha1.diff(fecha2, 'days') <= -14
                    });
                    this.products = result;
                    console.log('dos semana', event.title)
                    //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor2
                    break;
                  case 'Tres semanas':
                    var result = response.data.records.filter(result => {
                      var fechaInicio = new Date(result.created_at).getTime();
                      var fechaFin    = new Date().getTime();
                      var diff = fechaFin - fechaInicio;
                      var fecha1 = moment(result.created_at);
                      var fecha2 = moment();
                      return fecha1.diff(fecha2, 'days') <= -21
                    });
                    this.products = result;
                    //Declaraciones ejecutadas cuando el resultado de expresión coincide con valorN
                    break;
                  case '1 mes':
                    //Declaraciones ejecutadas cuando el resultado de expresión coincide con el valor2
                    var result = response.data.records.filter(result => {
                      var fechaInicio = new Date(result.created_at).getTime();
                      var fechaFin    = new Date().getTime();
                      var diff = fechaFin - fechaInicio;
                      var fecha1 = moment(result.created_at);
                      var fecha2 = moment();
                      return fecha1.diff(fecha2, 'days') <= -28
                    });
                    this.products = result;
                    break;
                  default:
                    this.products = response.data.records
                    //Declaraciones ejecutadas cuando ninguno de los valores coincide con el valor de la expresión
                    break;
                }
                console.log(response.data)
              }else{console.log(response.error)}
            },
            countDownChanged(dismissCountDown) {
              this.dismissCountDown = dismissCountDown
            },
            showAlert(msg = 'No hay mensaje',alertColor = 'default') {
              this.alertColor = alertColor
              this.alertMsg = msg
              this.dismissCountDown = this.dismissSecs
            },
          },
          computed: {
            items(){
              return this.table.keyword
                ? this.products.filter(
                  item => 
                    item.name.includes(this.table.keyword)
                )
                : this.products
            },
          },
          created(){
            this.getProducts()
          },
        })
      </script>
  </x-slot>
</x-admin>