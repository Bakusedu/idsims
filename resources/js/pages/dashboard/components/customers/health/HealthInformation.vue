<template>
  <div>
      <div class="chart">
          <GChart
                type="ColumnChart"
                :data="chartData"
                :options="chartOptions"
            />
      </div>
  </div>
</template>

<script>
import { GChart } from 'vue-google-charts';
export default {
    data(){
        return {
            token: '',
            url: 'http://127.0.0.1:8000/api/health_information/'+this.id,
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
    props:['id'],
    methods: {
        getHealthInformation(){
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
        }
    },
    mounted(){
        this.getHealthInformation();
    }
}
</script>

<style>

</style>