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
            {{ event.title }}
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
    methods: {
        editEvent() {
            if (this.isDaySelected) {
                window.location.href = `/admin/lesson/${this.event.id}/edit`;
            }
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
