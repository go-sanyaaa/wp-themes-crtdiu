import Vue from 'vue'
import VueCookie from 'vue-cookie'

const APP_DOMAIN = process.env.VUE_APP_DOMAIN

Vue.use(VueCookie)

const ID_TOKEN_KEY = 'user-token'

export const getToken = () => {
    return window.localStorage.getItem(ID_TOKEN_KEY);
    // return Vue.cookie.get(ID_TOKEN_KEY)
};

export const saveToken = token => {
    window.localStorage.setItem(ID_TOKEN_KEY, token);
    // Vue.cookie.set(ID_TOKEN_KEY,token,{expires: '7D', domain: APP_DOMAIN})
};

export const destroyToken = () => {
    window.localStorage.removeItem(ID_TOKEN_KEY);
    // Vue.cookie.delete(ID_TOKEN_KEY,{domain: APP_DOMAIN})
};

export default { getToken, saveToken, destroyToken };