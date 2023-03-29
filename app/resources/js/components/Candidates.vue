<template>
  <div>
    <div class="p-10">
      <h1 class="text-4xl font-bold">Candidates</h1>
    </div>
    <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-5">
      <div v-for="candidate in filterCandidates(candidates)" class="rounded overflow-hidden shadow-lg">
        <img class="w-full" src="/avatar.png" alt="candidate-avatar">
        <div class="px-6 py-4">
          <div class="font-bold text-xl mb-2">{{ candidate.name }}</div>
          <p class="text-gray-700 text-base">{{ candidate.description }}</p>
        </div>
        <div class="px-6 pt-4 pb-2">
        <span
            v-for="strength in JSON.parse(candidate.strengths)"
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
            :class="{'bg-teal-100': isActiveAttribute(strength, 'strengths')}"
        >
          {{ strength }}
        </span>
        </div>
        <div class="px-6 pb-2">
        <span
            v-for="skill in JSON.parse(candidate.soft_skills)"
            class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
            :class="{'bg-teal-100': isActiveAttribute(skill, 'skills')}"
        >
          {{ skill }}
        </span>
        </div>
        <div
            v-if="candidate.companies.length"
            class="px-6 py-4 font-bold text-gray-600"
        >
          Candidate status:
          <span
              v-for="data in candidate.companies"
              class="inline-block bg-teal-100 px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2"
          >
            {{ data.pivot.status.toUpperCase() }}
          </span>
        </div>
        <div class="p-6 float-right">
          <button
              class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow"
              :disabled="isLoadingContact"
              @click="contactCandidate(candidate.id)"
          >
            Contact
          </button>
          <button
              class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 hover:bg-teal-100 rounded shadow"
              :disabled="isLoadingHire"
              @click="hireCandidate(candidate.id)"
          >
            Hire
          </button>
        </div>
      </div>
    </div>
    <MvpCandidates />
  </div>
</template>

<script>
import MvpCandidates from "./MvpCandidates.vue";
import { EventBus } from '../event-bus';

export default {
  components: {
    MvpCandidates
  },
  props: ['candidates'],
  data() {
    return {
      isLoadingContact: false,
      isLoadingHire: false,
      action: 'contacted',
      desiredStrengths: [
        'Vue.js', 'Laravel', 'PHP', 'TailwindCSS',
      ],
      desiredSoftSkills: [
        'Leadership', 'Conflict management',
      ],
    }
  },
  methods: {
    async contactCandidate(candidateId) {
      this.isLoadingContact = true;

      try {
        await axios
            .post('http://localhost:8080/candidates-contact', { candidate_id: candidateId })
        EventBus.$emit('update-coins');
        this.$toast.success("Candidate successfully contacted!");
      } catch (error) {
        console.warn(error)
        this.$toast.error("Something went wrong or candidate was already contacted!");
      } finally {
        this.isLoadingContact = false;
      }
    },
    async hireCandidate(candidateId) {
      this.isLoadingHire = true;

      try {
        await axios
            .post('http://localhost:8080/candidates-hire', { candidate_id: candidateId })
        EventBus.$emit('update-coins');
        this.$toast.success("Candidate successfully hired!");
      } catch (error) {
        console.warn(error)
        this.$toast.error("Something went wrong or candidate was not yet contacted!");
      } finally {
        this.isLoadingHire = false;
      }
    },
    isActiveAttribute(attribute, type) {
      if (type === 'strengths') {
        return this.desiredStrengths.includes(attribute);
      }

      return this.desiredSoftSkills.includes(attribute)
    },
    filterCandidates(candidates) {
      return candidates.filter((candidate) => !JSON.parse(candidate.strengths).includes('Wordpress'))
    }
  },
}
</script>
