<template lang="pug">
    div.sign-up
        c-alert(type="error" v-if="error" @ok="clearErrors").sign-up__alert
            template(v-slot:header) Ошибка регистрации
            template {{error.message}}
        c-alert(type="success" v-if="success" @ok="clearSuccess")
            template(v-slot:header) Учетная запись создана
            template {{success.message}}
        form(v-else @submit.prevent="signUp").form.sign-up__form
            div.sign-up__column
                .form__line.form__line--v
                    label.form__label(for="first_name") Имя: *
                    input#first_name.sign-up__input.input(v-model="first_name" type="text" required)
                .form__line.form__line--v
                    label.form__label(for="last_name") Фамилия: *
                    input#last_name.sign-up__input.input(v-model="last_name" type="text" required)
            div.sign-up__column
                .form__line.form__line--v
                    label.form__label(for="username") Электронная почта / email: *
                    input#username.sign-up__input.input(v-model="username" type="email" autocomplete="email" required)
                .form__line.form__line--v
                    label.form__label(for="password") Пароль: *
                    input#password.sign-up__input.input(v-model="password" type="password" autocomplete="current-password" required)
                //.form__line.form__line--v
                    label.form__label(for="repassword") Повторите пароль
                    input#repassword.sign-up__input.input(v-model="repassword" type="password" autocomplete="off")
            div.sign-up__column
                .form__line.form__line--h
                    button.button.button--blue()
                        | Создать учетную запись
                        i.fas.fa-user-plus.button-icon
</template>

<script>
    import ApiService from "../common/api.service"
    import CAlert from "./Alert";

    export default {
        components: {CAlert},
        data(){
            return {
                username: "",
                first_name: "",
                last_name: "",
                password: "",
                //repassword: "",
                error: "",
                success: ""
            }
        },
        methods:{
            signUp(){
                this.clearErrors()
                const {username, first_name, last_name, password} = this;
                ApiService.post("wp/v2/users/register",{
                    username, first_name, last_name, password, email: username
                }).then(resp => {
                    this.success = resp.data;
                }).catch(err => {
                    this.error = err.response.data;
                })
            },
            clearErrors(){
                this.error = ''
            },
            clearSuccess(){
                this.username = ''
                this.first_name = ''
                this.last_name = ''
                this.password = ''
                this.success = ''
            }
        },
        name: "cSignUp"
    }
</script>

<style lang="scss" scoped>
    .sign-up{
        &__form{
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }
        &__column{
            flex: 1 1 280px;
            max-width: 320px;
            &:nth-child(2n){
                margin-left: 40px;
            }
        }
        &__input{
            border-radius: 8px;
        }
        &__alert{
            margin-bottom: 30px;
        }
        @media screen and (max-width: 1200px){
            &__column{
                &:nth-child(2n){
                    margin-left: 30px;
                }
            }
        }
        @media screen and (max-width: 980px){
            &__column{
                flex-basis: 100%;
                max-width: 400px;
                &:nth-child(2n){
                    margin-left: 0;
                }
            }
        }

    }
</style>