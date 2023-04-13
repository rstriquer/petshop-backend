<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'remember_token']);
            $table->uuid('uuid')
                ->after('id')
                ->comment(
                    'UUID to allow easy migration between envs without '
                    . 'breaking FK in the logic'
                );
            $table->string('first_name')
                ->after('uuid');
            $table->string('last_name')
                ->after('first_name');
            $table->boolean('is_admin')
                ->default(false)
                ->after('last_name');
            $table->string('avatar')
                ->nullable()
                ->after('password')
                ->comment('UUID of the image stored into the files table');
            $table->string('address')
                ->after('avatar');
            $table->string('phone_number')
                ->after('address');
            $table->boolean('is_marketing')
                ->default(false)
                ->after('phone_number')
                ->comment('Enable marketing preferences');
            $table->timestamp('last_login_at')
                ->nullable()
                ->after('updated_at');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_uuid_unique');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'uuid', 'first_name', 'last_name', 'is_admin', 'avatar',
                'address', 'phone_number', 'is_marketing', 'last_login_at',
            ]);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')
                ->after('id');
            $table->rememberToken();
        });
    }
};
