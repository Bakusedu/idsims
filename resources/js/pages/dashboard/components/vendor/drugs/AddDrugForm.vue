<template>
  <div>
      <div>
        <h6 style="color:black"><i style="color:black" class="fa fa-plus pr-1"></i>Add a new drug</h6>
        <div v-if="this.errorArray.length > 0">
            <ErrorComponent v-bind:errors = "this.errorArray"/>
        </div>
        <form @submit.prevent="addDrug" enctype="multipart/form-data" style="overflow-y:scroll;height:50vh">
            <div class="form-group">
                <label for="">Drug name</label>
                <input type="text" name="name" v-model="drug.name" class="form-control">
            </div>
            <div style="display:flex;justify-content:space-between">
                <div class="form-group width-45">
                    <label for="">Company name</label>
                    <input type="text" name="company" v-model="drug.company" class="form-control">
                </div>
                <div class="form-group width-45" style="position:relative">
                    <label for="">Price</label>
                    <span style="position:absolute;color:black;top:40px;left:10px;">&#8358;</span>
                    <input type="text" name="price" v-model="drug.price" class="form-control" style="padding-left:25px;">
                </div>
            </div>
            <div class="form-group">
                <label for="">Drug photo</label>
                <input type="file" style="border:none" class="form-control" @change="OnChangeFile($event)">
            </div>
            <div class="border-red">
                <div class="form-group">
                        <label for="">Active ingredients</label>
                        <input type="text" name="active_ingredients" v-model="drug.active_ingredients" class="form-control">
                    </div>
                <div class="form-group">
                    <label for="">What does this drug cure?</label>
                    <textarea name="cure" v-model="drug.cure" id="" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Drug effects</label>
                    <textarea name="effects" v-model="drug.effects" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Drug interactions</label>
                    <textarea name="interactions" v-model="drug.interaction" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Overdose</label>
                    <textarea name="overdose" v-model="drug.overdose" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Dosage</label>
                    <textarea name="dosage" v-model="drug.dosage" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <label for="">Note</label>
                    <textarea name="note" v-model="drug.note" cols="10" rows="2" class="form-control"></textarea>
                </div>
                <div style="display:flex;justify-content:space-between">
                    <div class="form-group width-45">
                        <label for="">Drug quantity</label>
                        <input type="text" v-model="drug.qty" name="quantity" class="form-control">
                    </div>
                    <div class="form-group width-45">
                        <label for="">Drug type</label><br>
                        <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedDrugTypes('satchet')" :disabled = disableSatchet name="satchet" v-model="drug_type.satchet" value="1">Satchet</label>
                        <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedDrugTypes('counting')" :disabled = disableCounting name="counting" v-model="drug_type.counting"  value="2">Counting</label>
                        <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedDrugTypes('syrup')" :disabled = disableSyrup name="syrup" v-model="drug_type.syrup"  value="3">Syrup</label>
                    </div>
            </div>
            <div class="form-group">
                <label for="">Health care proffessional involvement in drug dosage</label>
                <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedHcpi('low')" :disabled = disableLow name="low" v-model="hcpi.low" value="0">Low</label>
                <label class="checkbox-inline pr-2"><input type="checkbox" @change="disableUnCheckedHcpi('moderate')" :disabled = disableModerate name="moderate" v-model="hcpi.moderate" value="2">Moderate</label>
                <label class="checkbox-inline"><input type="checkbox" @change="disableUnCheckedHcpi('high')" :disabled = disableHigh name="high" v-model="hcpi.high" value="5">High</label>
            </div>
            <div class="form-group">
                <label for="">Nafdac registration number</label>
                <input type="text" v-model="drug.nafdac" class="form-control">
            </div>
            <div class="form-group">
                <label for="">Expiry date</label>
                <input type="text" v-model="drug.expiry_date" class="form-control">
            </div>
            <BlockButtonBlue>Add drug</BlockButtonBlue>
            </div>
        </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
