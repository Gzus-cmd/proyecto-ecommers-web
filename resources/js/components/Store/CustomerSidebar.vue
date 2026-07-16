<script setup lang="ts">
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { User as UserIcon, Package, Pill } from 'lucide-vue-next';


const page = usePage();
const currentPath = computed(() => (page as any).url as string);


const isActive = (path: string) => {
    return currentPath.value.includes(path);
};
</script>

<template>
    <div class="space-y-4">
        <div class="bg-white p-5 rounded-[2rem] border border-gray-100 shadow-sm/5">
            <nav class="flex flex-col gap-2">

                <Link href="/mi-cuenta/perfil" 
                    :class="isActive('perfil') ? 'bg-[#072D44] text-white shadow-lg' : 'hover:bg-gray-50 text-gray-500'"
                    class="flex items-center gap-3 p-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-300">
                    <UserIcon class="size-4" /> Mi Perfil
                </Link>


                <Link href="/mi-cuenta/pedidos" 
                    :class="isActive('pedidos') ? 'bg-[#072D44] text-white shadow-lg' : 'hover:bg-gray-50 text-gray-500'"
                    class="flex items-center gap-3 p-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-300">
                    <Package class="size-4" /> Mis Pedidos
                </Link>


                <Link href="/mi-cuenta/botiquin" 
                    :class="isActive('botiquin') ? 'bg-[#072D44] text-white shadow-lg' : 'hover:bg-gray-50 text-gray-500'"
                    class="flex items-center gap-3 p-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all duration-300">
                    <Pill class="size-4" /> Mi Botiquín
                </Link>
            </nav>
        </div>

        <div class="p-6 bg-[#F8FAFC] rounded-[2rem] border border-gray-100">
            <p class="text-[9px] font-black text-[#5790AB] uppercase tracking-[0.2em] leading-relaxed italic">
                PharmaVictoria <br/>Seguridad Farmacéutica
            </p>
        </div>
    </div>
</template>