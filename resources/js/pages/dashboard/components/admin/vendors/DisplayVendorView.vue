<template>
  <div class="drug-container">
      <header>
          <div style="display:flex;justify-content:space-between">
            <h4 style="color:black">Sold drugs</h4>
            <p style="color:black" @click="emitCloseVendor()" id="close">&times;</p>
          </div>
      </header>
      <div style="width:100%;display:flex;justify-content:space-between">
          <div style="width:49%">
            <VendorSoldDrugs v-bind:vendor_id="this.id"/>
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
            chartOptions: {
                chart: {
                title: 'Drug Purchase Frequency',
            },
        },
        chartData: [
            ['Drug', 'Sales'],
            ['Drug name', 0] 
            ],
        url:'',
      }
    },
    props: ['name', 'id'],
    
  methods: {
      getVendorFrequency(){
            this.url = 'http://127.0.0.1:8000/api/vendor_purchase_frequency/'+this.id
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
        emitCloseVendor(){
            this.$emit('close_vendor');
        }
  },
  mounted(){
      this.getVendorFrequency();
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