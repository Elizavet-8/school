<template>
    <div
        class="panel no-margin"
        :class="[event.color]"
        @click="editEvent"
    >
        <div
            class="panel-heading event-title btn btn-block btn-primary mb-1"
            :class="{ 'clickable-event': isDaySelected }"
        >
            {{ time }}<br>{{ course }}<br v-if="(themes.length > 0)">{{ themes }}<br>{{ teacher }}

        </div>
    </div>
</template>

<script>
export default {
    props: {
        event: {
            type: Object,
        },
        isDaySelected: {
            type: Boolean,
        },
        day: {
            type: Object,
        },
    },
    computed: {
        time() {
            const started = new Date(this.event.lesson.started_at);
            const ended = new Date(this.event.lesson.ended_at);

            const start_time = this.makeTime(started);
            const end_time = this.makeTime(ended);

            return `${start_time} - ${end_time}`;
        },
        course() {
            return this.event.lesson.course.title;
        },
        teacher() {
            return "учитель: " + this.event.lesson.course.user.name;
        },
        themes() {
            let themes = "";

            if (this.event.lesson.themes.length == 0) {
                return themes;
            }
            
            themes = "тема: ";

            this.event.lesson.themes.forEach(theme => {
                themes += theme.title + " ";
            });

            return themes;
        }
    },
    methods: {
        editEvent() {
            if (this.isDaySelected) {
                window.location.href = `/admin/lesson/${this.event.id}/edit`;
            }
        },

        makeTime(time) {
            let minutes;
            let hours;

            time.getMinutes() < 10
                ? (minutes = "0" + time.getMinutes())
                : (minutes = "" + time.getMinutes());

            let finalHours = time.getHours() + 3;

            if (finalHours == 24) {
                finalHours = 0;
            }

            finalHours < 10
                ? (hours = "0" + finalHours)
                : (hours = "" + finalHours);

            return "" + hours + ":" + minutes;
        },
    },
};
</script>
<style>
.event-title {
    padding: 0px 5px;
    font-size: 12px;
}
.clickable-event {
    text-decoration: underline;
}
</style>
