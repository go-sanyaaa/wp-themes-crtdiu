<template lang="pug">
    div.event-slider
        v-dialog
        div.event-slider__hooper
            loading(:active="isLoading" v-if="isLoading" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
            hooper(
                :settings="hooperSettings"
                ref="eventSlider"
                :style="{'height': 'auto'}"
                v-if="!isLoading"
            )
                template(v-for="event in treeEvents")
                    slide(v-if="event.type === 'group'")
                        div.event
                            div.event__data
                                div.event__name.event__name--nested.text--red {{event.group.name}}
                                div.event__meta.event__meta--nested
                                    div.event__meta-date {{getHumanDate(event.date,'D MMMM')}}
                                    a.event__meta-link(href="/events") Все события
                                a.event-nested(v-for="cEvent in event.childEvents" :key="`event-nested-${cEvent.id}`" :href="cEvent.link")
                                    h2.event-nested__name(v-html="cEvent.title.rendered")
                                    div.event-nested__date.meta
                                        span.event__date.meta__field.meta__field--chips-small
                                            i.fas.fa-clock.meta__icon
                                            | {{getHumanDate(cEvent.event_date,"LT")}} - {{getHumanDate(cEvent.event_date_end,"LT")}}
                    template(v-else)
                        slide
                            div.event
                                div.event__data
                                    a.event__name.event__link(:href="event.link" v-html="event.title.rendered")
                                    div.event__meta.meta
                                        span.event__date.meta__field
                                            i.fas.fa-clock.meta__icon
                                            | {{getHumanDate(event.event_date,"LL")}}, {{getHumanDate(event.event_date,"LT")}} - {{getHumanDate(event.event_date_end,"LT")}}
                                        span.event__persons.meta__field
                                            i.fas.fa-users.meta__icon
                                            | {{event.persons}} ({{event.place_free}})
                                    div.event__desc-box
                                        div
                                            p.event__desc(v-html="event.excerpt.rendered")
                                    div.event__actions(v-if="!eventHasCome(event)")
                                        event-subscribe(:event="event" :is-register="event.is_register")
            div.event-slider__cntrl.container.block.block--slider
                button.event-slider__btn.event-slider__prev(@click.prevent="prevEvent")
                    i.fas.fa-long-arrow-alt-left.button-icon
                div.event-slider__hooper-pagination
                button.event-slider__btn.event-slider__next(@click.prevent="nextEvent")
                    i.fas.fa-long-arrow-alt-right.button-icon

</template>
<script>
    import { Hooper, Pagination as HooperPagination, Navigation as HooperNavigation, Slide } from 'hooper'
    import {LOAD_EVENTS} from "../store/actions.type";
    import {mapGetters,mapState} from "vuex"
    import moment from 'moment'
    import Loading from 'vue-loading-overlay'
    import CAlert from "./Alert";
    import EventSubscribe from "./EventSubscribe";

    // import 'hooper/dist/hooper.css'

    export default {
        data(){
            return {
                isLoading: true,
                groupEventsName: ['Развивающая суббота'],
                hooperSettings: {
                    itemsToSlide: 1,
                    itemsToShow: 1,
                    mouseDrag: false,
                    wheelControl: false,
                    breakpoints: {
                        800: {
                            itemsToShow: 2
                        },
                        1200: {
                            itemsToShow: 3
                        }
                    }
                }
            }
        },
        methods: {
            prevEvent(){
                this.$refs.eventSlider.slidePrev();
            },
            nextEvent(){
                this.$refs.eventSlider.slideNext();
            },
            getHumanDate(date,format = "LLL"){
                return moment(date).locale('ru').format(format)
            },
            eventHasCome(event){
                return moment().isAfter(event.event_date_end)
            },
        },
        computed: {
            ...mapGetters({
                isAuthenticated: 'auth/isAuthenticated'
            }),
            ...mapState('events', {
                categories: state => state.categories,
                events: state => state.events,
            }),
            treeEvents(){
                let {categories} = this
                let events = [];
                this.events
                    .sort((a,b) => moment(a.event_date) - moment(b.event_date))
                    .forEach((el,i,arr) => {
                        const group = categories.find(cat => el.event_cat.includes(cat.id))
                        if(group){
                            let last_el = events[events.length - 1]
                            if(
                                last_el.type === 'group' &&
                                last_el.date === moment(el.event_date).format('MM-DD-YYYY') &&
                                last_el.group.id === group.id
                            ){
                                events[events.length - 1].childEvents.push(el)
                            }
                            else{
                                events.push({
                                    type:'group',
                                    group: group,
                                    date: moment(el.event_date).format('MM-DD-YYYY'),
                                    childEvents: [el]
                                })
                            }
                        }else{
                            events.push(Object.assign(el,{type:'single'}))
                        }
                    })
                return events;
            },
        },
        created(){
            this.$store.dispatch(`events/${LOAD_EVENTS}`).then(resp => {
                this.isLoading = !resp
            })
        },
        components: {
            EventSubscribe,
            CAlert,
            Hooper,
            Slide,
            HooperPagination,
            HooperNavigation,
            Loading
        }
    }
</script>

<style lang="scss" scoped>
    .event-slider{
        display: flex;
        align-items: center;
    }
    .event-slider__cntrl{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        margin-top: 15px;
    }
    .event-slider__btn{
        display: flex;
        flex: 3 1 440px;
        max-width: 440px;
        justify-content: center;
        height: 32px;
        background: transparentize(#FFF,1);
        padding: 9px auto;
        box-sizing: border-box;
        font-size: 30px;
        color: $LIGHT-BLUE;
        border: none;
        border-radius: 16px;
        transition: 0.19s;
        transition-property: background-color, color;
        &:hover {
            background: $SOFT-BLUE;
            color: $DEEP-BLUE;
            cursor: pointer;
        }
    }
    .event-slider__hooper{
        position: relative;
        overflow: hidden;
        width: 100%;
    }
    .hooper {
        /*margin-bottom: 30px;*/
    }
    .event-slider__hooper-pagination{
        /*top: 100%;*/
    }

    .event{
        box-sizing: border-box;
        margin: 0 20px;
        background: transparentize(#FFF,1);
        border-radius: 16px;

        &__name {
            display: flex;
            font-size: 20px;
            font-weight: bold;
            color: $LIGHT-TEXT;
            &--nested{
                font-weight: 800;
            }
        }
        &__link {
            transition: 0.230s color, text-decoration;
            margin-bottom: 16px;
            &:hover {
                color: $DEEP-GREEN;
                cursor: pointer;
                text-decoration: underline;
            }
        }
        &__meta{
            margin-bottom: 16px;
            line-height: 18px;
            &--nested{
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-top: 6px;
            }
        }
        &__meta-link{
            color: $DARK-GREY;
            font-size: 13px;
            font-weight: normal;
            font-style: italic;
            text-decoration: underline;
            transition: .19s color;
            &:hover{
                color: $LIGHT-BLACK;
            }
        }
        &__meta-date{
            color: $LIGHT-TEXT;
            font-weight: bold;
            font-size: 16px;
        }
        &__desc-box{
            text-overflow: clip;
            margin-bottom: 16px;
        }
        &__desc{
            @extend %text;
        }
        &__tags {
            margin-bottom: 10px;
        }
        &__actions{
            margin: 15px 0 0 0;
        }
    }

    .event-nested {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 10px 16px;
        background: #FFF;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        border-radius: 8px;
        margin-bottom: 10px;
        transition: .19s box-shadow;
        &:hover{
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.12);
            .event-nested__name {
                color: $DEEP-GREEN;
                text-decoration: underline;
            }
        }
        &__name{
            font-size: 16px;
            font-weight: 600;
            color: $LIGHT-TEXT;
            transition: .19s color;
        }
        &__date{
            margin-top: 10px;
            display: flex;
        }
        &__more-box{
            display: flex;
            align-items: center;
            justify-content: center;
        }
        &__more-link{
            font-size: 14px;
            color: $DARK-GREY;
            font-weight: normal;
            font-style: italic;
            transition: .19s color;
            margin-top: 10px;
            &:hover{
                color: $LIGHT-BLACK;
                text-decoration: underline;
            }
        }
    }
</style>


