<template lang="pug">
    div#comments.post__container.comments__container
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
    import {mapState} from 'vuex'
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
            this.$store.dispatch(`comments/${FETCH_COMMENTS}`,{post_id,page_id})
            this.$store.dispatch(`comments/${CHANGE_PARENT}`, 0)
        },
        methods:{
            loadMoreComments(){
                const post_id = this.post
                const page_id = ++this.page_id
                this.$store.dispatch(`comments/${FETCH_COMMENTS}`,{post_id,page_id})
            }
        },
        provide: {
            cancelComment(){
                this.$store.dispatch(`comments/${CHANGE_PARENT}`, 0)
            }
        },
        computed:{
            ...mapState('comments',{
                getComments: state => state.comments,
                isLoading: state => state.isLoading,
                for_comment: state => state.parent,
                commentsCount: state => state.commentsCount
            }),
            comments(){
                const comments = this.getComments
                let commentsTree = []
                let commentsKey = []

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
            position: relative;
            margin-top: 20px;
            padding-left: 60px;
            > *{
                margin-bottom: 30px;
            }

            > *:last-child{
                margin-bottom: 0;
            }
            &:before{
                content: "";
                display: flex;
                position: absolute;
                width: 4px;
                height: 100%;
                background: #F1F1F1f1;
                left: 28px;
                border-radius: 2px;
            }
        }

        &__container{
            margin-top: 0 !important;
            display: flex;
            flex-direction: column;
        }

        &__body{
            position: relative;
            display: flex;
            flex-direction: row;
            align-items: flex-start;
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
            position: relative;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
        }

        &__author{
            color: $LIGHT-TEXT;
            font-weight: bold;
            font-size: 14px;
        }
        &__avatar{
            display: flex;
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
        @media screen and (max-width: 768px){
            &__avatar{
                position: relative;
                z-index: 1;
                margin-right: 10px;
                &-img{
                    width: 40px;
                    height: 40px;
                }
            }
            &__data{
                position: relative;
                left: -50px;
                flex: 1 0 100%;
            }
            &__infobar{
                margin-left: 50px;
            }
            &__children{
                padding-left: 40px;
                &:before{
                    left: 18px;
                }
            }
        }
    }
</style>