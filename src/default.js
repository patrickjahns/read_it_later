import 'babel-polyfill';
import Icons from 'uikit/dist/js/uikit-icons';
import UIkit from 'uikit';
import Vue       from 'vue'
import VueRouter from 'vue-router';

import App         from './App.vue'
import List        from './components/List.vue'

require('./styles/theme.scss');

UIkit.use(Icons);

Vue.use(VueRouter);

const router = new VueRouter(
    {
        routes: [
            {
                path: '/',
                component: List,
                name: 'index'
            }
        ]
    }
);

const ReadItLater = new Vue({
	router: router,
	render (h) {return h(App)}
});

window.onload = function () {
    ReadItLater.$mount('.app-read_it_later')
};
