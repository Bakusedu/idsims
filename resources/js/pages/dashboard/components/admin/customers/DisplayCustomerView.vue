<template>
  <div class="drug-container">
      <header>
          <div style="display:flex;justify-content:space-between">
            <h4 style="color:black">Bought drugs</h4>
            <p style="color:black" @click="emitCloseCustomer()" id="close">&times;</p>
          </div>
      </header>
      <div style="width:100%;display:flex;justify-content:space-between">
          <div style="width:49%">
            <CustomerBoughtDrugs v-bind:id="this.id"/>
          </div>
          <div style="width:49%;">
              <div class="chart">
                <GChart
                      type="ColumnChart"
                      :data="chartData"
                      :options="chartOptions"
                  />
            </div>
          </div>
      </div>
  </div>
</template>

<script>
import { GChart } from 'vue-google-charts';
export default {
    data(){
        return {
        url:'',
        chartOptions: {
            chart: {
            title: 'Drug Purchase Frequency',
            },
         },
        chartData: [
            ['Drug', 'Sales'],
            ['Drug name', 0] 
            ],
      }
    },
    props: ['id'],
    
  methods: {
        getHealthInformation(){
          this.url = 'http://127.0.0.1:8000/api/health_information/'+this.id
            this.token = localStorage.getItem('token');
            let config = {
                headers:{
                    'Authorization': "Bearer "+this.token
                }
            }
            fetch(this.url,config)
            .then(res => res.json())
            .then(res => {
                this.chartData = res;
            }).catch(err => {

            })
        },
        emitCloseCustomer(){
            this.$emit('close_customer');
        }
  },
  mounted(){
      this.getHealthInformation();
  }
}
</script>

<style>
     .drug-container {
        background-color:white;
        position: absolute;
        width: 80%;
        height: 80vh;
        z-index: 2;
        box-shadow: 1px 1px 6px 1px #a09e9e;
        padding: 20px 20px;
    }
    header {
        display:flex;
        justify-content: space-between;

    }
    #close {
        font-weight: bold;
        font-size: 30px;
        margin-bottom: 0px;
        line-height: 27px;
        cursor:pointer;
    }
    .info {
        background-color: #8f8fe8;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid blue;
    }
    .check-button {
        width: 20%;
        background-color: #08b577;
        height: 38px;
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
        cursor:pointer;
    }
</style>