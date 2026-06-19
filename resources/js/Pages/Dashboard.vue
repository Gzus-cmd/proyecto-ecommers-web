<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue'; // El que copiaste de Central
import AppPageShell from '@/components/app/AppPageShell.vue'; // Tu componente pro
import AppSectionCard from '@/components/app/AppSectionCard.vue';

// No necesitamos AuthenticatedLayout de Breeze, usamos el AppLayout de Central
</script>

<template>
    <AppLayout>
        <AppPageShell title="Panel de Control E-Commerce" variant="wide">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card de Bienvenida Estilo Central -->
                <AppSectionCard class="md:col-span-2">
                    <h3 class="text-xl font-black uppercase tracking-tighter text-white">
                        ¡Bienvenido al Gestor de PharmaVictoria!
                    </h3>
                    <p class="text-navy-400 mt-2 text-sm">
                        Desde aquí podrás vincular los productos de la Administración Central 
                        para publicarlos en la tienda online.
                    </p>
                </AppSectionCard>

                <!-- Status Rápido -->
                <AppSectionCard>
                    <span class="text-[10px] font-black uppercase tracking-widest text-gold-500">Estado de Conexión</span>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                        <span class="font-bold text-white">Sincronizado con Central</span>
                    </div>
                </AppSectionCard>
            </div>

        </AppPageShell>
    </AppLayout>
</template>