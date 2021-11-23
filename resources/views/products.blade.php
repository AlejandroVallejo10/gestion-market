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
        <!-- nuevo -->
        <div class="row">
          <div class="col-12">
            <form @submit.prevent="createProduct()" action="#">
              <b-card
              header-tag="header"
              tag="article"
              class="m-3"
              >
                <template #header>
                  <h4 class="mb-0">
                    <b-button v-b-toggle.collapse-1 class="btn btn-info mx-0" size="sm">
                      <i class="fa fa-chevron-circle-down"></i>
                    </b-button> Nuevo Producto
                  </h4>
                </template>
                
                <b-collapse id="collapse-1" class="mt-2">
                  <b-card-text>
                    <div class="row">
                      <div v-for="i in form.inputs" :class="'col-12 col-md-'+i.colSize">
                        <label>${i.label}</label>
                        <b-form-input :required="i.required" :type="i.type" v-model="newProduct[i.key]" placeholder="Buscar" size="sm"></b-form-input><br>
                      </div>
                    </div>
                  </b-card-text>
                  
                  <button class="btn btn-primary" type="submit">Crear</button>
                  <pre v-if="debug"><code>${newProduct}</code></pre>
                </b-collapse>
              </b-card>
            </form>
            
          </div>
          
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
                  </b-button> Tabla Productos
                </h4>
              </template>
              <b-collapse visible id="collapse-2" class="mt-2">

                <b-card-text>
                  <div class="row">
                    <div class="col-6">
                      <b-form-input v-model="table.keyword" placeholder="Buscar" size="sm"></b-form-input><br>
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
                      <input v-model="row.item.precio" type="number" class="btn px-0">
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
      <script>
        let appAdmin = new Vue({
          el: '#appAdmin',
          delimiters: ['${', '}'],
          data: {
            alertMsg: 'Sin mensaje',
            alertColor: 'warning',
            dismissSecs: 10,
            dismissCountDown: 0,
            newProduct: {
              name: 'Manzana', 
              precio: 1000,
            },
            form: {
              inputs: [
                {label: 'Nombre', key: 'name', colSize: '6', placeholder: '', type: 'text', required: true},
                {label: 'Precio', key: 'precio', colSize: '6', placeholder: '', type: 'number', required: true},
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
                    {'key' : 'precio', 'label' : 'PRECIO', 'sortable' : true},
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