<template>
  <div>
      <div class="form">
            <form @submit.prevent="register()">
                <div>
                    <h4 style="color:black"><i class="fa fa-user-plus" style="color:black"></i> Sign up new customer</h4>
                </div>
                <div v-if="this.errorArray.length > 0">
                    <ErrorComponent v-bind:errors = "this.errorArray"/>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" v-model="data.name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" v-model="data.email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" v-model="data.password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="password">Confirm password</label>
                    <input type="password" v-model="data.password_confirmation" class="form-control">
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="text" v-model="data.phone" class="form-control">
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" v-model="data.age" class="form-control">
                </div>
                <div>
                    <button class="btn-blue">
                        <div v-if="isLoading_signup" class="spinner-border" style="height:1.3rem;width:1.3rem" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <div v-else>
                            Submit
                        </div>
                    </button>
                </div>
            </form>
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return {
            errorArray:[],
            url:'',
            data: {
                    age:'',
                    phone: '',
                    password: '',
                    password_confirmation: '',
                    email: '',
                    name: ''
            },
            isLoading_signup:false,
        }
    },
    methods: {
            register() {
                        // signup new user
                        // check if the user is a vendor
                        this.url = 'http://127.0.0.1:8000/api/customer';
                        this.isLoading_signup = true;
                        this.errorArray = [];
                        this.temp_errors = [];
                        axios.post(this.url,this.data)
                        .then(res => {
                            this.$noty.success(res.data.message);
                            this.isLoading_signup = false;
                        }).catch(err => {
                            this.temp_errors.push(err.response.data.error);
                            this.temp_errors.forEach(element => {
                                // this.errorArray.push(value);
                                if(element.name){
                                    this.errorArray.push(element.name[0]);
                                }
                                if(element.email){
                                    this.errorArray.push(element.email[0]);
                                }
                                if(element.password){
                                    this.errorArray.push(element.password[0]);
                                }
                                if(element.phone){
                                    this.errorArray.push(element.phone[0]);
                                }
                                if(element.age){
                                    this.errorArray.push(element.age[0]);
                                }
                            });
                            this.isLoading_signup = false;
                            this.url = '';
                        }) 
                    }

    },
}
</script>

<style scoped>
    .form {
        height: 50vh;
        overflow-y: scroll;
    }
</style>