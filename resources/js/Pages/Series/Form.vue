<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import DatePicker from "@/Components/DatePicker.vue";

const props = defineProps({
    series: {
        type: Object,
        default: () => ({
            name: "",
            logo: "",
            category_id: null,
            stream_type: "series",
            is_active: true,
            description: "",
            release_date: null,
            director: "",
            cast: "",
            genre: "",
            rating: "",
            poster: "",
            backdrop: "",
            trailer_url: "",
            seasons: [],
        }),
    },
    categories: Array,
});

const form = useForm({
    name: props.series.name,
    logo: props.series.logo,
    category_id: props.series.category_id,
    stream_type: props.series.stream_type,
    is_active: props.series.is_active,
    description: props.series.description,
    release_date: props.series.release_date,
    director: props.series.director,
    cast: props.series.cast,
    genre: props.series.genre,
    rating: props.series.rating,
    poster: props.series.poster,
    backdrop: props.series.backdrop,
    trailer_url: props.series.trailer_url,
    seasons: props.series.seasons || [],
});

const newSeason = ref({
    name: "",
    season_number: "",
    description: "",
    poster: "",
    episodes: [],
});

const newEpisode = ref({
    name: "",
    episode_number: "",
    stream_url: "",
    description: "",
    duration: "",
    air_date: "",
    poster: "",
    subtitles: [],
    audio_tracks: [],
});

const addSeason = () => {
    if (newSeason.value.name && newSeason.value.season_number) {
        form.seasons.push({
            ...newSeason.value,
            episodes: [],
        });
        newSeason.value = {
            name: "",
            season_number: "",
            description: "",
            poster: "",
            episodes: [],
        };
    }
};

const removeSeason = (index) => {
    form.seasons.splice(index, 1);
};

const addEpisode = (seasonIndex) => {
    if (newEpisode.value.name && newEpisode.value.episode_number && newEpisode.value.stream_url) {
        form.seasons[seasonIndex].episodes.push({
            ...newEpisode.value,
        });
        newEpisode.value = {
            name: "",
            episode_number: "",
            stream_url: "",
            description: "",
            duration: "",
            air_date: "",
            poster: "",
            subtitles: [],
            audio_tracks: [],
        };
    }
};

const removeEpisode = (seasonIndex, episodeIndex) => {
    form.seasons[seasonIndex].episodes.splice(episodeIndex, 1);
};

