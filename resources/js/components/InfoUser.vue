<template>
  <div class="sidebar-user-header">
      <div class="user-pic">
        <img class="img-fluid img-rounded" src="https://raw.githubusercontent.com/azouaoui-med/pro-sidebar-template/gh-pages/src/img/user.jpg"
          alt="User picture">
      </div>
      <div class="user-info">
        <span class="user-name" v-text="user.name"></span>
        <span class="user-status" v-text="user.email"></span>
        <span class="user-status">
          <i class="fa fa-circle"></i>
          <span>Online</span>
        </span>
      </div>
  </div>
</template>

<script>
  export default {
    data(){
        return {
          user:{},
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
            service_key:localStorage.service_key
        }
      },
      dataUser(){
        axios.post('/data-user',
          this.access,
          {'headers': {
            'Content-type': 'application/json',
          }  
        }

        ).then(response => {
          if(response.statusText=="OK"){
             this.user=response.data.user
          }
            
        }).catch(error => {
            this._errorProccessor(error);
        });
      }
    }  
  };
</script>