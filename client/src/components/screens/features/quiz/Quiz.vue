<template>
  <div class="quiz_container">
    <div v-if="data">
      <QuizStartScreen v-if="quizState === QUIZ_STATES.START" :name="data.name" :questionsLength="data.questions.length" @start="start" @finish="finish"></QuizStartScreen>
      <QuizQuestionsScreen v-if="quizState === QUIZ_STATES.QUESTIONS" @finish="finish"></QuizQuestionsScreen>
      <QuizSummeryScreen v-if="quizState === QUIZ_STATES.SUMMARY"></QuizSummeryScreen>
    </div>
    <div v-else>Loading...</div>
  </div>
</template>

<script>
import QuizStartScreen from './startScreen/QuizStartScreen.vue'
import QuizQuestionsScreen from './questionsScreen/QuizQuestionsScreen.vue'
import QuizSummeryScreen from './summeryScreen/QuizSummeryScreen.vue';

const QUIZ_STATES = {
  START: 'start',
  QUESTIONS: 'questions',
  SUMMARY: 'summary'
}

export default {
  name: 'Quiz',
  components: {
    QuizStartScreen,
    QuizQuestionsScreen,
    QuizSummeryScreen
  },
  props: {
    data: {
      type: Object,
      required: false
    }
  },
  data() {
    return {
      QUIZ_STATES,
      quizState: QUIZ_STATES.START
    }
  },
  methods: { 
    start() {
      this.quizState = QUIZ_STATES.QUESTIONS
    },
    finish() {
      this.quizState = QUIZ_STATES.SUMMARY
    }
  }
}
</script>

<style lang="scss" scoped></style>
