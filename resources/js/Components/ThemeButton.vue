<template>
    <button
        type="button"
        name="Toggle theme"
        id="Toggle theme"
        class="flex h-11 w-11 items-center justify-center rounded-md border text-white transition-colors border-neutral-200 "
        @click="handleToggle"
        :title="!isFantasyTheme ? 'Switch to light theme' : 'Switch to dark theme'"
    >
    <span class="swap swap-rotate">
        <!-- Ikona słońca (tryb ciemny) -->
      <svg
          v-if="!isFantasyTheme"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="swap-off h-6 w-6"
      >
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z" />
      </svg>

        <!-- Ikona księżyca (tryb fantasy) -->
      <svg
          v-if="isFantasyTheme"
          class="swap-off h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
      >
          <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
        </svg>

    </span>
    </button>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const theme = ref(localStorage.getItem('theme') || 'dark');
const isFantasyTheme = ref(theme.value === 'fantasy');

// Obsługa zmiany tematu
const handleToggle = () => {
    isFantasyTheme.value = !isFantasyTheme.value;
    theme.value = isFantasyTheme.value ? 'fantasy' : 'dark';
};

// Aktualizacja atrybutu `data-theme` na elemencie HTML
const updateTheme = () => {
    document.documentElement.setAttribute('data-theme', theme.value);
    localStorage.setItem('theme', theme.value);
};

// Aktualizacja na zmianę tematu
watch(theme, updateTheme);

// Inicjalizacja na zamontowanie komponentu
onMounted(updateTheme);
</script>
