<template lang="pug">
    div.timer
        div.timer__header
            figure.timer__header-icon
                img.timer__header-img(:src="templateDirectory + '/img/kuzbass300.png'")
            span.timer__header-title {{timerTitle}}
        div.timer__body
            span.timer__date-days.timer__date {{days}}
            span.timer__date-hours.timer__date {{hours}}
            span.timer__date-minutes.timer__date {{minutes}}
            span.timer__date-seconds.timer__date {{seconds}}
</template>

<script>
    export default {
        props:{
            timerTitle: {
                type: String
            },
            templateDirectory: {
                type: String
            }
        },
        data(){
            return {
                days: '',
                hours: '',
                minutes: '',
                seconds: ''
            }
        },
        mounted(){
            var target_date = new Date(2021,6,4).getTime() + (1000*3600*48); // установить дату обратного отсчета
            var vm = this; // переменные для единиц времени

            countdown();

            setInterval(countdown, 1000);
            function countdown(){
                var current_date = new Date().getTime();
                var seconds_left = (target_date - current_date) / 1000;

                vm.days = pad( parseInt(seconds_left / 86400) );
                seconds_left = seconds_left % 86400;

                vm.hours = pad( parseInt(seconds_left / 3600) );
                seconds_left = seconds_left % 3600;

                vm.minutes = pad( parseInt(seconds_left / 60) );
                vm.seconds = pad( parseInt( seconds_left % 60 ) );
            }

            function pad(n) {
                return (n < 10 ? '0' : '') + n;
            }
        },
        name: "cTimer"
    }
</script>

<style lang="scss" scoped>
    .timer{
        &__header{
            display: flex;
            flex-direction: row;
            align-items: flex-end;
            &-icon{
                display: flex;

            }
            &-img{
                width: 100%;
                object-fit: cover;
                height: 100%;
                max-width: 80px;
            }
            &-title{
                margin-left: 10px;
                font-size: 16px;
                font-weight: 600;
                color: $LIGHT-TEXT;
            }
        }
        &__body{
            margin-top: 10px;
            background: #1B416B;
            border-radius: 8px;
            display: flex;
            padding: 15px 30px 13px;
            justify-content: space-between;
        }
        &__date{
            position: relative;
            flex: 1 1 25%;
            text-align: center;
            color: #FFF;
            font-size: 24px;
            font-weight: 900;
            &:after{
                display: block;
                font-size: 12px;
                font-weight: 600;
                min-width: 100%;
                text-align: center;
            }
            &:first-child:before{
                display: none;
            }
            &:before{
                position: absolute;
                content: ":";
                left: -2px;
                display: block;
            }
            &-days:after{
                content: "дней";
            }
            &-hours:after{
                content: "часов";
            }
            &-minutes:after{
                content: "минут";
            }
            &-seconds:after{
                content: "секунд";
            }
        }
        @media screen and (max-width: 1200px){
            &__body{
                padding-left: 15px;
                padding-right: 15px;
            }
        }
    }

</style>