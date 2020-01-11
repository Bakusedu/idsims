<template>
  <div>
      <div style="box-shadow: 0 0 5px 1px #d2cccc;padding:20px;overflow:scroll">
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Name</p>
            <p style="color:black;width:40%">{{ profile.name }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Email</p>
            <p style="color:black;width:40%">{{ profile.email }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Address</p>
            <p v-if="profile.address" style="color:black;width:40%">{{ profile.address }}</p>
            <p v-else style="color:black;width:40%">Nil</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Phone number</p>
            <p style="color:black;width:40%">{{ profile.phone }}</p>
        </div>
        <div class="d-flex" style="justify-content:space-between">
            <p style="color:black;width:40%">Age</p>
            <p style="color:black;width:40%">{{ profile.age }}</p>
        </div>
      </div>
  </div>
</template>

<script>
import UpdateUserEvent from './UpdateUserEvent';
export default {
    data(){
        return {
            profile: {
                name: '',
                email: '',
                address: '',
                phone: '',
                age: ''
            }
        }
    },
    props:['user','updated_user'],
    mounted(){
        this.profile = this.user;
    },
    created(){
        UpdateUserEvent.$on('updated',(value) => {
            this.profile.name = value.name;
            this.profile.email = value.email;
            this.profile.address = value.address;
            this.profile.phone = value.phone;
        })
    }
}
</script>

<style>
    .d-flex p {
        font-size:14px;
    }
</style>