<template>
  <div class="start_container">
    <BackgroundWave />
    <Navigator
      :items="[
        { text: name, to: `/feature/quiz` },
        { text: 'Quiz', to: '' }
      ]"
    />
    <main class="start_content">
      <h1>Quiz</h1>
      <h2 class="capitalize">{{ name }}</h2>
      <h3 class="capitalize">{{ questionsLength }} questions</h3>
      <Jumbotron title="Get Ready" info="Once start you can't go back.">
        <div class="image_container">
          <img src="@/assets/quiz-image-1.png" alt="" class="image" />
          <img src="@/assets/quiz-image-2.png" alt="" class="image" />
        </div>
        <Badge class="badge"></Badge>
        <div class="button_container">
          <BaseButton :theme="BUTTON_THEMES.SECONDARY" @click="start" v-if="quiz && quiz.length === 0">Start</BaseButton>
          <BaseButton :theme="BUTTON_THEMES.SECONDARY" @click="viewResults" v-if="quiz && quiz.length > 0">View Results</BaseButton>
          <BaseButton :theme="BUTTON_THEMES.OUTLINE" @click="start" v-if="quiz && quiz.length > 0">Retake Quiz</BaseButton>
        </div>
      </Jumbotron>
    </main>
  </div>
</template>

<script>
// CONFIGURATIONS
import { THEMES as BUTTON_THEMES } from '@/components/base/button/config.js'

// COMPONENTS
import BackgroundWave from '@/components/base/backgrounds/wave/BackgroundWave.vue'
import BaseButton from '@/components/base/button/BaseButton.vue'
import Jumbotron from '@/components/base/jumbotron/Jumbotron.vue'
import Badge from '@/assets/badge.svg?component'

// COMPOSITIONS
import Navigator from '@/components/compositions/navigator/Navigator.vue'

export default {
  name: 'QuizStartScreen',
  emits: ['start', 'finish'],
  components: { BaseButton, Jumbotron, BackgroundWave, Badge, Navigator },

  data() {
    return {
      quiz: [],
      BUTTON_THEMES
    }
  },
  props: {
    name: {
      type: String,
      default: 'Quiz name'
    },
    questionsLength: {
      type: Number,
      default: 5
    }
  },
  created() {
    this.fetchQuiz()
  },
  methods: {
    start() {
      this.$emit('start')
    },
    viewResults() {
      this.$emit('finish')
    },
    async fetchQuiz() {
      try {
        const response = await fetch('http://localhost:3000/api/quiz', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })
        if (!response.ok) {
          if (response.status === 401) {
            this.$router.push({ name: 'login' })
          }
          throw new Error(`HTTP error! status: ${response.status}`)
        }
        const data = await response.json()
        this.quiz = data.quiz
      } catch (error) {
        localStorage.removeItem('token')
        localStorage.removeItem('loggedIn')
        console.error('Error fetching quiz:', error)
      }
    }
  }
}
</script>
<style lang="scss" scoped>
@import '@/utilities/css/vars/vars.scss';

.start_container {
  min-height: 100vh;
  color: #343a41;
}

.start_content {
  margin-block: 40px auto;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  gap: 1.2rem;
}

.image_container {
  display: flex;
  justify-content: space-evenly;
  width: 100%;
  gap: 8px;
  margin-block-end: 15px;
}

.badge {
  margin-block-start: -45px;
  background: white;
  border-radius: 50px;
  padding: 6px;
}

.image {
  width: clamp(120px, 30vw, 174px);
  height: auto;
}

.button_container {
  display: flex;
  gap: 1rem;
}
</style>
