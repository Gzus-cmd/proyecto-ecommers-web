<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CustomerSidebar from '@/components/Store/CustomerSidebar.vue';
import OrderTruckTracker from '@/components/Store/OrderTruckTracker.vue';
import { Package, Calendar, ChevronRight, ShoppingBag, CreditCard } from 'lucide-vue-next';


interface Pedido {
    id: number;
    total: string;
    estado_id: number;
    created_at: string;
    estado: {
        id: number;
        nombre: string;
    };
}

defineProps<{ pedidos: Pedido[] }>();


const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('es-PE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};
</script>

<template>
    <Head title="Mis Pedidos - PharmaVictoria" />

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            

            <aside class="lg:col-span-1">
                <CustomerSidebar />
            </aside>


            <main class="lg:col-span-3 space-y-8">
                <header class="flex justify-between items-end mb-4">
                    <div>
                        <h1 class="text-4xl font-black text-[#072D44] tracking-tighter uppercase italic">Mis Pedidos</h1>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1">Seguimiento logístico en tiempo real</p>
                    </div>
                    <Link href="/catalogo" class="text-xs font-black text-[#5790AB] uppercase border-b-2 border-[#5790AB]/20 pb-1 hover:text-[#072D44] hover:border-[#072D44] transition-all italic">
                        Seguir comprando
                    </Link>
                </header>


                <div v-if="pedidos.length > 0" class="space-y-6">
                    <div v-for="pedido in pedidos" :key="pedido.id" 
                        class="bg-white border border-gray-100 rounded-[2.5rem] shadow-sm overflow-hidden hover:shadow-xl transition-all duration-500 group">
                        
                        <div class="p-8">

                            <div class="flex flex-col md:flex-row justify-between gap-6 mb-10 pb-6 border-b border-gray-50">
                                <div class="space-y-3">
                                    <div class="flex items-center gap-3">
                                        <span class="px-4 py-1.5 bg-[#072D44] text-white rounded-full text-[10px] font-black uppercase italic tracking-widest">
                                            Orden #{{ pedido.id }}
                                        </span>
                                        <span class="flex items-center gap-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-tighter">
                                            <Calendar class="size-3.5" /> {{ formatDate(pedido.created_at) }}
                                        </span>
                                    </div>
                                    <div class="flex items-baseline gap-2">
                                        <span class="text-3xl font-black text-[#072D44] italic tracking-tighter">S/ {{ pedido.total }}</span>
                                        <span class="text-[9px] font-bold text-gray-400 uppercase tracking-[0.2em]">Total Transacción</span>
                                    </div>
                                </div>


                                <div class="flex items-start">
                                    <div class="flex items-center gap-2 px-5 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-sm"
                                        :class="pedido.estado_id === 4 ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-amber-50 text-amber-600 border border-amber-100'">
                                        <div class="size-2 rounded-full animate-pulse" :class="pedido.estado_id === 4 ? 'bg-emerald-500' : 'bg-amber-500'"></div>
                                        {{ pedido.estado.nombre }}
                                    </div>
                                </div>
                            </div>


                            <div class="mt-4" v-if="pedido.estado_id !== 5">
                                <OrderTruckTracker :status="pedido.estado_id === 4 ? 3 : (pedido.estado_id === 3 ? 2 : 1)" />
                            </div>
                        </div>
                    </div>
                </div>


                <div v-else class="py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100 flex flex-col items-center">
                    <div class="size-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <ShoppingBag class="size-10 text-gray-200" />
                    </div>
                    <h3 class="text-2xl font-black text-[#072D44] uppercase italic">Sin actividad comercial</h3>
                    <p class="text-gray-400 text-sm mt-2 italic font-medium max-w-xs">Aún no ha realizado pedidos. Sus compras aparecerán aquí para seguimiento clínico.</p>
                    <Link href="/catalogo" class="mt-10 px-10 py-4 bg-[#072D44] text-white rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-[#5790AB] transition-all shadow-xl shadow-[#072D44]/10">
                        Explorar Catálogo
                    </Link>
                </div>
            </main>
        </div>
    </div>
</template>