import ApiService from '@/common/api.service'

import {
    CREATE_COMMENT,
    FETCH_COMMENTS,
    CHANGE_PARENT
} from "../actions.type";

import {
    SET_COMMENTS,
    SET_COMMENTS_COUNT,
    SET_PARENT
} from "../mutations.type";

const state = {
    isLoading: true,
    comments: [],
    commentsCount: '',
    parent: 0
}

const getters = {
}

const mutations = {
    [SET_COMMENTS](state,comments){
        state.comments = comments
        state.isLoading = false
    },

    [SET_PARENT](state,parent_id){
        state.parent = parent_id
    },

    [SET_COMMENTS_COUNT](state,{comments_count}){
        state.commentsCount = comments_count
    }
}

const actions = {
    [CREATE_COMMENT](context,comment){
        return new Promise((res,rej)=>{
            ApiService.post('wp/v2/comments',comment)
                .then(resp => {res(resp)})
                .catch(err => {rej(err)})
        })
    },
    [FETCH_COMMENTS](context,data){
        return new Promise((res,rej)=>{
            const {post_id:id,page_id:page} = data
            ApiService.get('wp/v2/comments',{
                post: id,
                orderby: 'parent',
                per_page: 100,
                order: 'asc'
            }).then(resp => {
                    const comments = resp.data
                    const comments_count = resp.headers['x-wp-total']
                    context.commit(SET_COMMENTS_COUNT, {comments_count})
                    context.commit(SET_COMMENTS, comments)
                })
        })
    },
    [CHANGE_PARENT](context,parent_id){
        context.commit(SET_PARENT,parent_id)
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}