<template lang="pug">
    div.post__container.comments__container
        div.content__header(:style="{marginBottom: commentsCount > 0 ? '30px' : '0px'}")
            h2.content__title Комментарии: {{commentsCount}}
        div.content__body
            loading(:active="isLoading" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
            ul.comments(v-if="Object.entries(comments).length")
                comment-item(v-for="item in comments" :item="item" :key="`item-comment-${item.id}`")
            template(v-if="comments.length >= page_id * 100")
                div.comments__more
                    button.button.button--grey(@click.prevent="loadMoreComments") Загрузить еще комментарии
            comment-form(:parent="0",:post="post",v-if="for_comment == parent")
</template>

<script>
    import {mapState,mapGetters} from 'vuex'
    import {FETCH_COMMENTS, CHANGE_PARENT} from "../store/actions.type";
    import CommentItem from './CommentItem'
    import CommentForm from './CommentForm'
    import Loading from 'vue-loading-overlay'

    export default {
        name: 'Comments',
        props: ['post'],
        data(){
            return {
                parent: 0,
                page_id: 1
            }
        },
        created() {
            const post_id = this.post
            const page_id = this.page_id
            this.$store.dispatch(FETCH_COMMENTS,{post_id,page_id})
            this.$store.dispatch(CHANGE_PARENT, 0)
        },
        methods:{
            loadMoreComments(){
                const post_id = this.post
                const page_id = ++this.page_id
                this.$store.dispatch(FETCH_COMMENTS,{post_id,page_id})
            }
        },
        provide: {
            cancelComment(){
                this.$store.dispatch(CHANGE_PARENT, 0)
            }
        },
        computed:{
            ...mapGetters(['commentsCount']),
            ...mapState({
                getComments: state => state.comments.comments,
                isLoading: state => state.comments.isLoading,
                for_comment: state => state.comments.parent
            }),
            comments(){
                const comments = this.getComments
                // console.log(this.getComments)
                let commentsTree = []
                let commentsKey = []

                // console.log('Load')

                let i = 0
                for(;i < comments.length; i++){
                    let item = comments[i]
                    item.children = []
                    if(!item.parent){
                        commentsTree.push(item)
                        commentsKey[item.id] = i
                    }else {
                        let parentKey = commentsKey[item.parent]
                        commentsTree[parentKey].children.push(item)
                    }
                }

                return commentsTree
            }
        },
        components:{
            CommentForm,
            CommentItem,
            Loading
        }
    }
</script>

<style lang="scss">
    .comments{
        position: relative;
        min-height: 100px;
        > *{
            margin-bottom: 30px;
        }

        > *:last-child{
            margin-bottom: 0;
        }
        &__children{
            margin-top: 20px;
            margin-left: 60px;
            > *{
                margin-bottom: 30px;
            }

            > *:last-child{
                margin-bottom: 0;
            }
        }

        &__container{
            margin-top: 0 !important;
            display: flex;
            flex-direction: column;
        }

        &__body{
            display: flex;
            flex-direction: row;
        }

        &__more{
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        &__infobar{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        &__reply{
            color: $DARK-GREY;
            font-size: 13px;
            font-weight: 500;
            font-style: italic;
            cursor: pointer;
        }

        &__data{
            flex: 1 0 auto;
            display: flex;
            flex-direction: column;
        }

        &__author{
            color: $LIGHT-TEXT;
            font-weight: bold;
            font-size: 14px;
        }
        &__avatar{
            margin-right: 20px;
            &-img{
                width: 60px;
                height: 60px;
                border-radius: 50%;
                box-sizing: border-box;
            }
        }

        &__meta{
            margin-top: 3px;
        }

        &__meta-date{
            font-size: 14px;
            font-weight: 600;
        }

        &__content{
            @extend %text;
            color: $LIGHT-TEXT;
            line-height: 100%;
            background: $SOFT-BLUE;
            margin-top: 10px;
            padding: 12px 20px;
            box-sizing: border-box;
            border-radius: 8px;
        }
    }
</style>