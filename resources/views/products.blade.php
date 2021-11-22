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
                      <input v-model="row.item.cantidad" type="number" class="btn px-0">
                    </template>

                    <template #cell(actions)="row">
                      <b-button size="sm" @click="deleteUser(row.item.id)" variant="danger">
                        ${row.item.id} <i class="fa fa-trash"></i>
                      </b-button>
                      <b-button size="sm" @click="updateUser(row.item)" variant="default">
                          <i class="fa fa-edit"></i>
                      </b-button>
                    </template>
                  </b-table>
                </b-card-text>

                <b-button @click="getUsers" variant="primary">Refrescar datos</b-button>
                <pre v-if="debug"><code>${users}</code></pre>
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
                    {'key' : 'email', 'label' : 'EMAIL', 'sortable' : true},
                    {'key' : 'cedula', 'label' : 'CEDULA', 'sortable' : true},
                    {'key' : 'birthday', 'label' : 'CUMPLEAÑOS', 'sortable' : true},
                    {'key' : 'address', 'label' : 'DIRECCION', 'sortable' : true},
                    {'key' : 'password', 'label' : 'CONTRASENA', 'sortable' : true},
                    {'key' : 'created_at', 'label' : 'CREAD0', 'sortable' : true},
                    {'key' : 'updated_at', 'label' : 'ACTUALIZADO', 'sortable' : true},
                ],
            },
            infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
            },
            debug: true,
            users: [],
          },
          methods:{
            async updateUser(userObj){
              const copyUserData = Object.assign({}, userObj);
              delete copyUserData.created_at
              delete copyUserData.updated_at
              delete copyUserData.email_verified_at
              delete copyUserData.id
              console.log(userObj, copyUserData)
              try {
                let response = await axios.put("{{route('users.index')}}/" + userObj.id, {data: copyUserData}, {headers:{'Content-type': 'application/json'}})
                this.getUsers()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            async deleteUser(userId){
              try {
                let response = await axios.delete("{{route('users.index')}}/" + userId, {}, {headers:{'Content-type': 'application/json'}})
                this.getUsers()
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

                let response = await axios.post("{{route('productos.store')}}", {data: this.newProduct}, {headers:{'Content-type': 'application/json'}})
                this.getUsers()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            async getUsers(){
              let response = await axios.get("{{route('users.index')}}", {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
                console.log(response.data.records)
                this.users = response.data.records
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
                ? this.users.filter(
                  item => 
                    item.name.includes(this.table.keyword) || item.email.includes(this.table.keyword)
                )
                : this.users
            },
          },
          created(){
            this.getUsers()
          },
        })
      </script>
  </x-slot>
</x-admin>