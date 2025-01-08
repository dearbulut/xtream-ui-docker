<script setup>
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import Button from "@/Components/Button.vue";
import Input from "@/Components/Input.vue";
import Badge from "@/Components/Badge.vue";

const props = defineProps({
    channel: Object,
    programs: Array,
    date: String,
});

const form = useForm({
    epg_channel_id: props.channel.epg_channel_id,
});

const submit = () => {
    form.put(route("epg.update", props.channel.id));
};

const formatTime = (date) => {
    return new Date(date).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
    });
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <AppLayout>
        <Head :title="`EPG - ${channel.name}`" />

        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    EPG - {{ channel.name }}
                </h2>

                <div class="flex items-center space-x-4">
                    <Button href="/epg" variant="secondary" size="sm">
                        Back to EPG
                    </Button>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Channel Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-16 w-16">
                                <img class="h-16 w-16 rounded-full" :src="channel.logo || '/default-channel.png'" :alt="channel.name">
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ channel.name }}
                                </h3>
                                <div class="mt-1 text-sm text-gray-500">
                                    Category: <Badge>{{ channel.category?.name || "Uncategorized" }}</Badge>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="submit" class="mt-6">
                            <div class="max-w-xl">
                                <Input
                                    v-model="form.epg_channel_id"
                                    type="text"
                                    label="EPG Channel ID"
                                    :error="form.errors.epg_channel_id"
                                />
                            </div>

                            <div class="mt-4">
                                <Button type="submit" :disabled="form.processing">
                                    Update EPG ID
                                </Button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Program Schedule -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                            Program Schedule - {{ formatDate(date) }}
                        </h3>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Time
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Program
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Category
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Language
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="program in programs" :key="program.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatTime(program.start_time) }} - {{ formatTime(program.end_time) }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ program.title }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ program.description }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <Badge>{{ program.category }}</Badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ program.language }}
                                        </td>
                                    </tr>
                                    <tr v-if="!programs.length">
                                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No program data available for this date.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>