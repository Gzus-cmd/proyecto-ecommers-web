<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import CustomerSidebar from '@/components/Store/CustomerSidebar.vue';
import { Pill, ArrowRight, Search, Activity, ShoppingCart, Plus } from 'lucide-vue-next';
import { useCart } from '@/composables/useCart';


interface ProductCabinet {
    sku: string;
    nombre_comercial: string;
    nombre_generico: string;
    precio_web: string;
    imagen_url: string;
    categoria_nombre: string;
}

defineProps<{ productos: ProductCabinet[] }>();

const { addToCart } = useCart();
</script>

<template>
    <Head title="Mi Botiquín Personal - PharmaVictoria" />

    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            

            <aside class="lg:col-span-1">
                <CustomerSidebar />
            </aside>


            <main class="lg:col-span-3 space-y-8">
                <header class="mb-4">
                    <h1 class="text-4xl font-black text-[#072D44] tracking-tighter uppercase italic">Mi Botiquín</h1>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1 italic">Gestión de medicación recurrente</p>
                </header>


                <div v-if="productos.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div v-for="prod in productos" :key="prod.sku" 
                        class="group bg-white p-6 rounded-[2.5rem] border border-gray-100 flex items-center gap-6 hover:shadow-2xl transition-all duration-500 shadow-sm relative overflow-hidden">
                        

                        <Activity class="absolute -bottom-4 -right-4 size-24 text-[#5790AB] opacity-[0.03] group-hover:opacity-10 transition-opacity" />


                        <div class="size-24 bg-[#F8FAFC] rounded-[1.5rem] flex items-center justify-center p-4 border border-gray-50 shrink-0 group-hover:bg-white transition-colors duration-500">
                            <img :src="prod.imagen_url" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500" :alt="prod.nombre_comercial" />
                        </div>


                        <div class="flex-1 space-y-1">
                            <span class="text-[9px] font-black text-[#5790AB] uppercase tracking-[0.2em] italic">{{ prod.categoria_nombre }}</span>
                            <h3 class="text-lg font-black text-[#072D44] leading-tight uppercase italic tracking-tighter">{{ prod.nombre_comercial }}</h3>
                            <p class="text-[10px] text-gray-400 font-bold italic uppercase">{{ prod.nombre_generico }}</p>
                            
                            <div class="pt-4">
                                <button @click="addToCart(prod)" 
                                    class="flex items-center gap-2 text-[10px] font-black text-[#072D44] uppercase tracking-widest hover:text-[#5790AB] transition-colors group/btn">
                                    <div class="size-6 bg-gray-50 rounded-lg flex items-center justify-center group-hover/btn:bg-[#5790AB] group-hover/btn:text-white transition-all">
                                        <Plus class="size-3" />
                                    </div>
                                    Pedir Reabastecimiento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                <div v-else class="py-24 text-center bg-white rounded-[3rem] border-2 border-dashed border-gray-100 flex flex-col items-center">
                    <div class="size-20 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                        <Pill class="size-10 text-gray-200" />
                    </div>
                    <h3 class="text-2xl font-black text-[#072D44] uppercase italic">Botiquín Digital Vacío</h3>
                    <p class="text-gray-400 text-sm mt-2 max-w-sm italic font-medium">Aquí aparecerán los productos que ya ha comprado anteriormente para facilitar su acceso recurrente.</p>
                    <Link href="/catalogo" class="mt-8 px-10 py-4 bg-[#072D44] text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#5790AB] transition-all">
                        Explorar Farmacia
                    </Link>
                </div>
            </main>
        </div>
    </div>
</template>