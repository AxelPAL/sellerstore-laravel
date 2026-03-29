<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_admin')) {
                $table->boolean('is_admin')->default(false)->after('password');
            }
        });

        if (Schema::hasTable('roles') && Schema::hasColumn('users', 'role_id')) {
            $adminRoleIds = DB::table('roles')->where('name', 'admin')->pluck('id');
            if ($adminRoleIds->isNotEmpty()) {
                DB::table('users')->whereIn('role_id', $adminRoleIds)->update(['is_admin' => true]);
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasColumn('users', 'is_admin')) {
            return;
        }
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_admin');
        });
    }
};
