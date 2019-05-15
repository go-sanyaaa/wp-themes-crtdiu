<template lang="pug">
    div.associations-request
        button.widget__req-assoc.widget-req-assoc(@click="showModal")
            div.widget-req-assoc__icon-wrapper
                i.far.widget-req-assoc__icon(:class="linkIconClass")
            div.widget-req-assoc__text-wrapper
                h4.widget-req-assoc__name {{linkName}}
                p.widget-req-assoc__desc {{linkDesc}}
        modal(
            transition="pop-out" width="440" height="auto"
            :adaptive="true" name="assoc-req-modal"
            :scrollable="true"
        )
            div.modal
                div.modal__header
                    span.modal__header-title Запись в творческое объединение
                div.modal__body
                    form.form(action='')
                        div.form__line.form__line.form__line--v
                            label.form__label(for="username") Логин
                            input#username.input( type="text" autocomplete="off")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="password") Пароль
                            input#password.input( type="password" autocomplete="off")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="username2") Логин
                            input#username2.input( type="text" autocomplete="off")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="password2") Пароль
                            input#password2.input( type="password" autocomplete="off")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="username3") Логин
                            input#username3.input( type="text" autocomplete="off")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="password3") Пароль
                            input#password3.input( type="password" autocomplete="off")
                        div.form__line.form__line
                            button.button.button--red(@click.prevent="login")
                                | Войти
                                i.fas.fa-sign-in-alt.button-icon
                button.button.button--red.button--circle.modal__close(@click.prevent="hideModal")
                    i.fas.fa-times
</template>

<script>
    import Loading from "vue-loading-overlay"

    export default {
        name: "cAssocReq",
        data(){
            return {
            }
        },
        props: {
            linkName: {type: String, required: true},
            linkIcon: {type: String, required: true},
            linkDesc: {type: String, required: true}
        },
        computed: {
            linkIconClass(){
                return `fa-${this.linkIcon}`
            }
        },
        methods: {
            showModal(){
                this.$modal.show('assoc-req-modal')
            },
            hideModal(){
                this.$modal.hide('assoc-req-modal')
            }
        },
        components: {
            Loading
        }
    }
</script>

<style scoped>

</style>