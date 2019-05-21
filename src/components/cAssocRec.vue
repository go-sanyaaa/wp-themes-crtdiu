<template lang="pug">
    div.associations-reg
        button.button.button--red(@click="showModal")
            | Подать заявку
            i.fas.fa-plus.button-icon
        modal(
            transition="pop-out" width="440" height="auto"
            :adaptive="true" name="assoc-rec-modal"
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
                            label.form__label Объединение
                            input.input(:value="assocName" disabled)
                        div.form__line.form__line
                            button.button.button--green(type="submit")
                                | Отправить заявку
                                i.fas.fa-paper-plane.button-icon
                button.button.button--red.button--circle.modal__close(@click.prevent="hideModal")
                    i.fas.fa-times
</template>

<script>
    import Loading from "vue-loading-overlay"

    export default {
        name: "c-assoc-rec",
        data(){
            return {
            }
        },
        props: {
            assocId: {type: Number, required: true},
            assocName: {type: String, required: true}
        },
        methods: {
            showModal(){
                this.$modal.show('assoc-rec-modal')
            },
            hideModal(){
                this.$modal.hide('assoc-rec-modal')
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