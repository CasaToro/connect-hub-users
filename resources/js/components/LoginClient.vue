<template>
<div class="container">
  <div class="row justify-content-center">
  <div class="col-md-8">
      <form @submit.prevent="login" method="post">
        <div class="card">
            <div class="card-header">Login</div>
            <div class="card-body">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">Correo Electrónico</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" v-model='element.email' required autocomplete="email" autofocus>
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Contraseña</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" v-model='element.password' required autocomplete="current-password">
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">
                      Recordarme
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                      Iniciar Sesión
                  </button>
                </div>
              </div>
            </div>
        </div>
      </form>
    </div>
  </div>
</div>
</template>

<script>
    export default {
        data(){
            return {
              element:{}
            }
        },
        mounted() {
            console.log('Component mounted.')
            this.element=this.elementInitialState();

        },

        methods:{
          elementInitialState(){
            return {
                email:'',
                password:'',
                service_key:'89381452d9d4c001cf04bbacb631dc6a',
                profile_key:'78c4f9b117bcbfce15434b2327c5ec4c'
            }
          },
          login(){
            axios.post('/login-client',
              this.element,
              {'headers': {
                'Content-type': 'application/json',
              }  
            }

            ).then(response => {
    
              if(response.data.status=="OK"){
                var token = response.data.data.access_token
                var type = response.data.data.token_type
                var service_key = this.element.service_key
                var profile_key = this.element.profile_key
                localStorage.setItem('access_token', token)
                localStorage.setItem('token_type', type)
                localStorage.setItem('service_key', service_key)
                localStorage.setItem('profile_key', profile_key)
                window.location.href ="/home-hub";
              }
                
            }).catch(error => {
                this._errorProccessor(error);
            });
          }
        }  
    };
</script>