const submit = () => {
    if (props.series.id) {
        form.put(route("series.update", props.series.id));
    } else {
        form.post(route("series.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="series.id ? 'Edit Series' : 'Add Series'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ series.id ? 'Edit Series' : 'Add Series' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Basic Info -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                                
                                <div>
                                    <Input
                                        v-model="form.name"
                                        type="text"
                                        label="Name"
                                        :error="form.errors.name"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.logo"
                                        type="text"
                                        label="Logo URL"
                                        :error="form.errors.logo"
                                    />
                                </div>

                                <div>
                                    <Select
                                        v-model="form.category_id"
                                        :options="categories"
                                        label="Category"
                                        :error="form.errors.category_id"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        v-model="form.is_active"
                                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300 rounded"
                                    />
                                    <label class="ml-2 block text-sm text-gray-900">
                                        Active
                                    </label>
                                </div>
                            </div>

                            <!-- Series Details -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Series Details</h3>

                                <div>
                                    <Input
                                        v-model="form.description"
                                        type="textarea"
                                        label="Description"
                                        :error="form.errors.description"
                                    />
                                </div>

                                <div>
                                    <DatePicker
                                        v-model="form.release_date"
                                        label="Release Date"
                                        :error="form.errors.release_date"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.director"
                                        type="text"
                                        label="Director"
                                        :error="form.errors.director"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.cast"
                                        type="text"
                                        label="Cast"
                                        :error="form.errors.cast"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.genre"
                                        type="text"
                                        label="Genre"
                                        :error="form.errors.genre"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.rating"
                                        type="text"
                                        label="Rating"
                                        :error="form.errors.rating"
                                    />
                                </div>
                            </div>

                            <!-- Media -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Media</h3>

                                <div>
                                    <Input
                                        v-model="form.poster"
                                        type="text"
                                        label="Poster URL"
                                        :error="form.errors.poster"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.backdrop"
                                        type="text"
                                        label="Backdrop URL"
                                        :error="form.errors.backdrop"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.trailer_url"
                                        type="text"
                                        label="Trailer URL"
                                        :error="form.errors.trailer_url"
                                    />
                                </div>
                            </div>

                            <!-- Seasons -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Seasons</h3>

                                <!-- Add Season Form -->
                                <div class="space-y-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <Input
                                                v-model="newSeason.name"
                                                type="text"
                                                label="Season Name"
                                            />
                                        </div>
                                        <div>
                                            <Input
                                                v-model="newSeason.season_number"
                                                type="number"
                                                label="Season Number"
                                            />
                                        </div>
                                        <div>
                                            <Input
                                                v-model="newSeason.description"
                                                type="textarea"
                                                label="Description"
                                            />
                                        </div>
                                        <div>
                                            <Input
                                                v-model="newSeason.poster"
                                                type="text"
                                                label="Poster URL"
                                            />
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <Button
                                            type="button"
                                            @click="addSeason"
                                            size="sm"
                                        >
                                            Add Season
                                        </Button>
                                    </div>
                                </div>

                                <!-- Seasons List -->
                                <div class="space-y-6">
                                    <div
                                        v-for="(season, seasonIndex) in form.seasons"
                                        :key="seasonIndex"
                                        class="border rounded-lg p-4"
                                    >
                                        <div class="flex items-center justify-between mb-4">
                                            <h4 class="text-lg font-medium">
                                                Season {{ season.season_number }}: {{ season.name }}
                                            </h4>
                                            <button
                                                type="button"
                                                class="text-red-600 hover:text-red-900"
                                                @click="removeSeason(seasonIndex)"
                                            >
                                                Remove Season
                                            </button>
                                        </div>

                                        <!-- Add Episode Form -->
                                        <div class="space-y-4 mb-4">
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <Input
                                                        v-model="newEpisode.name"
                                                        type="text"
                                                        label="Episode Name"
                                                    />
                                                </div>
                                                <div>
                                                    <Input
                                                        v-model="newEpisode.episode_number"
                                                        type="number"
                                                        label="Episode Number"
                                                    />
                                                </div>
                                                <div>
                                                    <Input
                                                        v-model="newEpisode.stream_url"
                                                        type="text"
                                                        label="Stream URL"
                                                    />
                                                </div>
                                                <div>
                                                    <Input
                                                        v-model="newEpisode.duration"
                                                        type="text"
                                                        label="Duration"
                                                    />
                                                </div>
                                            </div>
                                            <div class="flex justify-end">
                                                <Button
                                                    type="button"
                                                    @click="() => addEpisode(seasonIndex)"
                                                    size="sm"
                                                >
                                                    Add Episode
                                                </Button>
                                            </div>
                                        </div>

                                        <!-- Episodes List -->
                                        <div class="space-y-2">
                                            <div
                                                v-for="(episode, episodeIndex) in season.episodes"
                                                :key="episodeIndex"
                                                class="flex items-center justify-between p-2 bg-gray-50 rounded"
                                            >
                                                <div>
                                                    <span class="font-medium">Episode {{ episode.episode_number }}: {{ episode.name }}</span>
                                                    <span class="text-gray-500 ml-2">{{ episode.duration }}</span>
                                                </div>
                                                <button
                                                    type="button"
                                                    class="text-red-600 hover:text-red-900"
                                                    @click="() => removeEpisode(seasonIndex, episodeIndex)"
                                                >
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/series"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ series.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>