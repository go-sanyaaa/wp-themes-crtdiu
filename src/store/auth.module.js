import JwtService from '@/common/jwt.service'
import ApiService from '@/common/api.service'

import {AUTH_LOGIN, AUTH_LOGOUT, UPDATE_USER, CHECK_TOKEN} from "@/store/actions.type";
import {SET_TOKEN, PURGE_AUTH, SET_USER, SET_ERROR} from "@/store/mutations.type";

const state = {
    isAuthenticated: !!JwtService.getToken(),
    token: '',
    user: {},
    errors: false
}

const getters = {
    isAuthenticated(state) {
        return state.isAuthenticated;
    },
    user(state) {
        return state.user;
    }
}

const mutations = {
    [SET_TOKEN](state, token){
        state.token = token;
        state.isAuthenticated = true
    },
    [SET_USER](state, user){
        state.user = user;
        state.errors = false
    },
    [PURGE_AUTH](state){
        state.token = ''
        state.user = {}
        state.errors = false
        state.isAuthenticated = false
        JwtService.destroyToken()
    },
    [SET_ERROR](state,errors){
        state.errors = errors
    }
}

const actions = {
    [AUTH_LOGIN](context,user){
        return new Promise((res,rej)=>{
            const {username, password} = user
            ApiService.post('aam/v1/authenticate',{username,password})
                .then(resp => {
                    const token = resp.data.token;
                    context.commit(SET_TOKEN,token)
                    JwtService.saveToken(token)
                    ApiService.setHeader()
                    context.dispatch(UPDATE_USER)
                        .then(resp => {
                            res(resp)
                        })
                })
                .catch(err => {
                    context.commit(SET_ERROR,[err.response.data.message])
                })
        })
    },
    [UPDATE_USER](context){
        return new Promise((res,rej)=>{
            ApiService.post('wp/v2/users/me')
                .then(resp => {
                    const {id,first_name,last_name,email, avatar_urls, username} = resp.data;
                    const user = {
                        id,
                        first_name,
                        last_name,
                        email,
                        avatar_urls,
                        username
                    }
                    context.commit(SET_USER,user)
                    res(resp)
                })
        })
    },
    [CHECK_TOKEN](context, token){
        return new Promise((res,rej) => {
            ApiService.setHeader()
            ApiService.post('/aam/v1/validate-jwt',{jwt:token})
                .then(resp => {
                    console.log(resp)
                    if(resp.data.status == 'valid'){
                        context.commit(SET_TOKEN,token)
                        res(resp)
                    }else{
                        context.commit(PURGE_AUTH)
                        rej(err)
                    }
                })
                .catch(err => {
                    context.commit(PURGE_AUTH)
                    rej(err)
                })
        })
    },
    [AUTH_LOGOUT](context){
        return new Promise((res,rej) => {
            context.commit(PURGE_AUTH)
            res()
        })
    }
}

export default {
    state,
    mutations,
    actions,
    getters
}