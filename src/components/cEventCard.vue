<template lang="pug">
    div.event
        div.event__wrapper(@mouseenter="changeHover" @mouseleave="changeHover")
            a.event__image-container
                img.event__img(
                    :src='getPostImages(event)'
                    :class="{'event__img--completed':eventHasCome && !eventOnline}"
                )
                event-subscribe(
                    v-if="!eventHasCome && !eventOnline"
                    :event="event"
                    :is-register="event.is_register"
                    button-style="full-width"
                    :class="showSubscribeButton ? 'event__subscribe--show' : 'event__subscribe--hide'"
                )
                div.event__status.event__status--online(v-else-if="eventOnline")
                    span.event__status-icon
                    | Сейчас идет
                div.event__status.event__status--completed(v-else)
                    | Завершено
                div.event__img-wrapper
                    div.event__categories
                        a.event__cat.tag(
                            v-for="cat in getEventCats(event.event_cat)"
                            :href="`/events/${cat.slug}`"
                        ) {{cat.name}}
            div.event__data
                a.event__header(v-html="event.title.rendered" :href="event.link")
                div.event__body
                    div.event__meta.meta
                        span.meta__field.meta__field--chips.meta__field--blue
                            | {{getHumanDate(event.event_date,"LL")}}
                        span.meta__field.meta__field--chips(
                            :class="{'meta__field--red' : eventHasCome && false}")
                            i.fas.fa-clock.meta__icon
                            | {{getHumanDate(event.event_date,"LT")}} - {{getHumanDate(event.event_date_end,"LT")}}
                            //template(v-if="eventHasCome")
                                span.meta__subtext Завершено
                    hr
                    div.event__infopanel
                        div.event__meta.meta
                            span.meta__field
                                i.fas.fa-users.meta__icon
                                | {{event.persons}}
                        a.event__link-more(:href="event.link") Подробнее
</template>

<script>
    import moment from "moment"
    import {mapGetters} from 'vuex'
    import EventSubscribe from "./EventSubscribe"

    export default {
        props: ['event'],
        name: "cEventCard",
        data(){
            return {
                isHover: false
            }
        },
        computed: {
            ...mapGetters(['categories']),
            showSubscribeButton(){
                return (this.isHover && !this.event.is_register) || this.event.is_register
            },
            eventHasCome(){
                return moment().isAfter(this.event.event_date_end)
            },
            eventOnline(){
                return moment().isBetween(this.event.event_date, this.event.event_date_end)
            }
        },
        methods: {
            getPostImages(post){
                if(post.better_featured_image){
                    var images = post.better_featured_image.media_details.sizes;
                    var max_size = Object.keys(images).pop()
                    return images[max_size].source_url
                }else{
                    return 'https://crtdiu-app.ru/wp-content/themes/crtdiu/img/news-default.png'
                }
            },
            getEventCats(cat_array){
                const event_cats = [...cat_array]
                return this.categories.filter(category => event_cats.some((cat_id,i) => category.id == cat_id && delete event_cats[i]))
            },
            getHumanDate(date,format = "LLL"){
                return moment(date).locale('ru').format(format)
            },
            changeHover(){
                this.isHover = !this.isHover;
            }
        },
        components: {EventSubscribe}
    }
</script>

<style lang="scss" scoped>
    .event{
        display: flex;
        width: calc(50% - 20px);
        box-sizing: border-box;
        margin: 0 40px 40px 0;
        &:nth-child(2n){
            margin-right: 0;
        }
        &__wrapper{
            display: flex;
            flex-direction: column;
            width: 100%;
            border-radius: 8px;
            overflow: hidden;
            transition: .19s ease-in-out all;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.04), 0 0 40px rgba(0, 0, 0, 0.04);
            &:hover{
                box-shadow: 20px -20px 40px rgba(33, 175, 255, 0.2), -20px 20px 40px rgba(49, 216, 96, 0.2);
            }
        }
        &__image-container{
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }
        &__img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            &--completed{
                filter: grayscale(1);
            }
        }
        &__img-wrapper{
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            padding: 20px;
        }
        &__header{
            color: $LIGHT-TEXT;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        &__data{
            padding: 20px;
            display: flex;
            flex: 1 0 auto;
            flex-direction: column;
            justify-content: space-between;
        }
        &__infopanel{
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: space-between;
        }
        &__meta{
            display: flex;
        }
        &__link-more{
            color: $DARK-GREY;
            font-weight: 600;
            font-size: 13px;
        }
        hr{
            width: 100%;
            height: 2px;
            border-radius: 2px;
            background: #F4F4F4;
            margin: 20px 0;
        }
        &__subscribe{
            cursor: pointer;
            &--show{
                z-index: 1;
                transform: translateY(0);
            }
            &--hide{
                transform: translateY(100%);
            }
        }
        &__status{
            position: absolute;
            bottom: 0;
            left: 0;
            display: flex;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 10px 20px;
            height: 100%;
            box-sizing: border-box;
            font-size: 15px;
            font-weight: bold;
            &-icon{
                display: flex;
                width: 8px;
                height: 8px;
                background: red;
                border-radius: 50%;
                margin-right: 6px;
                animation-name: blink;
                animation-timing-function: linear;
                animation-duration: 2s;
                animation-iteration-count: infinite;
            }
            &--online{
                color: red;
                background: transparentize(#FFF,.3);
            }
            &--completed{
                background: transparentize($DEEP-RED,.5);
                color: #FFF;
            }
        }

        @media screen and (max-width: 1200px){
            margin: 0 30px 30px 0;
            width: calc(50% - 15px);
        }
        @media screen and (max-width: 880px){
            margin-bottom: 20px;
            width: 100%;
            margin-right: 0;
        }
    }
    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

</style>