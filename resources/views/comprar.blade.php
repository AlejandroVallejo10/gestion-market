<x-admin>
  <x-slot name="imgHeader">{{asset('images/header.jpeg')}}</x-slot>
  <x-slot  name="titleHeader">Administrador</x-slot>
  <x-slot  name="parHeader">Market Gestion</x-slot>

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
                          <h5>Sucursales</h5>
                          <v-select
                          style="top: -30px;"
                            :options="stores" 
                            label="admin"
                            @input="storeSelect"
                          ></v-select>
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

                                        <td style="left: 70px;position: relative;">${ item.precio }</td>

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
                                        ${productSelect.name}  ${ productSelect.precio }
                                        <i @click="removeProduct(productSelect, index)" class="fas fa-times-circle"></i>
                                      </div>


                                      <hr class="navbar-divider">
  
                                      <a type="button" @click="pagar()" class="navbar-item">
                                          Pagar
                                      </a>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </nav>  
                </b-card-text>
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
      <script>
        Vue.component("v-select", VueSelect.VueSelect);
        let appAdmin = new Vue({
          el: '#appAdmin',
          delimiters: ['${', '}'],
          data: {
            alertMsg: 'Sin mensaje',
            alertColor: 'warning',
            dismissSecs: 10,
            dismissCountDown: 0,
            stores: [],
            warehouses: [],
            cartProducts: [],
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
            products: []
          },
          methods:{
            async getStores(){
              let response = await axios.get("{{route('stores.index')}}", {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
                this.stores = response.data.records
                console.log(response.data)
              }else{console.log(response.error)}
            },
            async getWarehouse(id){
              let response = await axios.get("{{route('warehouses.index')}}?filter=store_id&valuefilter=" + id, {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
                this.warehouses = response.data.records
                for (var productId of this.warehouses) {
                    let response = await axios.get("{{route('products.index')}}?filter=id&valuefilter=" + productId['product_id'], {}, {headers:{'Content-type': 'application/json'}})
                    console.log(response.data.records[0])
                    if(response.data.records){
                      response.data.records[0]['cantidad'] = productId['quantity']
                      this.products.push(response.data.records[0])
                    }
                }
                console.log(this.products)
              }else{console.log(response.error)}
            },
            addProduct(item){
              if(this.cartProducts.includes(item)){
                let ProductosActuales = this.cartProducts;
                for (var product of this.cartProducts) {
                    console.log('product', item,  ProductosActuales);
                    if (product == item) {
                      if(product['cantidad'] == 0){
                        alert("El producto no tiene mas cantidades para agregar")
                      }else{
                        product['cantidad'] = product['cantidad'] - 1
                        product['precio'] = product['precio'] * 2
                      }
                    }
                  }
                  this.cartProducts = ProductosActuales;
              }else{
                item['cantidad'] = item['cantidad'] - 1
                this.cartProducts.push(item);
                console.log(this.cartProducts)
              }
            },
            async removeProduct(item, index){
              let response = await axios.get("{{route('warehouses.index')}}?filter=product_id&valuefilter=" + item['id'], {}, {headers:{'Content-type': 'application/json'}})
              console.log('response', response)
              item['cantidad'] = response.data.records[0]['quantity']
              this.cartProducts.splice(index, 1);
            },
            pagar(){
              let total = 0
              for (var product of this.cartProducts) {
                total = total + product['precio']
              }
              console.log(this.cartProducts, total, this.warehouses);
            },
            countDownChanged(dismissCountDown) {
              this.dismissCountDown = dismissCountDown
            },
            showAlert(msg = 'No hay mensaje',alertColor = 'default') {
              this.alertColor = alertColor
              this.alertMsg = msg
              this.dismissCountDown = this.dismissSecs
            },
            storeSelect(event) {
              console.log(event, 'event')
              this.getWarehouse(event['id']);
            }
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
            this.getStores()
          },
        })
      </script>
  </x-slot>
</x-admin>