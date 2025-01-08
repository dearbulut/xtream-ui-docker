<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import DatePicker from "@/Components/DatePicker.vue";

const props = defineProps({
    movie: {
        type: Object,
        default: () => ({
            name: "",
            stream_url: "",
            logo: "",
            category_id: null,
            stream_type: "movie",
            is_active: true,
            description: "",
            duration: "",
            release_date: null,
            director: "",
            cast: "",
            genre: "",
            rating: "",
            poster: "",
            backdrop: "",
            trailer_url: "",
            subtitles: [],
            audio_tracks: [],
        }),
    },
    categories: Array,
});

const form = useForm({
    name: props.movie.name,
    stream_url: props.movie.stream_url,
    logo: props.movie.logo,
    category_id: props.movie.category_id,
    stream_type: props.movie.stream_type,
    is_active: props.movie.is_active,
    description: props.movie.description,
    duration: props.movie.duration,
    release_date: props.movie.release_date,
    director: props.movie.director,
    cast: props.movie.cast,
    genre: props.movie.genre,
    rating: props.movie.rating,
    poster: props.movie.poster,
    backdrop: props.movie.backdrop,
    trailer_url: props.movie.trailer_url,
    subtitles: props.movie.subtitles || [],
    audio_tracks: props.movie.audio_tracks || [],
});

const newSubtitle = ref({ language: "", url: "" });
const newAudioTrack = ref({ language: "", url: "" });

const addSubtitle = () => {
    if (newSubtitle.value.language && newSubtitle.value.url) {
        form.subtitles.push({ ...newSubtitle.value });
        newSubtitle.value = { language: "", url: "" };
    }
};

const removeSubtitle = (index) => {
    form.subtitles.splice(index, 1);
};

const addAudioTrack = () => {
    if (newAudioTrack.value.language && newAudioTrack.value.url) {
        form.audio_tracks.push({ ...newAudioTrack.value });
        newAudioTrack.value = { language: "", url: "" };
    }
};

const removeAudioTrack = (index) => {
    form.audio_tracks.splice(index, 1);
};

const submit = () => {
    if (props.movie.id) {
        form.put(route("movies.update", props.movie.id));
    } else {
        form.post(route("movies.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="movie.id ? 'Edit Movie' : 'Add Movie'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ movie.id ? 'Edit Movie' : 'Add Movie' }}
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
                                        v-model="form.stream_url"
                                        type="text"
                                        label="Stream URL"
                                        :error="form.errors.stream_url"
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

                            <!-- Movie Details -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Movie Details</h3>

                                <div>
                                    <Input
                                        v-model="form.description"
                                        type="textarea"
                                        label="Description"
                                        :error="form.errors.description"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.duration"
                                        type="text"
                                        label="Duration"
                                        :error="form.errors.duration"
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

                            <!-- Subtitles -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Subtitles</h3>

                                <div class="space-y-4">
                                    <div class="flex gap-4">
                                        <div class="flex-1">
                                            <Input
                                                v-model="newSubtitle.language"
                                                type="text"
                                                label="Language"
                                            />
                                        </div>
                                        <div class="flex-1">
                                            <Input
                                                v-model="newSubtitle.url"
                                                type="text"
                                                label="URL"
                                            />
                                        </div>
                                        <div class="flex items-end">
                                            <Button
                                                type="button"
                                                @click="addSubtitle"
                                                size="sm"
                                            >
                                                Add
                                            </Button>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div
                                            v-for="(subtitle, index) in form.subtitles"
                                            :key="index"
                                            class="flex items-center justify-between p-2 bg-gray-50 rounded"
                                        >
                                            <div>
                                                <span class="font-medium">{{ subtitle.language }}</span>
                                                <span class="text-gray-500 ml-2">{{ subtitle.url }}</span>
                                            </div>
                                            <button
                                                type="button"
                                                class="text-red-600 hover:text-red-900"
                                                @click="removeSubtitle(index)"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Audio Tracks -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Audio Tracks</h3>

                                <div class="space-y-4">
                                    <div class="flex gap-4">
                                        <div class="flex-1">
                                            <Input
                                                v-model="newAudioTrack.language"
                                                type="text"
                                                label="Language"
                                            />
                                        </div>
                                        <div class="flex-1">
                                            <Input
                                                v-model="newAudioTrack.url"
                                                type="text"
                                                label="URL"
                                            />
                                        </div>
                                        <div class="flex items-end">
                                            <Button
                                                type="button"
                                                @click="addAudioTrack"
                                                size="sm"
                                            >
                                                Add
                                            </Button>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div
                                            v-for="(track, index) in form.audio_tracks"
                                            :key="index"
                                            class="flex items-center justify-between p-2 bg-gray-50 rounded"
                                        >
                                            <div>
                                                <span class="font-medium">{{ track.language }}</span>
                                                <span class="text-gray-500 ml-2">{{ track.url }}</span>
                                            </div>
                                            <button
                                                type="button"
                                                class="text-red-600 hover:text-red-900"
                                                @click="removeAudioTrack(index)"
                                            >
                                                Remove
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/movies"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ movie.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>