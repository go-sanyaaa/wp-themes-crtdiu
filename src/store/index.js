import Vue from 'vue'
import Vuex from 'vuex'

import auth from './auth.module'
import comments from './comments.module'
import events from './events.module'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        auth,
        comments,
        events
    }
})
