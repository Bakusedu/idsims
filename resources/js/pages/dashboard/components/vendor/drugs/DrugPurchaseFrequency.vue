<template>
  <div>
      <h4 class="text-center" style="color:black">Drug purchase frequency</h4>

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
components: {
    GChart
  },
  data () {
    return {
      // Array will be automatically processed with visualization.arrayToDataTable function
    //   chartData: [
    //     ['Drug', 'Sales'],
    //     ['Drug name', 0] 
    //   ],
      chartOptions: {
        chart: {
          title: 'Drug Purchase Frequency',
        }
      },
      drug_name:'',
      drug_qty:0,
    }
  },
  props:['name','qty','error'],
  computed: {
      chartData(){
          return [
              ['Drug','Sales'],
              [this.drug_name,this.drug_qty]
          ]
      }
  },
  watch: {
      name: function(value){
          this.drug_name = value;
      },
      qty: function(value){
          this.drug_qty = value;
      },
  },
mounted(){
  
}

}

</script>

<style>

</style>