
<script setup lang="ts">
import * as Icons from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps<{ name: string; iconName: string }>();
const IconComponent = computed(() => (Icons as any)[props.iconName] || Icons.Package);
</script>

<template>
    <div class="flex flex-col items-center gap-4 group cursor-pointer">
        <div class="size-24 md:size-32 bg-gray-50 border border-gray-100 rounded-[2.5rem] flex items-center justify-center group-hover:bg-white group-hover:shadow-xl group-hover:shadow-primary/10 transition-all duration-300">
            <component :is="IconComponent" class="size-8 text-navy-900" />
        </div>
        <span class="text-sm font-bold text-gray-600 uppercase tracking-tight">{{ name }}</span>
    </div>
</template>