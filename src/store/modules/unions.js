import {FETCH_UNIONS} from "../actions.type";
import {SET_UNIONS} from "../mutations.type";

import ApiService from "@/common/api.service"

const state = {
    unions: []
}

const getters = {
    shortUnionsList: (state) => state.unions.map((value => {
        return {
            id: value.id,
            name: value.title.rendered
        }
    }))
}

const actions = {
    [FETCH_UNIONS](context){
        return new Promise((res,rej) => {
            ApiService.get('wp/v2/associations')
                .then(resp => {
                    context.commit(SET_UNIONS,resp.data)
                    res(resp)
                })
                .catch(err => {
                    console.log(err.message)
                    rej(err)
                })
        })
    }
}

const mutations = {
    [SET_UNIONS](state,data){
        state.unions = data;
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}
