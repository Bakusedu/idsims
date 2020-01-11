<template>
    <div>
        <transition name="fade">
            <div v-if="signup" class="wrapper">
                    <div style="box-shadow: 0 0 5px 1px #d2cccc" class="form">
                        <form @submit.prevent="register">
                            <div class="form-header">
                                <h4 id="form-header">Sign up</h4>
                                <p  @click="signupClose" id="form-p">&times;</p>
                            </div>
                            <div v-if="this.errorArray.length > 0">
                                <ErrorComponent v-bind:errors = "this.errorArray"/>
                            </div>
                            <div v-if="this.output">
                                <div class="success">
                                    <SuccessComponent v-bind:message = "this.output" />
                                </div>
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
                            <div style="margin-left: 6px;" class="form-check">
                                <input type="checkbox" v-model="vendor" class="form-check-input">
                                <label class="form-check-label" for=""><h6 style="color:black">Click to signup as an OTC Vendor</h6></label>
                            </div>
                            <div>
                                <button @click="register" class="btn-blue">
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
        </transition>
        <transition name="fade">
            <div v-if="login" class="wrapper">
                    <div style="box-shadow: 0 0 5px 1px #d2cccc" class="form">
                        <form @submit.prevent="loginQuery">
                            <div class="form-header">
                                <h4 id="form-header">Login</h4>
                                <p  @click="loginClose" id="form-p">&times;</p>
                            </div>
                            <div v-if="this.errorArray.length > 0">
                                <ErrorComponent v-bind:errors = "this.errorArray"/>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" v-model="dataLogin.email" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" v-model="dataLogin.password" class="form-control">
                            </div>
                            <div>
                                <button @click="loginQuery" class="btn-blue">
                                    <div v-if="isLoading_login" class="spinner-border" style="height:1.3rem;width:1.3rem" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    <div v-else>
                                        Login
                                    </div>
                                </button>
                            </div>
                            <div style="margin-top:10px;">
                                <img src="../images/login.png" style="border-radius:5px" class="img-fluid" alt="">
                            </div>
                        </form>
                    </div>
            </div>
        </transition>
            <AppHeader v-bind:name="this.auth_user_name" v-on:form="displayForm($event)"></AppHeader>
            <div :class="[form ? 'blur' : '']">
            <main>
                <section style="width:39%;margin-right:2%">
                    <div>
                        <p style="font-size:30px">
                            IDSIMS helps to cater for your
                            over-the-counter drug information
                            keeping your purchase history on 
                            drugs that matter the most to your
                            health.
                        </p>
                        <p class="btn-green">
                            <router-link style="text-decoration:none;color:white" to="#">Learn more</router-link>
                        </p>
                    </div>
                </section>
                <section style="width:59%">
                    <div>
                        <img src="../images/home-drugs.jpeg" style="border-radius:10px" height="60%" width="100%" alt="">
                    </div>
                </section>
            </main>
            <AppFooter></AppFooter>
        </div>
    </div>
</template>
<style scoped>
    #bgColor {
        background-color : #2770c2;
    }
    #container {
        padding-top: 20px;
        padding-left: 50px;
        padding-right: 50px;
        min-height: 100vh;
        box-sizing: border-box;
    }
    main {
        margin-top:20px;
        width:100%;
        display: flex;
        justify-content: space-between;
    }
    .btn-green {
        width: 90%;
        background-color: #08B577;
        text-align: center;
        padding: 10px;
        border-radius: 5px;
        margin-top: 10px;
    }
    .btn-blue {
        background-color:#2770c2;
        width:100%;
        border: none;
        padding: 5px;
        border-radius: 5px;
        outline: none;
    }
    .wrapper {
        display:flex;
        justify-content: center;
        width: 100%;
        min-height: 100vh;
        position: absolute;
        z-index:1
    }
    .form {
        background-color: white;
        align-self: center;
        width: 30%;
        position: absolute;
        border-radius:5px;
    }
    form {
        padding:20px;
    }
    .form-group {
        margin-bottom:0px;
        padding:5px;
    }
    .form-group label {
        color:black;
        margin:0px;
    }
    form .form-header{
        display:flex;
        justify-content: space-between;
        padding:5px;
    }
    #form-header, #form-p {
        color:black;
        margin-bottom: 0px;
    } 
    #form-p {
        font-size:1.5em;
        cursor:pointer;
    }
    .blur {
        filter:blur(5px);
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
    .slide-fade-enter-active {
        transition: all .7s ease;
    }
    .slide-fade-leave-active {
        transition: all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0);
    }
    .slide-fade-enter, .slide-fade-leave-to
    /* .slide-fade-leave-active below version 2.1.8 */ {
        transform: translateX(100px);
        opacity: 0;
    }
</style>
<script>
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
import axios from 'axios';
    export default {
        data(){
            return {
                signup: false,
                data: {
                    age:'',
                    phone: '',
                    password: '',
                    password_confirmation: '',
                    email: '',
                    name: ''
                },
                dataLogin : {
                    email: '',
                    password: '',
                },
                vendor: '',
                url: '',
                output: '',
                form: false,
                temp_errors: [],
                errorArray: [],
                login: false,
                isLoading_login: false,
                isLoading_signup: false,
                auth_user_name: ''
            }
        },
        methods : {
            displayForm(payload){
                if(payload === 'signup'){
                    this.signup = true;
                    this.form = true;
                }
                else{
                    this.login = true;
                    this.form = true;
                }
            },
            signupClose(){
                this.signup = false;
                this.errorArray = [];
                this.output = '';
                this.data.name = '';
                this.data.email = '';
                this.data.password = '';
                this.data.password_confirmation = '';
                this.data.phone = '';
                this.data.age = '';
                this.form = false;
                this.output = '';
                this.isLoading_signup = false;
            },
            loginClose(){
                this.login = false;
                this.form = false;
                this.isLoading_login = false;
                this.errorArray = [];
            },
            register() {
                // signup new user
                // check if the user is a vendor
                this.url = this.vendor ? 'http://127.0.0.1:8000/api/vendor' : 'http://127.0.0.1:8000/api/customer';
                this.isLoading_signup = true;
                this.errorArray = [];
                this.temp_errors = [];
                axios.post(this.url,this.data)
                .then(res => {
                    this.output = res.data.message;
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
                    this.url = false;
                }) 
            },
            loginQuery(){
                // log the user in
                this.output = '';
                this.errorArray = [];
                this.url = 'http://127.0.0.1:8000/api/login';
                this.isLoading_login = true;
                axios.post(this.url,this.dataLogin)
                .then(res => {
                    localStorage.setItem('token',res.data.token);
                    this.isLoading_login = false;
                    this.$router.push('/dashboard');
                    // location.reload();
                    this.$noty.info('Logged in successfully');
                }).catch(err => {
                    this.errorArray.push(err.response.data.error); 
                    this.isLoading_login = false;
                })
            },
            fetchAuthUser(){
                if(localStorage.getItem('token')){
                    fetch('http://127.0.0.1:8000/api/user',config)
                     .then(res => res.json())
                     .then(res => {
                         this.auth_user_name = res.name;
                     }) 
                }
            }
        },
        created(){
            this.fetchAuthUser();
        }
    }
</script>
