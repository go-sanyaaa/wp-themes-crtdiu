<template lang="pug">
    div.event-subscribe(:class="addedClasses")
        button.button.button--green.event-subscribe--no-subscribed(v-if="!isRegister" @click="subscribe") Записаться
            i.fas.fa-user-plus.button-icon
        button.button.button--light-blue.event-subscribe--subscribed(v-else @click="unSubscribe") Вы записаны
            i.fas.fa-user-check.button-icon
</template>

<script>
    import moment from "moment"
    import {mapGetters} from "vuex"
    import {SUBSCRIBE_ON_EVENT, UNSUBSCRIBE_ON_EVENT} from "../store/actions.type";

    export default {
        name: "EventSubscribe",
        props: {
            event: {
                type: Object,
                required: true
            },
            isRegister: {
                type: Boolean,
                required: true
            },
            buttonStyle: {
                type: String,
                default: ''
            }
        },
        computed:{
            ...mapGetters(['isAuthenticated']),
            addedClasses(){
                const objClasses = {};
                if(this.buttonStyle === 'full-width'){
                    objClasses['event-subscribe--full-width'] = true
                }
                return objClasses
            }
        },
        methods: {

            subscribe(){
                const {id} = this.event;
                if(!this.isAuthenticated){
                    this.$modal.show('dialog',{
                        title:`
                        <div class="event-subscribe__header">
                            <p class="event-subscribe__header-title">Внимание!</p>
                        </div>
                    `,
                        text:`

                        <div class="event-subscribe__body">
                            <p class="event-subscribe__body-subtitle">Ошибка!</p>
                            <h2 class="event-subscribe__body-title">Чтобы принять участие вам необходимо войти в свою учетную запись.</h2>
                            <Auth></Auth>
                        </div>
                    `,
                        buttons: [
                            {
                                title: '<p class="event-subscribe__button">ОК</p>'
                            }
                        ]
                    })
                    return
                }
                this.$modal.show('dialog',{
                    title:`
                        <div class="event-subscribe__header">
                            <p class="event-subscribe__header-title">Подтвердите действие!</p>
                        </div>
                    `,
                    text:`
                        <div class="event-subscribe__body">
                            <p class="event-subscribe__body-subtitle">Запись на мероприятие:</p>
                            <h2 class="event-subscribe__body-title">${this.event.title.rendered}</h2>
                        </div>
                        <div class="event-subscribe__meta meta">
                            <span class="meta__field meta__field--chips meta__field--blue">${this.getHumanDate(this.event.event_date,"LL")}</span>
                            <span class="meta__field meta__field--chips"><i class="fas fa-clock meta__icon"></i>${this.getHumanDate(this.event.event_date,"LT")} - ${this.getHumanDate(this.event.event_date_end,"LT")}</span>
                        </div>
                    `,
                    buttons: [
                        {
                            title: '<p class="event-subscribe__button">Пойду <i class="event-subscribe__button-icon">🏃‍♂️</i></p>',
                            default: true,
                            handler: () => {
                                const {id} = this.event
                                let loader = this.$loading.show({
                                    container: null
                                })
                                this.$store.dispatch(SUBSCRIBE_ON_EVENT,id)
                                    .then((resp) => {
                                        loader.hide()
                                        this.$modal.hide('dialog')
                                    })
                            }
                        },
                        {
                            title: '<p class="event-subscribe__button">Отменить действие</p>'
                        }
                    ]
                })

            },
            unSubscribe(){
                const {id} = this.event;
                this.$modal.show('dialog',{
                    title:`
                        <div class="event-subscribe__header">
                            <p class="event-subscribe__header-title">Подтвердите действие!</p>
                        </div>
                    `,
                    text:`
                        <div class="event-subscribe__body">
                            <p class="event-subscribe__body-subtitle">Отменить запись на мероприятие:</p>
                            <h2 class="event-subscribe__body-title">${this.event.title.rendered}</h2>
                        </div>
                        <div class="event-subscribe__meta meta">
                            <span class="meta__field meta__field--chips meta__field--blue">${this.getHumanDate(this.event.event_date,"LL")}</span>
                            <span class="meta__field meta__field--chips"><i class="fas fa-clock meta__icon"></i>${this.getHumanDate(this.event.event_date,"LT")} - ${this.getHumanDate(this.event.event_date_end,"LT")}</span>
                        </div>
                    `,
                    buttons: [
                        {
                            title: '<p class="event-subscribe__button">Не пойду <i class="event-subscribe__button-icon">❌</i></p>',
                            default: true,
                            handler: () => {
                                const {id} = this.event
                                let loader = this.$loading.show({
                                    container: null
                                })
                                this.$store.dispatch(UNSUBSCRIBE_ON_EVENT,id)
                                    .then((resp) => {
                                        loader.hide()
                                        this.$modal.hide('dialog')
                                    })
                            }
                        },
                        {
                            title: '<p class="event-subscribe__button">Отменить действие</p>'
                        }
                    ]
                })
            },
            getHumanDate(date,format = "LLL"){
                return moment(date).locale('ru').format(format)
            },
        },
        components:{
            moment
        }
    }
</script>

<style lang="scss">
    .event-subscribe{
        transition: .27s ease-in all;
        &--full-width{
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
            & .button{
                width: 100%;
                border-radius: 0;
                padding: 10px;
                height: auto;
            }
            & .event-subscribe--subscribed{
                color: #FFF;
                background: transparentize($DEEP-BLUE,.1);
            }
        }
    }
    .event-subscribe{
        &__header{
            display: flex;
            justify-content: center;
        }
        &__header-title{
            font-size: 14px;
            color: $DARK-GREY;
        }
        &__body{
            margin-bottom: 15px;
        }
        &__body-subtitle{
            color: $LIGHT-TEXT;
        }
        &__body-title{
            font-size: 18px;
            color: $LIGHT-TEXT;
        }
        &__button{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }
        &__button-icon{
           margin-left: 10px;
        }
        &__meta{
            display: flex;
        }
    }
</style>