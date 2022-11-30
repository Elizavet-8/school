<template>
    <div style="display: block" class="row ml-5 mr-5 mb-5">
        <div v-if="loading">Загрузка...</div>

        <div v-if="error" class="error"></div>

        <div class="panel panel-default">
            <div class="panel-heading mb-4">
                <h2>Календарь</h2>
            </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <calendar-header
                            :current-month="currentMonth"
                            :first-day="firstDay"
                            :locale="appLocale"
                        >
                        </calendar-header>

                        <div class="full-calendar-body">
                            <div class="weeks">
                                <strong class="week" v-for="dayIndex in 7" :key="dayIndex">{{
                                    dayIndex | weekDayName(firstDay, appLocale)
                                }}</strong>
                            </div>

                            <div class="dates" ref="dates">
                                <week
                                    v-for="(week, index) in Weeks"
                                    :firstDay="firstDay"
                                    :key="index"
                                    :week="week"
                                >
                                </week>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import moment from "moment";
import { CHANGE_MONTH } from "./actions";

export default {
    data() {
        return {
            loading: true,
            error: null,
            currentMonth: moment().startOf("month"),
            eventsList: [

            ],
        };
    },
    props: {
        lessons: {
            type: Array,
            default: function () {
                return [];
            },
        },
        allEvents: {
            type: Array,
            default: function () {
                return [];
            },
        },
        firstDay: {
            type: Number | String,
            validator(val) {
                let res = parseInt(val);
                return res >= 0 && res <= 6;
            },
            default: 0,
        },
    },
    components: {
        CalendarHeader: require("./calendar/Header.vue").default
            ? require("./calendar/Header.vue").default
            : require("./calendar/Header.vue"),
        Week: require("./calendar/Week.vue").default
            ? require("./calendar/Week.vue").default
            : require("./calendar/Week.vue"),
    },
    created() {
        let me = this;
        this.$root.$on(CHANGE_MONTH, function (payload) {
            me.currentMonth = payload;
        });

        axios
            .get("/admin/api/lessons")
            .then((res) => {
                res.data.forEach((lesson) => {
                    this.eventsList.push({
                        id: lesson.id,
                        title: "Test title",
                        date: new Date(lesson.started_at),
                        color: "panel-default",
                    });
                });

                console.log(res);
                //console.log(this.events);
            })
            .catch((err) => {
                //this.loading = false;
                console.log(err);
            });
    },
    mounted() {
        this.loading = false;
    },
    computed: {
        Weeks() {
            let monthMomentObject = this.getMonthViewStartDate(
                this.currentMonth,
                this.firstDay
            );
            let weeks = [],
                week = [];

            let daysInCurrentMonth = this.currentMonth.daysInMonth();

            for (let weekIndex = 0; weekIndex < 5; weekIndex++) {
                week = [];
                for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
                    week.push(this.getDayObject(monthMomentObject, dayIndex));

                    monthMomentObject.add(1, "day");
                }

                weeks.push(week);
            }

            let diff = daysInCurrentMonth - weeks[4][6].date.format("D");

            if (diff > 0 && diff < 3) {
                week = [];
                for (let dayIndex = 0; dayIndex < 7; dayIndex++) {
                    week.push(this.getDayObject(monthMomentObject, dayIndex));

                    monthMomentObject.add(1, "day");
                }

                weeks.push(week);
            }

            return weeks;
        },
        appLocale: function () {
            return 'ru';
        },
        events: function () {
            return this.eventsList;
        },
    },
    methods: {
        getEvents(date) {
            return this.events.filter((event) => {
                return date.isSame(event.date, "day") ? event : null;
            });
        },

        getMonthViewStartDate(date, firstDay) {
            firstDay = parseInt(firstDay);

            let start = moment(date).locale(this.appLocale);
            let startOfMonth = moment(start.startOf("month"));

            start.subtract(startOfMonth.day(), "days");

            if (startOfMonth.day() < firstDay) {
                start.subtract(7, "days");
            }

            start.add(firstDay, "days");

            return start;
        },

        getDayObject(monthMomentObject, dayIndex) {
            return {
                isToday: monthMomentObject.isSame(moment(), "day"),
                isCurrentMonth: monthMomentObject.isSame(
                    this.currentMonth,
                    "month"
                ),
                weekDay: dayIndex,
                isWeekEnd: dayIndex == 5 || dayIndex == 6,
                date: moment(monthMomentObject),
                events: this.getEvents(monthMomentObject),
            };
        },
    },
    filters: {
        weekDayName(weekday, firstDay, locale) {
            firstDay = parseInt(firstDay);
            const localMoment = moment().locale(locale);
            return localMoment.localeData().weekdaysShort()[
                (weekday + firstDay) % 7
            ];
        },
    },
};
</script>
<style>
ul,
p {
    margin: 0;
    padding: 0;
}

.full-calendar-body {
    margin-top: 20px;
}
.weeks {
    display: flex;
    border-top: 1px solid #e0e0e0;
    border-bottom: 1px solid #e0e0e0;
    border-left: 1px solid #e0e0e0;
}
.week {
    flex: 1;
    padding: 5px;
    text-align: center;
    border-right: 1px solid #e0e0e0;
}

.dates {
    position: relative;
}
</style>
