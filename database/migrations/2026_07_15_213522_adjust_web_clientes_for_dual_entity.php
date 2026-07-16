<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
public function up(): void
{
    Schema::table('web_clientes', function (Blueprint $table) {
        if (!Schema::hasColumn('web_clientes', 'user_id')) {
            $table->foreignId('user_id')->after('id')->nullable()->constrained('users')->onDelete('cascade');
        }

        if (Schema::hasColumn('web_clientes', 'email')) {
            $table->dropColumn('email');
        }

        if (Schema::hasColumn('web_clientes', 'password_hash')) {
            $table->dropColumn('password_hash');
        }
    });
}
    public function down(): void {
        Schema::table('web_clientes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email')->unique();
            $table->string('password_hash');
        });
    }
};