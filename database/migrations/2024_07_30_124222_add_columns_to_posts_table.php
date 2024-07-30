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
        Schema::table('posts', function (Blueprint $table) {
            $table->string('title'); // Ajoute une colonne string 'title'
            $table->longText('content'); // Ajoute une colonne longText 'content'
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['title', 'content', 'created_at', 'updated_at']); // Supprime les colonnes ajoutées lors du rollback
        });
    }
};