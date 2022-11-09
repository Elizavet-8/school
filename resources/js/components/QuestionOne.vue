<template>
    <div>
        <div>{{ index }}. {{ question.content }}</div>
        <div
            class="form-check"
            v-for="(answer, index) in question.answers"
            :key="index"
        >
            <input
                class="form-check-input"
                type="radio"
                :id="index"
                :value="index"
                v-model="picked"
            />
            <label class="form-check-label" for="exampleRadios1">
                {{ answer.text }}
            </label>
        </div>
    </div>
</template>

<script>
export default {
    props: ["question", "index", "admin"],
    created() {
        let correct;

        correct = JSON.parse(this.question.correct);

        if (this.admin) {
            this.picked = correct[0].result;
        }
        this.correct = correct[0].result;

        if (!this.admin) {
            this.$emit("answer", {
                answer: this.picked == this.correct,
                question_index: this.question.id
            });
        } else {
            this.$emit("answer", {
                answer: this.picked,
                question_index: this.index
            });
        }
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
                if (!this.admin) {
                    this.$emit("answer", {
                        answer: this.picked == this.correct,
                        question_index: this.question.id
                    });
                } else {
                    this.$emit("answer", {
                        answer: this.picked,
                        question_index: this.index
                    });
                }
            },
            deep: true
        }
    }
};
</script>
