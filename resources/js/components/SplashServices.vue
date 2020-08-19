<template>
<div class="collapse navbar-collapse " id="navbarSupportedContent">
    <ul class="nav navbar-nav ml-auto">
      <li class="nav-item active">
          <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
          <i class="fa fa-th" style="font-size: 22px"></i>
          <input type="hidden">
      </a>
      <div class="dropdown-menu dropdown-menu-right col-md-4" style="height:400px; overflow:auto" aria-labelledby="navbarDropdown">
       <div class="row col-md-12">  
        <div v-for="service in services" class="card bg-light mb-3 col-md-6 ">
          <div class="card-header" v-text="service.name" ></div>
            <div class="card-body align-self-center">
            <div class="row col-md-12 justify-content-center">
                <h4 style="font-size: 50px"><i class="fas fa-briefcase"></i></h4>
            </div>
            <div class="row col-md-12">  
              <div class="btn-group">
                <div class="dropdown-submenu">
                  <template v-if="service.profiles">    
                    <template v-if="service.profiles.length > 1">
                       <a class="btn btn-primary btn-white dropdown-toggle" v-bind:id="'dropdownMenuLink-'+service.id" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Ingresar</a>
                        <div class="dropdown-menu" v-bind:aria-labelledby="'dropdownMenuLink-'+service.id" x-placement="bottom-start"> 
                          <template v-for="profile in service.profiles">
                            <a class="dropdown-item" v-bind:href="service.url+profile.slug+'?api_token='+hubssk+'&profile='+profile.key" target="_blank" v-text="profile.name"></a>
                          </template>
                        </div>
                    </template>
                    <template v-else>
                      <template v-for="profile in service.profiles">
                        <a v-bind:href="service.url+profile.slug+'?api_token='+hubssk+'&profile='+profile.key" target="_blank"><input type="button" class="btn btn-primary" value="Ingresar"></a>
                       </template> 
                    </template>            
                  </template>  
                  <template v-else>
                    <a href="#"><input type="button" class="btn btn-primary" value="Adquirir servicio"></a>
                  </template>     
                </div>
              </div>
            </div>            
         </div>
        </div>
      </div>
     </div>
    </li>
  </ul> 
</div>   
</template>
<script>
  var hubssk = $("#hubssk").val(); 
  export default { 
    
    data(){
        return{
          hubssk:hubssk,
          services:[]
        }
    },
    mounted() {
       this.dataUser()
      
    },
    methods:{
  
      dataUser(){
        axios.get('/hub-users-info',
          this.access,
          {'headers': {
            'Content-type': 'application/json',
          }  
        }
        ).then(response => {
          console.log(response.data)
          if(response.data.status=="OK"){
             this.services=response.data.data.services
          }
        }).catch(error => {
            this._errorProccessor(error)
        });
      },
    } 
  };  
</script>