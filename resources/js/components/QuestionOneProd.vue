<template>
    <div class="test-block">
        <div class="test-number number">
            {{ index }} <b>/ {{ questionsintest }}</b>
        </div>
        <div class="test-main test-exercise-in-topical-diagnostics">
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
                <div class="compliance-block" style="margin-left: 0">
                    <div class="radio test-radio">
                        <div
                            v-for="(answer, key) in question.answers"
                            :key="key"
                        >
                            <input
                                class="form-check-input"
                                type="radio"
                                :id="key + '-radio-' + index"
                                :name="'radio-' + index"
                                :value="key"
                                v-model="picked"
                                :disabled="completed"
                            />
                            <label
                                :for="key + '-radio-' + index"
                                v-bind:class="{
                                    correct: check(picked, correct, key) == 1,
                                    incorrect: check(picked, correct, key) == 0
                                }"
                            >
                                {{ answer.text }}
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div
                style="color:red"
                v-if="completed && picked !== correct && question.comment"
            >
                {{ question.comment }}
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["question", "index", "questionsintest", "completed", "answers"],
    created() {
        if (this.completed) {
            this.picked = this.currentQuestionAnswer.actual;
        }
        const correct = JSON.parse(this.question.correct);
        this.correct = correct[0].result;

        this.$emit("answer", {
            answer: this.picked == this.correct,
            actual: this.picked,
            question_index: this.question.id
        });
    },
    data: function() {
        return {
            picked: -1,
            correct: 0
        };
    },
    watch: {
        picked: {
            handler: function(newVal, oldVal) {
                this.$emit("answer", {
                    answer: this.picked == this.correct,
                    actual: this.picked,
                    question_index: this.question.id
                });
            },
            deep: true
        }
    },
    methods: {
        check(answer, correct, current) {
            if (!this.completed) {
                return null;
            }

            if (answer != current) {
                return null;
            }

            if (answer === correct) {
                return 1;
            }

            return 0;
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
