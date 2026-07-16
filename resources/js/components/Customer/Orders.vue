<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import OrderTruckTracker from '@/components/Store/OrderTruckTracker.vue';
import { ChevronRight, Package, Calendar } from 'lucide-vue-next';


const props = defineProps<{
    pedidos: any[]
}>();
</script>

<template>
    <Head title="Mis Pedidos" />

    <div class="max-w-5xl mx-auto py-12 px-4">
        <header class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-black text-[#072D44] tracking-tighter uppercase italic">Mis Pedidos</h1>
                <p class="text-gray-400 font-bold uppercase text-[9px] tracking-[0.3em] mt-1 italic">Historial de adquisiciones clínicas</p>
            </div>
            <Link href="/catalogo" class="text-[10px] font-black text-[#5790AB] uppercase border-b-2 border-[#5790AB] pb-1 hover:text-[#072D44] hover:border-[#072D44] transition-all italic">Nueva Compra</Link>
        </header>

        <div class="space-y-8">

            <div v-for="pedido in pedidos" :key="pedido.id" class="group">
                <div class="bg-white border border-gray-100 rounded-[2.5rem] overflow-hidden shadow-sm group-hover:shadow-xl group-hover:-translate-y-1 transition-all duration-500">
                    <div class="p-8 flex flex-col md:flex-row gap-8 items-center">

                        <div class="flex-1 space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="px-3 py-1 bg-[#F8FAFC] rounded-full text-[10px] font-black text-[#072D44] uppercase italic border border-gray-100">Orden #{{ pedido.id }}</span>
                                <div class="flex items-center gap-1 text-gray-400">
                                    <Calendar class="size-3" />
                                    <span class="text-[10px] font-bold uppercase tracking-tight">{{ new Date(pedido.created_at).toLocaleDateString() }}</span>
                                </div>
                            </div>
                            
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black text-[#072D44] italic tracking-tighter">S/ {{ pedido.total }}</span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest italic">Total Pagado</span>
                            </div>
                        </div>


                        <div class="w-full md:w-2/3">

                            <OrderTruckTracker :status="pedido.estado_id === 3 ? 3 : 2" />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div v-if="pedidos.length === 0" class="py-20 text-center bg-white rounded-[3rem] border border-dashed border-gray-200">
            <Package class="size-12 text-gray-200 mx-auto mb-4" />
            <h3 class="text-xl font-black text-[#072D44] uppercase italic">Sin pedidos registrados</h3>
            <p class="text-gray-400 text-sm italic">Comience su tratamiento hoy mismo desde nuestro catálogo.</p>
        </div>
    </div>
</template>