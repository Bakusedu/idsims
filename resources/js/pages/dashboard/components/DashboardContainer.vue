<template>
  <div>
      <div class="container pt-4">
            <div v-if="displayDrugView">
                <DisplayDrugView v-bind:drugId="this.drugId" v-on:close="closeDisplayDrugView()" />
            </div>
          <section class="d-flex">
              <aside v-if="user.priviledges === 2">
                  <VendorSidebar v-on:choice="renderComponentContent($event)" />
              </aside>
              <aside v-if="user.priviledges === 3">
                  <CustomerSidebar v-on:customer="renderCustomerContent($event)"/>
              </aside>
              <main style="padding:10px">
                  <h4 style="color:black">{{ content }}</h4>
                  <section class="main-content">
                    <section v-if="user.priviledges === 2" class="width-50">
                        <SearchComponent v-if="drugs"/>
                        <AllVendorDrugs v-on:viewDrug="popUpViewDrugView" :key="this.$store.getters.getDrugProps" v-bind:newDrug ="this.new_drug" v-if="drugs"/>
                    </section>
                    <section v-if="user.priviledges === 3" class="width-50">
                        <UserProfile v-if="profile" v-bind:user="user"/>
                    </section>
                    <section class="width-40">
                        <AddDrugForm v-if="drugs" v-on:new-drug="pushNewDrug($event)"/>
                        <EditUserProfile v-bind:user="this.user" v-if="profile" />
                    </section>
                  </section>
              </main>
          </section>
      </div>
  </div>
</template>

<script>
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
export default {
    data(){
        return {
            content: '',
            drugs:false,
            settings:false,
            customers:false,
            medecine:false,
            health:false,
            profile:false,
            drugProp: 0,
            displayDrugView: false,
            drugId: '',
            new_drug:'',
            updated_user: {}
        }
    },
    props:['user'],
    watch:{
        user: function(value){
            if((value.priviledges === 2) && (!value.picture)){
                this.$noty.info('Hey there, Ensure to setup your profile for your OTC Shop to be displayed on our Home page!')
            }
        }
    },
    methods: {
        renderComponentContent(value){
            if(value === 'My drugs'){
                this.content = 'My drugs';
                this.drugs = true;
                this.settings = this.customers = this.medecine = false;
            }
            if(value === 'Settings'){
                this.content = 'Settings';
                this.settings = true;
                this.drugs = this.customers = this.medecine = false;
            }
            if(value === 'Customers'){
                this.content = 'Customers';
                this.customers = true;
                this.drugs = this.settings = this.medecine = false;
            }
            if(value === 'Sell medecine'){
                this.content = 'Sell medecine';
                this.medecine = true;
                this.drugs = this.settings = this.customers = false;
            }
        },
        renderCustomerContent(value){
            if(value === 'health'){
                this.content = 'Health Information';
                this.health = true;
                this.profile = false;
            }
            if(value === 'profile'){
                this.content = 'Profile';
                this.profile = true;
                this.health = false;
            }
        },
        populateDrugProps(){
            this.drugProp++;
        },
        popUpViewDrugView($event){
            this.displayDrugView = true;
            this.drugId = $event;
            console.log(this.user)
        },
        closeDisplayDrugView(){
            this.displayDrugView = false;
            this.drugProp++;
        },
        pushNewDrug(value){
            this.new_drug = value;
        },
    }
}
</script>

<style>
    section {
        display:flex;
    }
    aside {
        color:black;
        width:25%;
    }
    main {
        color: black;
        width: 75%;
    }
    .main-content {
        display:flex;
        justify-content: space-between;
    }
    .width-50 {
        width:50%;
    }
    .width-40 {
        width:40%;
    }
</style>