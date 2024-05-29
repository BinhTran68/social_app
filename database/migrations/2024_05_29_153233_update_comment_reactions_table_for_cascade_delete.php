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
        Schema::table('comment_reactions', function (Blueprint $table) {
            $table->dropForeign('comment_reaction_comment_id_foreign');
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comment_reactions', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
            $table->foreign('comment_id')
                ->references('id')
                ->on('comments');
        });
    }
};
