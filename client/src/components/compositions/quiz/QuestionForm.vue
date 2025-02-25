<template>
  <div class="question_container">
    <div class="question_wrapper">
      <div class="question_header">
        <span class="question_number">{{ currentQuestionIndex + 1 }}</span>
        <h2 class="question_text">{{ currentQuestion.question_text }}</h2>
      </div>

      <div class="options_container">
        <button v-for="(option, index) in currentQuestion.options" :key="option.id" :class="[
          'option_button',
          {
            selected: selectedOption === option.id,
            correct: answer && option.is_correct && answer.option_id === option.id,
            incorrect: answer && !option.is_correct && answer.option_id === option.id
          }
        ]" @click="selectOption(option.id)">
          <span class="option_letter">{{ ['A', 'B', 'C', 'D'][index] }}</span>
          <span class="option_text">{{ option.option_text }}</span>
          <span v-if="answer && option.is_correct && answer.option_id === option.id" class="status_icon correct"
            v-html="check_circle">
          </span>
          <span v-if="answer && !option.is_correct && answer.option_id === option.id" class="status_icon incorrect"
            v-html="times_circle">
          </span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import times_circle from '@/assets/times_circle.svg?raw'
import check_circle from '@/assets/check_circle.svg?raw'

export default {
  name: 'QuestionForm',
  emits: ['selectOption'],
  props: {
    currentQuestionIndex: {
      type: Number,
      required: true
    },
    currentQuestion: {
      type: Object,
      required: true
    },
    selectedOption: {
      type: [String, Number, null],
      default: null
    },
    answer: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      times_circle,
      check_circle
    }
  },
  methods: {
    selectOption(optionId) {
      this.$emit('selectOption', optionId)
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.question_container {
  width: 100%;
  margin-bottom: 2rem;
}

.question_wrapper {
  width: 40rem;
  max-width: calc(100vw - 2.5rem);
  margin: 0 auto;
}

.question_header {
  display: flex;
  align-items: flex-start;
  margin-bottom: 1rem;
}

.question_number {
  font-family: $FONT_BOLD;
  font-size: 2.5rem;
  color: $VADER;
  line-height: .8;
  margin-right: 1rem;
}

.question_text {
  font-family: $FONT_REGULAR;
  font-size: $FONT_SIZE_S;
  margin: 0;
  color: $VADER;
}

.options_container {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.option_button {
  display: flex;
  align-items: center;
  width: 40rem;
  max-width: calc(100vw - 4rem);
  padding: 1rem;
  border: 1px solid transparent;
  box-shadow: 0 0 0 1px #cecece;
  border-radius: 8px;
  background: white;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: left;
  position: relative;

  &:hover,
  &.selected {
    border-color: #196ef4;
    background: #edfcfe;

    .option_letter {
      background: #ccf5f5;
      border-color: #108484;
    }
  }

  &.correct,
  &.incorrect {
    .option_letter {
      background: #ccf5f5;
      border-color: #108484;
    }
  }

  &.correct {
    border-color: #3da461;
    background: #f0fff0;
  }

  &.incorrect {
    border-color: #ec407a;
    background: #fdf7f7;
  }
}

.option_letter {
  display: inline-block;
  text-align: center;
  font-family: $FONT_BOLD;
  font-size: $FONT_SIZE_M;
  line-height: 1.4;
  width: 24px;
  height: 24px;
  border: 2px solid #e0e0e0;
  border-radius: 50%;
  margin-right: 1rem;
  transition: all 0.2s ease;
}

.option_text {
  font-family: $FONT_REGULAR;
  font-size: $FONT_SIZE_S;
  flex: 1;
}

.status_icon {
  position: absolute;
  right: -2rem;
  fill: v-bind(color);

  :deep(svg) {
    width: 1.2rem;
  }

  &.correct {
    color: #4CAF50;
  }

  &.incorrect {
    color: #F44336;
  }
}
</style>