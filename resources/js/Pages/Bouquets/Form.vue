<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";
import MultiSelect from "@/Components/MultiSelect.vue";

const props = defineProps({
    bouquet: {
        type: Object,
        default: () => ({
            name: "",
            description: "",
            type: "all",
            is_active: true,
            sort_order: 0,
            channels: [],
            movies: [],
            series: [],
        }),
    },
    channels: Array,
    movies: Array,
    series: Array,
});

const form = useForm({
    name: props.bouquet.name,
    description: props.bouquet.description,
    type: props.bouquet.type,
    is_active: props.bouquet.is_active,
    sort_order: props.bouquet.sort_order,
    channels: props.bouquet.channels?.map(c => c.id) || [],
    movies: props.bouquet.movies?.map(m => m.id) || [],
    series: props.bouquet.series?.map(s => s.id) || [],
});

const types = [
    { value: "all", label: "All Content" },
    { value: "channel", label: "Channels Only" },
    { value: "movie", label: "Movies Only" },
    { value: "series", label: "Series Only" },
];

const submit = () => {
    if (props.bouquet.id) {
        form.put(route("bouquets.update", props.bouquet.id));
    } else {
        form.post(route("bouquets.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="bouquet.id ? 'Edit Bouquet' : 'Add Bouquet'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ bouquet.id ? 'Edit Bouquet' : 'Add Bouquet' }}
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
                                        v-model="form.description"
                                        type="textarea"
                                        label="Description"
                                        :error="form.errors.description"
                                    />
                                </div>

                                <div>
                                    <Select
                                        v-model="form.type"
                                        :options="types"
                                        label="Type"
                                        :error="form.errors.type"
                                    />
                                </div>

                                <div>
                                    <Input
                                        v-model="form.sort_order"
                                        type="number"
                                        label="Sort Order"
                                        :error="form.errors.sort_order"
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

                            <!-- Content Selection -->
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900">Content Selection</h3>
                                
                                <div v-if="form.type === 'all' || form.type === 'channel'">
                                    <MultiSelect
                                        v-model="form.channels"
                                        :options="channels"
                                        label="Channels"
                                        :error="form.errors.channels"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div v-if="form.type === 'all' || form.type === 'movie'">
                                    <MultiSelect
                                        v-model="form.movies"
                                        :options="movies"
                                        label="Movies"
                                        :error="form.errors.movies"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>

                                <div v-if="form.type === 'all' || form.type === 'series'">
                                    <MultiSelect
                                        v-model="form.series"
                                        :options="series"
                                        label="Series"
                                        :error="form.errors.series"
                                        valueKey="id"
                                        labelKey="name"
                                    />
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/bouquets"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ bouquet.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>