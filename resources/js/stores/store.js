import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        drugProps:0
    },
    mutations: {
        increment(state) {
            state.drugProps++;
        }
    },
    getters: {
        getDrugProps: state => {
            return state.drugProps;
        }
    },
    actions: {

    }
})