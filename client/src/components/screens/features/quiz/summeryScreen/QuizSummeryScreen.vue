<template>
  <Navigator :items="[
    { text: 'Test Quiz', to: '', icon: topicAvatar },
    { text: 'Summery', to: '' }
  ]" />
  <div class="separator"></div>
  <div class="score">
    <p>Scored {{ score }} / {{ totalQuestions }}</p>
  </div>
  <div class="quiz_summery_screen">
    <QuestionForm v-for="(question, index) in questions" :key="question.id" :currentQuestion="question"
      :currentQuestionIndex="index" :answer="getAnswerForQuestion(question.id)" />
  </div>
</template>

<script>
import Navigator from '@/components/compositions/navigator/Navigator.vue';
import QuestionForm from '@/components/compositions/quiz/QuestionForm.vue';
import topicAvatar from '@/assets/topic_avatar.svg?raw';

export default {
  name: 'QuizSummeryScreen',
  components: {
    Navigator,
    QuestionForm,
  },
  data() {
    return {
      quiz: [],
      questions: [],
      topicAvatar: topicAvatar
    }
  },
  created() {
    this.fetchQuiz()
  },
  methods: {
    async fetchQuiz() {
      try {
        const response = await fetch('http://localhost:3000/api/quiz', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })
        const data = await response.json()
        this.quiz = data.quiz
        this.questions = data.questions
      } catch (error) {
        console.error('Error fetching quiz:', error)
      }
    },
    getAnswerForQuestion(questionId) {
      return this.quiz.find(answer => answer.question_id === questionId) || null
    }
  },
  computed: {
    score() {
      // If no questions or quiz data yet, return 0
      if (!this.questions.length || !this.quiz.length) {
        return 0
      }

      // Calculate score by comparing user answers with correct answers
      let correctAnswers = 0

      // For each question in the quiz
      this.quiz.forEach(userAnswer => {
        // Find the question this answer belongs to
        const question = this.questions.find(q => q.id === userAnswer.question_id)

        if (question) {
          // Find the correct option for this question
          const correctOption = question.options.find(option => option.is_correct)

          // If user selected the correct option, increment score
          if (correctOption && userAnswer.option_id === correctOption.id) {
            correctAnswers++
          }
        }
      })

      return correctAnswers
    },
    totalQuestions() {
      return this.questions.length
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.quiz_summery_screen {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  margin: 60px auto 0;
}

.navigation {
  position: relative;
}

.separator {
  height: 65px;
  background: #f3f3f3;
  border-bottom: 1px solid #e3e3e3;
}

.score {
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: $FONT_BOLD;
  font-size: $FONT_SIZE_XL;
  height: 65px;
  background: #eef7f7;
  border-bottom: 1px solid #e3e3e3;
}

.question_container {
  padding-bottom: 2rem;

  &:not(:last-child) {
    border-bottom: 1px solid #e3e3e3;
  }
}
</style>