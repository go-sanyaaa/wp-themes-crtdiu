<template lang="pug">
    div.alert(:class="`alert--${type}`")
        slot(name="header")
        p.alert__message
            slot Добавьте текст уведомлению
        div.alert__actions(v-if="actions")
            slot(name="actions")
            button(v-if="closed").alert__button.alert__ok(@click="$emit('ok')") ОК
</template>

<script>
    export default {
        props: {
            type: {
                type: String,
                default: 'grey'
            },
            actions: {
                type: Boolean,
                default: true
            },
            closed: {
                type: Boolean,
                default: true
            }
        },
        name: "c-alert"
    }
</script>

<style lang="scss" scoped>
    .alert{
        box-sizing: border-box;
        width: 100%;
        padding: 20px;
        border-radius: 8px;


        &__header{
            font-size: 24px;
            font-weight: bold;
            letter-spacing: .02em;
            margin-bottom: 12px;
        }

        &__message{
            font-size: 14px;
            letter-spacing: .02em;
            font-weight: 600;
        }

        &__actions{
            display: flex;
            flex-direction: row;
            align-items: center;
            margin-top: 20px;
            & > *{
                margin-right: 20px;
                &:last-child{
                    margin-right: 0;
                }
            }
        }

        &__button{
            color: $LIGHT-BLACK;
            font-weight: 900;
            font-size: 14px;
            letter-spacing: .02em;
            background: $LIGHT-BLUE;
            border-radius: 8px;
            padding: 6px 20px;
            height: 30px;
        }

        &--error{
            background: $DEEP-RED;
            .alert__message{
                color: #FFF;
            }
        }

        &--success{
            background-color: $DEEP-GREEN;
            .alert__message{
                color: #FFF;
            }
        }

        &--grey{
            background-color: #f4f4f4;
            .alert__header{
                color: $LIGHT-BLACK;
            }
            .alert__message{
                color: $LIGHT-TEXT;
            }
            .alert__button{
                transition: .19s background-color, color;
                &:hover{
                    cursor: pointer;
                }
            }
            .alert__ok{
                color: $DEEP-BLUE;
            }
        }
    }
</style>