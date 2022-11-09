<template>
    <div class="build-accordion">
        <div
            class="build-accordion__head"
            @click="accardion.open = !accardion.open"
            v-bind:class="{ active: accardion.open }"
        >
            {{ accardion.title }}
            <svg
                width="13"
                height="7"
                viewBox="0 0 13 7"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
                class="build-accordion__svg"
                v-bind:class="{ active: accardion.open }"
            >
                <path
                    d="M13.0005 0.487709C13.0005 0.551732 12.9879 0.615133 12.9634 0.674292C12.9389 0.73345 12.903 0.787206 12.8577 0.832491L6.84543 6.84068C6.75396 6.93206 6.62992 6.9834 6.50059 6.9834C6.37126 6.9834 6.24722 6.93206 6.15575 6.84068L0.14344 0.832491C0.0981338 0.787235 0.0621908 0.733505 0.0376631 0.674367C0.0131354 0.615229 0.000503394 0.551841 0.000488295 0.487824C0.000473196 0.423807 0.0130754 0.360414 0.0375751 0.301264C0.0620749 0.242115 0.0979926 0.188366 0.143277 0.143088C0.188562 0.0978107 0.242327 0.0618911 0.301503 0.0373788C0.360678 0.012867 0.424106 0.000242233 0.488163 0.000226974C0.55222 0.000211716 0.615654 0.0128064 0.674841 0.0372906C0.734028 0.0617752 0.78781 0.0976706 0.833116 0.142927L6.50043 5.80666L12.1677 0.142927C12.236 0.0747123 12.3229 0.0282521 12.4175 0.00942612C12.5122 -0.00940037 12.6103 0.000252247 12.6994 0.0371637C12.7886 0.0740752 12.8648 0.136587 12.9184 0.216786C12.9719 0.296986 13.0005 0.39127 13.0005 0.487709Z"
                    fill="#14134F"
                />
            </svg>
        </div>
        <transition name="fade">
            <div v-if="accardion.open" class="build-accordion__body">
                <p v-for="item in accardion.list" :key="item">
                    {{ item }}
                </p>
            </div>
        </transition>
    </div>
</template>
<script>
export default {
    props: ["accardion"],
    watch: {
        accardion: {
            handler: function() {
                this.$emit("open", this.accardion);
            },
            deep: true
        }
    }
};
</script>
<style>
.slide-fade-enter-active {
    transition: all 0.3s ease;
}
.slide-fade-leave-active {
    transition: all 0.2s cubic-bezier(1, 0.5, 0.8, 1);
}
.slide-fade-enter, .slide-fade-leave-to
/* .slide-fade-leave-active до версии 2.1.8 */ {
    transform: translateX(10px);
    opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
