<script setup lang="ts">
import { Head, router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useCart } from '@/composables/useCart';
import { MapPin, Store, CheckCircle, ArrowLeft, ShoppingCart } from 'lucide-vue-next';


interface Direccion { id: number; alias: string; direccion_completa: string; }
interface Sede { id: number; nombre: string; }

const props = defineProps<{ 
    direcciones: Direccion[], 
    sedes: Sede[] 
}>();


const { cart, total, clearCart } = useCart();

const form = ref({
    tipo_entrega: 'delivery',
    direccion_id: props.direcciones[0]?.id || null,
    sede_id: props.sedes[0]?.id || null,
});

const isProcessing = ref(false);

const confirmOrder = () => {
    if (cart.value.length === 0) return;
    
    isProcessing.value = true;
    router.post('/checkout', {
        ...form.value,
        cart: cart.value,
        total: total.value
    }, {
        onSuccess: () => {
            clearCart(); 
        },
        onFinish: () => isProcessing.value = false
    });
};
</script>

<template>
    <Head title="Finalizar Pedido - PharmaVictoria" />

    <div class="max-w-6xl mx-auto py-12 px-4 min-h-screen">
        <header class="mb-12 flex items-center gap-4">
            <Link href="/" class="p-3 bg-white border border-gray-100 rounded-full text-gray-400 hover:text-[#072D44] transition-all">
                <ArrowLeft class="size-5" />
            </Link>
            <h1 class="text-4xl font-black text-[#072D44] tracking-tighter uppercase italic">Resumen de Compra</h1>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-8">
                <section class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-8 italic">¿Cómo desea recibir su pedido?</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button @click="form.tipo_entrega = 'delivery'" 
                            :class="form.tipo_entrega === 'delivery' ? 'border-[#072D44] bg-[#072D44] text-white shadow-xl' : 'border-gray-100 text-gray-400 bg-gray-50/50'"
                            class="flex flex-col items-center gap-3 p-8 rounded-[2rem] border-2 transition-all">
                            <MapPin class="size-6" />
                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Envío a Casa</span>
                        </button>
                        <button @click="form.tipo_entrega = 'recojo'" 
                            :class="form.tipo_entrega === 'recojo' ? 'border-[#072D44] bg-[#072D44] text-white shadow-xl' : 'border-gray-100 text-gray-400 bg-gray-50/50'"
                            class="flex flex-col items-center gap-3 p-8 rounded-[2rem] border-2 transition-all">
                            <Store class="size-6" />
                            <span class="text-[10px] font-black uppercase tracking-[0.2em]">Recojo en Sede</span>
                        </button>
                    </div>

                    <div class="mt-8 pt-8 border-t border-gray-50">

                        <div v-if="form.tipo_entrega === 'delivery'" class="space-y-4">
                            <label class="text-[10px] font-black text-[#5790AB] uppercase tracking-widest ml-2">Dirección de Destino</label>
                            <select v-if="direcciones.length" v-model="form.direccion_id" class="w-full h-14 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold text-[#072D44]">
                                <option v-for="dir in direcciones" :key="dir.id" :value="dir.id">{{ dir.alias }} - {{ dir.direccion_completa }}</option>
                            </select>
                            <div v-else class="p-6 bg-amber-50 rounded-2xl border border-amber-100">
                                <p class="text-xs font-bold text-amber-700">No tiene direcciones registradas. <Link href="/mi-cuenta/perfil" class="underline">Ir a mi perfil para agregar una.</Link></p>
                            </div>
                        </div>


                        <div v-else class="space-y-4">
                            <label class="text-[10px] font-black text-[#5790AB] uppercase tracking-widest ml-2">Seleccionar Punto de Recojo</label>
                            <select v-model="form.sede_id" class="w-full h-14 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold text-[#072D44]">
                                <option v-for="sede in sedes" :key="sede.id" :value="sede.id">{{ sede.nombre }}</option>
                            </select>
                        </div>
                    </div>
                </section>
            </div>


            <aside class="space-y-6">
                <div class="bg-[#072D44] p-10 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
                    <ShoppingCart class="absolute -top-10 -right-10 size-40 text-white/5" />
                    <h3 class="text-xs font-black text-[#5790AB] uppercase tracking-[0.2em] mb-8 italic">Resumen de Orden</h3>
                    
                    <div class="space-y-5 mb-10 max-h-[300px] overflow-y-auto pr-2">
                        <div v-for="item in cart" :key="item.sku" class="flex justify-between items-center text-xs">
                            <span class="text-white/60 font-medium">{{ item.quantity }}x {{ item.nombre }}</span>
                            <span class="font-black italic">S/ {{ (item.precio * item.quantity).toFixed(2) }}</span>
                        </div>
                    </div>

                    <div class="border-t border-white/10 pt-8">
                        <div class="flex justify-between items-end">
                            <span class="text-[10px] font-black uppercase text-[#5790AB] tracking-widest">Total Estimado</span>
                            <span class="text-4xl font-black italic tracking-tighter">S/ {{ total.toFixed(2) }}</span>
                        </div>
                    </div>

                    <button @click="confirmOrder" :disabled="isProcessing || (form.tipo_entrega === 'delivery' && !form.direccion_id)"
                        class="w-full h-16 bg-white text-[#072D44] rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] mt-10 hover:bg-[#9CCDDB] transition-all flex items-center justify-center gap-3 disabled:opacity-30 shadow-2xl active:scale-95">
                        <span v-if="isProcessing">PROCESANDO...</span>
                        <template v-else>
                            CONFIRMAR PEDIDO REAL <CheckCircle class="size-4" />
                        </template>
                    </button>
                </div>
            </aside>
        </div>
    </div>
</template>