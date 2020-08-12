<template>
 <!-- sidebar-user-header  -->
 <div>
   <div >
    <span><b v-text="profile.name"></b></span>
    <ul class="list-unstyled components">
      <li v-for="module in profile.available_modules" v-text="module.name"></span></li>
    </ul>
   </div> 
</div>
</template>

<script>
  export default {
    data(){
        return {
          profile:{},
          access:{}
        }
    },
    mounted() {
        this.access=this.getAccessData();
        this.dataProfile();
    },
    methods:{
      
      getAccessData(){
        return {
            access_token:localStorage.access_token,
            token_type:localStorage.token_type,
            service_key:localStorage.service_key,
            profile_key:localStorage.profile_key
        }
      },
      dataProfile(){
        axios.post('/data-profiles',
          this.access,
          {'headers': {
            'Content-type': 'application/json',
          }  
        }

        ).then(response => {

          if(response.data.status=="OK"){
             this.profile=response.data.data.user.profiles;
          }
            
        }).catch(error => {
            this._errorProccessor(error);
        });
      }
    }  
  };
</script>