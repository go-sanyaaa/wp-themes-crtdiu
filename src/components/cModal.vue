<template lang="pug">
    modal(
        transition="pop-out" width="440" height="auto"
        :adaptive="true"
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
    export default {
        name: "cModal",
        methods: {
            sendReq(){
                console.log("Send req")
            }
        }
    }
</script>

<style scoped>

</style>