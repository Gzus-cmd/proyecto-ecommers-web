<script setup lang="ts">
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { Lock, Unlock, AlertCircle } from 'lucide-vue-next';

const props = defineProps<{ form: any }>();


const dniBloqueado = ref(true);
</script>

<template>
    <div class="space-y-6 text-foreground">
        

        <div class="p-4 bg-navy-950/50 rounded-2xl border border-primary/10">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-2">
                    <AlertCircle class="size-4 text-primary" />
                    <span class="text-[10px] font-black uppercase tracking-widest text-primary">Identidad Legal (Campo Crítico)</span>
                </div>
                

                <button 
                    type="button"
                    @click="dniBloqueado = !dniBloqueado"
                    :class="['flex items-center gap-2 px-3 py-1 rounded-lg border transition-all text-[9px] font-black uppercase', 
                             dniBloqueado ? 'bg-muted/50 border-border text-muted-foreground' : 'bg-orange-500/10 border-orange-500/20 text-orange-500 shadow-lg shadow-orange-500/10']"
                >
                    <component :is="dniBloqueado ? Lock : Unlock" class="size-3" />
                    {{ dniBloqueado ? 'Desbloquear DNI' : 'DNI Habilitado' }}
                </button>
            </div>

            <div>
                <Label for="dni" class="text-[10px] uppercase ml-1">Documento Nacional de Identidad</Label>
                <Input 
                    v-model="form.dni" 
                    id="dni" 
                    :disabled="dniBloqueado"
                    :class="['mt-1 h-11 font-mono text-lg tracking-widest', dniBloqueado ? 'opacity-50 grayscale' : 'border-orange-500/40 bg-orange-500/5']" 
                />
                <InputError :message="form.errors.dni" />
                <p v-if="!dniBloqueado" class="text-[9px] text-orange-500 mt-2 italic font-bold">
                    ⚠️ Advertencia: Modificar el DNI afectará la trazabilidad histórica de los pedidos.
                </p>
            </div>
        </div>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <Label for="nom" class="text-[10px] uppercase ml-1">Nombres</Label>
                <Input v-model="form.nombres" id="nom" class="mt-1 h-11" />
                <InputError :message="form.errors.nombres" />
            </div>
            <div>
                <Label for="ape" class="text-[10px] uppercase ml-1">Apellidos</Label>
                <Input v-model="form.apellidos" id="ape" class="mt-1 h-11" />
                <InputError :message="form.errors.apellidos" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <Label for="em" class="text-[10px] uppercase ml-1">Correo Electrónico</Label>
                <Input v-model="form.email" id="em" type="email" class="mt-1 h-11" />
                <InputError :message="form.errors.email" />
            </div>
            <div>
                <Label for="tel" class="text-[10px] uppercase ml-1">Teléfono / Celular</Label>
                <Input v-model="form.telefono" id="tel" class="mt-1 h-11" />
                <InputError :message="form.errors.telefono" />
            </div>
        </div>

        <div class="p-4 bg-muted/20 rounded-xl border border-border/50">
            <label class="flex items-center gap-3 cursor-pointer group">
                <input type="checkbox" v-model="form.activo" class="rounded border-border text-primary focus:ring-primary" />
                <span class="text-[10px] font-black uppercase tracking-widest text-muted-foreground group-hover:text-foreground transition-colors">Permitir acceso a la plataforma web</span>
            </label>
        </div>

        <slot name="actions" />
    </div>
</template>