<template>
  <div class="search-container position-relative">
    <input
      type="text"
      class="form-control"
      v-model="query"
      @input="search"
      placeholder="Search for movies or events..."
    />
    <div v-if="results.length > 0" class="bg-white rounded shadow search-results">
      <ul class="list-group">
        <li class="list-group-item active">Movies</li>
        <li
          v-for="movie in filteredMovies"
          :key="movie.id"
          class="list-group-item"
        >
          🎬 {{ movie.title }}
        </li>
        <li v-if="filteredMovies.length === 0" class="list-group-item text-muted">No movies found</li>

        <li class="list-group-item active">Events</li>
        <li
          v-for="event in filteredEvents"
          :key="event.id"
          class="list-group-item"
        >
          🎟️ {{ event.name }}
        </li>
        <li v-if="filteredEvents.length === 0" class="list-group-item text-muted">No events found</li>
      </ul>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import debounce from "lodash.debounce";

export default {
  data() {
    return {
      query: "",
      results: [],
    };
  },
  computed: {
    filteredMovies() {
      return this.results.filter((item) => item.type === "movie");
    },
    filteredEvents() {
      return this.results.filter((item) => item.type === "event");
    },
  },
  methods: {
    search: debounce(async function () {
      if (this.query.length < 2) {
        this.results = [];
        return;
      }
      try {
        const response = await axios.get(`/api/search?query=${this.query}`);
        this.results = response.data;
      } catch (error) {
        console.error("Search failed", error);
      }
    }, 500), // Debounce to avoid too many requests
  },
};
</script>

<style scoped>
.search-container {
  width: 100%;
  max-width: 500px;
  margin: auto;
}
.search-results {
  position: absolute;
  width: 100%;
  top: 100%;
  left: 0;
  z-index: 1000;
}
.list-group-item {
  cursor: pointer;
}
.list-group-item:hover {
  background-color: #f8f9fa;
}
</style>
