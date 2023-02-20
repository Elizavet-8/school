<template>
    <div class="row">
        <div class="col-sm-4 header-center">
            <div class="btn-group">
                <button
                    @click.stop="goPrev"
                    class="btn btn-outline btn-primary"
                >
                    &lArr; Назад
                </button>
                <button
                    @click.stop="goToday"
                    class="btn btn-outline btn-default today-button"
                >
                    &dArr; Сегодня
                </button>
                <button
                    @click.stop="goNext"
                    class="btn btn-outline btn-primary"
                >
                    Вперед &rArr;
                </button>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <select
                    class="form-control custom-select"
                    v-model="selected"
                >
                    <option
                        v-for="option in options"
                        :key="option.id"
                        :value="option.value"
                    >
                        {{ option.title }}
                    </option>
                </select>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="title">{{ title }}</div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import { CHANGE_MONTH } from "../actions";
import { CHANGE_GRADE } from "../actions";

export default {
    data() {
        return {
            localeSelect: "en",
            selected: null,
            options: [{
                id: 99,
                title: "Доступные мне",
                value: null
            }, {
                id: 1,
                title: "1 класс",
                value: 1
            },
            {
                id: 2,
                title: "2 класс",
                value: 2
            },
            {
                id: 3,
                title: "3 класс",
                value: 3
            },
            {
                id: 4,
                title: "4 класс",
                value: 4
            },
            {
                id: 5,
                title: "5 класс",
                value: 5
            },
            {
                id: 6,
                title: "6 класс",
                value: 6
            },
            {
                id: 7,
                title: "7 класс",
                value: 7
            },
            {
                id: 8,
                title: "8 класс",
                value: 8
            },
            {
                id: 9,
                title: "9 класс",
                value: 9
            },
            {
                id: 10,
                title: "10 класс",
                value: 10
            }]
        };
    },
    props: {
        currentMonth: {},
        locale: {
            type: String,
        },
    },
    computed: {
        title() {
            if (!this.currentMonth) return;
            return this.currentMonth.locale(this.locale).format("MMMM YYYY");
        },
    },
    watch: {
        selected: function (newSelection, oldSelection) {
            this.$root.$emit(CHANGE_GRADE, newSelection);
        },
    },
    methods: {
        goPrev() {
            let payload = moment(this.currentMonth)
                .subtract(1, "months")
                .startOf("month");
            this.$root.$emit(CHANGE_MONTH, payload);
        },
        goNext() {
            let payload = moment(this.currentMonth)
                .add(1, "months")
                .startOf("month");
            this.$root.$emit(CHANGE_MONTH, payload);
        },
        goToday() {
            this.$root.$emit(CHANGE_MONTH, moment());
        },
        setLocale() {
            if (i18n) {
                i18n.locale = this.localeSelect;
            } else {
                console.warn(
                    'Please define global vue locale object named "i18n"!'
                );
            }
        },
    },
};
</script>
<style>
.full-calendar-header {
    display: flex;
    align-items: center;
}
.header-center {
    flex: 3;
    text-align: center;
}
.title {
    text-align: center;
    font-size: 1.5em;
    font-weight: bolder;
}
.language-select {
    display: inline-block;
    width: 50%;
}
</style>
