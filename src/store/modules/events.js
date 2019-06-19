import ApiService from '@/common/api.service'


import {
    GET_EVENT,
    FETCH_EVENTS,
    FETCH_EVENTS_CAT,
    LOAD_EVENTS,
    SUBSCRIBE_ON_EVENT,
    UNSUBSCRIBE_ON_EVENT,
    ADD_MORE_EVENTS
} from "../actions.type";

import {
    SET_EVENT,
    SET_EVENTS,
    SET_EVENTS_COUNT,
    SET_EVENTS_CAT,
    UPDATE_EVENT_SUBSCRIBE, ADD_EVENTS
} from "../mutations.type";

const state = {
    eventsCount: 0,
    events: [],
    categories: []
}

const getters = {
    catCount: state => state.categories.length,
}

const actions = {
    [GET_EVENT](context,params){
        const {event_id} = params;
        return new Promise((res,rej)=>{
            ApiService.get(`wp/v2/events/${event_id}`)
                .then(resp => {
                    context.commit(SET_EVENT,resp.data)
                    res({status:resp.status,text: resp.statusText})
                })
        })
    },
    [LOAD_EVENTS](context,params){
        return Promise.all([
            context.dispatch(FETCH_EVENTS_CAT),
            context.dispatch(FETCH_EVENTS, params)
        ]).then(resp => {
            return resp.every(({status}) => status === 200 )
        })
    },
    [FETCH_EVENTS](context,params = {}){
        return new Promise((res,rej) => {
            ApiService.get('wp/v2/events',params)
                .then(resp => {
                    const events_count = Number(resp.headers['x-wp-total'])
                    context.commit(SET_EVENTS_COUNT,{events_count})
                    context.commit(SET_EVENTS,resp.data)
                    res({status:resp.status,text: resp.statusText})
                })
        })
    },
    [ADD_MORE_EVENTS](context,params = {}){
        return new Promise((res,rej)=> {
            ApiService.get('wp/v2/events',params)
                .then(resp => {
                    const events_count = Number(resp.headers['x-wp-total'])
                    context.commit(SET_EVENTS_COUNT,{events_count})
                    context.commit(ADD_EVENTS,resp.data)
                    res({status:resp.status,text: resp.statusText})
                })
        })
    },
    [FETCH_EVENTS_CAT](context){
        return new Promise((res,rej) => {
            ApiService.get('wp/v2/event_cat')
                .then(resp => {
                    context.commit(SET_EVENTS_CAT,resp.data)
                    res({status:resp.status,text: resp.statusText})
                })
        })
    },
    [SUBSCRIBE_ON_EVENT](context,event_id){
        return new Promise((res,rej) => {
            ApiService.post(`wp/v2/events/${event_id}`)
                .then(({data}) => {
                    return ApiService.get(`wp/v2/events/${event_id}`)
                })
                .then(({data}) => {
                    context.commit(UPDATE_EVENT_SUBSCRIBE,data)
                    res(data)
                })
        })
    },
    [UNSUBSCRIBE_ON_EVENT](context,event_id){
        return new Promise((res,rej) => {
            ApiService.delete(`wp/v2/events/${event_id}`)
                .then(({data}) => {
                    return ApiService.get(`wp/v2/events/${event_id}`)
                })
                .then(({data}) => {
                    context.commit(UPDATE_EVENT_SUBSCRIBE,data)
                    res(data)
                })
        })
    }
}

const mutations = {
    [SET_EVENTS](state,data){
        const events = data
        state.events = events
    },
    [SET_EVENTS_CAT](state,data){
        const cats = data;
        state.categories = cats
    },
    [UPDATE_EVENT_SUBSCRIBE](state,data){
        const {id} = data
        const event_i = state.events.findIndex(event => event.id === id)
        console.log(data)
        if(event_i != -1){
            state.events[event_i].is_register = data.is_register
            state.events[event_i].place_free = data.place_free
        }
    },
    [SET_EVENTS_COUNT](state,{events_count}){
        state.eventsCount = events_count
    },
    [SET_EVENT](state,data){
        state.events.push(data)
    },
    [ADD_EVENTS](state,data){
        state.events = [...state.events, ...data]
    }
}

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}