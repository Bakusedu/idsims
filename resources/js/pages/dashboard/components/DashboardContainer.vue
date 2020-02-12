<template>
  <div>
      <div class="container pt-4">
            <div v-if="displayDrugView">
                <DisplayDrugView v-bind:drugId="this.drugId" v-on:close="closeDisplayDrugView()" />
            </div>
            <div v-if="displayVendorView">
                <DisplayVendorView v-bind:id="this.id" v-on:close_vendor="closeVendorView()" />
            </div>
            <div v-if="displayCustomerView">
                <DisplayCustomerView v-bind:id="this.id" v-on:close_customer="closeCustomerView()" />
            </div>
            <div v-if="sell">
                <SellDrugView v-on:close_sell="closeSellDrug()" v-bind:drugId="this.drugId" v-bind:drugName="this.drugName" v-bind:hcpi="this.hcpi" v-bind:drug_type="this.drug_type" v-bind:price="this.price" />
            </div>
          <section class="d-flex">
              <aside v-if="user.priviledges === 1">
                  <AdminSidebar v-on:choice="renderAdminContent($event)" />
              </aside>
              <aside v-if="user.priviledges === 2 && status === 1">
                  <VendorSidebar v-on:choice="renderComponentContent($event)" />
              </aside>
              <aside v-if="user.priviledges === 3 && status === 1">
                  <CustomerSidebar v-on:customer="renderCustomerContent($event)"/>
              </aside>
              <main style="padding:10px">
                  <h4 style="color:black">{{ content }}</h4>
                  <section class="main-content">
                    <section v-if="user.priviledges === 1" class="width-50">
                        <AllVendors v-on:open-vendor-view="openVendorView" :key="keyUpdate" v-if="vendors"/>
                        <AllCustomers v-on:open-customer-view="openCustomerView" :key="update_all_customers" v-if="customers" />
                    </section>
                    <section v-if="user.priviledges === 2 && status === 1" class="width-50">
                        <SearchComponent v-if="drugs"/>
                        <AllVendorDrugs v-on:viewDrug="popUpViewDrugView" :key="this.$store.getters.getDrugProps" v-bind:newDrug ="this.new_drug" v-if="drugs"/>
                        <VendorSettings v-on:profile_updated="updateVendorShop()" v-if="settings" />
                    </section>
                    <section v-if="user.priviledges === 3 && status === 1" class="width-50">
                        <HealthInformation v-if="health" v-bind:id="user.id" />
                        <UserProfile v-if="profile" v-bind:user="user"/>
                    </section>
                    <section class="width-40">
                        <AddDrugForm v-if="drugs" v-on:new-drug="pushNewDrug($event)"/>
                        <EditUserProfile v-bind:user="this.user" v-if="profile" />
                        <VendorShop :key="this.update_vendor" v-if="settings" />
                        <SignUpNewVendor v-if="vendors" />
                        <CustomerSignUp v-on:new_customer="updateAllCustomers()" v-if="customers" />
                        <CompareDrugs v-if="health" />
                        <CompareResponse v-if="health" />
                    </section>
                  </section>
              </main>
          </section>
      </div>
  </div>
</template>

<script>
import SellDrugEvent from './vendor/drugs/SellDrugEvent';
var config = {
    headers: {
        'Authorization': "Bearer "+localStorage.getItem('token'),
    }
};
export default {
    data(){
        return {
            content: '',
            vendors:false,
            customers:false,
            drugs:false,
            settings:false,
            health:false,
            profile:false,
            drugProp: 0,
            displayDrugView: false,
            displayVendorView: false,
            displayCustomerView: false,
            drugId: '',
            drugName:'',
            hcpi:'',
            drug_type:'',
            price: 0,
            new_drug:'',
            updated_user: {},
            sell: false,
            update_vendor:0,
            update_all_customers:0,
            keyUpdate: 0,
            id: 0,
            status: 1,
        }
    },
    props:['user'],
    watch:{
        user: function(value){
            if((value.priviledges === 2) && (!value.picture)){
                this.$noty.info('Hey there, Ensure to setup your profile for your OTC Shop to be displayed on our Home page!')
            }
            if(((value.priviledges === 2) || (value.priviledges === 3)) && (!value.status)){
                this.status = 0;
                this.$noty.error('Warning!!! Your account may have been disabled, contact the Admin on 08122632296 for more information');
            }
        }
    },
    methods: {
        renderComponentContent(value){
            if(value === 'My drugs'){
                this.content = 'My drugs';
                this.drugs = true;
                this.settings = false;
            }
            if(value === 'Settings'){
                this.content = 'Settings';
                this.settings = true;
                this.drugs = false;
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
        openVendorView(name,id){
            this.displayVendorView = true;
            this.id = id;
            
        },
        openCustomerView(name,id){
            this.displayCustomerView = true;
            this.id = id;
            
        },
        renderAdminContent(value){
            if(value === 'vendors'){
                this.content = 'Vendors';
                this.vendors = true;
                this.customers = false;
            }
            if(value === 'customers'){
                this.content = 'Customers';
                this.customers = true;
                this.vendors = false;
            }
        },
        populateDrugProps(){
            this.drugProp++;
        },
        popUpViewDrugView($event){
            this.displayDrugView = true;
            this.drugId = $event;
        },
        closeDisplayDrugView(){
            this.displayDrugView = false;
            this.drugProp++;
        },
        closeVendorView(){
            this.displayVendorView = false;
            this.keyUpdate++;
        },
        closeCustomerView(){
            this.displayCustomerView = false;
        },
        closeSellDrug(){
            this.sell = false;
        },
        pushNewDrug(value){
            this.new_drug = value;
        },
        updateVendorShop(){
            this.update_vendor++;
        },
        updateAllCustomers(){
            this.update_all_customers++;
        }
    },
    created(){
        SellDrugEvent.$on('sell', (value,id,hcpi,drug_type,price) => {
            this.sell = true;
            this.drugName = value;
            this.drugId = id;
            this.hcpi = hcpi;
            this.drug_type = drug_type;
            this.price = price;
        })
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