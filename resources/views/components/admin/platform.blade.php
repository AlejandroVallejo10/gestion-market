<x-admin>
  <x-slot name="imgHeader">{{asset('images/header.jpeg')}}</x-slot>
  {{-- <x-slot name="titleHeader">Plataforma</x-slot>
  <x-slot name="parHeader">Smart Reading</x-slot> --}}

  <x-slot name="styleSheets">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>

      #cont1 .iconHead {
        display:inline-block;
      }
      
      #cont1:hover .iconHead {
        animation: slide-bck-bl 0.45s cubic-bezier(0.470, 0.000, 0.745, 0.715) both;
      }
      
      #cont1 .iconHead2 {
        display:inline-block;
      }
      
      #cont1:hover .iconHead2 {
        animation: slide-bck-bl2 0.45s cubic-bezier(0.470, 0.000, 0.745, 0.715) both;
      }
      
      #cont1 .iconHead3 {
        display:inline-block;
      }
      
      #cont1:hover .iconHead3 {
        animation: slide-bck-bl3 1.5s cubic-bezier(0,1.54,.62,.1) both;
      }
      
      
      @keyframes slide-bck-bl {
        0% {
          transform: translateZ(0) translateY(0) translateX(0);
        }
        100% {
          transform: translateZ(-60px) translateY(45px) translateX(-20px);
        }
      }
      
      @keyframes slide-bck-bl2 {
        0% {
          transform: translateZ(0) translateY(0) translateX(0);
        }
        100% {
          transform: translateZ(0px) translateY(0px) translateX(20px);
        }
      }
      
      @keyframes slide-bck-bl3 {
        0% {
          transform: translateZ(0) translateY(0) translateX(0);
        }
        100% {
          transform: translateZ(0px) translateY(0px) translateX(-38vw);
        }
      }
      
      </style>
  </x-slot>

  <x-slot name="content">
    <div id="appAdmin">
      <header @click="animation" class="relative cursor-pointer w-full">
        <div class="flex items-center justify-center px-2 py-2">
          <div class="w-full rounded-lg  p-2 md:p-2 mx-0">
            <div id="cont1" class="text-center">
              <h2 class="text-2xl tracking-tight leading-10 font-extrabold text-gray-900 sm:text-5xl sm:leading-none md:text-5xl">
                <span class="iconHead2">Book</span><span class="iconHead text-indigo-600">aholic</span>
                <img :class="(!showHead?'animate-bounce':'')+' float-right iconHead3'"  :src="iconsHead.iconDef"/>
              </h2>
            </div>
    
            <div v-if="showHead" class="flex flex-wrap mt-10 justify-center">
                <div v-for="(item, index) in socialMedia" class="m-3">
                  <a :href="item.url"
                     :class="`rounded-none w-full px-3 py-2 border hover:shadow-md border-${index % 2 === 0? 'pink':'indigo'}-500 text-${index % 2 === 0? 'pink':'indigo'}-700 font-medium  hover:border-gray-500 hover:text-gray-700 rounded-b-md`">
                    <span class="mx-auto">${item.name}</span>
                  </a>
                </div>
            </div>
          </div>
        </div>
      </header>

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
        <div class="row">
          <div>
            <b-alert show variant="success">
              <h4 class="alert-heading">Esfuerzate un poco más!</h4>
              <p>
                Hasta el momento has acumulado <strong>${wallet? wallet : 0}</strong> puntos
              </p>
              <hr>
              <p class="mb-0">
                Estas a muy poco de desbloquear la siguiente aventura que traerá consigo nuevos retos.
              </p>
            </b-alert>
          </div>
        </div>
        <!-- nuevo -->
        <div class="row">
          <div class="col-12">
            <form @submit.prevent="createUser()" action="#">
              <b-card
              header-tag="header"
              tag="article"
              class="m-3"
              >
                <template #header>
                  <h4 class="mb-0">
                    <button v-b-toggle.collapse-1 :class="'btn btn-sm mx-0 btn-' + (wallet > 20 ? 'success' : 'info')" size="sm">
                      <i :class="'fa fa-'+(wallet > 20 ? 'check' : 'chevron-circle-down')"></i>
                    </button> Una Cena Elegante (clic en la flecha para ver)<br><br>
                    <b-row>
                      <b-col>
                        <audio controls>
                          <source src="{{asset('audios/a1.mp3')}}" type="audio/mp3">
                        Your browser does not support the audio element.
                        </audio>
                      </b-col>
                      <b-col>
                        
                      </b-col>
                      <b-col>
                        
                      </b-col>
                      <b-col>
                        <b-img fluid src="https://www.libreriamateoyleo.cl/wp-content/uploads/2020/06/BN-cena-4-300x300.png" alt="Image 3"></b-img>
                      </b-col>
                      <b-col>
                        <b-img fluid src="{{asset('images/cena3.PNG')}}" alt="Image 3"></b-img>
                      </b-col>
                      <b-col>
                        <b-img fluid src="{{asset('images/cena2.PNG')}}" alt="Image 3"></b-img>
                      </b-col>
                    </b-row>
                  </h4>
                </template>
                
                <b-collapse id="collapse-1" class="mt-2">
                  <b-card-text>
                    <div class="row">
                      
                      <div>
                        <b-jumbotron>
                          <template #header>Los Secretos Del Abuelo Sapo</template>
                      
                          <template #lead>
                            ${text1} 
                            <span :disabled="(keyword[0].disabled) || (keyword[0].time && (new Date()) < keyword[0].time)" v-b-modal.modal-1 :class="'btn btn-sm btn-'+ (keyword[0].disabled ? 'secondary' :  ( (keyword[0].time && (new Date()) < keyword[0].time)? 'warning':'info' )  )">${keyword[0].label}</span>
                             ${text2} <span v-b-modal.modal-2 class="btn btn-sm btn-info">${keyword[1].label}</span> ${text3}
                          </template>
                      
                          <hr class="my-4">
                      
                          <p>
                            Si te encantó esta maravillosa historia puedes obtenerlo <a href="https://librerianacional.com/producto/una-cena-elegante"><b-badge variant="light">aqui</b-badge></a>  con nuestro cupon BOOKAHOLICZSA1.
                          </p>
                        </b-jumbotron>
                      </div>


                    </div>
                  </b-card-text>
                  
                  <pre v-if="debug"><code>${newUser}</code></pre>
                </b-collapse>
              </b-card>
            </form>
            
          </div>
          
        </div>

        <div class="row">
          <div class="col-12">
            <form @submit.prevent="createUser()" action="#">
              <b-card
              header-tag="header"
              tag="article"
              class="m-3"
              >
                <template #header>
                  <h4 class="mb-0">
                    <button v-b-toggle.collapse-1 :class="'btn btn-sm mx-0 btn-' + (wallet > 20 ? 'success' : 'info')" size="sm">
                      <i :class="'fa fa-'+(wallet > 20 ? 'check' : 'chevron-circle-down')"></i>
                    </button> Los Secretos Del Abuelo Sapo (clic en la flecha para ver) <br><br>
                    <b-row>
                      <b-col>
                        <audio controls>
                          <source src="{{asset('audios/a2.mp3')}}" type="audio/mp3">
                        Your browser does not support the audio element.
                        </audio>
                      </b-col>
                      <b-col>
                        
                      </b-col>
                      <b-col>
                        
                      </b-col>
                      <b-col>
                        <b-img fluid src="{{asset('images/sapo3.PNG')}}" alt="Image 3"></b-img>
                      </b-col>
                      <b-col>
                        <b-img fluid src="{{asset('images/sapo2.PNG')}}" alt="Image 3"></b-img>
                      </b-col>
                      <b-col>
                        <b-img fluid src="{{asset('images/sapo1.PNG')}}" alt="Image 3"></b-img>
                      </b-col>
                    </b-row>
                  </h4>
                </template>
                
                <b-collapse id="collapse-1" class="mt-2">
                  <b-card-text>
                    <div class="row">
                      
                      <div>
                        <b-jumbotron>
                          <template #header>Una Cena Elegante</template>
                      
                          <template #lead>
                            ${text1} 
                            <span :disabled="(keyword[0].disabled) || (keyword[0].time && (new Date()) < keyword[0].time)" v-b-modal.modal-1 :class="'btn btn-sm btn-'+ (keyword[0].disabled ? 'secondary' :  ( (keyword[0].time && (new Date()) < keyword[0].time)? 'warning':'info' )  )">${keyword[0].label}</span>
                             ${text2} <span v-b-modal.modal-2 class="btn btn-sm btn-info">${keyword[1].label}</span> ${text3}
                          </template>
                      
                          <hr class="my-4">
                      
                          <p>
                            Si te encantó esta maravillosa historia puedes obtenerlo <a href="https://librerianacional.com/producto/una-cena-elegante"><b-badge variant="light">aqui</b-badge></a>  con nuestro cupon BOOKAHOLICZSA1.
                          </p>
                        </b-jumbotron>
                      </div>


                    </div>
                  </b-card-text>
                  
                  <pre v-if="debug"><code>${newUser}</code></pre>
                </b-collapse>
              </b-card>
            </form>
            
          </div>
          
        </div>
        <!-- tabla -->
        {{-- <div class="row">
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
                  </b-button> Tabla Tiendas
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
                    <template #cell(admin)="row">
                      <input v-model="row.item.admin" type="text" class="btn px-0">
                    </template>
                    <template #cell(phone)="row">
                      <input v-model="row.item.phone" type="number" class="btn px-0">
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
          
        </div> --}}
        <b-modal id="modal-1" title="Madriguera" hide-footer>
          <b-alert show variant="info">
            Una madriguera se trata del espacio físico, normalmente enterrado o escondido, donde un animal crea su hogar. Es una especie de cueva, donde estos seres vivos dejan sus crías y sus alimentos.
          </b-alert>
          <template>
            <div>
              <b-form-group label="Selecciona en que contexto utilizarías esta palabra" v-slot="{ ariaDescribedby }">
                <b-form-radio v-model="selectedx" :aria-describedby="ariaDescribedby" name="some-radios" value="A">Los conejos necesitaban un nido y construyeron una madriguera</b-form-radio>
                <b-form-radio v-model="selectedx" :aria-describedby="ariaDescribedby" name="some-radios" value="B">El lobo cenó una deliciosa madriguera</b-form-radio>
              </b-form-group><br><br><br>
              <label for="rating-inline">Califica esta pregunta</label>
              <b-form-rating id="rating-inline" inline value="4"></b-form-rating>
            </div>
          </template>
          <b-button size="sm" variant="primary" block @click="validaResp(0);$bvModal.hide('modal-1')">Guardar</b-button>
        </b-modal>

        <b-modal id="modal-2" title="Ávido" hide-footer>
          <b-alert show variant="info">
            Codicioso y ansioso, con un fuerte e intenso deseo de tener, hacer o conseguir algo.
          </b-alert>
          <template>
            <div>
              <b-form-group label="Selecciona en que contexto utilizarías esta palabra" v-slot="{ ariaDescribedby }">
                <b-form-radio v-model="selectedx" :aria-describedby="ariaDescribedby" name="some-radios" value="A">Con todo, no tardó en oírse el ávido y crepitante rugir del fuego</b-form-radio>
                <b-form-radio v-model="selectedx" :aria-describedby="ariaDescribedby" name="some-radios" value="B">El elefante se comio un ávido en el bosque Africano.</b-form-radio>
              </b-form-group><br><br><br>
              <label for="rating-inline">Califica esta pregunta</label>
              <b-form-rating id="rating-inline" inline value="4"></b-form-rating>
            </div>
          </template>
          <b-button size="sm" variant="primary" block @click="validaResp(1)">Guardar</b-button>
        </b-modal>
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
            wallet: localStorage.getItem('wallet'),
            socialMedia : [{name:'Home',url:'/'},{name:'Facebook',url:'#'},{name:'Instagram',url:'#'},{name:'Youtube',url:'#'}],
            iconsHead: {
              iconDef: 'https://img.icons8.com/nolan/64/knowledge-sharing.png',
              icon1:'https://img.icons8.com/nolan/64/knowledge-sharing.png',
              icon2:'https://img.icons8.com/nolan/64/mind-map.png'
            },
            showHead: false,

            selectedx: null ,
            text1: "La",
            text2: "de Tejón estaba llena de comida, pero él no estaba contento. -Manzanas, lombrices y raíces ... lo mismo de siempre -suspiró-. Quisiera comerme una cena elegante para variar. \nEntonces Tejón salió de su madriguera a rastras y se puso",
            text3: "a buscar su cena elegante. Muy pronto Tejón espió un topo que pasaba caminando. Mmm . . .  , pensó. ¿Qué tal un taco de topo con salsa picante? ¡Eso sí que sería una cena elegante!\n Se lanzó a agarrar el topo, pero este era demasiado escurridizo y resbala que se resbaló de las manos de Tejón. Luego se escabulló lo más rápido que pudo ... ",
            keyword: [{label: 'madriguera',disabled: false, time: null}, {label: 'ávido',disabled: false, time: null}],
            alertMsg: 'Sin mensaje',
            alertColor: 'warning',
            dismissSecs: 10,
            dismissCountDown: 0,
            newUser: {
              admin: 'Admin Tienda', 
              phone: 1234
            },
            form: {
              inputs: [
                {label: 'Nombre', key: 'name', colSize: '6', placeholder: '', type: 'text', required: true},
                {label: 'Administrador', key: 'admin', colSize: '6', placeholder: '', type: 'text', required: true},
                {label: 'Telefono', key: 'phone', colSize: '6', placeholder: '', type: 'number', required: true},
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
                    {'key' : 'admin', 'label' : 'ADMIN', 'sortable' : true},
                    {'key' : 'phone', 'label' : 'TELEFONO', 'sortable' : true},
                    {'key' : 'created_at', 'label' : 'CREAD0', 'sortable' : true},
                    {'key' : 'updated_at', 'label' : 'ACTUALIZADO', 'sortable' : true},
                ],
            },
            infoModal: {
                id: 'info-modal',
                title: '',
                content: ''
            },
            debug: false,
            users: [],
          },
          methods:{
            animation() {
              this.showHead = !(this.showHead)
              this.showHead? this.iconsHead.iconDef = this.iconsHead.icon2: this.iconsHead.iconDef = this.iconsHead.icon1
            },
            validaResp(keywordindex){
              if(this.selectedx == 'A'){
                let wallet =  localStorage.getItem('wallet') ? localStorage.getItem('wallet') : 0
                localStorage.setItem('wallet', parseInt(wallet)+10)
                this.keyword[keywordindex].disabled = true
                this.showAlert('Felicidades... has sumado 10 puntos', 'success')
              } else {
                this.keyword[keywordindex].time = new Date((new Date().getTime()) + 1*60000)
                this.showAlert('Tu respuesta es incorrecta', 'danger')
              }
            },
            async updateUser(userObj){
              const copyUserData = Object.assign({}, userObj);
              delete copyUserData.created_at
              delete copyUserData.updated_at
              delete copyUserData.email_verified_at
              delete copyUserData.id
              console.log(userObj, copyUserData)
              try {
                let response = await axios.put("{{route('stores.index')}}/" + userObj.id, {data: copyUserData}, {headers:{'Content-type': 'application/json'}})
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
                let response = await axios.delete("{{route('stores.index')}}/" + userId, {}, {headers:{'Content-type': 'application/json'}})
                this.getUsers()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              }
            },
            async createUser(){
              /* try {
                let response = await axios.post("{{route('stores.store')}}", {data: this.newUser}, {headers:{'Content-type': 'application/json'}})
                this.getUsers()
                this.showAlert(response.data.message, 'success')
              } catch(error) {
                console.log(error.response.status)
                400 === error.response.status ?
                  this.showAlert(error.response.data.message, 'danger') :
                  this.showAlert('Upss algo salió mal, comunicate con el administrador', 'danger')
              } */
            },
            async getUsers(){
              let response = await axios.get("{{route('stores.index')}}", {}, {headers:{'Content-type': 'application/json'}})
              if(200 === response.status){
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