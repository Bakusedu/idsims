import Vue from 'vue';
import Routes from './routes';
import AppHeader from './components/layouts/AppHeader';
import AppFooter from './components/layouts/AppFooter';
import SmallButtonBlue from './components/layouts/ui/SmallButtonBlue';
import SmallButtonWhite from './components/layouts/ui/SmallButtonWhite';
import BlockButtonBlue from './components/layouts/ui/BlockButtonBlue';

import App from './views/App';
import Datepicker from 'vuejs-datepicker';
import 'bootstrap/dist/css/bootstrap.min.css';

Vue.component('AppHeader', AppHeader);
Vue.component('AppFooter', AppFooter);
Vue.component('SmallButtonBlue', SmallButtonBlue);
Vue.component('SmallButtonWhite', SmallButtonWhite);
Vue.component('BlockButtonBlue', BlockButtonBlue);
Vue.component('DatePicker',Datepicker);

const app = new Vue({
    el: '#app',
    router: Routes,
    render: h => h(App),
});

export default app;