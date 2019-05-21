import './sass/app.scss'

import Vue from 'vue'
import store from './store'
import VueCookie from 'vue-cookie'

import EventSlider from './components/EventSlider.vue'
// import EventSubscribe from './components/EventSubscribe'
import cEventPost from './components/cEventPost'
import Auth from './components/Auth'
import cSignUp from './components/cSignUp'
import cAssocRecWidget from './components/cAssocRecWidget'
import cAssocRec from './components/cAssocRec'
import Comments from './components/Comments'
import cEventsArchive from './components/cEventsArchive'
import cTimer from './components/cTimer'
import cModal from './components/cModal'

import Alert from './components/Alert'

import vmodal from 'vue-js-modal'

import Loading from 'vue-loading-overlay'
// import 'vue-loading-overlay/dist/vue-loading.css'

import ApiService from './common/api.service'
import JwtService from './common/jwt.service'
import {CHECK_TOKEN, UPDATE_USER} from "./store/actions.type";

Vue.use(Loading,{
    color: '#FF0331',
    loader: 'dots',
    width: 48,
    height: 48,
    backgroundColor: '#ffffff',
    opacity: 0.8,
    zIndex: 999
})
Vue.use(vmodal,{
    dialog: true
})
Vue.use(VueCookie)

ApiService.init()

if(JwtService.getToken()){
    store.dispatch(CHECK_TOKEN,JwtService.getToken()).then(resp => {
        store.dispatch(UPDATE_USER)
    })
}

const app = new Vue({
    components: {
        EventSlider,
        Auth,
        cSignUp,
        Comments,
        Alert,
        cEventPost,
        cEventsArchive,
        cAssocRecWidget,
        cAssocRec,
        cTimer,
        cModal
    },
    store
}).$mount('#app')

