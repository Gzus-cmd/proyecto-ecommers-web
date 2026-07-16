<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';
import { User as UserIcon, MapPin, Plus, X, Save, CreditCard, Mail } from 'lucide-vue-next';
import CustomerSidebar from '@/components/Store/CustomerSidebar.vue';
import address from '@/routes/store/address'; 

interface UserAccount { id: number; name: string; email: string; }
interface PageProps { auth: { user: UserAccount | null; }; [key: string]: any; }

const props = defineProps<{
    cliente: any;
    direcciones: any[];
}>();

const page = usePage<PageProps>();
const user = page.props.auth.user;
const showModal = ref(false);

const form = useForm({
    alias: '',
    direccion_completa: '',
    distrito: '',
    ciudad: 'Lima',
});

const submitAddress = () => {
    form.post(address.store.url(), {
        onSuccess: () => {
            showModal.value = false;
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Mi Perfil - PharmaVictoria" />

    <div v-if="user" class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <header class="mb-10">
            <h1 class="text-4xl font-black text-[#072D44] tracking-tighter uppercase italic">Panel de Paciente</h1>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] mt-1 italic">Gestión de identidad</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            
            <!-- SIDEBAR REUTILIZABLE -->
            <aside class="lg:col-span-1">
                <CustomerSidebar />
            </aside>

            <!-- CONTENIDO -->
            <main class="lg:col-span-3 space-y-8">
                <!-- Card: Info Personal -->
                <section class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm/5">
                    <div class="flex items-center gap-6">
                        <div class="size-16 bg-[#F8FAFC] rounded-2xl flex items-center justify-center border border-gray-100 shadow-inner">
                            <UserIcon class="size-7 text-[#072D44]" />
                        </div>
                        <div>
                            <h2 class="text-2xl font-black text-[#072D44] leading-tight uppercase italic">
                                {{ cliente.nombres }} {{ cliente.apellidos }}
                            </h2>
                            <div class="flex gap-4 mt-2">
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                    <Mail class="size-3" /> {{ user.email }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1">
                                    <CreditCard class="size-3" /> DNI {{ cliente.dni }}
                                </span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Card: Direcciones -->
                <section class="bg-white p-8 rounded-[2.5rem] border border-gray-100 shadow-sm/5">
                    <div class="flex justify-between items-center mb-8">
                        <h2 class="text-xl font-black text-[#072D44] italic uppercase">Direcciones de Envío</h2>
                        <button @click="showModal = true" class="flex items-center gap-2 px-5 py-2.5 bg-[#5790AB] text-white rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-[#072D44] transition-all">
                            <Plus class="size-4" /> Agregar Nueva
                        </button>
                    </div>

                    <div v-if="direcciones.length" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div v-for="dir in direcciones" :key="dir.id" class="flex items-start gap-4 p-5 bg-gray-50/50 rounded-[2rem] border border-gray-100">
                            <MapPin class="size-4 text-[#5790AB] mt-1" />
                            <div>
                                <h4 class="text-[10px] font-black text-[#5790AB] uppercase tracking-widest">{{ dir.alias }}</h4>
                                <p class="text-sm font-bold text-[#072D44]">{{ dir.direccion_completa }}</p>
                                <p class="text-[10px] text-gray-400 font-bold uppercase">{{ dir.distrito }}, {{ dir.ciudad }}</p>
                            </div>
                        </div>
                    </div>
                    <div v-else class="py-12 text-center border-2 border-dashed border-gray-100 rounded-[2.5rem]">
                        <p class="text-gray-400 text-sm italic font-medium uppercase tracking-widest">No hay direcciones registradas.</p>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <!-- EL MODAL (Se mantiene igual) -->
    <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-[#072D44]/60 backdrop-blur-md" @click="showModal = false"></div>
        <div class="relative bg-white w-full max-w-md rounded-[3rem] shadow-2xl p-10 overflow-hidden border border-white/20">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-2xl font-black text-[#072D44] uppercase italic tracking-tighter">Ubicación</h3>
                <button @click="showModal = false" class="p-2 hover:bg-gray-100 rounded-full transition-colors"><X class="size-6 text-gray-400" /></button>
            </div>
            <form @submit.prevent="submitAddress" class="space-y-5">
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Nombre del Lugar</label>
                    <input v-model="form.alias" type="text" placeholder="Ej: Mi Casa, Oficina" required class="w-full h-12 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold" />
                </div>
                <div class="space-y-1">
                    <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Dirección Exacta</label>
                    <input v-model="form.direccion_completa" type="text" placeholder="Av. Principal 123..." required class="w-full h-12 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold" />
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Distrito</label>
                        <input v-model="form.distrito" type="text" required class="w-full h-12 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold" />
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] ml-2">Ciudad</label>
                        <input v-model="form.ciudad" type="text" required class="w-full h-12 bg-gray-50 border-none rounded-2xl px-5 text-sm font-bold" />
                    </div>
                </div>
                <button :disabled="form.processing" type="submit" class="w-full h-14 bg-[#072D44] text-white rounded-[1.5rem] font-black text-xs uppercase tracking-[0.2em] mt-6 flex items-center justify-center gap-3 hover:bg-[#5790AB] transition-all">
                    <Save class="size-4" /> Guardar Dirección
                </button>
            </form>
        </div>
    </div>
</template>