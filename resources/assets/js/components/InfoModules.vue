<template>
 <!-- sidebar-user-header  -->
 <div>
   <div v-for="profile in profiles">
    <p v-text="profile.name"></p>
    <ul class="list-unstyled components">
      <li v-for="module in profile.modules" v-text="module.name"></span></li>
    </ul>
   </div> 
</div>
</template>

<script>
  export default {
    data(){
        return {
          profiles:{},
          access:{}
        }
    },
    mounted() {
        this.access=this.getAccessData();
        this.dataUser();
    },
    methods:{
      
      getAccessData(){
        return {
            access_token:localStorage.access_token,
            token_type:localStorage.token_type,
            service_key:'a5d9d5be53215977ee26b6207f7be6bc'
        }
      },
      dataUser(){
        axios.post('/data-profiles',
          this.access,
          {'headers': {
            'Content-type': 'application/json',
          }  
        }

        ).then(response => {

          if(response.data.status=="OK"){
             this.profiles=response.data.data;
          }
            
        }).catch(error => {
            this._errorProccessor(error);
        });
      }
    }  
  };
</script>