var bodyParameters = {
    key: "value"
}
export default {
    data(){
        return {
            drug: {
                name: '',
                company: '',
                price: '',
                active_ingredients: '',
                cure: '',
                effects: '',
                interaction: '',
                overdose: '',
                dosage: '',
                note: '',
                qty: '',
                drug_type: '',
                hcpi: '',
                image: '',
                nafdac:'',
                expiry_date:'',
                token:''
            },
            drug_type: {
                satchet: '',
                counting: '',
                syrup: ''
            },
            hcpi: {
                low:'',
                moderate:'',
                high:''
            },
            disableSatchet:false,
            disableCounting:false,
            disableSyrup:false,
            disableLow:false,
            disableModerate:false,
            disableHigh:false,
            url: 'http://127.0.0.1:8000/api/drug',
            errorArray:[],
            temp_errors:[],
        }
    },
    methods: {
        addDrug(){
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            this.assignHcpi();
            this.assignDrugType();
            this.temp_errors = [];
            this.errorArray = [];
            axios.post(this.url,this.drug,config)
            .then(res => {
                this.$noty.success(res.data.message);
                this.$emit('new-drug',res.data.drug);
            }).catch(err => {
                this.temp_errors.push(err.response.data.error);
                this.temp_errors.forEach(element => {

                    // this.errorArray.push(value);
                        if(element.name){
                            this.errorArray.push(element.name[0]);
                        }
                        if(element.company){
                            this.errorArray.push(element.company[0]);
                        }
                        if(element.price){
                            this.errorArray.push(element.price[0]);
                        }
                        if(element.cure){
                            this.errorArray.push(element.cure[0]);
                        }
                        if(element.qty){
                            this.errorArray.push(element.qty[0]);
                        }
                        if(element.drug_type){
                            this.errorArray.push(element.drug_type[0]);
                        }
                        if(element.hcpi){
                            this.errorArray.push(element.hcpi[0]);
                        }
                        if(element.dosage){
                            this.errorArray.push(element.dosage[0]);
                        }
                        if(element.active_ingredients){
                            this.errorArray.push(element.active_ingredients[0]);
                        }
                })
            })
            // this.$store.commit('increment');
        },
        disableUnCheckedDrugTypes(value){
            if(value === 'satchet'){
                this.disableCounting = !this.disableCounting;
                this.disableSyrup = !this.disableSyrup;
            }
            if(value === 'counting'){
                this.disableSatchet = !this.disableSatchet;
                this.disableSyrup = !this.disableSyrup;
            }
            if(value === 'syrup'){
                this.disableCounting = !this.disableCounting;
                this.disableSatchet = !this.disableSatchet;
            }
        },
        disableUnCheckedHcpi(value){
            if(value === 'low'){
                this.disableModerate = !this.disableModerate;
                this.disableHigh = !this.disableHigh;
            }
            if(value === 'moderate'){
                this.disableLow = !this.disableLow;
                this.disableHigh = !this.disableHigh;
            }
            if(value === 'high'){
                this.disableLow = !this.disableLow;
                this.disableModerate = !this.disableModerate;
            }
        },
        assignHcpi(){
            if(this.hcpi.low){
                this.drug.hcpi = '0';
            }
            if(this.hcpi.moderate){
                this.drug.hcpi = '2';
            }
            if(this.hcpi.high){
                this.drug.hcpi = '5';
            }
        },
        assignDrugType(){
            if(this.drug_type.satchet){
                this.drug.drug_type = '1';
            }
            if(this.drug_type.counting){
                this.drug.drug_type = '2';
            }
            if(this.drug_type.syrup){
                this.drug.drug_type = '3';
            }
        },
        OnChangeFile(e){
            var fileReader = new FileReader();
            fileReader.readAsDataURL(e.target.files[0]);
            fileReader.onload = (e) => {
                this.drug.photo = e.target.result;
            }
        }
    }
}
</script>

<style>
    .width-45 {
        width:45%;
    }
    .form-group label {
        color:black;
    }
</style>