<template>
  <div>
        <div class="mt-2" v-if="this.errorArray.length > 0">
            <ErrorComponent v-bind:errors = "this.errorArray"/>
        </div>
      <form action="" @submit.prevent="uploadSettings()">
          <div class="form-group">
            <label style="color:black" for="name">Shop name</label>
            <input type="text" v-model="data.name" class="form-control">
          </div>
          <div class="form-group">
            <label style="color:black" for="address">Shop address</label>
            <textarea v-model="data.address" id="" cols="30" rows="4" class="form-control" placeholder="Address,Local-Govt,State"></textarea>
          </div>
          <div class="form-group">
            <label style="color:black" for="photo">Background photo</label>
            <input type="file" @change="OnChangeFile($event)" style="border:none" class="form-control">
          </div>
          <BlockButtonBlue>Upload</BlockButtonBlue>
      </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data(){
    return {
      data: {
        name: '',
        address: '',
        photo: '',
        token: '',
      },
      url:'',
      output: '',
      errorArray: [],
      temp_errors: []
    }
  },
  methods: {
    OnChangeFile(e){
            var fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) => {
                this.data.photo = e.target.result;
          }
      },
    uploadSettings(){
      this.token = localStorage.getItem('token');
      this.errorArray = [];
      this.temp_errors = [];
      this.url = 'http://127.0.0.1:8000/api/vendor_settings';
            let config = {
              headers:{
                'Authorization': "Bearer "+this.token,
                    // "content-type": "multipart/form-data"
                }
            }
      axios.post(this.url,this.data,config)
      .then(res => {
        this.$noty.success(res.data.message);
        this.$emit('profile_updated');
      }).catch(err => {
        this.temp_errors.push(err.response.data.error);
                this.temp_errors.forEach(element => {

                    // this.errorArray.push(value);
                        if(element.name){
                            this.errorArray.push(element.name[0]);
                        }
                        if(element.address){
                            this.errorArray.push(element.address[0]);
                        }
                });
      });
    },
    fetchVendorSettings(){
      this.url = 'http://127.0.0.1:8000/api/vendor_settings'
      this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token,
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.data.name = res.settings.store_name? res.settings.store_name:'';
                this.data.address = res.settings.address? res.settings.address:'';
            }).catch(err => {
                console.log(err)
            });
    }
  },
  mounted(){
    this.fetchVendorSettings();
  }
}
</script>

<style>

</style>