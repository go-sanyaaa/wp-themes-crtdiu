<template lang="pug">
    div.events
        loading(:active="isLoading" v-if="isLoading" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
        template
            v-dialog
            div.events__cats
                a.button.button--light-grey.text--semibold(href="/events" :class="[catId == 0 ? 'active-cat' : '']") Все
                a.button.button--light-grey.text--semibold(
                    v-for="category in categories"
                    :class="[catId == category.id ? 'active-cat' : '']"
                    :href="`/events/${category.slug}`"
                ) {{category.name}}
            div.events__filters-wrapper
                div.events__filters
                    div.events__filter-tabs
                        button.events-filter-tab(
                            v-for="(filter,i) in filters"
                            :class="[activeFilter == i ? 'events-filter-tab--active' : '']"
                            @click="setFilter(i)"
                        ) {{filter.name}}
                    //div.events__filter
                        date-picker(v-model="startDate" lang="ru" :not-after="endDate" :width="140" :first-day-of-week="1")
                            template(slot="calendar-icon")
                                i.far.fa-calendar-alt
                        date-picker(v-model="endDate" lang="ru" :not-before="startDate" :width="140" :first-day-of-week="1")
                            template(slot="calendar-icon")
                                i.far.fa-calendar-alt
            div.events__list
                loading(:active="isFetch" v-if="isFetch" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
                c-event-card(v-else v-for="event in events" :event="event" :key="`event-card-${event.id}`")
            div.events__loading-more(v-if="isFetchMore")
                loading(:active="isFetchMore" v-if="isFetchMore" :is-full-page="false" color="#FF0331" loader="dots" background-color="#fff" :opacity="1")
            button.button.button--blue.events__load-button(v-else-if="canLoad && !isFetch" @click="loadNextPage") Загрузить еще события

</template>

<script>
    // import DatePicker from "vue2-datepicker"
    import {mapState, mapGetters} from "vuex"
    import {ADD_MORE_EVENTS, FETCH_EVENTS, LOAD_EVENTS} from "../store/actions.type";
    import cEventCard from "./cEventCard"
    import Loading from 'vue-loading-overlay'
    import moment from "moment"

    export default {
        props: ['catId'],
        name: "cEventsArchive",
        data(){
            return{
                per_page: 10,
                page: 1,
                activeFilter: 0,
                isFetchMore: false,
                isFetch: false,
                isLoading: true,
                startDate: '',
                endDate: '',
                range: '',
                monthCount: 3,
                staticFilters: [
                    {name: "В любое время", params: {startDate: '', endDate: ''}}
                ],
            }
        },
        mounted() {
            this.$store.dispatch(`events/${LOAD_EVENTS}`,Object.assign(this.filter,{per_page:this.per_page}))
                .then(resp => this.isLoading = false)
        },
        computed:{
            ...mapState('events',['events','categories','eventsCount']),
            filter(){
                const params = {};
                if(this.catId != 0){
                    params['event_cat'] = this.catId
                }
                if(this.startDate){
                    params['after'] = this.startDate
                }
                if(this.endDate){
                    params['before'] = this.endDate
                }
                return params;
            },
            filters(){
                var generatedFilters = [];
                for(var i=0;i< this.monthCount; i++){
                    var filter = {}
                    var month = moment().add(i,'month')
                    filter['name'] = this.getHumanDate(month,'MMMM')
                    filter['params'] = {
                        startDate: month.startOf('month').format(),
                        endDate: month.endOf('month').format()
                    }
                    generatedFilters.push(filter)
                    //{name: this.getHumanDate(moment(),'MMMM'), params: {startDate: moment().startOf('week').format(), endDate: moment().endOf('week').format()}}
                }
                return [...this.staticFilters,...generatedFilters]
            },
            canLoad(){
                return this.per_page * this.page < this.eventsCount
            }
        },
        methods:{
            setFilter(i){
                this.page = 1
                this.activeFilter = i
                this.setDate(this.filters[i].params)
            },
            setCustomFilter(i){
                this.$modal.show('filter-modal')
            },
            getHumanDate(date,format = "LLL"){
                return moment(date).locale('ru').format(format)
            },
            setDate(newDate = {startDate: '',endDate: ''}){
                this.startDate = newDate.startDate;
                this.endDate = newDate.endDate;
            },
            loadNextPage(){
                this.isFetchMore = true
                this.page = ++this.page
                this.$store.dispatch(`events/${ADD_MORE_EVENTS}`,Object.assign(this.filter,{per_page:this.per_page,page:this.page}))
                    .then(resp => this.isFetchMore = false)
            }
        },
        watch:{
            filter: function (filters) {
                this.isFetch = true
                this.$store.dispatch(`events/${FETCH_EVENTS}`,Object.assign(filters,{per_page:this.per_page,page:this.page}))
                    .then(resp => this.isFetch = false)
            }
        },
        components: {Loading, cEventCard}
    }
</script>

<style lang="scss" scoped>
    .active-cat{
        color: $DEEP-BLUE;
        background: $SOFT-BLUE;
    }
    .events{
        position: relative;
        &__cats{
            display: flex;
            flex-direction: row;
            > * {
                margin-right: 20px;
                &:last-child{
                    margin-right: 0;
                }
            }
        }
        > * {
            margin-bottom: 30px;
            &:last-child{
                margin-bottom: 0;
            }
        }
        &__filters-wrapper{
            position: relative;
            display: grid;
            grid-template-columns: 1fr;
        }
        &__filters{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            white-space: nowrap;
            overflow-x: scroll;
            margin-top: -15px;
            padding-top: 15px;
            &::-webkit-scrollbar {
              display: none;
            }
        }
        &__filter-tabs{
            > * {
                margin-right: 20px;
                &:last-child{
                    margin-right: 0;
                }
            }
        }
        &__filter-icon{
            margin-left: 10px;
        }
        &__list{
            margin-bottom: -10px;
            position: relative;
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            min-height: 200px;
        }
        &__load-button{
            width: 100%;
            padding: 10px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.08);
            //box-shadow: 20px -20px 40px rgba(33, 175, 255, 0.2), -20px 20px 40px rgba(49, 216, 96, 0.2);
        }
        &__loading-more{
            min-height: 100px;
            position: relative;
        }
    }
    .events-filter-tab{
        color: $DARK-GREY;
        font-size: 16px;
        font-weight: normal;
        padding: 0 15px 15px;
        border-bottom: 3px solid rgba(0,0,0,0);
        transition: .19s ease-in all;
        &::first-letter{
            text-transform: uppercase;
        }
        &:not(.events-filter-tab--active):hover{
            cursor: pointer;
            border-color: $LIGHT-BLUE;
        }
        &--active{
            color: $LIGHT-TEXT;
            font-weight: 600;
            border-color: $DEEP-BLUE;
        }
    }
    @media screen and (max-width: 1200px){
        .events__list{
            margin-bottom: 0;
        }
    }
    @media screen and (max-width: 768px){
        .events__filters{
            border-radius: 8px;
            box-shadow: inset 10px 0px 10px 0px #ececec, inset -10px 0px 10px 0px #ececec;
        }
    }
</style>