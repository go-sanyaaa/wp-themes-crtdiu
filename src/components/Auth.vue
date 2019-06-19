<template lang="pug">
    div.auth
        template(v-if="!isAuthenticated")
            button.button.button--red(@click.prevent="showAuthModal" name="auth")
                | Войти
                i.fas.fa-sign-in-alt.button-icon
            modal(
                transition="pop-out" width="440" height="auto"
                :adaptive="true" name="auth-modal"
            )
                div.modal
                    div.modal__header
                        span.modal__header-title Авторизация
                    div.modal__body
                        form.form
                            .form__line.form__line--v
                                label.form__label(for="username") Логин
                                input#username.input(v-model="username" type="text" autocomplete="off")
                            .form__line.form__line--v
                                label.form__label(for="password") Пароль
                                input#password.input(v-model="password" type="password" autocomplete="off")
                            .form__line.form__line--h
                                button.button.button--red(@click.prevent="login")
                                    | Войти
                                    i.fas.fa-sign-in-alt.button-icon
                                a(href="/signup").form__link Регистрация
                    button.button.button--red.button--circle.modal__close(@click.prevent="hideAuthModal")
                        i.fas.fa-times
        template(v-else)
            div.auth__userpanel(ref="userpanelWrapper")
                loading(:active="!user.name" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
                span.auth__username {{user.name}}
                button.button.button--transparent(@click.prevent="logout")
                    i.fas.fa-sign-out-alt
</template>

<script>
    import {mapGetters, mapState} from 'vuex'
    import {AUTH_LOGIN, AUTH_LOGOUT} from "../store/actions.type";
    import Loading from 'vue-loading-overlay'

    export default {
        name: "Auth",
        data(){
          return{
              isLoading: true,
              password:'',
              username:'',
              loader: null
          }
        },
        components:{Loading},
        methods: {
            showAuthModal: function () {
                this.$modal.show('auth-modal')
            },
            hideAuthModal: function () {
                this.$modal.hide('auth-modal')
            },
            login: function(){
                const {username, password} = this
                this.$store.dispatch(AUTH_LOGIN,{username,password}).then(this.hideAuthModal)
            },
            logout: function () {
                this.$store.dispatch(AUTH_LOGOUT)
            }
        },
        computed: {
            ...mapGetters({isAuthenticated:'auth/isAuthenticated'}),
            ...mapState('auth',['user'])
        }
    }
</script>

<style lang="scss" scoped>
    .auth__username{
        position: relative;
        font-size: 14px;
        font-weight: 800;
        margin-right: 15px;
        color: $DEEP-BLUE;
    }
    .auth__userpanel{
        min-width: 100px;
        display: flex;
        flex-direction: row;
        align-items: center;
        position: relative;
        margin: 20px 0
        /*box-sizing: border-box;*/
        /*padding: 10px 20px;*/
        /*background: #f4f4f4;*/
        /*border-radius: 8px;*/
    }
</style>