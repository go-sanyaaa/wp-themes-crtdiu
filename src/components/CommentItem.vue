<template lang="pug">
    li(:id="`comment-${item.id}`")
        div.comments__body
            div.comments__avatar
                img.comments__avatar-img(:src="item.author_avatar_urls[96]")
            div.comments__data
                div.comments__infobar
                    div.comments__info
                        span.comments__author {{item.author_name}}
                        div.meta.comments__meta
                            span.meta__field.comments__meta-date {{getHumanDate(item.date)}}
                    button.comments__reply(@click.prevent="switchParent(item.id)") ответить
                div.comments__content(v-html="item.content.rendered")
        comment-form(:parent="parent_id",:post="item.post" v-if="for_comment == item.id")
        ul(v-if="item.children && item.children.length").comments__children
            comment-item(v-for="child in item.children" :item="child" :key="`item-comment-${child.id}`")


</template>

<script>
    import CommentForm from './CommentForm'
    import moment from 'moment'
    import {CHANGE_PARENT} from "../store/actions.type";
    import {mapState} from 'vuex'

    export default {
        name: "comment-item",
        props: ['item'],
        methods:{
            getHumanDate(date){
                return moment(date).locale('ru').format('LLL')
            },
            switchParent(id){
                this.$store.dispatch(CHANGE_PARENT,id)
            }
        },
        computed:{
            ...mapState({
                for_comment: state => state.comments.parent
            }),
            parent_id(){
                if(this.item.parent){
                    return this.item.parent
                }
                return this.item.id
            }
        },
        components: {
            CommentForm
        }
    }
</script>