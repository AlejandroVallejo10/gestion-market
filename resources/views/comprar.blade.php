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
                  </b-button> Comprar Productos
                </h4>
              </template>
              <b-collapse visible id="collapse-2" class="mt-2">

                <b-card-text>
                <nav class="navbar is-primary">
                      <div class="navbar-brand">
                          <a class="navbar-item" href="/">
                              Carrito de compras
                          </a>

                          <div class="navbar-burger burger">
                              <table>
                                <thead>
                                    <th>Nombre</th>
                                    <th style="left: 70px;position: relative;">Precio</th>
                                    <th></th>
                                </thead>

                                <tbody>
                                    <tr v-for="item in products" :key="item.id">
                                        <td v-text="item.name"></td>

                                        <td style="left: 80px;position: relative;">${ item.cantidad }</td>

                                        <td style="left: 70px;position: relative;" @click="addProduct(item)"> <i style="cursor: pointer;" class="fas fa-cart-plus"></i></td>
                                    </tr>
                                </tbody>
                            </table>
                          </div>
                      </div>

                      <div class="navbar-menu"> 
                          <div class="navbar-end">
                              <div class="navbar-item has-dropdown is-hoverable">
                                  <a class="navbar-link" href="">
                                      Carrito (${cartProducts.length}) 
                                  </a>

                                  <div class="navbar-dropdown is-boxed is-right">
                                      <div v-for="(productSelect, index) in cartProducts">
                                        ${productSelect.name}
                                        <i @click="removeProduct(index)" class="fas fa-times-circle"></i>
                                      </div>


                                      <hr class="navbar-divider">
  
                                      <a class="navbar-item" href="">
                                          Pagar
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </nav>  
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
            cartProducts: [],
            itemsCart: [
                {
                    id: 1,
                    title: 'Children of Bodom - Hatebreeder',
                    price: 9.99
                },
                {
                    id: 2,
                    title: 'Emperor - Anthems to the Welkin at Dusk',
                    price: 6.66
                },
                {
                    id: 3,
                    title: 'Epica - The Quantum Enigma',
                    price: 15.99
                },
                {
                    id: 4,
                    title: 'Chthonic - Takasago Army',
                    price: 14.00
                },
                {
                    id: 5,
                    title: 'Silencer - Death - Pierce Me',
                    price: 1.20
                },
                {
                    id: 6,
                    title: 'My Dying Bride - 34.788%... Complete',
                    price: 10.00
                },
                {
                    id: 7,
                    title: 'Shape of Despair - Shades of',
                    price: 7.80
                },
                {
                    id: 8,
                    title: 'Ne Obliviscaris - Portal of I',
                    price: 11.30
                },
                {
                    id: 9,
                    title: 'Protest the Hero - Fortress',
                    price: 5.55
                },
                {
                    id: 10,
                    title: 'Dark Lunacy - Devoid',
                    price: 6.00
                },
            ],
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
            addProduct(item){
              this.cartProducts.push(item);
              console.log('tem', this.cartProducts)
            },
            removeProduct(index){
              this.cartProducts.splice(index, 1); // devuelve ['dos']
              console.log('remove', index, this.cartProducts)
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