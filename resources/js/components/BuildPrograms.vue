<template>
    <div class="build__row">
        <div class="build__tabs">
            <div
                class="build__tab"
                v-for="(tab, index) in tabs"
                :key="index + 'j'"
                @click="selectedTab = tab.title"
                :class="{ active: selectedTab == tab.title }"
            >
                {{ tab.title }}
            </div>
        </div>

        <div class="tab__content">
            <img
                class="build__list_img"
                src="/images/landing/choice2.png"
                alt="capability"
            />
            <template>
                <ul class="build__list">
                    <li
                        class="build__item"
                        v-for="(subject, index) in subjects"
                        :key="index + 'i'"
                        @click="selectedsubject = subject"
                        :class="{ active: selectedsubject.id == subject.id }"
                    >
                        {{ subject.title | noGradeNumber(selectedTab) }}
                    </li>
                </ul>
            </template>
        </div>

        <SubjectProgram :selectedsubject="selectedsubject"></SubjectProgram>
    </div>
</template>

<script>
import SubjectProgram from "./landing/SubjectProgram.vue";
export default {
    filters: {
        noGradeNumber: function(value, selectedTab) {
            const classNumber = selectedTab.split(" ")[0];
            return value.replace(" " + classNumber, "");
        }
    },
    components: {
        // ClassProgram
        SubjectProgram
    },
    data: () => ({
        tabs: [
            {
                title: "1 класс"
            },
            {
                title: "2 класс"
            },
            {
                title: "3 класс"
            },
            {
                title: "4 класс"
            },
            {
                title: "5 класс"
            },
            {
                title: "6 класс"
            },
            {
                title: "7 класс"
            },
            {
                title: "8 класс"
            },
            {
                title: "9 класс"
            },
            {
                title: "10 класс"
            },
            {
                title: "11 класс"
            }
        ],
        selectedTab: "1 класс",
        subjects: [],
        selectedsubject: ""
    }),
    created() {
        this.getSubjects();
    },
    methods: {
        /*selectTab() {
            this.selectedTab = this.tab.title;
        },
        selectsubject() {
            this.selectedsubject = this.subject.title;
        }*/
        getSubjects() {
            const classNumber = this.selectedTab.split(" ")[0];

            axios
                .get("/subjects?grade=" + classNumber)
                .then(res => {
                    this.subjects = res.data;
                    if (this.subjects.length > 0) {
                        this.selectedsubject = this.subjects[0];
                    } else {
                        this.selectedsubject = "";
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
    },
    watch: {
        selectedTab() {
            this.getSubjects();
        },
        subjects: {
            handler: function() {},
            deep: true
        }
    }
};
</script>
