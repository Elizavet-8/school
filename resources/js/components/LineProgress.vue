<template>
    <div class="line" :style="styles"></div>
</template>

<script>
export default {
    name: "PercentCounter",
    props: ['percent'],
    data() {
        return {
            count: 0
        }
    },
    methods: {
        animateValue: function (start, end, duration) {
            if (start === end) return;
            const range = end - start;
            let current = start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            const timer = setInterval( () => {
                current += increment;
                this.count = current;
                if (current === end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }
    },
    mounted() {
        this.animateValue(0, this.percent, 2500)
    },
    computed: {
        styles() {
            return {
                width: `${this.count}%`
            };
        }
    }
}
</script>
