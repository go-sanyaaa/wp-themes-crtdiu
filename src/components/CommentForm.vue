<template lang="pug">
    div.comment__wrapper
        div.comment__header
            h1.comment__title Добавить комментарий
            button.comments__cancel.button.button--red.button--small(v-if="parent" @click.prevent="cancelComment") отменить
        c-alert(:type="message.status" v-if="Object.entries(message).length && message.status" @ok="hideAlert")
            //template(v-if="message.status == 'success'" v-slot:header) Учетная запись создана
            template {{message.content}}
        div.comment__form-wrapper(ref="formWrapper")
            form#comment-form.comment__form(@submit.prevent="createComment")
                div.comment__form-col.comment__form-userdata(v-if='!isAuthenticated')
                    label.comment__label(for='comment-form-name') Имя: *
                    input#comment-form-name.comment__input.input(type='text' v-model='name' required)
                    label.comment__label(for='comment-form-sname') Фамилия: *
                    input#comment-form-sname.comment__input.input(type='text' v-model='sname' required)
                    label.comment__label(for='comment-form-email') Электронная почта: *
                    input#comment-form-email.comment__input.input(type='email' v-model='author_email' required)
                div.comment__form-col
                    label.comment__label(for='comment-form-comment') Комментарий: *
                    textarea#comment-form-comment.comment__textarea.comment__input.input(v-model="comment" required)
        div.comment__actions
            button.button.button--blue(form='comment-form') Отправить

</template>

<script>
    import {CREATE_COMMENT, FETCH_COMMENTS} from "../store/actions.type";
    import {mapGetters} from 'vuex'
    import CAlert from "./Alert";

    export default {
        name: "CommentForm",
        components: {CAlert},
        props: ['post','parent'],
        data(){
            return {
                message: {
                    status: '',
                    content: ''
                },
                name: '',
                sname: '',
                author_email: '',
                comment: ''
            }
        },
        inject: ['cancelComment'],
        methods: {
            createComment(){
                let loader = this.$loading.show({
                    container: this.$refs.formWrapper
                });

                const {comment:content, post, parent} = this
                const comment_data = {content,post,parent}

                if(!this.isAuthenticated){
                    const {author_name,author_email} = this
                    Object.assign(comment_data,{author_name,author_email})
                }

                this.$store.dispatch(`comments/${CREATE_COMMENT}`,comment_data)
                    .then((resp)=>{
                        this.parseMessage(resp)
                        this.comment = ''
                        this.$store.dispatch(`comments/${FETCH_COMMENTS}`,{post_id:post,page_id:1})
                        loader.hide()
                    })
                    .catch(err => {
                        this.parseMessage(err.response)
                        loader.hide()
                    })
            },
            parseMessage(resp){
                const approved = 'Комментарий успешно добавлен'
                const hold = 'Комментарий отправлен на рассмотрение'

                if(resp.status == '400'){
                    this.message.status = 'error',
                    this.message.content = resp.data.message
                }else if(resp.status == '201'){
                    this.message.status = 'success'
                    this.message.content = resp.data.status == 'approved' ? approved : hold;
                }
            },
            hideAlert(){
                this.message = {
                    status: '',
                    content: ''
                }
            }
        },
        computed: {
            ...mapGetters({isAuthenticated: 'auth/isAuthenticated'}),
            author_name(){
                return this.name + ' ' + this.sname
            }
        }

    }
</script>

<style scoped lang="scss">
    .comment__wrapper{
        margin-top: 30px;
        > * {
            margin-bottom: 30px;
            &:last-child{
                margin-bottom: 0;
            }
        }
    }
    .comment__header{
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
    }
    .comment__title{
        color: $DARK-GREY;
        font-size: 18px;
        font-weight: 300;
    }
    .comment__form{
        position: relative;
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        &-wrapper{
            position: relative;
        }
    }
    .comment__label{
        color: $LIGHT-TEXT;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 5px;
    }
    .comment__form-col{
        flex: 1 0 auto;
        display: flex;
        flex-direction: column;
        margin-right: 40px;
        &:last-child{
            margin-right: 0;
        }
    }
    .comment__form-userdata{
        flex: 0 1 240px;
    }
    .comment__input{
        border-radius: 8px;
        padding-left: 15px;
        padding-right: 15px;
        margin-bottom: 20px;
        &:last-child{
            margin-bottom: 0;
        }
    }
    .comment__textarea{
        padding: 10px 15px;
        min-height: 120px;
        height: 100%;
        max-width: 100%;
        resize: vertical;
    }
    .comment__actions{
        display: flex;
        flex-direction: row;
        justify-content: flex-end;
    }
    @media screen and (max-width: 1024px){
        .comment__form-col{
            margin-right: 0;
            flex-basis: 100%;
        }
        .comment__form-userdata{
            margin-bottom: 20px;
        }
    }
</style>