<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Select from "@/Components/Select.vue";

const props = defineProps({
    category: {
        type: Object,
        default: () => ({
            name: "",
            description: "",
            type: "channel",
            parent_id: null,
            sort_order: 0,
            is_active: true,
        }),
    },
    parents: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: props.category.name,
    description: props.category.description,
    type: props.category.type,
    parent_id: props.category.parent_id,
    sort_order: props.category.sort_order,
    is_active: props.category.is_active,
});

const types = [
    { value: "channel", label: "Channel" },
    { value: "movie", label: "Movie" },
    { value: "series", label: "Series" },
];

const submit = () => {
    if (props.category.id) {
        form.put(route("categories.update", props.category.id));
    } else {
        form.post(route("categories.store"));
    }
};
</script>

<template>
    <AppLayout>
        <Head :title="category.id ? 'Edit Category' : 'Add Category'" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ category.id ? 'Edit Category' : 'Add Category' }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 bg-white border-b border-gray-200">
                        <div class="grid grid-cols-1 gap-6">
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
                                    type="text"
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
                                <Select
                                    v-model="form.parent_id"
                                    :options="parents"
                                    label="Parent Category"
                                    :error="form.errors.parent_id"
                                    valueKey="id"
                                    labelKey="name"
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

                            <div class="flex items-center justify-end space-x-3">
                                <Button
                                    href="/categories"
                                    variant="secondary"
                                    :disabled="form.processing"
                                >
                                    Cancel
                                </Button>

                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ category.id ? 'Update' : 'Create' }}
                                </Button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>