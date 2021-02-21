require('./bootstrap');

require('alpinejs');

import Vue from 'vue'

//Main pages
import Home from './components/home'


const app = new Vue({
    el: '#app',
    components: {Home}
});
