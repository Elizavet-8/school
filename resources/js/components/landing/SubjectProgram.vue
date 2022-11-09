<template>
    <div v-if="accardions.length > 0" class="build-accordion__container">
        <template>
            <Accardion
                v-for="(accardion, index) in accardions"
                :key="index"
                v-on:open="open"
                :accardion="accardion"
            ></Accardion>
        </template>
    </div>
</template>

<script>
import Accardion from "../landing/Accardion.vue";
export default {
    props: ["selectedsubject"],
    components: {
        Accardion
    },
    methods: {
        open(data) {
            if (data.open == true) {
                this.accardions.forEach((accardion, index) => {
                    const isEqual = new Intl.Collator().compare(
                        accardion.title,
                        data.title
                    );
                    if (isEqual != 0) {
                        this.accardions[index].open = false;
                    }
                });
            }
        },
        getModules() {
            axios
                .get("/modules?subject=" + this.selectedsubject.id)
                .then(res => {
                    this.createAccordions(res.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        createAccordions(modules) {
            const accordions = [];
            modules.forEach((module, index) => {
                let open = false;

                if (index == 0) {
                    open = true;
                }

                const themeList = [];

                module.themes.forEach(theme => {
                    themeList.push(theme.title);
                });

                accordions.push({
                    open: open,
                    title: module.title,
                    list: themeList
                });
            });
            this.accardions = accordions;
        }
    },
    watch: {
        selectedsubject() {
            this.getModules();
        },
        accardions: {
            handler: function() {},
            deep: true
        }
    },
    data: () => ({
        accardions: []
    })
};
</script>
