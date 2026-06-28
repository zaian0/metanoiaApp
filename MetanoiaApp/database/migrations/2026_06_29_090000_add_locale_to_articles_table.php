<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->string('locale', 5)->default('en')->after('id')->index();
            // Links an article to its translations in other locales.
            $table->uuid('group_id')->nullable()->after('locale')->index();
        });

        // Give every existing article its own translation group.
        foreach (DB::table('articles')->whereNull('group_id')->pluck('id') as $id) {
            DB::table('articles')->where('id', $id)->update(['group_id' => (string) Str::uuid()]);
        }
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn(['locale', 'group_id']);
        });
    }
};
