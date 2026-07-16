<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import AppLogoIcon from '@/components/AppLogoIcon.vue';
import { home } from '@/routes';

defineProps<{
    title?: string;
    description?: string;
}>();
</script>

<template>
    <div class="flex min-h-svh flex-col lg:flex-row bg-background antialiased">

        <div class="hidden lg:flex lg:w-1/2 relative bg-[#064469] flex-col items-center justify-center p-12 text-white overflow-hidden">

            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-[-10%] left-[-10%] w-[70%] h-[70%] rounded-full bg-[#5790AB] blur-[120px]"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-[60%] h-[60%] rounded-full bg-[#9CCDDB] blur-[100px]"></div>
            </div>

            <div class="relative z-10 flex flex-col items-center text-center max-w-md">
                <Link :href="home()" class="mb-8 group">
                    <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-white shadow-2xl group-hover:scale-105 transition-transform duration-500">
                        <AppLogoIcon class="size-12 fill-[#072D44]" />
                    </div>
                </Link>
                <h2 class="text-4xl font-black tracking-tighter uppercase mb-4 italic">
                    Pharma<span class="text-[#9CCDDB]">Victoria</span>
                </h2>
                <p class="text-lg font-medium text-[#D0D7E1] italic leading-relaxed">
                    Acceso exclusivo a la plataforma de gestión farmacéutica de alta gama.
                </p>
                
                <div class="mt-12 flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.3em] text-[#9CCDDB]/60">
                    <div class="h-px w-8 bg-current"></div>
                    Seguridad Clínica Verificada
                    <div class="h-px w-8 bg-current"></div>
                </div>
            </div>
        </div>


        <div class="flex flex-1 flex-col items-center justify-center p-6 md:p-10 bg-white dark:bg-[#072D44]">
            <div class="w-full max-w-sm">

                <div class="lg:hidden flex flex-col items-center gap-4 mb-8">
                    <Link :href="home()" class="p-3 bg-[#064469] rounded-xl">
                        <AppLogoIcon class="size-8 fill-white" />
                    </Link>
                </div>

                <div class="space-y-2 mb-8 text-center lg:text-left">
                    <h1 class="text-3xl font-black text-[#072D44] dark:text-white tracking-tighter uppercase italic">
                        {{ title }}
                    </h1>
                    <p class="text-sm text-muted-foreground font-medium">
                        {{ description }}
                    </p>
                </div>

                <slot />
            </div>
        </div>
    </div>
</template>