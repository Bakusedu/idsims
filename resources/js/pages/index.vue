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
                            <div style="margin-top:10px;" class="text-center">
                                <img src="../images/unlock.png" style="width:50%" alt="">
                            </div>
                        </form>
                    </div>
            </div>
        </transition>
            <AppHeader v-bind:name="this.auth_user_name" v-on:form="displayForm($event)"></AppHeader>
            <div :class="[form ? 'blur' : '']">
            <main class="main-content">
                <!-- <section style="width:39%;margin-right:2%">
                    <div>
                        <p style="font-size:30px">
                            IDSIMS helps to cater for your
                            over-the-counter drug information
                            keeping your purchase history on 
                            drugs that matter the most to your
                            health.
                        </p>
                    </div>
                </section> -->
                    <div class="text-center" style="position:relative;height:358px">
                        <div>
                            <img src="../images/doctor.png" style="height:50%;width:25%" alt="">
                        </div>
                        <p class="featured-text-1">
                            IDSIMS helps you manage everything about your over-the-counter medications,<br>
                            check up your desired OTC medecine information from our registered vendors before going to purchase.
                        </p>
                    </div>
                    <div style="position:relative;height:358px">
                        <div>
                            <img src="../images/fitness.png" style="height:50%;width:25%" alt="">
                        </div>
                        <p class="featured-text-2">
                            IDSIMS gives you the assurance that you are taking the right OTC drugs<br>
                            for the right reasons....
                        </p>
                    </div>
                    <h2 style="color:black;font-weight:bolder" class="text-center">Our Vendors</h2>
                    <transition name="fade">
                        <div style="position:relative">
                            <div class="brick viewDrug" v-if="displayDrug">
                                <div style="padding:25px">
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Photo</p>
                                        <p style="color:black;width:40%">
                                            <img :src="'http://127.0.0.1:8000/images/'+drugDetails.photo" class="img-fluid" style="height:250px; border-radius:20px" alt="">
                                        </p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Company</p>
                                        <p style="color:black;width:40%">{{ drugDetails.company }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Price</p>
                                        <p style="color:black;width:40%">&#8358; {{ drugDetails.price }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Drug type</p>
                                        <p v-if="drugDetails.drug_type === 1" style="color:black;width:40%">Satchet</p>
                                        <p v-if="drugDetails.drug_type === 2" style="color:black;width:40%">Counting</p>
                                        <p v-if="drugDetails.drug_type === 3" style="color:black;width:40%">Syrup</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Quantity in stock</p>
                                        <p style="color:black;width:40%">{{ drugDetails.qty }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Active ingredients</p>
                                        <p style="color:black;width:40%">{{ drugDetails.active_ingredients }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Drug effects</p>
                                        <p style="color:black;width:40%">{{ drugDetails.effects }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Cures</p>
                                        <p style="color:black;width:40%">{{ drugDetails.cure }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Drug interaction</p>
                                        <p style="color:black;width:40%">{{ drugDetails.interaction }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Overdose</p>
                                        <p style="color:black;width:40%">{{ drugDetails.overdose }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Dosage</p>
                                        <p style="color:black;width:40%">{{ drugDetails.dosage }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Note</p>
                                        <p style="color:black;width:40%">{{ drugDetails.note }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Hcpi</p>
                                        <p v-if="drugDetails.hcpi === 5" style="background-color:#e15361;text-align:center;width:40%;border-radius:20px">High</p>
                                        <p v-if="drugDetails.hcpi === 2" style="background-color:#ffc20d;text-align:center;width:40%;border-radius:20px">Moderate</p>
                                        <p v-if="drugDetails.hcpi === 0" style="background-color:#7d858c;text-align:center;width:40%;border-radius:20px">Low</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Nafdac reg no</p>
                                        <p style="color:black;width:40%">{{ drugDetails.nafdac }}</p>
                                    </div>
                                    <div class="d-flex" style="justify-content:space-between">
                                        <p style="color:black;width:40%">Expiry date</p>
                                        <p style="color:black;width:40%">{{ drugDetails.expiry_date }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </transition>
                    <div class="all-vendors">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <div class="brick mt-2 col-md-3" v-for="(vendor) in vendors" :key="vendor.index">
                                    <div class="image">
                                        <img  v-if="vendor.picture" :src="'http://127.0.0.1:8000/images/'+vendor.picture" alt="" class="img-fluid">
                                        <img v-else src="images/login.png" alt="" class="img-fluid">
                                    </div>
                                    <div class="vendor_info">
                                        <h5 style="color:black;font-weight:bold">{{ vendor.store_name }}</h5>
                                        <p style="color:black">{{ vendor.address }}</p>
                                        <button type="button" @click="enter(vendor.store_id)" class="btn btn-outline-secondary btn-block">Enter shop</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div v-if="display">
                                <div style="height:30vh;padding-top:40px" v-if="spinner">
                                    <div class="spinner-position spinner-border text-primary" style="height:3rem;width:3rem;" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="drugOpen" style="height:30vh;overflow-y:scroll">
                                        <div class="text-center mb-2">
                                            <span @click="closeDrugs()" class="btn btn-danger">
                                                <i style="color:white;font-size:25px" class="fa fa-times"></i>
                                            </span>
                                        </div>
                                        <div v-if="drugOpen">
                                            <div v-for="(drug) in drugs" v-bind:key="drug.index" class="card mb-1" style="width: 100%;overflow-y:scroll">
                                                <div class="card-body">
                                                    <div style="display:flex;justify-content:space-between">
                                                        <p style="color:black" class="card-title">{{ drug.name }}</p>
                                                        <p>
                                                            <button @click="viewDrug(drug.id)" class="btn btn-primary">
                                                                <i class="fa fa-eye" style="color:white"></i>
                                                                view
                                                            </button>
                                                        </p>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
        width:100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .spinner-position {
        position:relative;
        left:43%;
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
        border:1px solid lightgrey;
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
    .featured-text-1 {
        color: #b1abab;
        /* display: inline; */
        display: inline-block;
        width: 20%;
        font-weight: bold;
        line-height: 1.5;
        font-size: 1.2em;
        /* margin-top: 21px; */
        position: absolute;
        top: 100px;
        right:253px;
    }
    .featured-text-2 {
        color: #b1abab;
        /* display: inline; */
        display: inline-block;
        width: 20%;
        font-weight: bold;
        line-height: 1.5;
        font-size: 1.2em;
        /* margin-top: 21px; */
        position: absolute;
        top: 100px;
        left:320px;
    }
    .brick {
        border-radius: 20px;
        overflow: hidden;
        background-color: #fff;
        width: 100%;
        height: 100%;
        transition: all .2s ease-out;
        box-shadow: 0 2px 43px -4px rgba(0,0,0,.19);
        display: flex;
        flex-direction: column;
    }
    .brick:hover {
        box-shadow: none;
        border:1px solid lightgrey;
        box-shadow: 0 2px 6px 1px rgba(0,0,0,.19);
    }
    .vendor_info {
        padding: 19px 20px 13px;
        min-height: 110px;
    }
    .vendor_details {
        padding:5px 20px 10px 20px;
    }
    .vendor_border {
        border-top:1px solid lightgrey;
    }
    .all-vendors {
        padding-left:100px;
        padding-right:100px;
    }
    .viewDrug {
        color: black;
        position: absolute;
        background-color: white;
        height:60vh;
        width: 50%;
        z-index: 1;
        left: 350px;
        z-index: 1;
        overflow-y:scroll;
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
                token:'',
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
                displayDrug: false,
                isLoading_signup: false,
                auth_user_name: '',
                vendors:[],
                display:false,
                spinner:false,
                drugOpen: false,
                drugs: [],
                drugDetails:[],
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
                this.token = localStorage.getItem('token');
                let config = {
                    headers:{
                        'Authorization': "Bearer "+this.token
                    }
                }
                    fetch('http://127.0.0.1:8000/api/user',config)
                     .then(res => res.json())
                     .then(res => {
                         this.auth_user_name = res.name;
                }) 
            },
            fetchAllVendors(){
                this.url = 'http://127.0.0.1:8000/api/registered_vendors';
                fetch(this.url)
                .then(res => res.json())
                .then(res => {
                    if(res){
                        this.vendors = res;
                    }
                })

            },
            enter(value){
                this.display = true;
                this.spinner = true;
                this.drugOpen = false;
                this.url = 'http://127.0.0.1:8000/api/registered_vendors/'+value;
                fetch(this.url)
                .then(res => res.json())
                .then(res => {
                    if(res){
                        this.drugOpen = true;
                        this.drugs = res;
                        this.spinner = false;
                    }
                }) 
            },
            closeDrugs(){
                this.drugOpen = false;
                this.displayDrug = false;
            },
            viewDrug(id){
                this.displayDrug = true;
                this.url = 'http://127.0.0.1:8000/api/view_drug/'+id;
                fetch(this.url)
                .then(res => res.json())
                .then(res => {
                    this.drugDetails = res;
                }) 
            }
        },
        created(){
            this.fetchAuthUser();
            this.fetchAllVendors();
        }
    }
</script>
