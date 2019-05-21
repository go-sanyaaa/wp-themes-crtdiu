<template lang="pug">
    div.associations-request
        button.widget__req-assoc.widget-req-assoc(@click="showModal")
            div.widget-req-assoc__icon-wrapper
                i.widget-req-assoc__icon(:class="linkIcon")
            div.widget-req-assoc__text-wrapper
                h4.widget-req-assoc__name {{linkName}}
                p.widget-req-assoc__desc {{linkDesc}}
        modal(
            transition="pop-out" width="440" height="auto"
            :adaptive="true" name="assoc-rec-widget"
            :scrollable="true"
        )
            div.modal
                div.modal__header
                    span.modal__header-title Запись в творческое объединение
                div.modal__body
                    form.form(action='' @submit.prevent="sendReq")
                        div.form__line.form__line.form__line--v
                            label.form__label(for="first_name") Имя
                            input#first_name.input( type="text" required)
                        div.form__line.form__line.form__line--v
                            label.form__label(for="last_name") Фамилия
                            input#last_name.input( type="text" required)
                        div.form__line.form__line.form__line--v
                            label.form__label(for="birthday") Дата рождения
                            input#birthday.input( type="date" required)
                        div.form__line.form__line.form__line--v
                            label.form__label(for="union") Объединение
                            select#union.input.select(required)
                                option(disabled selected style="display: none;")
                                option.option(v-for="union in shortUnionsList") {{union.name}}
                        div.form__line.form__line
                            button.button.button--green(type="submit")
                                | Отправить заявку
                                i.fas.fa-paper-plane.button-icon
                button.button.button--red.button--circle.modal__close(@click.prevent="hideModal")
                    i.fas.fa-times
</template>

<script>
    import {FETCH_UNIONS} from "../store/actions.type";
    import {mapGetters} from "vuex"
    import Loading from "vue-loading-overlay"

    export default {
        name: "c-assoc-rec-widget",
        data(){
            return {
            }
        },
        props: {
            linkName: {type: String, required: true},
            linkIcon: {type: String, required: true},
            linkDesc: {type: String, required: true}
        },
        mounted(){
            this.$store.dispatch(FETCH_UNIONS)
        },
        computed: {
            ...mapGetters(['shortUnionsList']),
            linkIconClass(){
                return `fa-${this.linkIcon}`
            }
        },
        methods: {
            showModal(){
                this.$modal.show('assoc-rec-widget')
            },
            hideModal(){
                this.$modal.hide('assoc-rec-widget')
            },
            sendReq(){
                console.log("Send req")
            }
        },
        components: {
            Loading
        }
    }
</script>

<style scoped>

</style>