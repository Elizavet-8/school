<template>
    <div class="test-block">
        <div class="test-number number">
            {{ index }} <b>/ {{ questionsintest }}</b>
        </div>
        <div class="test-main test-prevalence-of-paralysis">
            <p class="test-caption">
                {{ question.content }}
            </p>
            <img
                v-if="question.img_url"
                class="mb-3"
                :src="question.img_url"
                alt="test-img"
                style="max-width:100%"
            />
            <div class="test-compliance">
                <div class="compliance-block" style="margin-left:0">
                    <div class="row">
                        <div class="compliance-elem">
                            <div class="compliance-input" style="padding:0">
                                <input
                                    type="text"
                                    class="test-input compliance-input"
                                    v-model="text"
                                    :readonly="completed"
                                    v-bind:class="{
                                        correct: check(text, correct) == 1,
                                        incorrect: check(text, correct) == 0
                                    }"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                style="color:red"
                v-if="check(text, correct) == 0 && question.comment"
            >
                {{ question.comment }}
            </div>
        </div>
    </div>
    <!-- <div style="margin-bottom:50px">
        <div>{{ index }}. {{ question.content }}</div>
        <div class="form-check">
            <input class="form-check-input" type="text" v-model="text" />
        </div>
    </div> -->
</template>

<script>
export default {
    props: ["question", "index", "questionsintest", "completed", "answers"],
    created() {
        if (this.completed) {
            this.text = this.currentQuestionAnswer.actual;
        }
        const correct = JSON.parse(this.question.correct);
        this.correct = correct[0].result;

        this.$emit("answer", {
            answer: this.checkAnswer(this.text, this.correct),
            actual: this.text,
            question_index: this.question.id
        });
    },
    data: function() {
        return {
            text: "",
            correct: ""
        };
    },
    watch: {
        text: {
            handler: function(newVal, oldVal) {
                this.$emit("answer", {
                    answer: this.checkAnswer(this.text, this.correct),
                    actual: this.text,
                    question_index: this.question.id
                });
            },
            deep: true
        }
    },
    methods: {
        b64DecodeUnicode(str) {
            // Going backwards: from bytestream, to percent-encoding, to original string.
            return decodeURIComponent(
                atob(str)
                    .split("")
                    .map(function(c) {
                        return (
                            "%" +
                            ("00" + c.charCodeAt(0).toString(16)).slice(-2)
                        );
                    })
                    .join("")
            );
        },
        // equalsIgnoreOrder(a, b) {
        //     if (a.length !== b.length) return false;
        //     const uniqueValues = new Set([...a, ...b]);
        //     for (const v of uniqueValues) {
        //         const aCount = a.filter(e => e === v).length;
        //         const bCount = b.filter(e => e === v).length;
        //         if (aCount !== bCount) return false;
        //     }
        //     return true;
        // },
        insensitiveSearch(str1, str2) {
            let search_str = new RegExp(str2, "ig");

            if (!str1) return false;

            var result = str1.search(search_str);

            return result != -1;
        },
        check(answer, correct) {
            if (!this.completed) {
                return null;
            }

            if (this.insensitiveSearch(answer, correct)) {
                return 1;
            }

            return 0;
        },
        checkAnswer(answer, correct) {
            if (this.insensitiveSearch(answer, correct)) {
                return true;
            }

            return false;
        }
    },
    computed: {
        currentQuestionAnswer() {
            if (!this.completed) {
                return null;
            }

            return this.answers.find(x => x.question_index == this.question.id);
        }
    }
};
</script>
