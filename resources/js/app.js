import Vue from 'vue';
import Routes from './routes';
import AppHeader from './components/layouts/AppHeader';
import AppFooter from './components/layouts/AppFooter';
import SmallButtonBlue from './components/layouts/ui/SmallButtonBlue';
import SmallButtonWhite from './components/layouts/ui/SmallButtonWhite';
import BlockButtonBlue from './components/layouts/ui/BlockButtonBlue';
import BlockButtonGreen from './components/layouts/ui/BlockButtonGreen';
import DashboardHeader from './pages/dashboard/components/DashboardHeader';
import DashboardContainer from './pages/dashboard/components/DashboardContainer';
import VendorSidebar from './pages/dashboard/components/vendor/Sidebar';
import CustomerSidebar from './pages/dashboard/components/customers/Sidebar';
import SearchComponent from './pages/dashboard/components/vendor/drugs/SearchComponent';
import AddDrugForm from './pages/dashboard/components/vendor/drugs/AddDrugForm';
import ErrorComponent from './components/layouts/ui/ErrorComponent';
import SuccessComponent from './components/layouts/ui/SuccessComponent';
import AllVendorDrugs from './pages/dashboard/components/vendor/drugs/AllVendorDrugs';
import DisplayDrugView from './pages/dashboard/components/vendor/drugs/DisplayDrugViewComponent';
import DrugDetails from './pages/dashboard/components/vendor/drugs/DrugDetails';
import EditDrug from './pages/dashboard/components/vendor/drugs/EditDrugComponent';
import EditDrugForm from './pages/dashboard/components/vendor/drugs/EditDrugForm';
import VendorSearchResult from './pages/dashboard/components/vendor/drugs/VendorSearchResult';
import UserProfile from './pages/dashboard/components/UserProfile';
import EditUserProfile from './pages/dashboard/components/EditUserProfile';
import store from './stores/store';
import App from './views/App';
import VueNoty from 'vuejs-noty';
import Datepicker from 'vuejs-datepicker';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'font-awesome/css/font-awesome.min.css';
import 'vuejs-noty/dist/vuejs-noty.css';

Vue.component('AppHeader', AppHeader);
Vue.component('AppFooter', AppFooter);
Vue.component('SmallButtonBlue', SmallButtonBlue);
Vue.component('SmallButtonWhite', SmallButtonWhite);
Vue.component('BlockButtonBlue', BlockButtonBlue);
Vue.component('BlockButtonGreen', BlockButtonGreen);
Vue.component('DatePicker',Datepicker);
Vue.component('DashboardHeader',DashboardHeader);
Vue.component('DashboardContainer',DashboardContainer);
Vue.component('VendorSidebar',VendorSidebar);
Vue.component('CustomerSidebar',CustomerSidebar);
Vue.component('SearchComponent',SearchComponent);
Vue.component('AddDrugForm',AddDrugForm);
Vue.component('ErrorComponent',ErrorComponent);
Vue.component('SuccessComponent',SuccessComponent);
Vue.component('AllVendorDrugs',AllVendorDrugs);
Vue.component('DisplayDrugView',DisplayDrugView);
Vue.component('DrugDetails',DrugDetails);
Vue.component('EditDrug',EditDrug);
Vue.component('EditDrugForm',EditDrugForm);
Vue.component('VendorSearchResult',VendorSearchResult);
Vue.component('UserProfile',UserProfile);
Vue.component('EditUserProfile',EditUserProfile);

Vue.use(VueNoty);

const app = new Vue({
    el: '#app',
    store,
    router: Routes,
    render: h => h(App),
});

export default app;