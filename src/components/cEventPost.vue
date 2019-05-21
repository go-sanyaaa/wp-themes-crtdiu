<template lang="pug">
    div.post.post--single.event.event--single
        loading(:active="isLoading" v-if="isLoading" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
        template(v-else)
            v-dialog
            figure.event__thumbnail
                img.event__thumbnail-img(:src="getPostImages(event)" :class="eventHasCome && !eventOnline ? 'event__thumbnail-img--completed' : ''")
                div.event__status(v-if="(!eventHasCome && eventOnline) || eventHasCome"
                    :class="eventOnline ? 'event__status--online' : 'event__status--completed'")
                    template(v-if="eventOnline")
                        span.event__status-icon
                        | Сейчас идет
                    template(v-else)
                        | Завершено
            div.event__container.post__container
                header.post__header
                    div.event__cats.tag-list
                        a.tag-item.tag(
                            v-for="cat in getEventCats(event.event_cat)"
                            :href="`/events/${cat.slug}`"
                        ) {{cat.name}}
                    h1.event__title(v-html="event.title.rendered")
                    div.event__infopanel
                        div.event__meta.meta
                            span.meta__field.meta__field--chips.meta__field--blue
                                | {{getHumanDate(event.event_date,"LL")}}
                            span.meta__field.meta__field--chips(:class="eventHasCome && false ? 'meta__field--red' : '' ")
                                i.fas.fa-clock.meta__icon
                                | {{getHumanDate(event.event_date,"LT")}} - {{getHumanDate(event.event_date_end,"LT")}}
                                //template(v-if="eventHasCome")
                                    span.meta__subtext Завершено
                            span.meta__field
                                i.fas.fa-users.meta__icon
                                | {{event.persons}}
                        div.event__actions(v-if="!eventHasCome")
                            event-subscribe(:event="event" :is-register="event.is_register")
                hr.post__hr
                div.content__header
                    h2.content__title Описание:
                div.post__content(v-html="event.content.rendered")
                hr.post__hr
            Comments(:post="eventId")
</template>

<script>
    import moment from "moment"
    import Loading from "vue-loading-overlay"
    import Comments from "./Comments"
    import EventSubscribe from "./EventSubscribe"
    import {FETCH_EVENTS_CAT, GET_EVENT} from "../store/actions.type";
    import {mapGetters} from "vuex";

    export default {
        name: "cEventPost",
        props:{
            eventId: {
                type: Number,
                required: true
            }
        },
        data(){
            return{
                isLoading: true
            }
        },
        mounted() {
            Promise.all([
                this.$store.dispatch(GET_EVENT,{event_id: this.eventId}),
                this.$store.dispatch(FETCH_EVENTS_CAT)
            ])
                .then(()=>{this.isLoading = false})
        },
        computed: {
            ...mapGetters(['events','categories']),
            event(){
                return this.events[0]
            },
            eventHasCome(){
                return moment().isAfter(this.event.event_date_end)
            },
            eventOnline(){
                return moment().isBetween(this.event.event_date, this.event.event_date_end)
            }
        },
        methods:{
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
        },
        components:{Loading, EventSubscribe, Comments, moment}
    }
</script>

<style lang="scss" scoped>
    .event {
        position: relative;
        display: flex;
        min-height: 100px;
        &__thumbnail {
            position: relative;
            display: flex;
            width: 100%;
            max-height: 300px;
            border-radius: 8px;
            overflow: hidden;
            align-items: center;
            justify-content: center;
            &-img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            &-img--completed {
                filter: grayscale(1);
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
            padding: 20px 20px;
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
    }

    .event--single .event {
        /*&__container{*/
        /*    width: 100%;*/
        /*    max-width: 840px;*/
        /*    box-sizing: border-box;*/
        /*    margin: 30px auto;*/
        /*    padding: 0 40px;*/
        /*    > *{*/
        /*        margin-bottom: 30px;*/
        /*    }*/
        /*    > :last-child{*/
        /*        margin-bottom: 0;*/
        /*    }*/
        /*}*/
        &__cats{
            margin-bottom: 8px;
        }
        &__infopanel{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            flex-wrap: wrap;
            margin: 20px 0;
        }
        &__meta{
            display: flex;
            align-items: center;
        }
        &__title{
            color: $LIGHT-TEXT;
            font-size: 24px;
        }
    }
    @media screen and (max-width: 580px){
        .event--single .event{
            &__actions{
                flex-basis: 100%;
                margin-top: 15px;
            }
        }
    }

</style>