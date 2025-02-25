<template>
  <Navigator
    :items="[
      { text: 'Acceleration', to: '', icon: topicAvatar },
      { text: 'Quiz', to: '' }
    ]"
  />
  <div class="separator"></div>
  <div class="quiz_questions_screen">
    <div v-if="loading" class="quiz_form">
      Loading questions...
    </div>
    <div v-else class="quiz_form">
      <QuestionForm 
        :currentQuestionIndex="currentQuestionIndex" 
        :currentQuestion="currentQuestion" 
        :selectedOption="selectedOption"
        @selectOption="selectOption" />
    </div>
  </div>
  
  <div class="footer">
    <BaseButton
      theme="OUTLINE"
      v-if="currentQuestionIndex > 0" 
      class="back_button" 
      @click="previousQuestion"
    >
      Back
    </BaseButton>
    <BaseButton
      theme="SECONDARY"
      :class="['next_button', { disabled: !selectedOption }]" 
      @click="nextQuestion"
      :disabled="!selectedOption"
    >
      {{ isLastQuestion ? 'Finish' : 'Next' }}
    </BaseButton>
  </div>
</template>

<script>
import BaseButton from '@/components/base/button/BaseButton.vue';
import Navigator from '@/components/compositions/navigator/Navigator.vue'
import QuestionForm from '@/components/compositions/quiz/QuestionForm.vue'
import topicAvatar from '@/assets/topic_avatar.svg?raw';

export default {
  name: 'QuizQuestionsScreen',
  components: { Navigator, BaseButton, QuestionForm },
  emits: ['finish'],
  data() {
    return {
      currentQuestionIndex: 0,
      selectedOptions: new Array(5).fill(null),
      questions: [],
      loading: true,
      topicAvatar: topicAvatar
    }
  },
  created() {
    this.fetchQuestions()
  },
  computed: {
    currentQuestion() {
      return this.questions[this.currentQuestionIndex]
    },
    selectedOption: {
      get() {
        return this.selectedOptions[this.currentQuestionIndex]
      },
      set(value) {
        this.selectedOptions[this.currentQuestionIndex] = value
      }
    },
    isLastQuestion() {
      return this.currentQuestionIndex === this.questions.length - 1
    }
  },
  methods: {
    async fetchQuestions() {
      try {
        const response = await fetch('http://localhost:3000/api/questions', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })
        const data = await response.json()
        this.questions = data
      } catch (error) {
        console.error('Error fetching questions:', error)
      } finally {
        this.loading = false
      }
    },
    selectOption(optionId) {
      this.selectedOption = optionId
    },
    nextQuestion() {
      if (!this.selectedOption) return
      
      if (this.isLastQuestion) {
        this.finishQuiz()
      } else {
        this.currentQuestionIndex++
      }
    },
    previousQuestion() {
      if (this.currentQuestionIndex > 0) {
        this.currentQuestionIndex--
      }
    },
    async finishQuiz() {
      console.log('Quiz completed!', this.selectedOptions)
      try {
        const response = await fetch('http://localhost:3000/api/quiz', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify({
            questions: this.selectedOptions.map((option, index) => ({
              id: this.questions[index].id,
              selectedOption: option
            }))
          })
        })
        const data = await response.json()
        console.log('Quiz submitted:', data)
        this.$emit('finish')
      } catch (error) {
        console.error('Error submitting quiz:', error)
      }
    }
  }
}
</script>

<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.separator {
  height: 65px;
  background: #f3f3f3;
  border-bottom: 1px solid #e3e3e3;
}

.quiz_questions_screen {
  display: flex;
  flex-direction: column;
  padding: 2rem;
  max-width: 800px;
  margin: 100px auto;

  @media (max-width: 768px) {
    padding: 0;
  }
}

.quiz_form {
  background: white;
  border-radius: 8px;
  padding: 2rem;
}

.footer {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1rem;
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
  border-top: 1px solid #e0e0e0;
  background: white;
}
</style>